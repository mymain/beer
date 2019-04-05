// Create the module where our functionality can attach to
let beersModule = angular.module('app.beers', []);

// Include our UI-Router config settings
import BeersConfig from './beers.config.js';
beersModule.config(BeersConfig);


// Controllers
import BeersCtrl from './beers.controller.js';
beersModule.controller('BeersCtrl', BeersCtrl);

export default beersModule;