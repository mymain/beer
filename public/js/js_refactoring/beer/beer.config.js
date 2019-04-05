function BeerConfig($routeProvider) {
    'ngInject';

    $routeProvider.when('/beer/:beerId', {
        controller: 'BeerCtrl',
        controllerAs: 'ctrl',
        templateUrl: './js/beer/beer.html',
        title: 'Beer',
        resolve: {
            beer: function (Beer, $route) {
                return Beer.get($route.current.params.beerId).then(
                    (beer) => beer,
                    (err) => console.log(err)
                );
            }
        }
    });

};

export default BeerConfig;