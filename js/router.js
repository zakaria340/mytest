define([
  'Backbone',
  'app'
], function (Backbone, app) {
  var Router = Backbone.Router.extend({
    routes: {
      'chercher/:sourceId(/)(:term)(/:ville)(/:tags)(/:order)(/:page)': 'searchImages',
      'chercher-annonce/:sourceId(/)(/:tags)(/:idannonce--:title)': 'showSingle'
    },
    searchImages: function (sourceId, term, ville, tags, order, page) {
      if (typeof term === 'undefined') {
        term = '';
      }
      app.appQuery.set({sourceId: sourceId, term: term, ville: ville, tags: tags, order: order, page: page});
    },
    showSingle: function (sourceId, tags, idannonce, title) {
      app.appQuery.set({sourceId: sourceId, tags: tags, idannonce: idannonce, title: title});
    }
  });
  return Router;
});
