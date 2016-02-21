﻿define([
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
            this.products.fetch({
                data: {
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
                        this.$el.append(this.template({products: data[0].items, page:data[0].page, total_count:data[0].total_count}));
                        $('.search-extra-tags').append(this.templatetags({tags: data[0].tags}));
                        $('.search-extra-tags').find('[data-tag="' + options.tags + '"]').addClass('active');

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