   <!-- Este arquivo é o meio de campo entre o front e o cerebro (modal/quarto.php) -->
   
   <?php
    require_once __DIR__ . '/../config/conexaobd.php';


    if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_GET['action'])) {
        header('Location: quarto.php');
        exit;
    }

    $action = $_POST['action'] ?? $_GET['action'] ?? '';

    try {
        $conexao = new Conexao();
        $pdo = $conexao->getPdo();

        switch ($action) {
            case 'create':
                $numero = $_POST['numero'];
                $tipo = $_POST['tipo'];
                $preco = $_POST['preco'];
                $descricao = $_POST['descricao'] ?? '';
                $ativo = isset($_POST['ativo']) ? 1 : 0;

                $sql = "INSERT INTO quartos (numero, tipo, preco, descricao, ativo) VALUES (?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$numero, $tipo, $preco, $descricao, $ativo]);

                header('Location: /projetohotel/sucesso.php?action=create'); 
                break;
 

            case 'update':
                $id = $_POST['id'];
                $numero = $_POST['numero'];
                $tipo = $_POST['tipo'];
                $preco = $_POST['preco'];
                $descricao = $_POST['descricao'] ?? '';
                $ativo = isset($_POST['ativo']) ? 1 : 0;

                $sql = "UPDATE quartos SET numero = ?, tipo = ?, preco = ?, descricao = ?, ativo = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$numero, $tipo, $preco, $descricao, $ativo, $id]);

                header('Location: sucesso_quarto.php?action=update');
                break;

            case 'delete':
                $id = $_GET['id'];

                $sql = "DELETE FROM quartos WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);

                header('Location: sucesso_quarto.php?action=delete');
                break;

            default:
                header('Location: quartos.php');
        }
    } catch (Exception $e) {
        echo "<h3>Erro: " . htmlspecialchars($e->getMessage()) . "</h3>";
        echo "<a href='quartos.php'>Voltar</a>";
    }
    ?>

   <!-- Fim Inicio processar_quartos !>