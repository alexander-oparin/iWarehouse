function WarehouseCtrl($scope, $http) {
    var scope = this;

    scope.action = 'load';
    scope.part = {good_id: 1, quantity: 1};
    scope.parts = {};
    scope.results = [];

    scope.addPart = function () {
        var good_id = parseInt(scope.part.good_id);
        var quantity = parseInt(scope.part.quantity);
        if ((typeof good_id === 'number') && (good_id > 0) &&
            (typeof quantity === 'number') && (quantity > 0)) {
            scope.parts[good_id] = quantity;
            $('.parts-filled').removeClass('hidden');
            $('.parts-empty').addClass('hidden');
        }
    };

    scope.resetParts = function () {
        scope.parts = {};
        $('.parts-filled').addClass('hidden');
        $('.parts-empty').removeClass('hidden');
    };

    scope.removePart = function (good_id) {
        delete scope.parts[good_id];
        if (countParts() == 0) {
            scope.resetParts();
        }
    };

    function countParts() {
        var count = 0;
        for (var key in scope.parts) {
            if (scope.parts.hasOwnProperty(key)) {
                count++;
            }
        }
        return count;
    }

    scope.resetResults = function () {
        scope.results = [];
        $('.result-filled').addClass('hidden');
    };

    scope.actionConfirm = function () {
        $http.post('/warehouse/' + scope.action, {
            goods: scope.parts
        }).then(function (data) {
            if (data.status == 200) {
                scope.results.push(data.data);
                $('.result-filled').removeClass('hidden');
            }
        });
    };
}

var warehouse = angular.module("warehouse", []);
warehouse.controller("WarehouseCtrl", ['$scope', '$http', WarehouseCtrl]);
warehouse.filter('reverse', function () {
    return function (items) {
        return items.slice().reverse();
    };
});
