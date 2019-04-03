'use strict';

var app = angular.module('app', ['ngRoute', 'ngTouch', 'ui.grid', 'ui.grid.pagination', 'ui.grid.selection', 'ui.grid.cellNav', 'ngAria']);

app.config(function($routeProvider){
    $routeProvider.when('/', {
        templateUrl: 'pages/beers.html',
        controller: 'BeersCtrl'
    })
    .when('/beers/:brewerId', {
        templateUrl:'pages/beers.html',
        controller:'BeersCtrl'
    })
    .when('/brewers', {
        templateUrl:'pages/brewers.html',
        controller:'BrewersCtrl'
    })
    .when('/beer/:beerId', {
        templateUrl:'pages/beer.html',
        controller:'BeerCtrl'
    });
});

app.controller('BeerCtrl', function ($scope, $http, $location, $routeParams) {
    $http.get('/api/beers/' + $routeParams.beerId).then(function (response) {
        var data = response.data;
        $scope.beerName = data.name;
        $scope.brewerName = data.brewer_name;
        $scope.typeName = data.type_name;
        $scope.pricePerLiter = data.price_per_liter;
        $scope.countryName = data.country_name;
        $scope.image = data.image;
    });
});

app.controller('BrewersCtrl', function ($scope, $http, $location) {
    var paginationOptions = {
        pageNumber: 1,
        pageSize: 10,
        sort: null
    };

    $scope.gridOptions = {
        paginationPageSizes: [5, 10, 20],
        paginationPageSize: paginationOptions.pageSize,
        enableColumnMenus: false,
        enableFiltering: true,
        enableSorting: true,
        enableRowSelection: true,
        enableRowHeaderSelection: false,
        columnDefs: [
            {name: 'name'},
            {name: 'beers_no'}
        ],
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
            gridApi.selection.on.rowSelectionChanged($scope, function (row) {
                $location.path('/beers/' + row.entity.id);
            });
        }

    };

    $http.get('/api/brewers').then(function(response) {
        $scope.gridOptions.data = response.data.brewers;
    });

});

app.controller('BeersCtrl', function ($scope, $http, $location, $routeParams, uiGridConstants) {
    var paginationOptions = {
            pageNumber: 1,
            pageSize: 10,
            sort: null
        },
        activeFiltersConfig = {
        },
        brewerFilterConfig = {
            noTerm: true,
            selectOptions: filtersData['Brewer'],
            type: uiGridConstants.filter.SELECT
        };
        
        activeFiltersConfig.params = {};
        
    if($routeParams.brewerId !== undefined) {
        brewerFilterConfig['term'] = false;
        //no need to refresh or trigger event
        activeFiltersConfig.params['brewerId'] = brewerFilterConfig['term'] = parseInt($routeParams.brewerId);
    }
    
    $scope.gridOptions = {
        paginationPageSizes: [5, 10, 20],
        paginationPageSize: paginationOptions.pageSize,
        enableColumnMenus: false,
        enableFiltering: true,
        enableSorting: false,
        useExternalPagination: true,
        useExternalFiltering: true,
        enableRowSelection: true,
        enableRowHeaderSelection: false,
        columnDefs: [
            {
                name: 'brewer_name', 
                filter: brewerFilterConfig
            },
            {name: 'name'},
            {
                name: 'price_per_liter',
                filters: [
                    {
                        condition: uiGridConstants.filter.GREATER_THAN,
                        placeholder: 'greater than'
                    },
                    {
                        condition: uiGridConstants.filter.LESS_THAN,
                        placeholder: 'less than'
                    }
                ]
            },
            {
                name: 'country_name',
                filter: {
                    noTerm: true,
                    type: uiGridConstants.filter.SELECT,
                    selectOptions: filtersData['Country']
                }
            },
            {
                name: 'type_name',
                filter: {
                    noTerm: true,
                    type: uiGridConstants.filter.SELECT,
                    selectOptions: filtersData['Type']
                }
            }
        ],
        onRegisterApi: function(gridApi) {

            $scope.gridApi = gridApi;

            gridApi.pagination.on.paginationChanged($scope, function (newPage, pageSize) {
                paginationOptions.pageNumber = newPage;
                paginationOptions.pageSize = pageSize;
                //load data from REST API
                getPage();
            });

            gridApi.selection.on.rowSelectionChanged($scope, function (row) {
                //redirect to beer details view
                $location.path('/beer/' + row.entity.id);
            });

            gridApi.core.on.filterChanged($scope, function() {
                var grid = this.grid;
                /**
                 * @todo we may want to reload dropdowns data depending 
                 * on the current available options in our search results only
                 */
                //add filters
                if(angular.isNumber(grid.columns[0].filters[0].term)) {
                    activeFiltersConfig.params['brewerId'] = grid.columns[0].filters[0].term;
                } else {
                    activeFiltersConfig.params['brewerId'] = null;
                }

                if(grid.columns[1].filters[0].term) {
                    activeFiltersConfig.params['name'] = grid.columns[1].filters[0].term;
                } else {
                    activeFiltersConfig.params['name'] = null;
                }

                if(grid.columns[2].filters[0].term) {
                    activeFiltersConfig.params['priceFrom'] = grid.columns[2].filters[0].term;
                } else {
                    activeFiltersConfig.params['priceFrom'] = null;
                }

                if(grid.columns[2].filters[1].term) {
                    activeFiltersConfig.params['priceTo'] = grid.columns[2].filters[1].term;
                } else {
                    activeFiltersConfig.params['priceTo'] = null;
                }

                if(grid.columns[3].filters[0].term) {
                    activeFiltersConfig.params['countryId'] = grid.columns[3].filters[0].term;
                } else {
                    activeFiltersConfig.params['countryId'] = null;
                }

                if(grid.columns[4].filters[0].term) {
                    activeFiltersConfig.params['typeId'] = grid.columns[4].filters[0].term;
                } else {
                    activeFiltersConfig.params['typeId'] = null;
                }

                //reset pagination before data load
                paginationOptions.pageNumber = 1;
                getPage();
            });
        }
    };
    
    var getPage = function() {
        activeFiltersConfig.params['page'] = paginationOptions.pageNumber;
        activeFiltersConfig.params['size'] = paginationOptions.pageSize;

        $http.get('/api/beers', activeFiltersConfig).then(function (response) {
            $scope.gridOptions.data = response.data.beers;
            $scope.gridOptions.totalItems = response.data.totalElements;
        });
    };

    getPage();

});