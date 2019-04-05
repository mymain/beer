// Create the module where our functionality can attach to
let brewersModule = angular.module('app.brewers', []);

// Include our UI-Router config settings
import BrewersConfig from './brewers.config.js';
brewersModule.config(BrewersConfig);

// Controllers
import BrewersCtrl from './brewers.controller.js';
brewersModule.controller('BrewersCtrl', BrewersCtrl);

export default brewersModule;