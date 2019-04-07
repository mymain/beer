// Create the module where our functionality can attach to
let beerModule = angular.module('app.beer', []);

// Include our UI-Router config settings
import BeerConfig from './beer.config.js';
beerModule.config(BeerConfig);

// Controllers
import BeerCtrl from './beer.controller.js';
beerModule.controller('BeerCtrl', BeerCtrl)
.directive('beerImage', function(AppConstants) {
    return {
        link: function (scope, element, attrs) {
            scope.$watch(function () {
                return attrs.ngSrc;
            }, function (value) {
                if (!value) {
                    element.attr('src', AppConstants.beerImgPlaceholder);
                }
            });

            element.bind('error', function () {
                element.attr('src', AppConstants.beerImgPlaceholder);
            });
        }
    };
});
export default beerModule;