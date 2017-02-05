<?php

namespace app\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use app\models\Warehouse;


class WarehouseController extends Controller {

    public function actionLoad() {
        return Json::encode((new Warehouse())->load(Yii::$app->request->post()));
    }

    public function actionShip() {
        return Json::encode((new Warehouse())->ship(Yii::$app->request->post()));
    }
}
