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

    public function getWatchlist()
    {
        return $this->hasOne(Watchlist::class, ['id' => 'watchlist_id']);
    }

    public static function getTotal($provider, $fieldName)
    {
        if ($provider) {
            $total = 0;

            foreach ($provider as $item) {
                $total += $item[$fieldName];
            }

            return number_format($total, 2);
        }
    }

    public static function getTotalPrice($provider, $quantity, $price)
    {
        // var_dump($price); die;
        if ($provider) {
            $total_quantity = 0;
            $total_price = 0;
            foreach ($provider as $item) {
                $total_quantity += $item[$quantity];
            }
            foreach ($provider as $item) {
                $total_price += $item[$price];
            }
            return "Avg: ₹ " . number_format($total_price / $total_quantity, 2);
        }
    }

    public static function getTotalAmount($provider, $fieldName)
    {
        if ($provider) {
            $total = 0;

            foreach ($provider as $item) {
                $total += $item[$fieldName];
            }

            return "₹ " . number_format($total, 2);
        }
    }
}
