<?php
// Este arquivo é o meio de campo entre o front e o cerebro (modal/reserva.php)
    require_once __DIR__ . '/../config/conexaobd.php';

    // Permitir POST com form-encoded ou JSON. Se for JSON, decodifica e popula $jsonInput.
    $jsonInput = null;
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    $raw = file_get_contents('php://input');
    if ($raw && (strpos($contentType, 'application/json') !== false)) {
        $jsonInput = json_decode($raw, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($jsonInput)) {
            // permite usar as mesmas chaves que $_POST
            $_POST = array_merge($_POST, $jsonInput);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_GET['action'])) {
        header('Location: reserva.php');
        exit;
    }

    $action = $_POST['action'] ?? $_GET['action'] ?? '';

    try {
        $conexao = new Conexao();
        $pdo = $conexao->getPdo();

        switch ($action) {
            case 'verificar_disponibilidade':
                // Espera: quarto, entrada, saida (nome das chaves compatíveis com o front-end)
                $quarto = $_POST['quarto'] ?? $_POST['quarto_id'] ?? null;
                $entrada = $_POST['entrada'] ?? $_POST['data_checkin'] ?? null;
                $saida = $_POST['saida'] ?? $_POST['data_checkout'] ?? null;

                header('Content-Type: application/json; charset=utf-8');

                if (!$quarto || !$entrada || !$saida) {
                    echo json_encode(['available' => true, 'error' => 'Parâmetros insuficientes']);
                    exit;
                }

                // Consulta reservas que se sobrepõem ao intervalo [entrada, saida)
                $sql = "SELECT id, quarto_id, nome_cliente, data_checkin, data_checkout, status FROM reservas WHERE quarto_id = ? AND status <> 'cancelada' AND NOT (data_checkout <= ? OR data_checkin >= ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$quarto, $entrada, $saida]);
                $conflicts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $available = count($conflicts) === 0;
                echo json_encode(['available' => $available, 'conflicts' => $conflicts]);
                exit;
                break;
            case 'create':
                // Campos esperados do formulário/admin
                $quarto_id = $_POST['quarto_id'] ?? null;
                $nome_cliente = $_POST['nome_cliente'] ?? null;
                $email = $_POST['email'] ?? null;
                $cpf = $_POST['cpf'] ?? null;
                $telefone = $_POST['telefone'] ?? null;
                $adultos = isset($_POST['adultos']) ? intval($_POST['adultos']) : 0;
                $criancas = isset($_POST['criancas']) ? intval($_POST['criancas']) : 0;
                $data_checkin = $_POST['data_checkin'] ?? null;
                $data_checkout = $_POST['data_checkout'] ?? null;
                $status = $_POST['status'] ?? 'confirmada';

                $sql = "INSERT INTO reservas (quarto_id, nome_cliente, adultos, criancas, email, cpf, telefone, data_checkin, data_checkout, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$quarto_id, $nome_cliente, $adultos, $criancas, $email, $cpf, $telefone, $data_checkin, $data_checkout, $status]);

                header('Location: /projetohotel/sucesso.php?action=create&type=reserva');
                break;

            case 'update':
                $id = $_POST['id'] ?? null;
                $quarto_id = $_POST['quarto_id'] ?? null;
                $nome_cliente = $_POST['nome_cliente'] ?? null;
                $email = $_POST['email'] ?? null;
                $cpf = $_POST['cpf'] ?? null;
                $telefone = $_POST['telefone'] ?? null;
                $adultos = isset($_POST['adultos']) ? intval($_POST['adultos']) : 0;
                $criancas = isset($_POST['criancas']) ? intval($_POST['criancas']) : 0;
                $data_checkin = $_POST['data_checkin'] ?? null;
                $data_checkout = $_POST['data_checkout'] ?? null;
                $status = $_POST['status'] ?? 'confirmada';

                $sql = "UPDATE reservas SET quarto_id = ?, nome_cliente = ?, adultos = ?, criancas = ?, email = ?, cpf = ?, telefone = ?, data_checkin = ?, data_checkout = ?, status = ? WHERE id = ?";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([$quarto_id, $nome_cliente, $adultos, $criancas, $email, $cpf, $telefone, $data_checkin, $data_checkout, $status, $id]);

                header('Location: /projetohotel/sucesso.php?action=update&type=reserva');
                break;

            case 'delete':
                $id = $_GET['id'];
                $sql = "DELETE FROM reservas WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);
                header('Location: /projetohotel/sucesso.php?action=delete&type=reserva');
                break;
            default:
                header('Location: reserva.php');
                break;
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }

    ?>