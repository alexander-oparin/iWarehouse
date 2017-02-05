<?php
namespace app\models;

use Yii;
use yii\base\Exception;
use yii\web\BadRequestHttpException;

class Warehouse implements WarehouseInterface {

    /**
     * @param $value
     * @return bool
     */
    private static function validateData($value) {
        if (!isset($value)) {
            return false;
        }

        $value = intval($value);

        if ($value <= 0) {
            return false;
        }

        return true;
    }

    /**
     * @param string $request
     * @return array|string
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function load($request) {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            if (!isset($request['goods']) || !count($request['goods'])) {
                throw new BadRequestHttpException('Некорректные данные', 400);
            }

            $timestamp = intval(microtime(true) * 1000000);
            foreach ($request['goods'] as $good_id => $quantity) {
                if (!self::validateData($good_id) || !self::validateData($quantity)) {
                    throw new BadRequestHttpException('Некорректные данные', 400);
                }

                (new Part($good_id, $quantity, $timestamp))->insert();
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::$app->response->statusCode = $e->getCode();
            return $e->getMessage();
        }

        $transaction->commit();

        return ['timestamp' => $timestamp];
    }


    public function ship($request) {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            if (!isset($request['goods']) || !count($request['goods'])) {
                throw new BadRequestHttpException('Некорректные данные', 400);
            }

            $timestamp = intval(microtime(true) * 1000000);
            $goods = [];

            foreach ($request['goods'] as $good_id => $quantity) {
                if (!self::validateData($good_id) || !self::validateData($quantity)) {
                    throw new BadRequestHttpException('Некорректные данные', 400);
                }

                $countGood = Part::countGood($good_id);
                if ($countGood < $quantity) {
                    $transaction->rollBack();

                    $response = ['timestamp' => $timestamp];
                    $response['status'] = 'not shipped';
                    $response['notEnoughGoods'] = [$good_id => $quantity - $countGood];

                    return $response;
                } else {
                    $goods[$good_id] = Part::takeGood($good_id, $quantity);
                }
            }
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::$app->response->statusCode = $e->getCode();
            return $e->getMessage();
        }

        $transaction->commit();
        return ['timestamp' => $timestamp, 'status' => 'shipped', 'goods' => $goods];
    }
}