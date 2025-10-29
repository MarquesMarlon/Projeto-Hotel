<!-- CADASTRAR NOVA RESERVA -->
<?php
define('ROOT_PATH', __DIR__);
require_once ROOT_PATH . '/config/conexaobd.php';
require_once ROOT_PATH . '/model/reserva.php';

$reserva = new Reserva();

// carregar lista de quartos ativos para o select
$conexao = new Conexao();
$pdo = $conexao->getPdo();
$quartosStmt = $pdo->prepare("SELECT id, nome FROM quartos WHERE ativo = 1 ORDER BY nome ASC");
$quartosStmt->execute();
$quartosList = $quartosStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="assets/css/form.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<title>Cadastrar Nova Reserva</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
	<?php include 'view/header.php'; ?>
	<div class="container_mt-5">
		<h2>Cadastrar Nova Reserva</h2>
		<div class="card">
			<div class="card-body">
				<form id="reservaForm" action="controller/processar_reservas.php" method="POST">
					<input type="hidden" name="action" value="create">

					<div class="mb-3">
						<label for="quarto_id" class="form-label">Quarto *</label>
						<select class="form-control" id="quarto_id" name="quarto_id" required>
							<option value="">Selecione o quarto</option>
							<?php foreach ($quartosList as $q) : ?>
								<option value="<?php echo htmlspecialchars($q['id'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($q['nome'], ENT_QUOTES, 'UTF-8'); ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="mb-3">
						<label for="nome_cliente" class="form-label">Nome Cliente *</label>
						<input type="text" class="form-control" id="nome_cliente" name="nome_cliente" required>
					</div>

					<div class="mb-3 row">
						<div class="col">
							<label for="adultos" class="form-label">Adultos</label>
							<input type="number" class="form-control" id="adultos" name="adultos" min="0" value="1" required>
						</div>
						<div class="col">
							<label for="criancas" class="form-label">Crianças</label>
							<input type="number" class="form-control" id="criancas" name="criancas" min="0" value="0">
						</div>
					</div>

					<div class="mb-3">
						<label for="email" class="form-label">E-mail</label>
						<input type="email" class="form-control" id="email" name="email" required>
					</div>

					<div class="mb-3">
						<label for="cpf" class="form-label">CPF</label>
						<input type="text" class="form-control" id="cpf" name="cpf" maxlength="15"required>
					</div>

					<div class="mb-3">
						<label for="telefone" class="form-label">Telefone</label>
						<input type="text" class="form-control" id="telefone" name="telefone" maxlength="20" required>
					</div>

					<div class="mb-3 row">
						<div class="col">
							<label for="data_checkin" class="form-label">Check-in</label>
							<input type="date" class="form-control" id="data_checkin" name="data_checkin" required>
						</div>
						<div class="col">
							<label for="data_checkout" class="form-label">Check-out</label>
							<input type="date" class="form-control" id="data_checkout" name="data_checkout"required>
						</div>
					</div>

					<div class="mb-3">
						<label for="status" class="form-label">Status</label>
						<select class="form-select" id="status" name="status">
							<option value="confirmada" selected>confirmada</option>
							<option value="cancelada">cancelada</option>
						</select>
					</div>

					<button type="submit" class="btn btn-primary">Cadastrar</button>
					<a href="reservas-gerenciar.php" class="btn btn-secondary">Cancelar</a>
					</form>

					<!-- incluir validações (máscaras e checagens) -->
					<script src="assets/js/validacoes-reserva.js"></script>
					<script>
						document.addEventListener('DOMContentLoaded', function() {
							var form = document.getElementById('reservaForm');
							var cpfInput = document.getElementById('cpf');
							var telInput = document.getElementById('telefone');
							var emailInput = document.getElementById('email');
							var checkin = document.getElementById('data_checkin');
							var checkout = document.getElementById('data_checkout');

							if (cpfInput) {
								cpfInput.addEventListener('input', function(e) {
									e.target.value = mascaraCPF(e.target.value);
								});
							}

							if (telInput) {
								telInput.addEventListener('input', function(e) {
									e.target.value = mascaraTelefone(e.target.value);
								});
							}

							if (!form) return;

							form.addEventListener('submit', function(e) {
								// campos obrigatórios
								var quarto = document.getElementById('quarto_id');
								var nome = document.getElementById('nome_cliente');
								if (!quarto || !quarto.value) {
									alert('Selecione o quarto.');
									e.preventDefault();
									return;
								}

								if (!nome || !nome.value.trim()) {
									alert('Preencha o nome do cliente.');
									e.preventDefault();
									return;
								}

								// email (opcional)
								if (emailInput && emailInput.value && !validarEmail(emailInput.value)) {
									alert('E-mail inválido.');
									e.preventDefault();
									return;
								}

								// telefone (opcional)
								if (telInput && telInput.value && !validarTelefone(telInput.value)) {
									alert('Telefone inválido. Informe DDD + número.');
									e.preventDefault();
									return;
								}

								// datas (se preenchidas)
								if ((checkin && checkin.value) || (checkout && checkout.value)) {
									if (!checkin.value || !checkout.value) {
										alert('Preencha as duas datas: check-in e check-out.');
										e.preventDefault();
										return;
									}
									if (!validarDatas(checkin.value, checkout.value)) {
										e.preventDefault();
										return;
									}
								}
							});
						});
					</script>
			</div>
		</div>
	</div>

	<?php include 'view/footer.php'; ?>
</body>

</html>
