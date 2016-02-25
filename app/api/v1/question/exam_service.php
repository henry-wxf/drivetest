<?php
require_once 'model.php';

class ExamService{
    public function getQuestions() {
        $questions = array();

        $o1 = new Option(1, 'stop 3 metres into the intersection in a rural area', False);
        $o2 = new Option(2, 'in a town or city, where there is no stop line, sidewalk or crosswalk, stop 10 metres before the intersection.', False);
        $o3 = new Option(3, 'stop where it is convenient.', False);
        $o4 = new Option(4, 'stop directly before the crosswalk whether it is clearly marked on the road or not', True);
        $q1_o = array($o1, $o2, $o3, $o4);
        $q1 = new Question(1, 'When preparing to stop at an intersection controlled with a stop sign:', $q1_o);

        $o7 = new Option(7, 'stop 3 metres into the intersection in a rural area', False);
        $o8 = new Option(8, 'in a town or city, where there is no stop line, sidewalk or crosswalk, stop 10 metres before the intersection.', False);
        $o5 = new Option(5, 'stop where it is convenient.', False);
        $o6 = new Option(6, 'stop directly before the crosswalk whether it is clearly marked on the road or not', True);
        $q2_o = array($o5, $o6, $o7, $o8);
        $q2 = new Question(2, 'When preparing to stop at an intersection controlled with a stop sign:', $q2_o);

        array_push($questions, $q1);
        array_push($questions, $q2);
        
        return $questions;
    }
}
?>