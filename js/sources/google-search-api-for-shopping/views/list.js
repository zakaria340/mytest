define([
    'jQuery',
    'jqueryui',
    'Underscore',
    'Backbone',
    'models/query',
    'router',
    'sources/google-search-api-for-shopping/collections/products',
    'sources/google-search-api-for-shopping/models/product',
    'text!sources/google-search-api-for-shopping/templates/products.html',
    'text!sources/google-search-api-for-shopping/templates/tags.html',
    'Masonry',
  ],
  function ($, jqueryui, _, Backbone, QueryModel, Router, ProductsCollection, ProductModel, productsTemplate, tagsTemplate, Masonry) {
    var ListView = Backbone.View.extend({
      events: {
        'click .singleAnnonce': 'setAnnonce'
      },
      template: _.template(productsTemplate),
      templatetags: _.template(tagsTemplate),
      initialize: function () {
        this.model = new QueryModel();
        this.products = new ProductsCollection();
      },
      render: function (options) {
        var page;
        if (options.page == '') {
          page = 1;
        }
        else {
          page = options.page;
        }
        this.products.fetch({
          data: {
            page: page,
            q: options.term,
            tags: options.tags,
            ville: options.ville,
            order: options.order
          },
          success: _.bind(function (collection, response) {
            this.$el.empty();
            $('.search-extra-tags').empty();
            if (this.products.size() > 0) {
              var data = this.products.toJSON();

              var currentpath = '#chercher/annonces/' + options.term + '/' + options.ville +
                '/' + options.tags + '/' + options.order;

              this.$el.append(this.template({
                current_path: unescape(currentpath),
                products: data[0].items,
                page: data[0].page,
                total_count: data[0].total_count
              }));
              $('.full-tabs').show();
              $('.current_page').val(data[0].page);
              new Masonry('ol.collections', {
                itemSelector: '.group'
              });
            }
            else {
              this.$el.text('No result found!');
            }

          }, this),
          error: _.bind(function (collection, xhr, options) {
            this.$el.empty().text('Error get result!!');
          }, this)
        });
      },
      setAnnonce: function (e) {
        // var name = $(e.target).parents('.singleAnnonce').attr('id');
        //this.model.set({sourceId: 'annonces', tags: 'AAAA', idannonce: name, title: 'azezaezaezae'});
        //var itemView = new ItemView({el: '.contentItem'});
        //return;
      }
    });
    return ListView;
  });