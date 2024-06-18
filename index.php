<?php
session_start();
require 'conexao.php';
if (!isset($_SESSION['id'])) {
  header('Location: login.php');
}

// Consulta SQL com JOIN para incluir a coluna 'nome_empresa'
$sqlJoin = "SELECT s.id, s.trabalhador, s.servico, s.preco, e.nome_empresa as empresa 
FROM servicos as s 
JOIN empresas as e 
ON s.id_empresa = e.id";

$resultado = $conn->prepare($sqlJoin);
$resultado->execute();
$servicos = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="side.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="side.js"></script>
  <style>
    body {
      background-color: #272727;
    }

    #sidebar {
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      width: 250px;
      background-color: #1a1a1a;
      padding-top: 20px;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 1);
    }

    #main-content {
      margin-left: 250px;
      padding: 20px;
    }

      .table-container {
        max-width: 1000px;
        margin: auto;
      }

      @media (max-width: 768px) {
        #sidebar {
          width: 100%;
          height: auto;
          position: relative;
        }

        #main-content {
          margin-left: 0;
        }
      }
  </style>
</head>

<body>
  <div id="sidebar" class="text-white p-3">
    <h2 class="text-center text-white fs-4">ServiceBell</h2>
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link text-white" href="relatorio.php"><i
            class="bi bi-file-earmark-text-fill me-2"></i>Relatório</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="empresas.php"><i class="bi bi-building me-2"></i>Empresas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="index.php"><i class="bi bi-briefcase-fill me-2"></i>Serviço</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="verify/sair.php"><i class="bi bi-box-arrow-right me-2"></i>Sair</a>
      </li>
    </ul>
  </div>

  <div id="main-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <h1 class="text-white">Seja bem-vindo, <?php echo $_SESSION['user']; ?></h1>
        </div>
      </div>
      <button type="button" class="btn btn-primary text-right mt-3" data-bs-toggle="modal"
        data-bs-target="#insertModal">
        Adicionar Serviço
      </button>

      <div class="container mt-4">
        <div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5 float-end" id="insertModalLabel">Adicionar Serviço</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method="post" id="serviceForm" data-parsley-validate action="verify/formServico.php">
                  <div class="mb-3">
                    <label for="trabalhador" class="form-label">Trabalhador<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="trabalhador" name="trabalhador" required>
                  </div>
                  <div class="mb-3">
                    <label for="servico" class="form-label">Serviço<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="servico" name="servico" required>
                  </div>
                  <div class="mb-3">
                    <label for="preco" class="form-label">Preço<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="preco" name="preco" required>
                  </div>
                  <div class="mb-3">
                    <label for="empresa" class="form-label">Empresa<span class="text-danger">*</span></label>
                    <select name="empresa" id="empresa" class="form-select" required>
                      <option value="">Selecione</option>
                      <?php
                      $sql = "SELECT * FROM empresas";
                      $resultado = $conn->prepare($sql);
                      $resultado->execute();
                      $empresas = $resultado->fetchAll(PDO::FETCH_ASSOC);
                      foreach ($empresas as $empresa) {
                        echo '<option value="' . $empresa['id'] . '">' . $empresa['nome_empresa'] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <button value="inserir" type="submit" name="submit" class="btn btn-primary">Salvar</button>
                  <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Fechar</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>


      <?php if (isset($_GET['deletar'])) { ?>
        <div class="container mt-5">
          <div class="alert alert-danger">
            Serviço de <?php echo $_GET["list_servico"]; ?> Deletado
          </div>
        </div>
      <?php } ?>

      <?php if (isset($_GET['sucesso'])) { ?>
        <div class="container mt-5">
          <div class="alert alert-success">
            Serviço de <?php echo $_GET["list_servico"]; ?> Cadastrado
          </div>
        </div>
      <?php } ?>

      <div class="table-container mt-5">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-header">
              <?php if (count($servicos) > 0) { ?>
                <h2>Lista de Serviços</h2>
              </div>
              <table class="table table-striped table-hover text-center">
                <div class="card-body">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Trabalhador</th>
                      <th>Serviço</th>
                      <th>Preço</th>
                      <th>Empresa</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($servicos as $servico) { ?>
                      <tr>
                        <td><?php echo $servico['id']; ?></td>
                        <td><?php echo $servico['trabalhador']; ?></td>
                        <td><?php echo $servico['servico']; ?></td>
                        <td><?php echo $servico['preco']; ?></td>
                        <td><?php echo $servico['empresa']; ?></td>
                        <td>
                          <form method='post' action='verify/deletar.php' class='d-inline'>
                            <input type='hidden' name='id' value='<?php echo $servico['id']; ?>' />
                            <input type='hidden' name='servico' value='<?php echo $servico['servico']; ?>' />
                            <button class='btn btn-danger' type='submit'>Deletar</button>
                          </form>
                          <button class='btn btn-primary' data-bs-toggle="modal"
                            data-bs-target="#editModal<?php echo $servico['id']; ?>">Editar</button>
                        </td>
                      </tr>

                      <div class="modal fade" id="editModal<?php echo $servico['id']; ?>" tabindex="-1"
                        aria-labelledby="editModalLabel<?php echo $servico['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="editModalLabel<?php echo $servico['id']; ?>">
                                Editar Serviço
                              </h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <form method="post" action="verify/editarServico.php">
                                <input type="hidden" name="id" value="<?php echo $servico['id']; ?>">
                                <div class="mb-3">
                                  <label for="trabalhador" class="form-label">Trabalhador<span
                                      class="text-danger">*</span></label>
                                  <input type="text" class="form-control" id="trabalhador" name="trabalhador"
                                    value="<?php echo $servico['trabalhador']; ?>" required>
                                </div>
                                <div class="mb-3">
                                  <label for="servico" class="form-label">Serviço<span class="text-danger">*</span></label>
                                  <input type="text" class="form-control" id="servico" name="servico"
                                    value="<?php echo $servico['servico']; ?>" required>
                                </div>
                                <div class="mb-3">
                                  <label for="preco" class="form-label">Preço<span class="text-danger">*</span></label>
                                  <input type="text" class="form-control" id="preco" name="preco"
                                    value="<?php echo $servico['preco']; ?>" required>
                                </div>
                                <div class="mb-3">
                                  <label for="empresa" class="form-label">Empresa<span class="text-danger">*</span></label>
                                  <select name="empresa" id="empresa" class="form-select" required>
                                    <option value="">Selecione</option>
                                    <?php
                                    $sql = "SELECT * FROM empresas";
                                    $resultado = $conn->prepare($sql);
                                    $resultado->execute();
                                    $empresas = $resultado->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($empresas as $empresa) {
                                      echo '<option value="' . $empresa['id'] . '">' . $empresa['nome_empresa'] . '</option>';
                                    }
                                    ?>
                                  </select>
                                </div>
                                <button value="inserir" type="submit" name="submit" class="btn btn-primary">Salvar</button>
                                <button type="button" class="btn btn-secondary float-end"
                                  data-bs-dismiss="modal">Fechar</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                <?php } ?>
                </tbody>
            </div>
            </table>
          <?php } else { ?>
            <h1>Você não tem nenhum serviço cadastrado no momento</h1>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>

  <script src="./node_modules/jquery/dist/jquery.js"></script>
  <script src="./node_modules/parsleyjs/dist/parsley.min.js"></script>
  <link rel="stylesheet" href="node_modules/parsleyjs/src/parsley.css">
  <script src="./node_modules/parsleyjs/dist/i18n/pt-br.js"></script>
  </div>
</body>

</html>