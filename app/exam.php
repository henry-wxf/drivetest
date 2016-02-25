<?php

require_once 'settings.php';
require_once 'ExamInfo.class.php';
require_once 'ExamDB.class.php';

/*echo DB_HOST_NAME, "<br>", DB_USER_NAME, "<br>", DB_USER_PASSWORD, "<br>", DB_DB_NAME;*/

session_start();

$examInfo = $_SESSION['examInfo'];

Logger::info("NUM_QUESTIONS_PER_EXAM:" . NUM_QUESTIONS_PER_EXAM);

$examDb = new ExamDB(DB_HOST_NAME, DB_USER_NAME, DB_USER_PASSWORD, DB_DB_NAME);

if ($examInfo == null) {
    $examInfo = new ExamInfo(NUM_CORRECT_NEEDED_TO_PASS);
    $examInfo->startExam($examDb->loadQuestions(NUM_QUESTIONS_PER_EXAM));

    $_SESSION['examInfo'] = $examInfo;
} elseif (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'answerLater':
            $examInfo->skipCurrentQuestion();
            break;
        case 'continue':
            $examInfo->continueExam();
            break;
        case 'practiceAgain':
            $examInfo->startExam($examDb->loadQuestions(NUM_QUESTIONS_PER_EXAM));
            break;
        default:
            break;
    }
}

header('Content-Type: application/json');
echo json_encode($examInfo);
?>