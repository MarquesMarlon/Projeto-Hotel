<?php
session_start();
require_once __DIR__ . '/../config/conexaobd.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

try {
    $con = new Conexao();
    $pdo = $con->getPdo();

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && $action === 'logout') {
        // logout
        session_unset();
        session_destroy();
        header('Location: /projetohotel/admin-login.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: /projetohotel/admin-login.php');
        exit;
    }

    if ($action === 'login') {
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($senha, $user['senha'])) {
            // Autenticado
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nome'] = $user['nome'];
            header('Location: /projetohotel/area-adm.php');
            exit;
        } else {
            // Falha no login
            header('Location: /projetohotel/admin-login.php?error=1');
            exit;
        }
    }

    header('Location: /projetohotel/admin-login.php');
    exit;

} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
}

?>
