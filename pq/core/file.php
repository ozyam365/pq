<?php
// PQ 파일 업로드 수사관 (v0.7.9)

class FileMaker {
    private $file = null;
    private $target_path = "";
    private $allowed_exts = [];
    private $max_size = 0;

    // 1. [수사 대상] 업로드된 파일 뭉치 확보
    public function upload($file_obj) {
        $this->file = $file_obj;
        return $this; 
    }

    // 2. [호송 경로] 저장될 위치 지정 (없으면 자동 생성)
    public function path($p) {
        $full_path = $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($p, '/');
        if (!is_dir($full_path)) mkdir($full_path, 0777, true);
        $this->target_path = rtrim($full_path, '/') . '/';
        return $this;
    }

    // 3. [검문 조건] 허용 확장자
    public function allow($exts) {
        $this->allowed_exts = array_map('trim', explode(',', strtolower($exts)));
        return $this;
    }

    // 4. [무게 제한] 파일 용량 제한 (2M, 500K 등)
    public function limit($size) {
        $unit = strtoupper(substr($size, -1));
        $val = (int)$size;
        switch($unit) {
            case 'M': $this->max_size = $val * 1024 * 1024; break;
            case 'K': $this->max_size = $val * 1024; break;
            default: $this->max_size = (int)$size;
        }
        return $this;
    }

    // 5. [최종 집행] 중복 수사 후 파일 저장
    public function save() {
        if (!$this->file || $this->file['error'] !== UPLOAD_ERR_OK) return false;

        $info = pathinfo($this->file['name']);
        $ext = strtolower($info['extension']);

        // [보안 검문]
        if (!empty($this->allowed_exts) && !in_array($ext, $this->allowed_exts)) return false;
        if ($this->max_size > 0 && $this->file['size'] > $this->max_size) return false;

        // [중복 수사] 동일범(파일명)이 있으면 번호 부여
        $final_name = $this->file['name'];
        $dest = $this->target_path . $final_name;
        $count = 1;
        while (file_exists($dest)) {
            $final_name = $info['filename'] . "_" . $count . "." . $ext;
            $dest = $this->target_path . $final_name;
            $count++;
        }

        // [호송 완료]
        if (move_uploaded_file($this->file['tmp_name'], $dest)) {
            return $final_name; // 성공 시 '확정된 파일명' 반환
        }
        return false;
    }
}

function file_pq() { static $i; if (!$i) $i = new FileMaker(); return $i; }
?>