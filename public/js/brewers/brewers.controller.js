class BrewersCtrl {
    constructor(Brewer, $rootScope, $scope, $location) {
        'ngInject';

        this.Brewer = Brewer;
        $rootScope.setPageTitle('Brewer view');
        
        this.$scope = $scope;
        this.$location = $location;
        
        this.paginationOptions = {
            pageSize: 10,
            pageNumber: 1  
        };
        
        this.initGrid();
        this.getData();
    }
    initGrid() {
        var self = this;
        self.$scope.gridOptions = {
                paginationPageSizes: [5, 10, 20],
                paginationPageSize: this.paginationOptions.pageSize,
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
                self.$scope.gridApi = gridApi;
                gridApi.selection.on.rowSelectionChanged(self.$scope, function (row) {
                    self.$location.path('/beers/' + row.entity.id);
                });
            }
        };
    }
    getData() {
        var $scope = this.$scope;
        this.Brewer.getAll().then(function(data){
            $scope.gridOptions.data = data.brewers;
        });
    }
}


export default BrewersCtrl;