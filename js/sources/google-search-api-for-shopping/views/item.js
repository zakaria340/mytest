define([
  'jQuery',
  'jqueryui',
  'Underscore',
  'Backbone',
  'models/query',
  'router',
  'sources/google-search-api-for-shopping/collections/products',
  'sources/google-search-api-for-shopping/models/product',
  'text!sources/google-search-api-for-shopping/templates/item.html',
], function ($, jqueryui, _, Backbone, QueryModel, Router, ProductsCollection, ProductModel, itemTemplate) {
  var ItemView = Backbone.View.extend({
    events: {
      'click .close-overlay': 'closeItem'
    },
    template: _.template(itemTemplate),
    initialize: function () {
      this.products = new ProductsCollection();
      //this.render();
    },
    render: function (options) {
      this.products.fetch({
        data: {
          page: '',
          q: '',
          tags: '',
          ville: '',
          order: '',
          idannonce: options.idannonce
        },
        success: _.bind(function (collection, response) {
          $('.contentItem').empty();
          if (this.products.size() > 0) {
            var data = this.products.toJSON();
            this.$el.append(this.template({
              product: data[0].items[0],
            }));
          }
          else {
            this.$el.text('No result found!');
          }
        }, this),
        error: _.bind(function (collection, xhr, options) {
          this.$el.empty().text('Error get Item!!');
        }, this)
      });
      return this;
    },
    closeItem: function (e) {
     $('.contentItem').html('');
    }
  });
  return ItemView;
});