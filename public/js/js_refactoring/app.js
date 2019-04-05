import appRun  from './config/app.run.js';
import appConfig  from './config/app.config.js';
import constants  from './config/app.constants.js';

import './services/services.index.js';
import './layout/layout.index.js';
import './beers/beers.index.js';
import './beer/beer.index.js';
import './brewers/brewers.index.js';

// Create and bootstrap application
const requires = [
    'ngRoute', 
    'ngTouch', 
    'ngAria',
    'ui.grid',
    'ui.router',
    'ui.grid.pagination', 
    'ui.grid.selection', 
    'ui.grid.cellNav', 
    'app.services',
    'app.beer',
    'app.beers',
    'app.brewers'
];


window.app = angular.module('app', requires);

angular.module('app').constant('AppConstants', constants);

angular.module('app').config(appConfig);

angular.module('app').run(appRun);

/*angular.bootstrap(document, ['app'], {
    strictDi: false
});*/