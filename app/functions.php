<?php
require_once __DIR__ . '/../config/config.php';

function insertEntry($pdo, $content) {
    $stmt = $pdo->prepare("INSERT INTO entries (content, created_at) VALUES (:content, NOW())");
    $stmt->execute(['content' => $content]);
    echo json_encode(['status' => 'success']);
}

function deleteEntry($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM entries WHERE id = :id");
    $stmt->execute(['id' => $id]);
    echo json_encode(['status' => 'success']);
}

function getEntries($pdo) {
    return $pdo->query("SELECT * FROM entries ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
}
