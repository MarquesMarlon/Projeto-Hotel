<?php
// db-test.php — testa a conexão usando config/conexaobd.php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../config/conexaobd.php';

try {
    // Força exibir erros (apenas para debug local)
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    $c = new Conexao();
    $pdo = $c->getPdo();

    // Teste simples de query
    $stmt = $pdo->query('SELECT 1');
    $ok = $stmt->fetchColumn();

    echo json_encode(['ok' => true, 'message' => 'Conexão OK', 'test' => $ok]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'message' => 'Falha na conexão ou erro PDO',
        'error' => $e->getMessage()
    ]);
}
