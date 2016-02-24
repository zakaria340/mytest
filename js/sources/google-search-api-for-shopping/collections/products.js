define([
    'Backbone',
    'sources/google-search-api-for-shopping/models/product'
], function (Backbone, ProductModel) {
    var ProductsCollection = Backbone.Collection.extend({
        model: ProductModel,
        url: 'http://localhost/cherchi/rest/annonces',
        parse: function (response) {
            return response;
        }
    });
    return ProductsCollection;
});
