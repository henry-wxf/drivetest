'use strict';

var examService = angular.module('examService', ['ngResource']);

examService.factory('Exam', ['$resource',
  function($resource){
    return $resource('exam.php', {}, {
      startExam: {method:'GET'},
      answer: {method:'POST', url: 'answer.php'}
    });
  }]);