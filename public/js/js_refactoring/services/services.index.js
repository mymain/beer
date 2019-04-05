// Create the module where our functionality can attach to
let servicesModule = angular.module('app.services', []);

import BeerService from './beer.service.js';
servicesModule.service('Beer', BeerService);

import BrewerService from './brewer.service.js';
servicesModule.service('Brewer', BrewerService);

export default servicesModule;