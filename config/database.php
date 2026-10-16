<?php
/**
 * MARBLE House - Modern Database Layer (PDO)
 * 최신 PHP 8.x 표준 PDO 지원 및 레거시 함수 호환 인터페이스
 */

class Database {
    private static $instance = null;

    public static function getConnection() {
        if (self::$instance === null) {
            $host = getenv('DB_HOST') ? getenv('DB_HOST') : 'db';
            $port = getenv('DB_PORT') ? getenv('DB_PORT') : '3306';
            $dbname = getenv('DB_NAME') ? getenv('DB_NAME') : 'shopmall';
            $user = getenv('DB_USER') ? getenv('DB_USER') : 'root';
            $pass = getenv('DB_PASS') ? getenv('DB_PASS') : 'apmsetup';

            $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_SILENT,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => true,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
            ];

            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                die("데이터베이스 연결 실패: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}

function getDB() {
    return Database::getConnection();
}

/**
 * PDO Statement 결과를 mysql_result 및 mysql_num_rows와 호환되도록 감싸는 래퍼
 */
class PDOResultWrapper {
    private $rows = [];
    private $currentIndex = 0;
    public $num_rows = 0;

    public function __construct(PDOStatement $stmt) {
        $this->rows = $stmt->fetchAll(PDO::FETCH_BOTH);
        $this->num_rows = count($this->rows);
    }

    public function num_rows() {
        return $this->num_rows;
    }

    public function get($rowIndex, $field = 0) {
        if (!isset($this->rows[$rowIndex])) {
            return false;
        }

        $row = $this->rows[$rowIndex];

        // 1. 숫자 인덱스로 요청한 경우
        if (is_numeric($field) && isset($row[$field])) {
            return $row[$field];
        }

        // 2. 컬럼명으로 요청한 경우 (대소문자 무시 매핑)
        if (is_string($field)) {
            if (array_key_exists($field, $row)) {
                return $row[$field];
            }
            $lowerField = strtolower($field);
            foreach ($row as $k => $v) {
                if (strtolower($k) === $lowerField) {
                    return $v;
                }
            }
        }

        return false;
    }

    public function fetch_array() {
        if ($this->currentIndex < $this->num_rows) {
            return $this->rows[$this->currentIndex++];
        }
        return false;
    }

    public function fetch_assoc() {
        $row = $this->fetch_array();
        if ($row === false) return false;
        $assoc = [];
        foreach ($row as $k => $v) {
            if (!is_numeric($k)) $assoc[$k] = $v;
        }
        return $assoc;
    }
}

// -----------------------------------------------------------------------------
// PHP 7/8 최신 환경을 위한 레거시 함수 PDO 폴리필 (Polyfill)
// -----------------------------------------------------------------------------

if (!function_exists('mysql_connect')) {
    function mysql_connect($host = null, $user = null, $pass = null) {
        return getDB();
    }
}

if (!function_exists('mysql_select_db')) {
    function mysql_select_db($dbname, $link = null) {
        return true;
    }
}

if (!function_exists('mysql_query')) {
    function mysql_query($query, $link = null) {
        $db = getDB();
        try {
            $trimmed = trim(strtoupper($query));
            if (strpos($trimmed, 'SELECT') === 0 || strpos($trimmed, 'SHOW') === 0) {
                $stmt = $db->query($query);
                if ($stmt === false) return false;
                return new PDOResultWrapper($stmt);
            } else {
                return $db->exec($query);
            }
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('mysql_num_rows')) {
    function mysql_num_rows($result) {
        if ($result instanceof PDOResultWrapper) {
            return $result->num_rows();
        }
        return 0;
    }
}

if (!function_exists('mysql_result')) {
    function mysql_result($result, $row, $field = 0) {
        if ($result instanceof PDOResultWrapper) {
            return $result->get($row, $field);
        }
        return false;
    }
}

if (!function_exists('mysql_fetch_array')) {
    function mysql_fetch_array($result) {
        if ($result instanceof PDOResultWrapper) {
            return $result->fetch_array();
        }
        return false;
    }
}

if (!function_exists('mysql_fetch_assoc')) {
    function mysql_fetch_assoc($result) {
        if ($result instanceof PDOResultWrapper) {
            return $result->fetch_assoc();
        }
        return false;
    }
}

if (!function_exists('mysql_close')) {
    function mysql_close($link = null) {
        return true;
    }
}
