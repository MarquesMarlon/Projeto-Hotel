<?php
// Arquivo: tools/test_email.php
// Uso (CLI): php test_email.php destinatario@example.com
// Se nenhum destinatário for passado, irá usar SMTP_USERNAME definido em config/smtp_config.php

$base = dirname(__DIR__);
$autoload = $base . '/vendor/autoload.php';
$smtpConfig = $base . '/config/smtp_config.php';

if (!file_exists($autoload)) {
    echo "Arquivo vendor/autoload.php não encontrado. Rode 'composer install' no projeto.\n";
    exit(1);
}
if (!file_exists($smtpConfig)) {
    echo "Arquivo de configuração SMTP não encontrado: config/smtp_config.php\n";
    exit(1);
}

require_once $autoload;
require_once $smtpConfig;

// Define destinatário a partir do argumento CLI se fornecido
$to = isset($argv[1]) && filter_var($argv[1], FILTER_VALIDATE_EMAIL) ? $argv[1] : (defined('SMTP_USERNAME') ? SMTP_USERNAME : null);
if (!$to) {
    echo "Informe um e-mail destinatário válido como primeiro argumento ou configure SMTP_USERNAME em config/smtp_config.php\n";
    exit(1);
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
try {
    // Configurações SMTP (baseadas em config/smtp_config.php)
    $mail->isSMTP();
    $mail->Host = SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    $mail->SMTPSecure = defined('SMTP_ENCRYPTION') ? SMTP_ENCRYPTION : 'tls';
    $mail->Port = defined('SMTP_PORT') ? SMTP_PORT : 587;

    $mail->CharSet = 'UTF-8';
    $mail->setFrom(defined('MAIL_FROM_EMAIL') ? MAIL_FROM_EMAIL : SMTP_USERNAME, defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : 'Reservas');
    $mail->addAddress($to);
    $mail->Subject = 'Teste de envio - Projeto Hotel';
    $mail->isHTML(true);
    $mail->Body = '<p>Esta é uma mensagem de teste enviada por PHPMailer via SMTP.</p>';

    // opções para ambiente local (evita erros com certificados autoassinados)
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ];

    $mail->send();
    echo "E-mail de teste enviado com sucesso para: {$to}\n";
    exit(0);
} catch (Exception $e) {
    echo "Falha ao enviar e-mail: " . $mail->ErrorInfo . "\n";
    // Mensagem do exception para logs
    echo "Detalhe: " . $e->getMessage() . "\n";
    exit(2);
}
