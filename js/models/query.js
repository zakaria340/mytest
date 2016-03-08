define([
  'Underscore',
  'Backbone'
], function (_, Backbone) {
  var QueryModel = Backbone.Model.extend({
    defaults: {
      term: '',
      tags: '',
      ville: '',
      order: '',
      page: '',
      sourceId: ''
    }
  });
  return QueryModel;
});