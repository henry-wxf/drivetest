<?php
class Question implements JsonSerializable{
    private $questionId;
    private $questionDesc;
    private $options;
    private $questionNo;

    public function __construct($questionNo, $id, $desc) {
        $this->questionNo = $questionNo;
        $this->questionId = $id;
        $this->questionDesc = $desc;
    }

    public function jsonSerialize() {
        return [
            'questionNo' => $this->questionNo,
            'questionId' => $this->questionId,
            'questionDesc' => $this->questionDesc,
            'options' => $this->options
        ];
    }

    public function getAnswer() {
        foreach ($this->options as $opt) {
            if($opt->isAnswer()) {
                return $opt->getOptionId();
            }
        }
    }

    public function getQuestionId() {
        return $this->questionId;
    }

    public function setOptions($opts) {
        $this->options = $opts;
    }
}

class Option implements JsonSerializable{
    private $optionId;
    private $optionDesc;
    private $isAnswer;

    public function __construct($id, $desc, $isAnswer){
        $this->optionId = $id;
        $this->optionDesc = $desc;
        $this->isAnswer = $isAnswer;
    }
    
    public function jsonSerialize() {
        return [
            'optionId' => $this->optionId,
            'optionDesc' => $this->optionDesc
        ];
    }

    public function getOptionId() {
        return $this->optionId;
    }

    public function isAnswer() {
        return $this->isAnswer == 1;
    }
}
?>