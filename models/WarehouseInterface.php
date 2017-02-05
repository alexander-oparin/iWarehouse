<?php
namespace app\models;

interface WarehouseInterface {
    const WH_STATUS_SHIPPED = 'shipped';
    const WH_STATUS_NOT_SHIPPED = 'not shipped';

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