<?php
class MySessionHandler extends SessionHandler {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function read(string $session_id): string|false {
        $stmt = $this->db->prepare("SELECT data FROM sessions WHERE session_id = ?");
        $stmt->bind_param('s', $session_id);
        $stmt->execute();
        $stmt->bind_result($data);
        $stmt->fetch();
        $stmt->close();

        if ($data) {
            session_decode($data);
            return $data;
        } else {
            return '';
        }
    }

    public function write(string $session_id, string $data): bool {
        // Unserialize the session data to extract user_id
        session_decode($data);
        $user_id = $_SESSION['user_id'] ?? null;

        // Prepare the SQL query
        $stmt = $this->db->prepare("REPLACE INTO sessions (session_id, user_id, data, timestamp) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('siss', $session_id, $user_id, $data, date('Y-m-d H:i:s'));
        return $stmt->execute();
    }

    public function destroy(string $session_id): bool {
        error_log("Attempting to delete session ID: $session_id");
        $stmt = $this->db->prepare("DELETE FROM sessions WHERE session_id = ?");
        $stmt->bind_param('s', $session_id);
        return $stmt->execute();
    }
    

    public function gc(int $max_lifetime): int|false {
        $stmt = $this->db->prepare("DELETE FROM sessions WHERE timestamp < ?");
        $stmt->bind_param('i', time() - $max_lifetime);
        return $stmt->execute();
    }
}
?>
