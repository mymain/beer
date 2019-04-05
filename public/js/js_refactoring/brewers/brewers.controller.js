class BrewersCtrl {
    constructor(Brewer, $rootScope, $scope) {
        'ngInject';

        this.Brewer = Brewer;
        $rootScope.setPageTitle('Brewer view');
        
        this.$scope = $scope;
        this.pageSize = 10;
        
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