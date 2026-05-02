<?php
// PQ 파일 업로드 수사관 (v0.7)

function file_pq() { return new FileMaker(); }

class FileMaker {
    private $file = null;
    private $target_path = "";
    private $allowed_exts = [];
    private $max_size = 0;

    // 수사 대상 지정
    public function upload($name) {
        $this->file = $_FILES[$name] ?? null;
        return $this;
    }

    // 저장 경로 (자동 생성 포함)
    public function path($p) {
        $full_path = $_SERVER['DOCUMENT_ROOT'] . $p;
        if (!is_dir($full_path)) {
            mkdir($full_path, 0777, true);
        }
        $this->target_path = rtrim($full_path, '/') . '/';
        return $this;
    }

    // 허용 확장자 (쉼표로 구분된 문자열)
    public function allow($exts) {
        $this->allowed_exts = array_map('trim', explode(',', strtolower($exts)));
        return $this;
    }

    // 용량 제한 (예: "2M", "500K")
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

    // 최종 집행
    public function save() {
        $res = ['ok' => false, 'name' => '', 'error' => ''];

        if (!$this->file || $this->file['error'] !== UPLOAD_ERR_OK) {
            $res['error'] = "파일이 없거나 업로드 오류 발생";
            return (object)$res;
        }

        // 검증: 확장자
        $ext = strtolower(pathinfo($this->file['name'], PATHINFO_EXTENSION));
        if (!empty($this->allowed_exts) && !in_array($ext, $this->allowed_exts)) {
            $res['error'] = "허용되지 않는 확장자입니다.";
            return (object)$res;
        }

        // 검증: 용량
        if ($this->max_size > 0 && $this->file['size'] > $this->max_size) {
            $res['error'] = "용량 제한을 초과했습니다.";
            return (object)$res;
        }

        // 파일명 중복 방지 처리 (보안)
        $safe_name = time() . "_" . bin2hex(random_bytes(4)) . "." . $ext;
        $dest = $this->target_path . $safe_name;

        if (move_uploaded_file($this->file['tmp_name'], $dest)) {
            $res['ok'] = true;
            $res['name'] = $safe_name;
        } else {
            $res['error'] = "파일 이동 실패";
        }

        return (object)$res;
    }
}
?>