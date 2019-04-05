function BrewersConfig($routeProvider) {
    'ngInject';
    
    $routeProvider.when('/brewers', {
        controller: 'BrewersCtrl',
        controllerAs: 'ctrl',
        templateUrl: './js/brewers/brewers.html',
        title: 'Brewers'
    });

};

export default BrewersConfig;