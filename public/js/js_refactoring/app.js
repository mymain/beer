import angular from 'angular';

import appRun  from './config/app.run';
import appConfig  from './config/app.config';
import constants  from './config/app.constants';

import './beer';//add other too

// Create and bootstrap application
const requires = [
    'ngRoute', 
    'ngTouch', 
    'ngAria',
    'ui.grid', 
    'ui.grid.pagination', 
    'ui.grid.selection', 
    'ui.grid.cellNav', 
    'app.beer'
];


// Mount on window for testing
window.app = angular.module('app', requires);

angular.module('app').constant('AppConstants', constants);

angular.module('app').config(appConfig);

angular.module('app').run(appRun);