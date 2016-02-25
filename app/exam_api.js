'use strict';

var examService = angular.module('examService', ['ngResource']);

examService.factory('Exam', ['$resource',
  function($resource){
    return $resource('api/v1/questions', {}, {
      getQuestions: {method:'GET', isArray:true}
    });
  }]);