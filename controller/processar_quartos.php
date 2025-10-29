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
                $nome = $_POST['nome'];
                $numero = $_POST['numero'];
                $tipo = $_POST['tipo'];
                $preco = $_POST['preco'];
                $descricao = $_POST['descricao'] ?? '';
              
                $ativo = (!empty($_POST['ativo']) && $_POST['ativo'] !== '0') ? 1 : 0;

                $sql = "INSERT INTO quartos (nome, numero, tipo, preco, descricao, ativo) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nome, $numero, $tipo, $preco, $descricao, $ativo]);

                header('Location: /projetohotel/sucesso.php?action=create'); 
                break;
 

            case 'update':
                $id = $_POST['id'];
                $nome = $_POST['nome'];
                $numero = $_POST['numero'];
                $tipo = $_POST['tipo'];
                $preco = $_POST['preco'];
                $descricao = $_POST['descricao'] ?? '';
                $ativo = (!empty($_POST['ativo']) && $_POST['ativo'] !== '0') ? 1 : 0;

                $sql = "UPDATE quartos SET nome = ?, numero = ?, tipo = ?, preco = ?, descricao = ?, ativo = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nome, $numero, $tipo, $preco, $descricao, $ativo, $id]);

                header('Location: /projetohotel/sucesso.php?action=update');
                break;

            case 'delete':
                $id = $_GET['id'];

                $sql = "DELETE FROM quartos WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);

                header('Location: /projetohotel/sucesso.php?action=delete');
                break;

            default:
                header('Location: quartos.php');
        }
    } catch (Exception $e) {
        echo "<h3>Erro: " . htmlspecialchars($e->getMessage()) . "</h3>";
        echo "<a href='quartos.php'>Voltar</a>";
    }
    ?>
