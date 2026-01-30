<?php
declare(strict_types=1);

/*
  storage.php
  - Small helper library for the guestbook
  - Stores data in: /data/messages.json
  - Functions used by index.php:
    e(), load_messages(), save_messages(), add_message()
*/

// Escape output for HTML
function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Path to the JSON file
function data_file(): string {
    return __DIR__ . '/data/messages.json';
}

// Make sure /data and messages.json exist
function ensure_data_file(): void {
    $dir = __DIR__ . '/data';

    // Create folder if missing
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }

    // Create empty JSON array file if missing
    if (!file_exists(data_file())) {
        file_put_contents(data_file(), "[]\n", LOCK_EX);
    }
}

// Load all messages from JSON file
function load_messages(): array {
    ensure_data_file();

    $json = file_get_contents(data_file());
    $data = json_decode($json ?: '[]', true);

    // If file is broken, fallback to empty list
    if (!is_array($data)) {
        $data = [];
    }

    // Sort: newest first (by timestamp)
    usort($data, fn($a, $b) => (int)($b['ts'] ?? 0) <=> (int)($a['ts'] ?? 0));

    return $data;
}

// Save all messages back to JSON file
function save_messages(array $messages): void {
    ensure_data_file();

    $json = json_encode($messages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents(data_file(), ($json ?: "[]") . "\n", LOCK_EX);
}

// Add one new message (append + save)
function add_message(string $name, string $message): void {
    $messages = load_messages();

    $messages[] = [
        'id' => bin2hex(random_bytes(8)), // simple unique id
        'name' => $name,
        'message' => $message,
        'ts' => time(), // unix timestamp
    ];

    save_messages($messages);
}
