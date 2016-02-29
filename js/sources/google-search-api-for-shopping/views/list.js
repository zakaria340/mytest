define([
  'jQuery',
  'Underscore',
  'Backbone',
  'sources/google-search-api-for-shopping/collections/products',
  'sources/google-search-api-for-shopping/models/product',
  'text!sources/google-search-api-for-shopping/templates/products.html',
  'text!sources/google-search-api-for-shopping/templates/tags.html',
  'Masonry',
], function ($, _, Backbone, ProductsCollection, ProductModel, productsTemplate, tagsTemplate, Masonry) {
  var ListView = Backbone.View.extend({
    template: _.template(productsTemplate),
    templatetags: _.template(tagsTemplate),
    initialize: function () {
      this.products = new ProductsCollection();
    },
    render: function (options) {
      var page;
      if(options.page == ''){
        page = 1;
      }
      else{
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
            
            var currentpath = '#search/annonces/' + options.term + '/' + options.ville +
                    '/' + options.tags + '/' + options.order;

            this.$el.append(this.template({current_path:unescape(currentpath),products: data[0].items, page: data[0].page, total_count: data[0].total_count}));
       $('.full-tabs').show();
            $('.current_page').val(data[0].page);
            new Masonry('ol.collections', {
              itemSelector: '.group'
            });
          } else {
            this.$el.text('No result found!');
          }

        }, this),
        error: _.bind(function (collection, xhr, options) {
          this.$el.empty().text('Error get result!!');
        }, this)
      });
    },
  });
  return ListView;
});