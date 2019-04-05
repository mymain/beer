class BeersCtrl {
    constructor(AppConstants, Beer, $scope, $rootScope, $location, uiGridConstants) {
        'ngInject';

        this.appName = AppConstants.appName;
        this.Beer = Beer;
        this.$scope = $scope;
        this.uiGridConstants = uiGridConstants;
        this.pageSize = 10;
        this.$location = $location;
        
        this.paginationOptions = {
            pageSize: 10,
            pageNumber: 1
            
        };
        this.brewerFilterConfig = {
            noTerm: true,
            selectOptions: filtersData['Brewer'],
            type: uiGridConstants.filter.SELECT
        };
        $rootScope.setPageTitle('Beer Test App');
        
        // Get list of all beers
        /*alert('ctrl');
        Beers
            .getAll()
            .then(
                (beers) => {
                    this.beersLoaded = true;
                    this.beers = beers;
                }
            );*/
        this.initGrid();
        this.getPage();
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
                        selectOptions: filtersData['Country']
                    }
                },
                {
                    name: 'type_name',
                    filter: {
                        noTerm: true,
                        type: this.uiGridConstants.filter.SELECT,
                        selectOptions: filtersData['Type']
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
                    var grid = self.grid;
                });
            }
        };
    }
    getPage() {
        var activeFiltersConfig = {},
            $scope = this.$scope;
        activeFiltersConfig.params = {};
        activeFiltersConfig.params['page'] = this.paginationOptions.pageNumber;
        activeFiltersConfig.params['size'] = this.paginationOptions.pageSize;
        
        this.Beer.getPage(this.paginationOptions.pageNumber, this.paginationOptions.pageSize).then(function(data){
            $scope.gridOptions.data = data.beers;
            $scope.gridOptions.totalItems = data.totalElements;
        });
    }
    

}

export default BeersCtrl;