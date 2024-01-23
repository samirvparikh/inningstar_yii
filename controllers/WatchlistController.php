<?php

namespace app\controllers;

use Yii;
use app\models\Watchlist;
use app\models\WatchlistSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Common;
use app\models\Tradebook;
use app\models\TradebookSearch;
use PharIo\Manifest\Url;

/**
 * WatchlistController implements the CRUD actions for Watchlist model.
 */
class WatchlistController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Watchlist models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new WatchlistSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);



        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Watchlist model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $startDate = $model->date; // start date
        $endDate = date('Y-m-d'); // end date
        $date1 = new \DateTime($startDate);
        $date2 = new \DateTime($endDate);
        $interval = $date1->diff($date2);
        $totalDays = ($interval->days <= 0) ? 1 : $interval->days + 1;
        $desiredProfit = $totalDays * $model->desired_profit;
        
        $sell_price = $model->current_price + $model->desired_per_share_price;

        $tradebook = Tradebook::find()->select(['SUM(quantity) as quantity', 'sum(amount) as amount'])->where(['watchlist_id' => $id])->one();
        if(!empty($tradebook->quantity) && !empty($tradebook->amount)){
            $desired_per_share_price = $model->desired_per_share_price;
            $desired_profit = $model->desired_profit;
            $remaining_avg_price = ceil($tradebook->amount/$tradebook->quantity);
            $remaining_stock_pl = ($tradebook->quantity*$sell_price) - ($tradebook->quantity*$remaining_avg_price);            
            // echo $remaining_stock_pl;die;
            $data['required_stock'] = ceil(($desiredProfit - $remaining_stock_pl) / $desired_per_share_price);
        }else{
            $data['required_stock'] = ceil($desiredProfit / $model->desired_per_share_price);
        }

        $searchModelTradebook = new TradebookSearch();
        $dataProviderTradebook = $searchModelTradebook->searchInWatchList($this->request->queryParams);

        return $this->render('view', [
            'model' => $model,
            'data' => $data,
            'searchModelTradebook' => $searchModelTradebook,
            'dataProviderTradebook' => $dataProviderTradebook,
        ]);
    }

    public function actionCalculate()
    {
        // [watchlist_id] => 1
        // [total_days] => 2
        // [total_desired_profit] => 400
        // [desired_per_share_price] => 1
        // [current_price] => 130
        // $request = Yii::$app->request->post();
        // echo "<pre>"; print_r(Yii::$app->request->post()); exit;
        // echo "<pre>"; print_r($request['watchlist_id']); exit;

        
        
        $desired_per_share_price = Yii::$app->request->post('desired_per_share_price');
        $current_price = Yii::$app->request->post('current_price');
        $id = Yii::$app->request->post('watchlist_id');

        $model = $this->findModel($id);
        $startDate = $model->date; // start date
        $endDate = date('Y-m-d'); // end date
        $date1 = new \DateTime($startDate);
        $date2 = new \DateTime($endDate);
        $interval = $date1->diff($date2);
        // $totalDays = ($interval->days <= 0) ? 1 : $interval->days + 1;
        $totalDays = Yii::$app->request->post('total_days');
        // $desiredProfit = $totalDays * $model->desired_profit;
        $desiredProfit = Yii::$app->request->post('total_desired_profit');
        
        // $sell_price = $model->current_price + $model->desired_per_share_price;
        $sell_price = $current_price + $desired_per_share_price;

        $tradebook = Tradebook::find()->select(['SUM(quantity) as quantity', 'sum(amount) as amount'])->where(['watchlist_id' => $id])->one();
        // print_r($tradebook); exit;
        if(!empty($tradebook->quantity) && !empty($tradebook->amount)){
            $desired_per_share_price = $model->desired_per_share_price;
            $desired_profit = $model->desired_profit;
            $remaining_avg_price = ceil($tradebook->amount/$tradebook->quantity);
            $remaining_stock_pl = ($tradebook->quantity*$sell_price) - ($tradebook->quantity*$remaining_avg_price);            
            // echo $remaining_stock_pl;die;
            $data['required_stock'] = ceil(($desiredProfit - $remaining_stock_pl) / $desired_per_share_price);
        }else{
            $data['required_stock'] = ceil($desiredProfit / $desired_per_share_price);
        }
        $data['required_amount'] = number_format(ceil($data['required_stock']*$current_price),2);
        // print_r($data); exit;        
        return json_encode($data);
    }
    /**
     * Creates a new Watchlist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Watchlist();

        if ($this->request->isPost) {
            $model->date = date('Y-m-d');
            $model->ip_address = Common::getIpAddress();
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Watchlist model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Watchlist model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Watchlist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Watchlist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Watchlist::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
