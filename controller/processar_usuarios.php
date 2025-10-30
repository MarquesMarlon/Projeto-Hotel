<?php
require_once __DIR__ . '/../config/conexaobd.php';
require_once __DIR__ . '/../model/usuario.php';
session_start();

// Protege: apenas usuários autenticados podem mexer com usuários
if (!isset($_SESSION['user_id'])) {
    header('Location: /projetohotel/admin-login.php');
    exit;
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$usuarioModel = new Usuario();

try {
    switch ($action) {
        case 'create':
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $usuarioModel->create($nome, $email, $senhaHash);
            header('Location: /projetohotel/usuarios-gerenciar.php?success=created');
            break;

        case 'update':
            $id = $_POST['id'] ?? null;
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            if ($id) {
                if (!empty($senha)) {
                    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
                    $usuarioModel->update($id, $nome, $email, $senhaHash);
                } else {
                    $usuarioModel->update($id, $nome, $email, null);
                }
            }

            header('Location: /projetohotel/usuarios-gerenciar.php?success=updated');
            break;

        case 'delete':
            $id = $_GET['id'] ?? null;
            if ($id) {
                $usuarioModel->delete($id);
            }
            header('Location: /projetohotel/usuarios-gerenciar.php?success=deleted');
            break;

        default:
            header('Location: /projetohotel/usuarios-gerenciar.php');
            break;
    }
} catch (PDOException $e) {
    echo 'Erro: ' . $e->getMessage();
}

?>
