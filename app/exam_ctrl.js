'use strict';

angular.module('drivetest.exam', ['ngRoute'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/exam', {
    templateUrl: 'exam.html',
    controller: 'ExamCtrl'
  });
}])

.controller('ExamCtrl', ['$scope', '$http', function($scope, $http) {

    $scope.hasChosenOne = false;

    function doExamSuccess(response) {
        var examInfo = response.data;
        updateExamStatus($scope, examInfo);
    };

    $http.get('exam.php').then(doExamSuccess);
    
    $scope.choose = function(choice) {
        if($scope.answered) {
            return;
        }

        $scope.hasChosenOne = true;
        $scope.userChoice = choice;
    };

    $scope.toBeChosen = function(choice) {
        return $scope.userChoice != choice;
    };

    $scope.hasChosen = function(choice) {
        return $scope.userChoice == choice;
    };

    $scope.submitAnswer = function() {
        if(!$scope.hasChosenOne) {
            return;
        }

        $http.post('answer.php', {"choice": $scope.userChoice}).then(doExamSuccess);
    };

    $scope.isCorrect = function(option) {
        return $scope.answered && $scope.userChoice == option && $scope.isAnswerCorrect;
    };

    $scope.isIncorrect = function(option) {
        return $scope.answered && $scope.userChoice == option && !$scope.isAnswerCorrect;
    };

    $scope.showCorrect = function(option) {
        return $scope.answered && !$scope.isAnswerCorrect && $scope.correctOpt == option;
    };

    $scope.continueExam = function() {
        $scope.hasChosenOne = false;
        $http.get('exam.php?action=continue').then(doExamSuccess);
    };

    $scope.answerLater = function() {
        $scope.hasChosenOne = false;
        $http.get('exam.php?action=answerLater').then(doExamSuccess);
    };

    $scope.practiceAgain = function() {
        $scope.hasChosenOne = false;
        $http.get('exam.php?action=practiceAgain').then(doExamSuccess);
    };

    $scope.exitExam = function() {
        $scope.hasChosenOne = false;
    }
}]);


function updateExamStatus($scope, examInfo){
    $scope.question = examInfo.question;

    $scope.questionTotal = examInfo.questionTotal;
    $scope.correctNum = examInfo.correctNum;
    $scope.incorrectNum = examInfo.incorrectNum;
    $scope.correctStillNeeded = examInfo.correctStillNeeded;
    $scope.answered = examInfo.isCurrentAnswered;

    $scope.isAnswerCorrect = examInfo.isCurrentAnswerCorrect;
    $scope.userChoice = examInfo.currentUserChoice;
    $scope.correctOpt = examInfo.currentCorrectOpt;

    $scope.totalAnsweredNum = $scope.correctNum + $scope.incorrectNum;
    $scope.questionNumLeft = $scope.questionTotal - $scope.totalAnsweredNum;

    if (!$scope.question || $scope.correctStillNeeded > $scope.questionNumLeft) {
        if (!$scope.question) { // all questions have been answered
            $scope.passed = false; //init it with failed

            if($scope.correctNum >= examInfo.correctNeeded) {
                $scope.passed = true;
            }
        } else { // no enough questions are left
            $scope.question = false; // set it no question
            $scope.passed = false;
        }
    }

    console.log(examInfo);
}