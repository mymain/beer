class BeerCtrl {
    constructor(beer, $rootScope) {
        'ngInject';

        this.article = beer;

        $rootScope.setPageTitle(this.beer.title);

        /*TBC*/
    }
}


export default BeerCtrl;