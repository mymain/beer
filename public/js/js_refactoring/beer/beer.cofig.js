function BeerConfig($stateProvider) {
    'ngInject';

    $stateProvider.state('app.beer', {
        url: '/beer/:beerId',
        controller: 'BeerCtrl',
        controllerAs: 'ctrl',
        templateUrl: 'beer/beer.html',
        title: 'Beer',
        resolve: {
            beer: function (Beers, $state, $stateParams) {
                return Beers.get($stateParams.beerId).then(
                        (beer) => beer,
                        (err) => $state.go('app.home')
                );
            }
        }
    });

};

export default BeerConfig;