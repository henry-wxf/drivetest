<?php
require_once 'model.php';

class ExamInfo implements JsonSerializable{
    private $questionTotal;
    private $correctNeeded;
    private $correctNum;
    private $incorrectNum;
    private $correctStillNeeded;
    private $questions;

    private $currentQuestion;
    private $isCurrentAnswered;
    private $isCurrentAnswerCorrect;
    private $currentUserChoice;
    private $currentCorrectOpt;

    public function __construct($correctNeeded) {
        $this->correctNeeded = $correctNeeded;
        /*
        $this->questions = array();

        for($i = 1; $i < 21; $i++) {
            $o1 = new Option(1 + $i * 10, 'stop 3 metres into the intersection in a rural area', False);
            $o2 = new Option(2 + $i * 10, 'in a town or city, where there is no stop line, sidewalk or crosswalk, stop 10 metres before the intersection.', False);
            $o3 = new Option(3 + $i * 10, 'stop where it is convenient.', False);
            $o4 = new Option(4 + $i * 10, 'stop directly before the crosswalk whether it is clearly marked on the road or not', True);
            $q1_o = array($o1, $o2, $o3, $o4);

            shuffle($q1_o);
            $q1 = new Question($i, $i, 'When preparing to stop at an intersection controlled with a stop sign:', $q1_o);

            array_push($this->questions, $q1);
            rsort($this->questions);
        }
        */
    }

    private function initQuestionStatus() {
        $this->questionTotal = count($this->questions);
        $this->correctNum = 0;
        $this->incorrectNum = 0;
        $this->correctStillNeeded = $this->correctNeeded;
    }

    private function initAnswerStatus() {
        $this->currentQuestion = array_pop($this->questions);
        $this->isCurrentAnswered = false;
        $this->isCurrentAnswerCorrect = false;
        $this->currentUserChoice = -1; // -1 means the user has not answered
        $this->currentCorrectOpt = -1;
    }

    public function startExam($questions) {
        $this->questions = $questions;

        $this->initQuestionStatus();
        $this->initAnswerStatus();

        return $this->questions;
    }

    public function jsonSerialize() {
        return [
            'questionTotal' => $this->questionTotal,
            'correctNeeded' => $this->correctNeeded,
            'correctNum' => $this->correctNum,
            'incorrectNum' => $this->incorrectNum,
            'correctStillNeeded' => $this->correctStillNeeded,
            'question' => $this->currentQuestion,
            'isCurrentAnswered' => $this->isCurrentAnswered,
            'isCurrentAnswerCorrect' => $this->isCurrentAnswerCorrect,
            'currentUserChoice' => $this->currentUserChoice,
            'currentCorrectOpt' => $this->currentCorrectOpt
        ];
    }

    public function skipCurrentQuestion(){
        array_unshift($this->questions, $this->currentQuestion);
        $this->continueExam();
    }

    public function answer($choice) {
        $this->currentUserChoice = $choice;
        $this->currentCorrectOpt = $this->currentQuestion->getAnswer();

        $isCorrect = $this->currentCorrectOpt == $choice;

        $this->isCurrentAnswerCorrect = $isCorrect;
        $this->isCurrentAnswered = true;

        if($isCorrect) {
            $this->correctNum += 1;
            $this->correctStillNeeded -= 1;

            if($this->correctStillNeeded < 0) {
                $this->correctStillNeeded = 0;
            }
        } else {
            $this->incorrectNum += 1;
        }
    }


    public function continueExam() {
        $this->initAnswerStatus();
    }
}
?>