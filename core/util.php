<?php
class FilterFlow {
    private $target;
    private $range;
    public function filter_range($range) {
        $this->range = str_replace(['~', ',', ' '], ['-', '', ''], trim($range, '"\''));
        return $this;
    }
    public function on($input) {
        $this->target = (string)$input;
        return $this;
    }
    public function replace($to = '') {
        $pattern = "/[^" . preg_quote($this->range, '/') . "]/u";
        $pattern = str_replace('\-', '-', $pattern); 
        return preg_replace($pattern, $to, $this->target);
    }
}
function filter_pq($range) {
    $f = new FilterFlow();
    return $f->filter_range($range);
}
?>