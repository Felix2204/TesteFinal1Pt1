<?php
session_start();
require 'conexao.php';
if(!isset( $_SESSION['id'])){
    header('Location: login.php');
}

$sql = "SELECT * FROM servicos";
$resultado = $conn->prepare($sql);
$resultado -> execute();
$servicos = $resultado -> fetchAll(PDO::FETCH_ASSOC); 
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="side.css">
  <script src="side.js "></script>
  <style>
    .container {
      margin-top: 50px;
    }
  </style>
</head>
<body>

<div class="container ">
  <div class="row">
    <div class="col-md-6">
      <h1>Seja bem-vindo, <?php echo $_SESSION['user'];?></h1>      
    </div>
    <div class = "col-md-6 3629">
        <a href="verify/sair.php" class="btn btn-danger">Sair da Conta</a>
    </div>
  </div>
 
  <div class="row mt-5">
    <div class="col-md-6">
      <?php
      if(count($servicos) > 0 ){
      ?>
      <h2>Lista de Servisos</h2>
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Empresa</th>
            <th>Trabalhador</th>
            <th>Serviços</th>
            <th>Categoria</th>
            <th>Preço</th>
          </tr>
        </thead>
      <tbody>
        <?php
          foreach($servicos as $servico){
            echo "<tr>";
            echo "<td>" . $servico['id'] . "</td>";
            echo "<td>" . $servico[ 'empresa'] . "</td>";
            echo "<td>" . $servico['trabalhador'] . "</td>";
            echo "<td>" . $servico['serviço'] . "</td>";
            echo "<td>" . $servico['categoria_servico'] . "</td>";
            echo "<td>" . $servico['preco'] . "</td>";
            echo "</tr>";

          }
        ?>
      </tbody>
             
      </table>
      <?php
      }else{
        echo "<h1>Você não tem nenhum serviço cadastrado no momento";
      }
      ?>

    </div>
  </div>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>



