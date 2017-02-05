<?php

/* @var $this yii\web\View */

$this->title = 'Складской интерфейс';

?>
<div class="site-index">
    <div class="body-content" ng-app="warehouse" ng-controller="WarehouseCtrl as WH">
        <h1 class="text-center"><?= $this->title ?></h1>
        <hr>
        <div class="row">
            <div class="col-lg-4 text-left">
                <label>Операция:</label>

                <div class="radio">
                    <label>
                        <input type="radio" name="action" ng-model="WH.action" value="load">
                        Загрузка партии товаров на склад
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="action" ng-model="WH.action" value="ship">
                        Отгрузка партии товаров со склада
                    </label>
                </div>
                <hr>
                <label>Добавление товара в список:</label>

                <div class="form-inline" style="margin-bottom: 1em;">
                    <div class="form-group">
                        <label>Артикул</label>
                        <input type="number" class="form-control" style="width:100px" min="1" step="1" ng-model="WH.part.good_id"/>
                    </div>
                    <div class="form-group">
                        <label>Количество</label>
                        <input type="number" class="form-control" style="width:100px" min="1" step="1" ng-model="WH.part.quantity"/>
                    </div>
                </div>

                <div style="margin-top: 1em">
                    <button class="btn btn-primary inline" ng-click="WH.addPart()">Добавить товар</button>
                </div>
            </div>


            <div class="col-lg-6 text-left">
                <div class="clearfix parts-filled hidden">
                    <label>Состав партии товаров:</label>

                    <table class="table col-lg-6 text-center">
                        <thead>
                        <tr>
                            <th class="col-lg-2 text-center">Артикул</th>
                            <th class="col-lg-2 text-center">Количество</th>
                            <th class="col-lg-2 text-center"></th>
                        </tr>
                        </thead>
                        <tbody ng-repeat="(good_id, quantity) in WH.parts">
                            <tr>
                                <td class="form-group">{{good_id}}</td>
                                <td class="form-group">{{quantity}}</td>
                                <td class="form-group">
                                    <button class="btn btn-danger btn-xs glyphicon glyphicon-trash" ng-click="WH.removePart(good_id)"></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="parts-filled hidden" style="margin-top: 1em;">
                    <button class="btn btn-danger" ng-click="WH.resetParts()">Очистить список</button>
                    <button class="btn btn-success" ng-click="WH.actionConfirm()">Подтвердить операцию</button>
                </div>
                <div class="parts-empty">
                    <label>Список пуст</label>
                </div>
            </div>
        </div>
        <hr>
        <div class="row col-lg-10 text-center result-filled hidden">
            <label>Ответы от сервера</label>
            <button class="btn btn-xs btn-danger glyphicon glyphicon-trash pull-right" ng-click="WH.resetResults()"></button>
            <div class="col-lg-12" ng-repeat="result in WH.results | reverse">
                <hr>
                <div class="bg-info">{{result}}</div>
            </div>
        </div>
    </div>
</div>
