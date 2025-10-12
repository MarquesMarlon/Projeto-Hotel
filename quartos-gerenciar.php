<!-- Gerenciar quartos -->

<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Gerenciar Quartos</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<?php 
define('ROOT_PATH', __DIR__ ); 
require_once ROOT_PATH . '/config/conexaobd.php';

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
             $sql = "SELECT * FROM quartos";
            $stmt = $this->prepare($sql);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
               while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  echo "<tr>";
                  echo "<td>" . $row['id'] . "</td>";
                  echo "<td>" . $row['numero'] . "</td>";
                  echo "<td>" . $row['tipo'] . "</td>";
                  echo "<td>R$ " . number_format($row['preco'], 2, ',', '.') . "</td>";
                  echo "<td>" . $row['status'] . "</td>";
                  echo "<td>
                      <a href='editar_quarto.php?id={$row['id']}' class='btn btn-primary btn-sm'>Editar</a>
                      <a href='excluir_quarto.php?id={$row['id']}' class='btn btn-danger btn-sm'>Excluir</a>
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
</body>
</html>
<?php 
include 'view/footer.php';  
?>

