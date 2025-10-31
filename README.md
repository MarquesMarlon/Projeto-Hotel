
# Projeto Hotel

**Sistema de Reservas e Gestão para Hotel / Pousada**

Aplicação web em PHP que permite gerenciar quartos, reservas, usuários e comunicações (contato/newsletter). Fornece uma interface pública para clientes realizarem reservas e um painel administrativo para gerenciar o estabelecimento. Ideal para automatizar a operação de pousadas e pequenos hotéis.

---

## Tecnologias

- PHP
- MySQL / MariaDB
- HTML5
- CSS3
- JavaScript
- Bootstrap
- Composer
- PHPMailer

---

## Requisitos

- PHP 7.4+ (extensão mysqli)
- MySQL / MariaDB
- Composer (se `vendor/` não estiver versionado)
- Servidor web (XAMPP/WAMP) ou PHP built-in server

---

## Rodando o projeto localmente

Siga estes passos para executar em um ambiente de desenvolvimento (Windows + XAMPP recomendado):

1. Clone o repositório ou copie os arquivos para a pasta do servidor (ex.: `C:\xampp\htdocs\projetohotel`).
2. Inicie Apache e MySQL (XAMPP).
3. Crie um banco de dados (sugestão: `projetohotel`).
4. Importe o dump SQL (se fornecido) — ver seção "Banco de dados".
5. Edite `config/conexaobd.php` com as credenciais do banco (host, usuário, senha, nome_do_banco).
6. Edite `config/smtp_config.php` para configurar o envio de e-mails (opcional, mas necessário para notificações por e-mail).
7. Acesse `http://localhost/projetohotel/` no navegador.

Alternativa (PHP built-in server):

```powershell
cd caminho\para\projeto
php -S localhost:8000
```

---

## Estrutura de pastas

- `config/` — configurações (conexão com BD, SMTP).
- `controller/` — processamento de formulários e rotinas (autenticação, processar reservas, processar quartos, etc.).
- `model/` — regras de dados e acesso (quarto, reserva, usuário).
- `view/` — cabeçalho, rodapé e includes usados nas páginas.
- `assets/` — CSS, JS, imagens.
- `tools/` — scripts utilitários (ex.: `test_email.php`).
- `vendor/` — dependências do Composer (PHPMailer).

Arquivos importantes na raiz:

- `index.php`, `contato.php`, `reserva.php`, `quarto.php` — front-end público.
- `admin-login.php`, `area-adm.php`, `*-gerenciar.php` — área administrativa.

O projeto segue um padrão leve inspirado em MVC (models em `model/`, controllers em `controller/` e views em `view/`).

---

## Banco de dados

- Nome sugerido: `projetohotel` (pode ser alterado; lembre-se de atualizar `config/conexaobd.php`).

Importar SQL (exemplos):

Usando phpMyAdmin:

1. Acesse `http://localhost/phpmyadmin`.
2. Crie a base de dados.
3. Vá em "Importar" e selecione o arquivo `.sql` do projeto.

Usando linha de comando (PowerShell):

```powershell
mysql -u SEU_USUARIO -p SEU_BANCO < caminho\para\arquivo.sql
```

Observação: não há um arquivo `.sql` visível no repositório por padrão — caso precise, solicite o dump ao autor ou gere a partir do esquema existente.

Diagrama E-R: se houver, normalmente estará em `docs/` ou `database/`. Caso não encontre, o diagrama não está incluído neste repositório.

---

## Funcionalidades principais

- Reservas online (formulário público).
- CRUD de quartos (gerenciamento de tipos, imagens e disponibilidade).
- CRUD de reservas (visualizar, aprovar, cancelar).
- Gestão de usuários (administradores / usuários do sistema).
- Autenticação para área administrativa.
- Envio de e-mails (confirmação de reserva, contato, newsletter) via PHPMailer.
- Painel administrativo: páginas `*-gerenciar.php` para controlar dados.
- Front-end responsivo com Bootstrap e CSS customizado.

---

## Configurações importantes

- Atualize `config/conexaobd.php` com credenciais do banco.
- Configure `config/smtp_config.php` para habilitar envio de e-mails.
- Se `vendor/` estiver ausente, execute `composer install`.
- Considere usar variáveis de ambiente (`.env`) em produção para credenciais.

---

## Autor

Marlon Marques (MarquesMarlon)

---

## Suporte / melhorias

Posso:

- Gerar um arquivo SQL exemplo com as tabelas básicas (`users`, `rooms`, `reservations`).
- Criar um `README` em inglês ou um `INSTALL.md` com imagens e prints do setup.
- Adicionar um `.env.example` e exemplificar o uso de variáveis de ambiente.

Se quiser que eu gere o dump SQL ou adicione um `.env.example`, diga qual opção prefere.

