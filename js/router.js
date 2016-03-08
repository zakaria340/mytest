define([
    'Backbone',
    'app'
], function (Backbone, app) {
    var Router = Backbone.Router.extend({
        routes: {
            'search/:sourceId/:term/:ville/:tags/:order/:page': 'searchImages'
        },
        searchImages: function (sourceId, term, ville, tags, order, page) {
          console.log(page);
            app.appQuery.set({sourceId: sourceId, term: term, ville: ville, tags: tags, order: order, page: page});
        }
    });
    return Router;
});
