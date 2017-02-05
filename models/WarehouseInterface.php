<?php
namespace app\models;

interface WarehouseInterface {

    /**
     * @param string $request
     * @return mixed
     * @throws \yii\web\BadRequestHttpException
     */
    public function load($request);

    /**
     * @param $request
     * @return mixed
     * @throws \yii\web\BadRequestHttpException
     */
    public function ship($request);
}