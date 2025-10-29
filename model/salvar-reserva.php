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
        // Preparar conteúdo do e-mail de confirmação
        $to = $email_cliente;
        $subject = 'Confirmação de Reserva - Sua Reserva';

        // Valores sanitizados para inclusão no e-mail
        $resumo_entrada = htmlspecialchars($dados['entrada']);
        $resumo_saida = htmlspecialchars($dados['saida']);
        $resumo_nome = htmlspecialchars($nome_cliente);
        $resumo_quarto = htmlspecialchars($quarto_id);
        $resumo_adultos = intval($adultos);
        $resumo_criancas = intval($criancas);

        $message = "<html><body>" .
            "<h2>Confirmação de Reserva</h2>" .
            "<p>Olá <strong>{$resumo_nome}</strong>,</p>" .
            "<p>Sua reserva foi confirmada com sucesso. Abaixo estão os detalhes:</p>" .
            "<ul>" .
            "<li><strong>ID da Reserva:</strong> {$lastId}</li>" .
            "<li><strong>Quarto (ID):</strong> {$resumo_quarto}</li>" .
            "<li><strong>Entrada:</strong> {$resumo_entrada}</li>" .
            "<li><strong>Saída:</strong> {$resumo_saida}</li>" .
            "<li><strong>Adultos:</strong> {$resumo_adultos}</li>" .
            "<li><strong>Crianças:</strong> {$resumo_criancas}</li>" .
            "</ul>" .
            "<p>Se precisar alterar sua reserva, responda a este e-mail ou entre em contato com a recepção.</p>" .
            "<p>Atenciosamente,<br>Equipe de Reservas</p>" .
            "</body></html>";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
        // Ajuste o From para um e-mail válido do seu domínio/servidor
        $headers .= "From: Reservas <reservas@seudominio.com>" . "\r\n";

        // Envio de e-mail: prioriza variáveis de ambiente (para facilitar testes/CI),
        // senão carrega `config/smtp_config.php`. Se PHPMailer/Composer estiver disponível
        // e as configurações estiverem completas, envia por SMTP via PHPMailer.
        $mailSent = false;
        $vendorAutoload = __DIR__ . '/../vendor/autoload.php';
        $smtpConfigFile = __DIR__ . '/../config/smtp_config.php';

        // Lê variáveis de ambiente (se definidas)
        $smtpHost = getenv('SMTP_HOST') ?: null;
        $smtpUsername = getenv('SMTP_USERNAME') ?: null;
        $smtpPassword = getenv('SMTP_PASSWORD') ?: null;
        $smtpPort = getenv('SMTP_PORT') ?: null;
        $smtpEncryption = getenv('SMTP_ENCRYPTION') ?: null;
        $mailFromEmail = getenv('MAIL_FROM_EMAIL') ?: null;
        $mailFromName = getenv('MAIL_FROM_NAME') ?: null;

        // Se env vars não fornecidas, tenta carregar arquivo de configuração
        if (!$smtpHost && file_exists($smtpConfigFile)) {
            require_once $smtpConfigFile;
            $smtpHost = $smtpHost ?: (defined('SMTP_HOST') ? SMTP_HOST : null);
            $smtpUsername = $smtpUsername ?: (defined('SMTP_USERNAME') ? SMTP_USERNAME : null);
            $smtpPassword = $smtpPassword ?: (defined('SMTP_PASSWORD') ? SMTP_PASSWORD : null);
            $smtpPort = $smtpPort ?: (defined('SMTP_PORT') ? SMTP_PORT : null);
            $smtpEncryption = $smtpEncryption ?: (defined('SMTP_ENCRYPTION') ? SMTP_ENCRYPTION : null);
            $mailFromEmail = $mailFromEmail ?: (defined('MAIL_FROM_EMAIL') ? MAIL_FROM_EMAIL : null);
            $mailFromName = $mailFromName ?: (defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : null);
        }

        // Se autoload existe e temos host/usuário/senha, tenta enviar por PHPMailer
        if (file_exists($vendorAutoload) && $smtpHost && $smtpUsername && $smtpPassword) {
            require_once $vendorAutoload;
            try {
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = $smtpHost;
                $mail->SMTPAuth = true;
                $mail->Username = $smtpUsername;
                $mail->Password = $smtpPassword;
                $mail->SMTPSecure = $smtpEncryption ?: 'tls';
                $mail->Port = $smtpPort ? intval($smtpPort) : 587;

                $mail->CharSet = 'UTF-8';
                $mail->setFrom($mailFromEmail ?: $smtpUsername, $mailFromName ?: 'Reservas');
                $mail->addAddress($to, $resumo_nome);
                $mail->Subject = $subject;
                $mail->isHTML(true);
                $mail->Body = $message;

                // Opções para TLS/SSL em ambiente local
                $mail->SMTPOptions = [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    ]
                ];

                $mail->send();
                $mailSent = true;
            } catch (Exception $e) {
                error_log('PHPMailer error: ' . $e->getMessage());
                $mailSent = false;
            }
        } else {
            // Fallback para mail()
            if (!file_exists($vendorAutoload)) {
                error_log('vendor/autoload.php não encontrado. Usando fallback mail().');
            } elseif (!($smtpHost && $smtpUsername && $smtpPassword)) {
                error_log('Configuração SMTP incompleta (env ou config). Usando fallback mail().');
            }
            try {
                $mailSent = @mail($to, $subject, $message, $headers);
            } catch (Exception $e) {
                error_log('Erro ao enviar e-mail com mail(): ' . $e->getMessage());
                $mailSent = false;
            }
        }

        // Monta mensagem final para o frontend
        if ($mailSent) {
            $userMsg = 'Reserva confirmada com sucesso! Olhe seu e-mail, lhe enviamos a confirmação.';
        } else {
            $userMsg = 'Reserva confirmada com sucesso! Não foi possível enviar o e-mail de confirmação automaticamente. Por favor, verifique seu e-mail mais tarde ou entre em contato conosco.';
            // Log do corpo do e-mail para diagnóstico (não exibe ao usuário)
            error_log("E-mail não enviado para {$to}. Conteúdo: " . $message);
        }

        http_response_code(200);
        echo json_encode([
            'success' => true,
            'message' => $userMsg,
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