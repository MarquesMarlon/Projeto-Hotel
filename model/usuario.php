<?php
require_once __DIR__ . '/../config/conexaobd.php';

class Usuario {
    private $pdo;

    public function __construct() {
        $con = new Conexao();
        $this->pdo = $con->getPdo();
    }

    public function listarTodos() {
        $stmt = $this->pdo->query("SELECT id, nome, email, data_cadastro FROM usuarios ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT id, nome, email, data_cadastro FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function create($nome, $email, $senhaHash) {
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nome, $email, $senhaHash]);
    }

    public function update($id, $nome, $email, $senhaHash = null) {
        if ($senhaHash) {
            $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$nome, $email, $senhaHash, $id]);
        } else {
            $sql = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$nome, $email, $id]);
        }
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

?>
