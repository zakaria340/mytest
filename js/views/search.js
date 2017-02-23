define([
  'Underscore',
  'Backbone',
  'app',
  'text!templates/search.html'
], function (_, Backbone, app, searchTemplate) {
  var SearchView = Backbone.View.extend({
    el: '.search',
    events: {
      'click .autocomplete__submit': 'setQuery',
      'click .order-item': 'setOrder',
      'click .tag-item': 'setTag',
      'click .pagination a': 'setPage',
      'change #searchtags_expanded': 'setQuery'
    },
    searchTemplate: _.template(searchTemplate),
    optionTemplate: _.template("<option value='<%= id %>'><%= name %></option>"),
    initialize: function () {
      this.model.on('change', this.applyQuery, this);
      $('.searchAnnonces').show();
      this.render();
    },
    setQuery: function () {
      var term = this.searchInput.val();
      if(term == '') {
        term = 'tous';
      }
      var order = this.orderInput.find('li.active').find('a').data('order');
      var tags = this.tagsInput.val();
      var page = this.pageInput.val();
      var ville = this.villeInput.val();
      var sourceId = 'annonces';
      this.model.set({term: term, sourceId: sourceId, ville: ville, tags: tags, order: order, page: page});
      return this;
    },
    setOrder: function (e) {
      $('.list-orders-items').find('.active').removeClass('active');
      $(e.currentTarget).parent().addClass('active');
      this.setQuery();
    },
    setTag: function (e) {
      $('.search-extra-tags').find('.active').removeClass('active');
      $(e.currentTarget).addClass('active');
      this.setQuery();
    },
    setPage: function (e) {
      $('.pagination').find('.active').removeClass('active');
      $(e.currentTarget).addClass('active');
      this.setQuery();
    },
    applyQuery: function () {
      var term = this.model.get('term');
      var sourceId = this.model.get('sourceId');
      var order = this.model.get('order');
      var tags = this.model.get('tags');
      var ville = this.model.get('ville');
      var page = this.model.get('page');

      if(term !== 'tous') {
        this.searchInput.val(unescape(term));
      } else {
        this.searchInput.val('');
      }
      this.sourceSelect.val(sourceId);
      this.orderInput.val(order);
      this.tagsInput.val(tags);
      this.villeInput.val(ville);
      this.pageInput.val(page);
    },
    render: function () {
      this.$el.empty().append(this.searchTemplate());
      this.searchInput = this.$('#home__hint');
      this.sourceSelect = this.$('.source-select');
      this.orderInput = this.$('.list-orders-items');
      this.tagsInput = this.$('.tags-select');
      this.villeInput = this.$('.villes-select');
      this.pageInput = this.$('.current_page');
      this.applyQuery();
      return this;
    },
    addSources: function (sourcesPool) {
      for (var id in sourcesPool) {
        this.sourceSelect.append(this.optionTemplate({
          id: id,
          name: sourcesPool[id].get("name")
        }));
      }
    }
  });
  return SearchView;
});