<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parts".
 *
 * @property integer $part_id
 * @property integer $good_id
 * @property integer $quantity
 * @property integer $timestamp
 */
class Part extends \yii\db\ActiveRecord {

    public function __construct($good_id = null, $quantity = null, $timestamp = null) {
        parent::__construct();
        $this->good_id = $good_id;
        $this->quantity = $quantity;
        $this->timestamp = $timestamp;
    }

    /**
     * @param $good_id
     * @return int|mixed
     */
    public static function countGood($good_id) {
        $result = Part::find()->select('sum(quantity) as cnt')->where(['good_id' => $good_id])->asArray();
        if (!$result->count()) {
            return 0;
        } else {
            $result = $result->one();
            return $result['cnt'];
        }
    }

    /**
     * @param $good_id
     * @param $quantity
     * @return array
     */
    public static function takeGood($good_id, $quantity) {
        $countReceived = 0;
        $received = [];

        /**@var Part $part */
        foreach (Part::find()->where(['good_id' => $good_id])->orderBy('timestamp')->each() as $part) {
            $goodToReceive = $quantity - $countReceived;

            if ($part->quantity >= $goodToReceive) {
                $received[$part->timestamp] = $goodToReceive;

                $countReceived += $goodToReceive;
                $part->quantity = $part->quantity - $goodToReceive;
                $part->save();
            } else {
                $received[$part->timestamp] = $part->quantity;
                $countReceived += $part->quantity;
                $part->quantity = 0;
                $part->delete();
            }
            if($countReceived < $quantity) {
                continue;
            }
        }

        return $received;
    }

    /**
     * @inheritdoc
     */
    public
    static function tableName() {
        return 'parts';
    }

    /**
     * @inheritdoc
     */
    public
    function rules() {
        return [
            [['good_id', 'quantity'], 'required'],
            [['good_id', 'quantity', 'timestamp'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public
    function attributeLabels() {
        return [
            'part_id' => 'Part ID',
            'good_id' => 'Good ID',
            'quantity' => 'Quantity',
            'timestamp' => 'Timestamp',
        ];
    }
}
