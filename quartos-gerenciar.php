<!-- GERENCIAR QUARTOS-->

<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="assets/css/correcao-modal.css">
   <title>Gerenciar Quartos</title>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
   <script src="assets/js/editar-quarto.js"></script>
</head>

<?php
require_once 'config/conexaobd.php'
?>

<body class="mt-5">
   <?php include 'view/header.php'; ?>

   <div class="container mt-5">
      <div class="row">
         <h2 class="col-sm text-start">Gerenciar Quartos</h2>
         <div class="col-sm text-end">
            <a href="quarto.php" class="btn btn-success mb-3"> Novo Quarto </a>
         </div>
      </div>
   </div>

   <div class="container mt-3 shadow border rounded p-3 ">

      <table class="table table-striped">
         <thead>
            <tr>
               <th>ID</th>
               <th>Número</th>
               <th>Tipo</th>
               <th>Preço</th>
               <th>Status</th>
               <th>Ações</th>
            </tr>
         </thead>
         <tbody>
            <?php
            function traduzStatus($ativo)
            {
               return $ativo ? "<span class='badge bg-success'>Ativo</span>" : "<span class='badge  bg-danger'>Inativo</span>";
               //importante para traduzir campo booleano, ativo/inativo
            }

            ?>
            <?php
            $conexao = new Conexao();
            $pdo = $conexao->getPdo();

            $sql = "SELECT * FROM quartos";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
               while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  echo "<tr>";
                  echo "<td>" . $row['id'] . "</td>";
                  echo "<td>" . $row['numero'] . "</td>";
                  echo "<td>" . $row['tipo'] . "</td>";
                  echo "<td>R$ " . number_format($row['preco'], 2, ',', '.') . "</td>";
                  echo "<td>" . traduzStatus($row['ativo']) . "</td>";
                  $dataNumero = htmlspecialchars($row['numero'], ENT_QUOTES);
                  $dataTipo = htmlspecialchars($row['tipo'], ENT_QUOTES);
                  $dataPreco = htmlspecialchars($row['preco'], ENT_QUOTES);
                  $dataAtivo = htmlspecialchars($row['ativo'], ENT_QUOTES);
                  echo "<td>
                                 <button type='button' class='btn btn-primary btn-sm edit-btn' data-bs-toggle='modal' data-bs-target='#editModal' data-id='{$row['id']}' data-numero='{$dataNumero}' data-tipo='{$dataTipo}' data-preco='{$dataPreco}' data-ativo='{$dataAtivo}'> Editar </button>
                                 <button type='button' onclick=\"if(confirm('Tem certeza que deseja excluir o quarto número {$row['numero']}?')){ window.location.href='controller/processar_quartos.php?action=delete&id={$row['id']}'; }\" class='btn btn-danger btn-sm'>Excluir</button>
                               
                              </td>";
                  echo "</tr>";
               }
            } else {
               echo "<tr><td colspan='6' class='text-center'>Nenhum quarto cadastrado.</td></tr>";
            }
            ?>
         </tbody>
      </table>
   </div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
   </script>

   <!-- MODAL AJAX  -->
   <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="editModalLabel">Editar Quarto</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form id="editForm" method="post" action="controller/processar_quartos.php">
                  <input type="hidden" id="edit-id" name="id">
                  <input type="hidden" name="action" value="update">
                  <div class="mb-3">
                     <label for="edit-numero" class="form-label"><b>Número</b></label>
                     <input type="number" class="form-control" id="edit-numero" name="numero" required>
                  </div>
                  <div class="mb-3">
                     <label for="edit-tipo" class="form-label"><b>Tipo</b></label>
                     <select class="form-control" id="edit-tipo" name="tipo" required>
                        <option value="Standard">Standard</option>
                        <option value="Luxo">Luxo</option>
                        <option value="Suíte">Suíte</option>
                     </select>
                  </div>
                  <!-- quero colocar select aqui -->


                  <div class="mb-3">
                     <label for="edit-preco" class="form-label"><b>Preço</b></label>
                     <input type="text" class="form-control" id="edit-preco" name="preco" required>
                  </div>
                  <div class="mb-3">
                     <label class="form-label"><b>Status</b></label>
                     <select class="form-select" id="edit-ativo" name="ativo">
                        <option value="1">Ativo</option>
                        <option value="0">Inativo</option>
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