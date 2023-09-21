<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tradebook".
 *
 * @property int $id
 * @property int $watchlist_id
 * @property int $quantity
 * @property float $price
 * @property float $amount
 * @property string|null $date
 * @property int $status 1=>active,0=>inactive
 * @property string|null $ip_address
 * @property int|null $created_by
 * @property int|null $created_dt
 * @property int|null $updated_by
 * @property int|null $updated_dt
 */
class Tradebook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tradebook';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['watchlist_id', 'quantity', 'price'], 'required'],
            [['watchlist_id', 'quantity', 'status', 'created_by', 'created_dt', 'updated_by', 'updated_dt'], 'integer'],
            [['price', 'amount'], 'number'],
            [['date'], 'safe'],
            [['ip_address'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'watchlist_id' => 'Watchlist ID',
            'quantity' => 'Quantity',
            'price' => 'Price',
            'amount' => 'Amount',
            'date' => 'Date',
            'status' => 'Status',
            'ip_address' => 'Ip Address',
            'created_by' => 'Created By',
            'created_dt' => 'Created Dt',
            'updated_by' => 'Updated By',
            'updated_dt' => 'Updated Dt',
        ];
    }
}
