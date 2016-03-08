require.config({
	paths: {
		jQuery: '../assets/js/jquery-1.9.0.min',
		Underscore: '../assets/js/underscore-min',
		Backbone: '../assets/js/backbone-min',
                Masonry: '../assets/js/masonry-pkjd',
                infiniScroll: '../assets/js/infiniscroll',
		tooltipster: '../assets/js/jquery.tooltipster',
		text: '../assets/js/text'
	},
	shim: {
		'jQuery': {
			exports: '$'
		},
		'Underscore': {
			exports: '_'
		},
                'infiniScroll': {
                    deps: [
				'Underscore',
				'jQuery'
			],
			exports: 'Backbone.infiniScroll'
		},
		'Backbone': {
			deps: [
				'Underscore',
				'jQuery'
			],
			exports: 'Backbone'
		},
		'tooltipster': {
			deps: [
				'jQuery'
			]
		}
	}
});

require([
	'Backbone',
	'router',
	'app'
], function(Backbone, Router, app) {
console.log('zzzz');
	var router = new Router();
	app.initialize(router);

	Backbone.history.start();
});