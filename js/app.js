define([
  'Underscore',
  'Backbone',
  'models/query',
  'views/search',
  'views/history',
  'sources/sources-manager',
  'models/source',
  'sources/google-search-api-for-shopping/views/list',
  'sources/google-search-api-for-shopping/views/item'
], function (_, Backbone,
             QueryModel, SearchView, HistoryView,
             SourcesManager, SourceModel,
             GoogleListView, ItemView) {

  var Application = function () {
  };

  _.extend(Application.prototype, {
    initialize: function (router) {
      this.router = router;
      this.appQuery = new QueryModel();
      this.appQuery.on('change', function (model, changes) {
        var paage = model.get('page');
        if (typeof paage === 'undefined') {
          paage = 1;
        }
        if (model.get('sourceId') == 'annonce') {
          this.router.navigate(
            '/chercher-annonce/' + model.get('sourceId') + '/' + model.get('tags') + '/' + model.get('idannonce') + '--' + model.get('title'),
            {trigger: false});

        }
        else {
          this.router.navigate(
            '/chercher/' + model.get('sourceId') + '/' + model.get('term') + '/' + model.get('ville') + '/' + model.get(
              'tags') + '/' + model.get('order') + '/' + paage,
            {trigger: false});
        }
      }, this);

      this.searchView = new SearchView({
        model: this.appQuery
      });

      this.sourcesManager = new SourcesManager({
        el: '.content',
        model: this.appQuery,
        sources: [
          new SourceModel({
            id: 'annonces',
            name: 'List annonces',
            view: GoogleListView
          }),
          new SourceModel({
            id: 'annonce',
            name: 'Annonce',
            view: ItemView
          })
        ]
      });

      this.searchView.addSources(this.sourcesManager.sourcesPool);
    }
  });

  return new Application();
});