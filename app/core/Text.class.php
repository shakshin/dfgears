<?php
class DFText {
    private $core;

    public function DFText($core) {
        $this->core = $core;
    }

    public function get($alias = null) {
        if ($alias == null) {
            return "DFText: no text alias specified";
        } else {
            $text = $this->core->database->fetchOne("select text from text where alias = '{$alias}'");
            if (empty($text)) { $text = "DFText: no text found by alias '{$alias}'"; }
            return $text;
        }
    }

    public function getHeader($alias = null) {
        if ($alias == null) {
            return "DFText: no text alias specified";
        } else {
            $text = $this->core->database->fetchOne("select title from text where alias = '{$alias}'");
            if (empty($text)) { $text = "DFText: no text found by alias '{$alias}'"; }
            return $text;
        }
    }
}

?>
