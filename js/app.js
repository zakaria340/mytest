define([
    'Underscore',
    'Backbone',
    'models/query',
    'views/search',
    'views/history',
    'sources/sources-manager',
    'models/source',
    'sources/google-search-api-for-shopping/views/list'
], function (_, Backbone,
        QueryModel, SearchView, HistoryView,
        SourcesManager, SourceModel,
        GoogleListView) {

    var Application = function () {
    };

    _.extend(Application.prototype, {
        initialize: function (router) {
            this.router = router;
            this.appQuery = new QueryModel();

            this.appQuery.on('change', function (model, changes) {
console.log('ra');
                var paage = model.get('page');
                if (typeof paage === 'undefined') {
                    paage = 1;
                }
                this.router.navigate(
                        '/search/' + model.get('sourceId') + '/' + model.get('term') + '/' + model.get('ville') + '/' + model.get('tags') + '/' + model.get('order') + '/' + paage,
                        {trigger: false});
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
                        name: 'Google Shopping',
                        view: GoogleListView
                    })
                ]
            });

            this.searchView.addSources(this.sourcesManager.sourcesPool);
        }
    });

    return new Application();
});