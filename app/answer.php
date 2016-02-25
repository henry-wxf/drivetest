<?php
require_once 'ExamInfo.class.php';

session_start();

$examInfo = $_SESSION['examInfo'];

if ($examInfo != null && $_SERVER["REQUEST_METHOD"] == "POST") {
    $userAnswer = json_decode(file_get_contents('php://input'), TRUE);

    $examInfo->answer($userAnswer['choice']);
}

header('Content-Type: application/json');
echo json_encode($examInfo);
?>