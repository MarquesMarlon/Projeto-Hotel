<!-- Este arquivo aqui é o cerebro das RESERVAS -->

<?php
require_once 'config/conexaobd.php';
class Reserva
{
    private $pdo;

    public function __construct()
    {
        $conexao = new Conexao();
        $this->pdo = $conexao->getPdo();
    }

    public function listarTodos()
    {
        $stmt = $this->pdo->query("SELECT * FROM reservas ORDER BY data_checkin DESC");
        return $stmt->fetchAll();
    }

    public function buscarPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM reservas WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
}


?>