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
        // echo "<pre>"; print_r($model->tradebooks); die;
        // $tradebook = Tradebook::find()->where(['watchlist_id' => $id])->one()->id;
        // $tradebook = Tradebook::find()->where(['watchlist_id' => $id])->all();
        // $tradebook = Watchlist::find()->select(['scrip_name', 'current_price'])->where(['id' => $id])->with(['tradebook'])->all();
        /*$tradebook = Watchlist::find()->where(['id1' => $id])->with([
            'tradebook' => function ($query) {
                $query->andWhere(['status' => 1]);
            },

        ])->all();*/
        /*$tradebook = Watchlist::find()
            ->joinWith('tradebooks')
            ->where(['tradebook.status' => 1])
            ->one();*/
        // $tradebook = Tradebook::find()->select('id, SUM(quantity) AS total_quantity')->where(['watchlist_id' => $id])->one();
        $tradebook = Tradebook::find()->where(['watchlist_id' => $id])->sum('quantity')->sum('amount');
        echo "<pre>"; print_r($tradebook); die; //SAMIR PARIKH

        $startDate = $model->date; // start date
        $endDate = date('Y-m-d'); // end date
        $date1 = new \DateTime($startDate);
        $date2 = new \DateTime($endDate);
        $interval = $date1->diff($date2);

        $totalDays = ($interval->days <= 0) ? 1 : $interval->days;

        $desiredProfit = $totalDays * $model->desired_profit;

        $data['required_stock'] = ceil($desiredProfit / $model->desired_per_share_price);



        $searchModelTradebook = new TradebookSearch();
        $dataProviderTradebook = $searchModelTradebook->searchInWatchList($this->request->queryParams);

        return $this->render('view', [
            'model' => $model,
            'data' => $data,
            'searchModelTradebook' => $searchModelTradebook,
            'dataProviderTradebook' => $dataProviderTradebook,
        ]);
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

    public function actionCalculate()
    {
        // echo "<pre>"; print_r(Yii::$app->request->post());
        return json_encode(Yii::$app->request->post());
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
