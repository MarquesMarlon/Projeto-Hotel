# Projeto-Hotel
Projeto de Capacitação Tecnologia - Essentia

## Envio de E-mails (SMTP) - Configuração rápida

Este projeto usa o PHPMailer para enviar e-mails de confirmação de reserva via SMTP. Existe também um fallback para a função nativa `mail()` caso o PHPMailer ou a configuração não estejam disponíveis.

Arquivos importantes:
- `config/smtp_config.php` - arquivo onde você deve colocar as constantes de configuração SMTP (host, usuário, senha, porta, criptografia, remetente).
- `vendor/` - dependências do Composer (PHPMailer está instalado aqui).
- `model/salvar-reserva.php` - código que envia o e-mail após salvar a reserva (usa PHPMailer se disponível).
- `tools/test_email.php` - script CLI para testar o envio de e-mail rapidamente.

Passos para configurar (Windows + XAMPP):

1. Instale dependências via Composer (se ainda não fez):

	Abra o PowerShell na pasta do projeto e rode:

	```powershell
	composer install
	```

2. Crie/edite o arquivo `config/smtp_config.php` com suas credenciais SMTP.
	Exemplo (Gmail) — NÃO comite suas credenciais no repositório:

	```php
	<?php
	define('SMTP_HOST', 'smtp.gmail.com');
	define('SMTP_USERNAME', 'seu-email@gmail.com');
	define('SMTP_PASSWORD', 'SENHA_DE_APP_DO_GMAIL');
	define('SMTP_PORT', 587);
	define('SMTP_ENCRYPTION', 'tls');

	define('MAIL_FROM_EMAIL', 'reservas@seudominio.com');
	define('MAIL_FROM_NAME', 'Nome do Hotel');
	```

	Observação: para enviar pelo Gmail, em geral você precisa ativar a autenticação em 2 passos na conta e criar uma Senha de App (App Password) para usar como `SMTP_PASSWORD`.

3. Habilite extensões do PHP necessárias no `php.ini` (XAMPP):
	- `extension=openssl` (necessário para TLS/SSL)
	- `extension=mbstring` (recomendado para charset UTF-8)

	Depois de alterar `php.ini`, reinicie o Apache no painel do XAMPP.

4. Testar o envio de e-mail (rápido):

	No PowerShell (a partir da raiz do projeto) rode:

	```powershell
	php .\tools\test_email.php seu-email@dominio.com
	```

	A saída indicará se o envio foi bem-sucedido ou qual erro ocorreu (mensagem do PHPMailer).

5. Uso no sistema de reservas
	- Quando uma reserva for salva via `model/salvar-reserva.php`, o código tentará usar PHPMailer/SMTP (config em `config/smtp_config.php`).
	- Se PHPMailer ou a config não estiverem disponíveis, o código tenta um fallback para `mail()`.
	- A resposta JSON retornada ao frontend incluirá uma mensagem informando se o e-mail foi enviado com sucesso ou não.

Boas práticas
- Não deixe credenciais em arquivos versionados. Use uma cópia local de `config/smtp_config.php` e exclua do VCS (adicione ao `.gitignore`).
- Em produção, prefira variáveis de ambiente ou um cofre de segredos para armazenar as credenciais.
- Verifique os logs do PHP/Apache (`error_log`) se houver falhas — o código já grava mensagens de log para diagnóstico.

Se quiser, posso adicionar um `.env.example` e ajustar o carregamento de configurações para usar variáveis de ambiente (mais seguro em produção).
