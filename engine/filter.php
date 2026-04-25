<?php
function pq_is_safe($code) {

    $blocked = [
        'exec', 'system', 'shell_exec',
        'passthru', 'unlink', 'file_put_contents'
    ];

    foreach ($blocked as $fn) {
        if (preg_match('/\b' . $fn . '\s*\(/i', $code)) {
            return false;
        }
    }

    return true;
}