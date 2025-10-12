<!-- Este arquivo aqui é o cerebro da operação -->
<?php
require_once 'config/conexaobd.php';
class Quarto
{
    private $pdo;

    public function __construct()
    {
        $conexao = new Conexao();
        $this->pdo = $conexao->getPdo();
    }

    public function listarTodos()
    {
        $stmt = $this->pdo->query("SELECT * FROM quartos WHERE ativo = 1 ORDER BY numero");
        return $stmt->fetchAll();
    }

    public function buscarPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM quartos WHERE id = :id AND ativo = 1");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
}
