// DEBUG
echo json_encode([
    "debug" => [
        "raw_input" => $raw_input,
        "json_data" => $data,
        "json_error" => json_last_error_msg(),
        "username" => $data['username'] ?? "NOT_FOUND",
        "password" => $data['password'] ?? "NOT_FOUND"
    ]
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
exit;
