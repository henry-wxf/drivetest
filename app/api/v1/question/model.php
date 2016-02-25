<?php
class Question implements JsonSerializable{
    private $question_id;
    private $question_desc;
    private $options;

    public function __construct($id, $desc, $opts) {
        $this->question_id = $id;
        $this->question_desc = $desc;
        $this->options = $opts;
    }
    /*
    public function getQuestionId() {
        return $this->question_id;
    }

    public function getQuestionDesc() {
        return $this->question_desc;
    }

    public function getOptions() {
        return $this->options;
    }
    */

    public function jsonSerialize() {
        return [
            'question_id' => $this->question_id,
            'question_desc' => $this->question_desc,
            'options' => $this->options
        ];
    }
}

class Option implements JsonSerializable{
    private $option_id;
    private $option_desc;
    private $is_answer;

    public function __construct($id, $desc, $is_answer){
        $this->option_id = $id;
        $this->option_desc = $desc;
        $this->is_answer = $is_answer;
    }

    /*
    public function getOptionId() {
        return $this->option_id;
    }

    public function getOptionDesc() {
        return $this->option_desc;
    }

    public function isAnswer() {
        return $this->is_answer;
    }
    */
    
    public function jsonSerialize() {
        return [
            'option_id' => $this->option_id,
            'option_desc' => $this->option_desc,
            'is_answer' => $this->is_answer
        ];
    }
}
?>