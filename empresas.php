<?php
session_start();
require 'conexao.php';
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$sql = "SELECT * FROM empresas";
$resultado = $conn->prepare($sql);
$resultado->execute();
$empresas = $resultado->fetchAll(PDO::FETCH_ASSOC);
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
    </style>
</head>

<body>
    <div id="sidebar" class="text-white p-3">
        <h2 class="text-center text-white fs-4">ServiceBell</h2>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white" href="relatorio.php"><i class="bi bi-file-earmark-text-fill me-2"></i>Relatório</a>
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
                    <h1 class="text-white">
                        <a href="index.php">Inicio</a>
                    </h1>
                </div>
            </div>
            <button type="button" class="btn btn-primary text-right mt-3" data-bs-toggle="modal" data-bs-target="#insertModal">
                Adicionar Empresa
            </button>

            <div class="container mt-4">
                <div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5 float-end" id="insertModalLabel">Adicionar Empresa</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post" id="serviceForm" data-parsley-validate action="verify/formEmpresas.php">
                                    <div class="mb-3">
                                        <label for="nome" class="form-label">Nome da Empresa<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="telefone" class="form-label">Telefone da Empresa<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="telefone" name="telefone" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="submit" class="btn btn-primary">Salvar</button>
                                    <button type="button" class="btn btn-secondary float-end" data-bs-dismiss="modal">Fechar</button>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <?php if (isset($_GET['deletar'])) { ?>
                    <div class="container mt-5">
                        <div class="alert alert-danger">
                            Empresa <?php echo $_GET["list_empresa"]; ?> Deletada
                        </div>
                    </div>
                <?php } ?>
                <?php if (isset($_GET['erro']) && $_GET['erro'] == "campos_vazios") { ?>
                    <div class="container mt-5">
                        <div class="alert alert-danger">
                            Preencha todos os Campos
                        </div>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['sucesso'])) { ?>
                    <div class="container mt-5">
                        <div class="alert alert-success">
                            Empresa <?php echo $_GET["list_empresa"]; ?> Cadastrada
                        </div>
                    </div>
                <?php } ?>
                <?php if (isset($_GET['editar'])) { ?>
                    <div class="container mt-5">
                        <div class="alert alert-success">
                            Empresa <?php echo $_GET["list_empresa"]; ?> Editada
                        </div>
                    </div>
                <?php } ?>
                <?php if (isset($_GET['erro']) && $_GET['erro']=="nome-existe") { ?>
                    <div class="container mt-5">
                        <div class="alert alert-danger">
                            Nome <?php echo $_GET["list_empresa"]; ?> já existe
                        </div>
                    </div>
                <?php } ?>
                <?php if (isset($_GET['erro']) && $_GET['erro']=="telefone-existe") { ?>
                    <div class="container mt-5">
                        <div class="alert alert-danger">
                            Telefone <?php echo $_GET["telefone"]; ?> já existe
                        </div>
                    </div>
                <?php } ?>

                <div class="table-container mt-5">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <?php if (count($empresas) > 0) { ?>
                                    <h2>Lista de Empresas</h2>
                                </div>
                                <table class="table table-striped table-hover text-center">
                                    <div class="card-body">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Empresa</th>
                                                <th>Telefone</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($empresas as $empresa) { ?>
                                                <tr>
                                                    <td><?php echo $empresa['id']; ?></td>
                                                    <td><?php echo $empresa['nome_empresa']; ?></td>
                                                    <td><?php echo $empresa['telefone']; ?></td>
                                                    <td>
                                                        <button class='btn btn-primary' data-bs-toggle="modal" data-bs-target="#editModal<?php echo $empresa['id']; ?>">Editar</button>
                                                        <button class='btn btn-danger' data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $empresa['id']; ?>">Deletar</button>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="deleteModal<?php echo $empresa['id']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $empresa['id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="editModalLabel<?php echo $empresa['id']; ?>">
                                                                    Deletar Empresa <?php echo $empresa['nome_empresa']; ?>
                                                                </h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method='post' action='verify/deletarEmpresas.php' class='d-inline'>
                                                                    <input type='hidden' name='id' value='<?php echo $empresa['id']; ?>' />
                                                                    <input type='hidden' name='nome_empresa' value='<?php echo $empresa['nome_empresa']; ?>' />
                                                            </div>
                                                            <div class="modal-footer">
                                                                    <button class='btn btn-danger' type='submit'>Deletar</button>
                                                                </form>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="editModal<?php echo $empresa['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $empresa['id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="editModalLabel<?php echo $empresa['id']; ?>">
                                                                    Editar Empresa
                                                                </h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post" action="verify/editarEmpresa.php">
                                                                    <input type="hidden" name="id" value="<?php echo $empresa['id']; ?>">
                                                                    <div class="mb-3">
                                                                        <label for="nome_empresa" class="form-label">Nome da Empresa<span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control" id="nome_empresa" name="nome_empresa" value="<?php echo $empresa['nome_empresa']; ?>" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="telefone" class="form-label">Telefone da Empresa<span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo $empresa['telefone']; ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                                                    <button type="submit" name="submit" class="btn btn-primary">Editar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </tbody>
                                    </div>
                                </table>
                            <?php } else { ?>
                                <h1>Você não tem nenhuma Empresa cadastrada no momento</h1>
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
</body>

</html>
