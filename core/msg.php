<?php
$__RESULT = [];

class Msg {

    public static function print($msg) {
        global $__RESULT;

        $__RESULT[] = $msg;
    }

    public static function output() {
        global $__RESULT;

        if (empty($__RESULT)) return;

        echo "---- RESULT ----" . nl();

        foreach ($__RESULT as $r) {
            echo $r . nl();
        }

        echo nl();
    }
}
?>