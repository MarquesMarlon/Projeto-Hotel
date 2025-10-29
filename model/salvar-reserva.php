<?php
// Retornar JSON para facilitar o consumo pelo frontend
header('Content-Type: application/json; charset=utf-8'); 

// 1. Recebe o corpo da requisição POST (que está em JSON)
$json_data = file_get_contents('php://input');

// 2. Decodifica o JSON para um objeto ou array associativo em PHP
$dados = json_decode($json_data, true);

// Verifica se os dados foram recebidos e decodificados corretamente
if (!$dados) {
    // Define o código de resposta HTTP como 400 (Bad Request) e retorna JSON
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Dados JSON inválidos ou ausentes na requisição.']);
    exit;
}

// 3. Verifica se todos os campos essenciais estão presentes
// Observação: sua tabela `reservas` (conforme imagem) tem as colunas:
// id, quarto_id, nome_cliente, email, telefone, data_checkin, data_checkout, status, created_at
// Vamos exigir pelo menos: quarto, entrada, saida, nome, email, telefone
$campos_obrigatorios = [
    'quarto', 'entrada', 'saida', 'adultos', 'criancas', 'nome', 'email', 'cpf', 'telefone'
];

foreach ($campos_obrigatorios as $campo) {
    if (!isset($dados[$campo]) || trim($dados[$campo]) === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => "Campo obrigatório '{$campo}' ausente."]);
        exit;
    }
}

// ==========================================================
// 4. PROCESSAMENTO E SIMULAÇÃO DE SALVAMENTO (Em ambiente real)
// ==========================================================

// Sanitização e formatação dos dados para o banco de dados
$quarto_id = filter_var($dados['quarto'], FILTER_SANITIZE_NUMBER_INT);
$nome_cliente = filter_var($dados['nome'], FILTER_SANITIZE_SPECIAL_CHARS);
$email_cliente = filter_var($dados['email'], FILTER_SANITIZE_EMAIL);
// CPF e Telefone podem ser salvos com as máscaras, mas é melhor remover
// as máscaras antes de salvar se o campo no DB for numérico.
// Sanitiza CPF e telefone (mantemos apenas dígitos)
$cpf_limpo = preg_replace('/[^0-9]/', '', $dados['cpf']);
$telefone_limpo = preg_replace('/[^0-9]/', '', $dados['telefone']);

// Sanitiza adultos/criancas como inteiros
$adultos = isset($dados['adultos']) ? filter_var($dados['adultos'], FILTER_SANITIZE_NUMBER_INT) : 0;
$criancas = isset($dados['criancas']) ? filter_var($dados['criancas'], FILTER_SANITIZE_NUMBER_INT) : 0;

// Validação do CPF: deve ter 11 dígitos
if (strlen($cpf_limpo) !== 11) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'CPF inválido: informe 11 dígitos.']);
    exit;
}


// --- SIMULAÇÃO DE CÓDIGO DE INSERÇÃO NO BANCO DE DADOS ---
try {
    // Conecta utilizando a classe Conexao existente
    require_once __DIR__ . '/../config/conexaobd.php';
    $conexao = new Conexao();
    $pdo = $conexao->getPdo();


    $sql = "INSERT INTO reservas (
        quarto_id,
        nome_cliente,
        email,
        cpf,
        telefone,
        adultos,
        criancas,
        data_checkin,
        data_checkout,
        status,
        created_at
    ) VALUES (
        :quarto_id,
        :nome_cliente,
        :email,
        :cpf,
        :telefone,
        :adultos,
        :criancas,
        :data_checkin,
        :data_checkout,
        :status,
        NOW()
    )";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':quarto_id', $quarto_id, PDO::PARAM_INT);
    $stmt->bindValue(':nome_cliente', $nome_cliente);
    $stmt->bindValue(':email', $email_cliente);
    // Salva CPF como dígitos (sem máscara)
    $stmt->bindValue(':cpf', $cpf_limpo);
    $stmt->bindValue(':telefone', $telefone_limpo);
    $stmt->bindValue(':adultos', $adultos, PDO::PARAM_INT);
    $stmt->bindValue(':criancas', $criancas, PDO::PARAM_INT);
    $stmt->bindValue(':data_checkin', $dados['entrada']);
    $stmt->bindValue(':data_checkout', $dados['saida']);
    // status padrão: 'confirmada'
    $stmt->bindValue(':status', isset($dados['status']) ? $dados['status'] : 'confirmada');

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $lastId = $pdo->lastInsertId();
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => "Reserva confirmada com sucesso!",
            'id' => $lastId
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Erro interno: Não foi possível salvar a reserva.']);
    }

} catch (PDOException $e) {
    // Loga o erro no servidor e retorna uma mensagem amigável
    http_response_code(500);
    error_log("Erro no DB ao salvar reserva: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erro inesperado do servidor ao salvar a reserva. Tente novamente mais tarde.']);
}
// --- FIM DA SIMULAÇÃO ---

// 5. (fim) a resposta já foi enviada como JSON dentro do try/catch acima

?>