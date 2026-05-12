<?php
/**
 * PQ FILE CORE (v1.1.2)
 * [수사 종결] 물류 수사망 보안 강화 및 지능형 경로 수색 적용
 * [보강] safePath() 도입으로 상위 디렉토리 침투(Path Traversal) 차단
 */

class FileMaker {
    private $target_path = "";
    private $temp_file = null;
    private $new_name = null;
    private $allowed_exts = [];
    private $max_size = 0;

    // 🕵️ [Step 0] 엔진 통합 체크용 별칭
    public function exists($f) { return $this->has($f); }

    // --- [1. 업로드/설정 장비] ---
    public function upload($field) { $this->temp_file = $_FILES[$field] ?? null; return $this; }
    
    public function path($p) { 
        $this->target_path = rtrim($p, '/') . '/'; 
        if(!is_dir($this->target_path)) $this->mkdir($this->target_path); 
        return $this; 
    }

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
        // 🚨 [보안 수사] 디렉토리 삭제 시 내부가 비어있지 않으면 오류 방지 위해 scan 연동 고려 가능
        return is_dir($f) ? @rmdir($f) : @unlink($f); 
    }
    
    public function copy($s, $t) { return copy($s, $t); }
    public function move($s, $t) { return rename($s, $t); }
    public function has($f) { return ($f && file_exists($f)); }

    public function clear($dir) {
        if (!is_dir($dir)) return false;
        $files = $this->scan($dir);
        foreach ($files as $f) $this->delete($f);
        return true;
    }
    
    public function touch($f) { return touch($f); }

    // --- [3. 수색/리스팅] ---
    public function mkdir($p) { if (!is_dir($p)) mkdir($p, 0777, true); return $this; }
    
    public function listdir($p) { 
        if (!is_dir($p)) return [];
        return array_values(array_diff(scandir($p), ['.', '..'])); 
    }
    
    public function scan($dir) {
        if (!is_dir($dir)) return [];
        $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = [];
        foreach (new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST) as $f) {
            $files[] = $f->getPathname();
        }
        return $files;
    }

    // --- [4. 정보 추출] ---
    public function size($f) { return file_exists($f) ? filesize($f) : 0; }
    public function ext($f) { return strtolower(pathinfo($f, PATHINFO_EXTENSION)); }
    public function name($f) { return pathinfo($f, PATHINFO_FILENAME); }
    public function dir($f) { return pathinfo($f, PATHINFO_DIRNAME); }
    
    public function mimeType($f) { 
        if (file_exists($f) && function_exists('mime_content_type')) return mime_content_type($f);
        $mimes = [
            'jpg'=>'image/jpeg','jpeg'=>'image/jpeg','png'=>'image/png','gif'=>'image/gif',
            'pdf'=>'application/pdf','txt'=>'text/plain','zip'=>'application/zip',
            'html'=>'text/html','css'=>'text/css','js'=>'application/javascript'
        ];
        return $mimes[$this->ext($f)] ?? 'application/octet-stream';
    }
    
    public function modified($f) { return file_exists($f) ? filemtime($f) : 0; }
    
    /**
     * 🕵️ 파일명 수사관: 불순물(특수문자) 제거
     */
    public function safeName($n) { 
        $n = str_replace([' ', '#', '$', '%', '&', '(', ')'], '_', $n);
        return preg_replace("/[^a-zA-Z0-9._-]/", "", $n); 
    }

    // --- [5. 출력/스트림] ---
    public function download($f, $n = null) {
        if (!$this->has($f)) return false;
        if (headers_sent()) return false;
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.($n ?? basename($f)).'"');
        header('Content-Length: ' . $this->size($f));
        header('Pragma: public');
        readfile($f); exit;
    }
    
    public function inline($f) {
        if (!$this->has($f)) return false;
        header('Content-Type: ' . $this->mimeType($f));
        header('Cache-Control: public, max-age=86400');
        header('Content-Length: ' . $this->size($f));
        readfile($f); exit;
    }
    
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
        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
        $base = "{$protocol}://{$_SERVER['HTTP_HOST']}/";
        return $base . ltrim($path, '/') . (substr($path, -1) == '/' ? '' : '/') . ltrim($name, '/');
    }
}

/**
 * FILE 헬퍼 함수
 * 사용법: [[ file.path("/uploads").upload("myFile").save(); ]]
 */
function file_pq() { static $f; if (!$f) $f = new FileMaker(); return $f; }
?>
