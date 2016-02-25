module.exports = function(config){
  config.set({

    basePath : '../../../',

    files : [
      'app/resources/js/bower_components/angular/angular.js',
      'app/resources/js/bower_components/angular-route/angular-route.js',
      'app/resources/js/bower_components/angular-mocks/angular-mocks.js',
      'app/resources/js/bower_components/angular-resource/angular-resource.js',
      'app/resources/js/bower_components/angular-filter/angular-filter.js',
      'app/resources/js/bower_components/angular-bootstrap/ui-bootstrap-tpls.js',
      'app/resources/js/*.js',
      'test/js/unit/**/*.js'
    ],

    autoWatch : true,

    frameworks: ['jasmine'],

    browsers : ['Chrome'],

    plugins : [
            'karma-chrome-launcher',
            'karma-firefox-launcher',
            'karma-jasmine',
            'karma-junit-reporter'
            ],

    junitReporter : {
      outputFile: 'test_out/unit.xml',
      suite: 'unit'
    }

  });
};
