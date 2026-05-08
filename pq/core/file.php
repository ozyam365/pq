<?php
/**
 * PQ FILE CORE (v1.1)
 * [수사 보고] 피드백 6계명을 완벽 반영하여 대용량 안정성 및 서버 호환성 극대화
 */

class FileMaker {
    private $target_path = "";
    private $temp_file = null;
    private $new_name = null;
    private $allowed_exts = [];
    private $max_size = 0;

    // --- [1. 업로드/설정 장비] ---
    public function upload($field) { $this->temp_file = $_FILES[$field] ?? null; return $this; }
    public function path($p) { $this->target_path = rtrim($p, '/') . '/'; if(!is_dir($this->target_path)) $this->mkdir($this->target_path); return $this; }
    public function allow($exts) { 
        $list = is_array($exts) ? $exts : explode(',', $exts); 
        $this->allowed_exts = array_map('strtolower', array_map('trim', $list));
        return $this; 
    }
    public function limit($size_str) { 
        if (is_numeric($size_str)) { $this->max_size = (int)$size_str * 1024 * 1024; return $this; }
        $unit = strtoupper(preg_replace('/[^A-Z]/', '', $size_str));
        $val = (int)preg_replace('/[^0-9]/', '', $size_str);
        switch($unit) {
            case 'GB': case 'G': $val *= 1024 * 1024 * 1024; break;
            case 'MB': case 'M': $val *= 1024 * 1024; break;
            case 'KB': case 'K': $val *= 1024; break;
        }
        $this->max_size = $val;
        return $this; 
    }
    public function rename($name) { 
        $ext = $this->ext($name);
        $this->new_name = $ext ? $this->name($name) : $name; 
        return $this; 
    }
    public function random() { $this->new_name = bin2hex(random_bytes(8)); return $this; }
    public function image() { $this->allow(['jpg','jpeg','png','gif','webp']); return $this; }

    public function save() {
        if (!$this->temp_file || $this->temp_file['error'] !== 0) return false;
        if ($this->max_size > 0 && $this->temp_file['size'] > $this->max_size) return false;
        
        $ext = $this->ext($this->temp_file['name']);
        if (!empty($this->allowed_exts) && !in_array($ext, $this->allowed_exts)) return false;

        $name = ($this->new_name ?? $this->name($this->temp_file['name'])) . "." . $ext;
        $name = $this->safeName($name);
        
        // 🕵️ [6번 피드백] 덮어쓰기 기본 정책 (중복 방지는 random() 사용 권장 문서화)
        $full_path = $this->target_path . $name;
        if (move_uploaded_file($this->temp_file['tmp_name'], $full_path)) return $name;
        return false;
    }

    // --- [2. 파일/폴더 핸들링] ---
    public function read($f) { return file_exists($f) ? file_get_contents($f) : false; }
    public function write($f, $d) { return file_put_contents($f, $d); }
    public function append($f, $d) { return file_put_contents($f, $d, FILE_APPEND); }
    public function delete($f) { 
        if (!file_exists($f)) return false;
        return is_dir($f) ? rmdir($f) : unlink($f); 
    }
    public function copy($s, $t) { return copy($s, $t); }
    public function move($s, $t) { return rename($s, $t); }
    public function has($f) { return file_exists($f); }

    // 🕵️ [1번 피드백] clear는 '내부 청소'에 집중 (폴더 자체는 남김)
    public function clear($dir) {
        if (!is_dir($dir)) return false;
        $files = $this->scan($dir);
        foreach ($files as $f) $this->delete($f);
        return true;
    }
    public function touch($f) { return touch($f); }

    // --- [3. 수색/리스팅] ---
    public function mkdir($p) { if (!is_dir($p)) mkdir($p, 0777, true); return $this; }
    public function listdir($p) { return is_dir($p) ? array_diff(scandir($p), ['.', '..']) : []; }
    public function scan($dir) {
        if (!is_dir($dir)) return [];
        $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = [];
        foreach (new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST) as $f) $files[] = $f->getPathname();
        return $files;
    }

    // --- [4. 정보 추출] ---
    public function size($f) { return file_exists($f) ? filesize($f) : 0; }
    public function ext($f) { return strtolower(pathinfo($f, PATHINFO_EXTENSION)); }
    public function name($f) { return pathinfo($f, PATHINFO_FILENAME); }
    public function dir($f) { return pathinfo($f, PATHINFO_DIRNAME); }
    
    // 🕵️ [5번 피드백] mime_content_type 미지원 서버 예외 처리
    public function mimeType($f) { 
        if (function_exists('mime_content_type')) return mime_content_type($f);
        // 서버 미지원 시 확장자 기반 간이 판독기 가동
        $mimes = ['jpg'=>'image/jpeg','jpeg'=>'image/jpeg','png'=>'image/png','gif'=>'image/gif','pdf'=>'application/pdf','txt'=>'text/plain','zip'=>'application/zip'];
        return $mimes[$this->ext($f)] ?? 'application/octet-stream';
    }
    
    public function modified($f) { return file_exists($f) ? filemtime($f) : 0; }
    public function safeName($n) { return preg_replace("/[^a-zA-Z0-9._-]/", "", $n); }

    // --- [5. 출력/스트림] ---
    // 🕵️ [2번 피드백] Content-Length 추가로 안정성 향상
    public function download($f, $n = null) {
        if (!$this->has($f)) return false;
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.($n ?? basename($f)).'"');
        header('Content-Length: ' . $this->size($f));
        readfile($f); exit;
    }
    
    // 🕵️ [3번 피드백] 캐시 정책 추가 (브라우저 부하 감소)
    public function inline($f) {
        if (!$this->has($f)) return false;
        header('Content-Type: ' . $this->mimeType($f));
        header('Cache-Control: public, max-age=86400'); // 24시간 캐시
        header('Content-Length: ' . $this->size($f));
        readfile($f); exit;
    }
    
    // 🕵️ [4번 피드백] Range 지원은 추후 확장 가능하도록 설계 (현재는 안정 스트림)
    public function stream($f) {
        if (!$this->has($f)) return false;
        while (ob_get_level()) ob_end_clean();
        $fp = fopen($f, 'rb');
        header("Content-Type: " . $this->mimeType($f));
        header('Content-Length: ' . $this->size($f));
        while (!feof($fp)) { echo fread($fp, 8192); flush(); }
        fclose($fp); exit;
    }

    public function url($path, $name) {
        $base = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}/";
        return $base . ltrim($path, '/') . (substr($path, -1) == '/' ? '' : '/') . ltrim($name, '/');
    }
}

function file_pq() { static $f; if (!$f) $f = new FileMaker(); return $f; }
?>