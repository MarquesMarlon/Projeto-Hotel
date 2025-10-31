<?php
// Endpoint para envio de newsletter/confirmacao para o e-mail informado pelo frontend
header('Content-Type: application/json; charset=utf-8');

// permite POST JSON
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
$email = $data['email'] ?? null;

if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'error' => 'E-mail inválido']);
    exit;
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/smtp_config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_USERNAME;
    $mail->Password = SMTP_PASSWORD;
    $mail->SMTPSecure = defined('SMTP_ENCRYPTION') ? SMTP_ENCRYPTION : 'tls';
    $mail->Port = defined('SMTP_PORT') ? SMTP_PORT : 587;

    $mail->CharSet = 'UTF-8';
    $mail->setFrom(defined('MAIL_FROM_EMAIL') ? MAIL_FROM_EMAIL : SMTP_USERNAME, defined('MAIL_FROM_NAME') ? MAIL_FROM_NAME : 'Hotel');
    $mail->addAddress($email);
    $mail->Subject = 'Confirmação de inscrição - Newsletter';
    $mail->isHTML(true);
    $mail->Body = '<p>Olá,<br>Obrigado por se inscrever na nossa newsletter. Você receberá novidades e ofertas no seu e-mail.</p>';

    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ];

    $mail->send();
    echo json_encode(['success' => true]);
    exit;
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $mail->ErrorInfo]);
    exit;
}

?>
