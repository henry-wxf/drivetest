<?php
require_once 'model.php';
require_once 'Logger.class.php';

define("IS_DEBUG", true);
define("SYS_ERR", "<p>System error happened, please try again later.</p>\n");

class ExamDB {
        private $db_host;
        private $db_username;
        private $db_userpasswd;
        private $db_name;

        public function __construct($db_host, $db_username, $db_userpasswd, $db_name) {
            $this->db_host = $db_host;
            $this->db_username = $db_username;
            $this->db_userpasswd = $db_userpasswd;
            $this->db_name = $db_name;

            Logger::info("db_host".$this->db_host);
        }

        public function loadQuestions($howMany) {

            //Logger::info("How many questions needed to get? ".$howMany);

            $questions = array();
            $conn = new mysqli($this->db_host, $this->db_username, $this->db_userpasswd, $this->db_name);

            if ($conn->connect_error) {
            die('Connect Error (' . $conn->connect_errno . ') '
                    . $conn->connect_error);
            }

            $query_question = "SELECT question_id, question_desc FROM questions ORDER BY RAND() LIMIT $howMany";
            $result_question = $conn->query($query_question);

            if($result_question) {
                for ($row_no = ($result_question->num_rows - 1); $row_no >= 0; $row_no--) {
                    $result_question->data_seek($row_no);
                    $row_question = $result_question->fetch_assoc();
                    $question = new Question($row_no + 1, $row_question['question_id'], $row_question['question_desc']);

                    $options = $this->loadOptions($question->getQuestionId(), $conn);

                    $question->setOptions($options);

                    array_push($questions, $question);
                }
                
                $result_question->free();
            }

            $conn->close();
            
            return $questions;
    }

    private function loadOptions($questionId, $conn) {
        //Logger::info("loadOptions($questionId)");

        $options = array();
        $stmt = $conn->prepare("SELECT option_id, option_desc, is_answer FROM options WHERE question_id = ?");

        $stmt->bind_param("i", $questionId);

        $stmt->execute();

        $stmt->bind_result($option_id, $option_desc, $is_answer);

        while ($stmt->fetch()) {
            $opt = new Option($option_id, $option_desc, $is_answer);

            //Logger::info("load one Option($option_id, $option_desc, $is_answer)");

            array_push($options, $opt);
        }

        $stmt->close();

        shuffle($options);

        return $options;
    }
}

class DBException extends Exception {
    private $err_code = 400;

    public function __contruct($rootCause) {
        parent::__construct("Exception happened when accessing DB", $err_code, $$rootCause);
    }
}
?>