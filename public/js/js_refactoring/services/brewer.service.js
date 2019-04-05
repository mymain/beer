export default class Brewer {
    constructor(AppConstants, $http, $q) {
        'ngInject';

        this._AppConstants = AppConstants;
        this._$http = $http;
        this._$q = $q;    
    }
    getAll() {
        let request = {
            url: `${this._AppConstants.api}/brewers/`,
            method: 'GET'
        };
        return this._$http(request).then(function(res){
            return res.data;
        }).catch(function (err) {
            console.log(err);
        });
    }
}