//https://coderwall.com/p/0wx6ca/angularjs-table-with-paging-filter-and-sorting-backed-by-rails
//https://github.com/eugenp/tutorials/blob/master/spring-rest-angular/src/main/webapp/view/app.js
//https://www.baeldung.com/pagination-with-a-spring-rest-api-and-an-angularjs-table
var app = angular.module('app', ['ui.grid','ui.grid.pagination']);

app.controller('BeerCtrl', ['$scope','BeerService', function ($scope,BeerService) {
   var paginationOptions = {
        pageNumber: 1,
        pageSize: 5,
        sort: null
   };

   BeerService.getBeers(paginationOptions.pageNumber, paginationOptions.pageSize).success(function(data){
        $scope.gridOptions.data = data.beers;
        $scope.gridOptions.totalItems = data.totalElements;
   });
   
   $scope.gridOptions = {
        paginationPageSizes: [5, 10, 20],
        paginationPageSize: paginationOptions.pageSize,
        enableColumnMenus: false,
	useExternalPagination: true,
        columnDefs: [
            {name: 'brewer_name'},
            {name: 'name'},
            {name: 'price_per_liter'},
            {name: 'country_name'},
            {name: 'type_name'}
        ],
    onRegisterApi: function(gridApi) {
        $scope.gridApi = gridApi;
        gridApi.pagination.on.paginationChanged($scope, function (newPage, pageSize) {
            paginationOptions.pageNumber = newPage;
            paginationOptions.pageSize = pageSize;
            BeerService.getBeers(newPage,pageSize).success(function(data){
                  $scope.gridOptions.data = data.beers;
                  $scope.gridOptions.totalItems = data.totalElements;
            });
        });
     }
  };
  
}]);

app.service('BeerService',['$http', function ($http) {
	
    function getBeers(pageNumber,size) {
        
        pageNumber = pageNumber > 0 ? pageNumber : 0;
        
        return  $http({
          method: 'GET',
          url: 'api/beers?page='+pageNumber+'&size='+size
        });
    }
	
    return {
    	getBeers : getBeers
    };
	
}]);