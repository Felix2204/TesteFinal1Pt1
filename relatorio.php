<?php
session_start();
require 'conexao.php';
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
}

$sqlCountServicos = "SELECT e.nome_empresa, COUNT(s.id) as total_servicos 
FROM servicos as s 
JOIN empresas as e 
ON s.id_empresa = e.id 
GROUP BY e.nome_empresa";

$resultadoCountServicos = $conn->prepare($sqlCountServicos);
$resultadoCountServicos->execute();
$servicosPorEmpresa = $resultadoCountServicos->fetchAll(PDO::FETCH_ASSOC);

$sqlCountEmpresas = "SELECT COUNT(*) as total_empresas FROM empresas";

$resultadoCountEmpresas = $conn->prepare($sqlCountEmpresas);
$resultadoCountEmpresas->execute();
$totalEmpresas = $resultadoCountEmpresas->fetch(PDO::FETCH_ASSOC);
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

        .card {
            border: none;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1.2rem;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .nav-link {
            transition: background-color 0.3s ease-in-out;
        }

        .nav-link:hover {
            background-color: #333;
        }
    </style>
</head>

<body>
    <div id="sidebar" class="text-white p-3">
        <h2 class="text-center text-white fs-4">ServiceBell</h2>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white" href="#"><i class="bi bi-file-earmark-text-fill me-2"></i>Relatório</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="empresas.php#"><i class="bi bi-building me-2"></i>Empresas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="index.php#"><i class="bi bi-briefcase-fill me-2"></i>Serviço</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="verify/sair.php#"><i class="bi bi-box-arrow-right me-2"></i>Sair</a>
            </li>
        </ul>
    </div>

    <div id="main-content">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Total de Empresas</h5>
                            <p class="card-text"><?php echo $totalEmpresas['total_empresas']; ?></p>
                            <a class="btn btn-black" href="empresas.php">Vizualizar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card text-white bg-secondary">
                        <div class="card-body">
                            <h5 class="card-title">Empresas e Serviços</h5>
                            <?php foreach ($servicosPorEmpresa as $empresaServicos): ?>
                                <p class="card-text"><?php echo $empresaServicos['nome_empresa']; ?>: <?php echo $empresaServicos['total_servicos']; ?> serviços</p>
                            <?php endforeach; ?>
                            <a class="btn btn-primary" href="index.php">Visualizar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
