function BeersConfig($routeProvider) {
    'ngInject';
    
    $routeProvider.when('/', {
        controller: 'BeersCtrl',
        controllerAs: 'ctrl',
        templateUrl: './js/beers/beers.html',
        title: 'Beers'
    }).when('/beers/:brewerId', {
        controller:'BeersCtrl',
        controllerAs: 'ctrl',
        templateUrl: './js/beers/beers.html',
        title: 'Beers'
    });

};

export default BeersConfig;