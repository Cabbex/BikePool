var module = angular.module("userApp",[]);

module.controller("userCtrl",function($scope, $http){
        $http.get("http://casper.te4.nu/BikePool/PHP/getdata.php")
            .then(function (data){
                console.log(data.data);
                $scope.users = data.data;
            });
    $scope.sortField = 'user';
    $scope.reverse = false;
});
