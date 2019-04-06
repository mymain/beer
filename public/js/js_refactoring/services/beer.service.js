export default class Beer {
    constructor(AppConstants, $http, $q) {
        'ngInject';

        this._AppConstants = AppConstants;
        this._$http = $http;
        this._$q = $q;
    }
    query(config) {
        
    }
    get(id) {
        let deferred = this._$q.defer();
        this._$http({
            url: this._AppConstants.api + '/beers/' + id,
            method: 'GET'
        }).then(
            (res) => deferred.resolve(res.data),
            (err) => alert(err)
        );

        return deferred.promise;
    }
    destroy(id) {
        
    }
    save(beer) {
        
    }
    getPage(params) {
        // Create the $http object for this request
        let request = {
            url: `${this._AppConstants.api}/beers/`,
            method: 'GET',
            params: params
        };
        return this._$http(request).then(function(res){
            return res.data;
        }).catch(function (err) {
            console.log(err);
        });
        

    }
}