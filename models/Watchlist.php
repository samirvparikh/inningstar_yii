<?php

namespace app\models;

use Yii;
use app\models\Common;

/**
 * This is the model class for table "watchlist".
 *
 * @property int $id
 * @property string $scrip_name
 * @property string $desired_per_share_price
 * @property string $desired_profit
 * @property string|null $date
 * @property int $status 1=>active,0=>inactive
 * @property string $ip_address
 * @property int|null $created_by
 * @property int|null $created_dt
 * @property int|null $updated_by
 * @property int|null $updated_dt
 */
class Watchlist extends \yii\db\ActiveRecord
{
    // public $days;
    public $total_days;
    public $total_desired_profit;
    public $current_price;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'watchlist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['scrip_name', 'desired_per_share_price', 'desired_profit'], 'required'],
            [['date'], 'safe'],
            [['desired_per_share_price', 'desired_profit'], 'number', 'numberPattern' => '/^\s*[-+]?[0-9]*[.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],
            [['status', 'created_by', 'created_dt', 'updated_by', 'updated_dt'], 'integer'],
            [['scrip_name'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'scrip_name' => 'Scrip Name',
            'desired_per_share_price' => 'Desired Per Share Price',
            'desired_profit' => 'Desired Profit',
            'date' => 'Date',
            'status' => 'Status',
            'ip_address' => 'Ip Address',
            'created_by' => 'Created By',
            'created_dt' => 'Created Dt',
            'updated_by' => 'Updated By',
            'updated_dt' => 'Updated Dt',
        ];
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->updated_dt = Common::getTimeStamp('', 'Y-m-d H:i:s');
            $this->updated_by = (isset(Yii::$app->user->identity->id) && !empty(Yii::$app->user->identity->id))?Yii::$app->user->identity->id:0;
            if ($insert) {
                $this->created_dt = Common::getTimeStamp('', 'Y-m-d H:i:s');
                $this->created_by = (isset(Yii::$app->user->identity->id) && !empty(Yii::$app->user->identity->id))?Yii::$app->user->identity->id:0;
            }
            return true;
        } else {
            return false;
        }
    }

    public static function getTotalDays($obj = null)
    {
        
    }
}
