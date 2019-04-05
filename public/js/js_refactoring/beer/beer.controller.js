class BeerCtrl {
    constructor(beer, $rootScope) {
        'ngInject';

        this.beer = beer;
        console.log(beer);
        $rootScope.setPageTitle('Beer view');
        
        
        
    }
}


export default BeerCtrl;