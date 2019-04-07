class BeersCtrl {
    constructor(AppConstants, Beer, Brewer, $scope, $rootScope, $location, $routeParams, uiGridConstants) {
        'ngInject';

        this.appName = AppConstants.appName;
        this.Beer = Beer;
        this.Brewers = Brewer;
        this.uiGridConstants = uiGridConstants;
        this.filtersConfig = {};
        this.$scope = $scope;
        this.$location = $location;
        this.brewerId = parseInt($routeParams.brewerId);
        
        this.paginationOptions = {
            pageSize: 10,
            pageNumber: 1  
        };
             
        $rootScope.setPageTitle('Beer Test App');
        
        this.initBrewersFilter(Brewer, uiGridConstants);
        
        this.initGrid();
        
        // Get list of all beers
        this.getPage();
        
    }
    initBrewersFilter(Brewer, uiGridConstants) {
        this.$scope.brewersValues = [];
        this.brewerFilterConfig = {
            noTerm: true,
            selectOptions: this.$scope.brewersValues,
            type: uiGridConstants.filter.SELECT
        };   

        if(!isNaN(this.brewerId)) {
            this.brewerFilterConfig['noTerm'] = false;
            //no need to refresh or trigger event
            this.filtersConfig['brewerId'] = this.brewerFilterConfig['term'] = this.brewerId;
        }
        //http://plnkr.co/edit/qIeXkkHPzJEClOppwrNN?p=preview
        Brewer.getAll().then((response) => {
            var $scope = this.$scope;
            angular.forEach(response.brewers, function(value, key) {
                $scope.brewersValues.push({label: value.name, value: value.id });
            });
        });
    }
    initGrid() {
        var self = this;
        self.$scope.gridOptions = {
            paginationPageSizes: [5, 10, 20],
            paginationPageSize: this.paginationOptions.pageSize,
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
                        filter: this.brewerFilterConfig
                },
                {name: 'name'},
                {
                    name: 'price_per_liter',
                    filters: [
                        {
                            condition: this.uiGridConstants.filter.GREATER_THAN,
                            placeholder: 'greater than'
                        },
                        {
                            condition: this.uiGridConstants.filter.LESS_THAN,
                            placeholder: 'less than'
                        }
                    ]
                },
                {
                    name: 'country_name',
                    filter: {
                        noTerm: true,
                        type: this.uiGridConstants.filter.SELECT,
                        selectOptions: filtersData['Country'] /* @todo REST API */
                    }
                },
                {
                    name: 'type_name',
                    filter: {
                        noTerm: true,
                        type: this.uiGridConstants.filter.SELECT,
                        selectOptions: filtersData['Type'] /* @todo REST API */
                    }
                }
            ],
            onRegisterApi: function(gridApi) {

                var gridApi = gridApi;

                gridApi.pagination.on.paginationChanged(self.$scope, function (newPage, pageSize) {
                    self.paginationOptions.pageNumber = newPage;
                    self.paginationOptions.pageSize = pageSize;
                    //load data from REST API
                    self.getPage();
                });

                gridApi.selection.on.rowSelectionChanged(self.$scope, function (row) {
                    //redirect to beer details view
                    self.$location.path('/beer/' + row.entity.id);
                });

                gridApi.core.on.filterChanged(self.$scope, function() {
                    var grid = this.grid;
                    self.processFilters(grid);
                });
            }
        };
    }
    processFilters(grid) {
       /**
        * @todo we may want to reload dropdowns data depending 
        * on the current available options in our search results only
        */
       //add filters
       if(angular.isNumber(grid.columns[0].filters[0].term)) {
           this.filtersConfig['brewerId'] = grid.columns[0].filters[0].term;
       } else {
           this.filtersConfig['brewerId'] = null;
       }

       if(grid.columns[1].filters[0].term) {
           this.filtersConfig['name'] = grid.columns[1].filters[0].term;
       } else {
           this.filtersConfig['name'] = null;
       }

       if(grid.columns[2].filters[0].term) {
           this.filtersConfig['priceFrom'] = grid.columns[2].filters[0].term;
       } else {
           this.filtersConfig['priceFrom'] = null;
       }

       if(grid.columns[2].filters[1].term) {
           this.filtersConfig['priceTo'] = grid.columns[2].filters[1].term;
       } else {
           this.filtersConfig['priceTo'] = null;
       }

       if(grid.columns[3].filters[0].term) {
           this.filtersConfig['countryId'] = grid.columns[3].filters[0].term;
       } else {
           this.filtersConfig['countryId'] = null;
       }

       if(grid.columns[4].filters[0].term) {
           this.filtersConfig['typeId'] = grid.columns[4].filters[0].term;
       } else {
           this.filtersConfig['typeId'] = null;
       }

       //reset pagination before data load
       this.paginationOptions.pageNumber = 1;
       
       this.getPage();
    }
    getPage() {
        var $scope = this.$scope,
            params = Object.assign(this.paginationOptions, this.filtersConfig);
        this.Beer.getPage(params).then(function(data){
            $scope.gridOptions.data = data.beers;
            $scope.gridOptions.totalItems = data.totalElements;
        });
    }
    

}

export default BeersCtrl;