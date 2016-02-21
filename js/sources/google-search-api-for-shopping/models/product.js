define([ 'Backbone' ], function(Backbone) {
	var ProductModel = Backbone.Model.extend({
		defaults: {
			title: '',
			description: '',
			link: '',
			thumbnail: ''
		},
		parse: function(item) {
                    return item;
			
		}
	});
	return ProductModel;
});