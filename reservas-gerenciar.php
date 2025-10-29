<!-- GERENCIAR RESERVAS -->

<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="assets/css/correcao-modal.css">
   <title>Gerenciar Reservas</title>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<?php
require_once 'config/conexaobd.php'
?>

<body class="mt-5">
   <?php include 'view/header.php'; ?>

   <div class="container mt-5">
      <div class="row">
         <h2 class="col-sm text-start"><i>Área Administrativa</i> | Gerenciar Reservas</h2>
         <div class="col-sm text-end">
            <a href="quartos-gerenciar.php" class="btn btn-primary me-3 "> Gerenciar Quartos </a>
            <a href="reserva.php" class="btn btn-success "> Nova Reserva </a>
         </div>
      </div>
   </div>

   <div class="container mt-3 shadow border rounded p-1">

      <table class="table table-striped table-hover table-bordered">
         <thead>
            <tr>
               <th>ID</th>
               <th>Quarto</th>
               <th>N° Quarto</th>
               <th>Nome Cliente</th>
               <th>Check in</th>
               <th>Check out</th>
               <th>Adultos</th>
               <th>Crianças</th>
               <th>Status</th>
               <th>Telefone</th>
               <th>CPF</th>
               <th>e-mail</th>
               <th>Ações</th>
            </tr>
         </thead>
         <tbody>
            <?php
            $conexao = new Conexao();
            $pdo = $conexao->getPdo();

            // carregar lista de quartos ativos para o modal (select)
            $quartosStmt = $pdo->prepare("SELECT id, nome FROM quartos WHERE ativo = 1 ORDER BY nome ASC");
            $quartosStmt->execute();
            $quartosList = $quartosStmt->fetchAll(PDO::FETCH_ASSOC);

            // buscar reservas com dados do quarto (nome e número) via JOIN
            $sql = "SELECT r.*, q.nome AS quarto_nome, q.numero AS quarto_numero FROM reservas r LEFT JOIN quartos q ON r.quarto_id = q.id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
               while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  echo "<tr>";
                  echo "<td>" . $row['id'] . "</td>";
                  // nome do quarto (vindo da tabela quartos)
                  echo "<td>" . htmlspecialchars($row['quarto_nome'] ?? '', ENT_QUOTES, 'UTF-8') . "</td>";
                  // número do quarto (fallback para quarto_id caso não exista)
                  $numeroQuarto = isset($row['quarto_numero']) && $row['quarto_numero'] !== null ? $row['quarto_numero'] : $row['quarto_id'];
                  echo "<td>" . htmlspecialchars($numeroQuarto, ENT_QUOTES, 'UTF-8') . "</td>";
                  echo "<td>" . htmlspecialchars($row['nome_cliente'], ENT_QUOTES, 'UTF-8') . "</td>";
                  $checkin = '';
                  if (!empty($row['data_checkin']) && $row['data_checkin'] !== '0000-00-00') {
                     $dt = strtotime($row['data_checkin']);
                     if ($dt !== false) {
                        $checkin = date('d/m/Y', $dt);
                     }
                  }
                  echo "<td>" . htmlspecialchars($checkin, ENT_QUOTES, 'UTF-8') . "</td>";
                  echo "<td>" . $row['data_checkout'] . "</td>";
                  echo "<td>" . $row['adultos'] . "</td>";
                  echo "<td>" . $row['criancas'] . "</td>";
                  echo "<td>" . $row['status'] . "</td>";
                  echo "<td>" . $row['telefone'] . "</td>";
                  echo "<td>" . $row['cpf'] . "</td>";
                  echo "<td>" . htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') . "</td>";

                  // botão editar com atributos data-* para popular o modal
                  $dataAttr = '';
                  $dataAttr .= " data-id='" . $row['id'] . "'";
                  $dataAttr .= " data-quarto='" . htmlspecialchars($row['quarto_id'], ENT_QUOTES, 'UTF-8') . "'";
                  $dataAttr .= " data-nome='" . htmlspecialchars($row['nome_cliente'], ENT_QUOTES, 'UTF-8') . "'";
                  $dataAttr .= " data-adultos='" . htmlspecialchars($row['adultos'], ENT_QUOTES, 'UTF-8') . "'";
                  $dataAttr .= " data-criancas='" . htmlspecialchars($row['criancas'], ENT_QUOTES, 'UTF-8') . "'";
                  $dataAttr .= " data-status='" . htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8') . "'";
                  $dataAttr .= " data-telefone='" . htmlspecialchars($row['telefone'], ENT_QUOTES, 'UTF-8') . "'";
                  $dataAttr .= " data-cpf='" . htmlspecialchars($row['cpf'], ENT_QUOTES, 'UTF-8') . "'";
                  $dataAttr .= " data-email='" . htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8') . "'";
                  $dataAttr .= " data-checkin='" . htmlspecialchars($row['data_checkin'], ENT_QUOTES, 'UTF-8') . "'";
                  $dataAttr .= " data-checkout='" . htmlspecialchars($row['data_checkout'], ENT_QUOTES, 'UTF-8') . "'";

                  echo "<td>
                                 <button type='button' class='btn btn-primary btn-sm edit-btn' data-bs-toggle='modal' data-bs-target='#editReserva' $dataAttr> Editar </button>
                                 <button type='button' onclick=\"if(confirm('Tem certeza que deseja excluir a reserva ID {$row['id']} do cliente {$row['nome_cliente']}?')){ window.location.href='controller/processar_reservas.php?action=delete&id={$row['id']}'; }\" class='btn btn-danger btn-sm'>Excluir</button>
                              </td>";
                  echo "</tr>";
               }
            } else {
               echo "<tr><td colspan='13' class='text-center'>Nenhuma reserva cadastrada.</td></tr>";
            }
            ?>

         </tbody>
      </table>
   </div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
   </script>
   <script src="assets/js/validacoes-reserva.js"></script>
   <script src="assets/js/editar-reserva.js"></script>

   <!-- MODAL AJAX  -->
   <div class="modal fade" id="editReserva" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="editModalLabel">Editar Reserva</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="editForm" method="post" action="controller/processar_reservas.php">
                  <input type="hidden" id="edit-id" name="id">
                  <input type="hidden" name="action" value="update">

                  <div class="mb-3">
                     <label for="edit-quarto" class="form-label"><b>Quarto</b></label>
                     <select class="form-control" id="edit-quarto" name="quarto_id" required>
                        <option value="">Selecione o quarto</option>
                        <?php foreach ($quartosList as $q) : ?>
                           <option value="<?php echo htmlspecialchars($q['id'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($q['nome'], ENT_QUOTES, 'UTF-8'); ?></option>
                        <?php endforeach; ?>
                     </select>
                  </div>
                  <div class="mb-3">
                     <label for="edit-nome" class="form-label"><b>Nome Cliente</b></label>
                     <input type="text" class="form-control" id="edit-nome" name="nome_cliente" required>
                  </div>
                  <div class="mb-3 row">
                     <div class="col">
                        <label for="edit-adultos" class="form-label"><b>Adultos</b></label>
                        <input type="number" class="form-control" id="edit-adultos" name="adultos" min="0" required>
                     </div>
                     <div class="col">
                        <label for="edit-criancas" class="form-label"><b>Crianças</b></label>
                        <input type="number" class="form-control" id="edit-criancas" name="criancas" min="0" required>
                     </div>
                  </div>
                  <div class="mb-3">
                     <label for="edit-email" class="form-label"><b>E-mail</b></label>
                     <input type="email" class="form-control" id="edit-email" name="email">
                  </div>
                  <div class="mb-3">
                     <label for="edit-cpf" class="form-label"><b>CPF</b></label>
                     <input type="text" class="form-control" id="edit-cpf" name="cpf" maxlength="15">
                  </div>
                  <div class="mb-3">
                     <label for="edit-telefone" class="form-label"><b>Telefone</b></label>
                     <input type="text" class="form-control" id="edit-telefone" name="telefone" maxlength="20">
                  </div>
                  <div class="mb-3 row">
                     <div class="col">
                        <label for="edit-checkin" class="form-label"><b>Check-in</b></label>
                        <input type="date" class="form-control" id="edit-checkin" name="data_checkin">
                     </div>
                     <div class="col">
                        <label for="edit-checkout" class="form-label"><b>Check-out</b></label>
                        <input type="date" class="form-control" id="edit-checkout" name="data_checkout">
                     </div>
                  </div>
                  <div class="mb-3">
                     <label class="form-label"><b>Status</b></label>
                     <select class="form-select" id="edit-status" name="status">
                        <option value="confirmada">confirmada</option>
                        <option value="cancelada">cancelada</option>
                     </select>
                  </div>
               </form>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
               <button type="button" class="btn btn-primary" id="saveChangesBtn">Salvar Alterações</button>
            </div>
         </div>
      </div>
   </div>
   <?php include 'view/footer.php'; ?>
</body>

</html