define([
	'Underscore',
	'Backbone'
], function(_, Backbone) {
	var QueryModel = Backbone.Model.extend({
		defaults: {
			term: '',
                        tags:'',
			sourceId: ''
		}
	});
	return QueryModel;
});