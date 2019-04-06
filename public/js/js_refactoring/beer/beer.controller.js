class BeerCtrl {
    constructor(beer, $rootScope) {
        'ngInject';

        this.beer = beer;
        $rootScope.setPageTitle('Beer view');
    }
}


export default BeerCtrl;