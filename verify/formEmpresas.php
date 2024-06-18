<?php
if (isset($_POST['submit'])) {
    if (
        isset($_POST['nome']) && !empty($_POST['nome']) &&
        isset($_POST['telefone']) && !empty($_POST['telefone'])) {
        require '../conexao.php';

        $empresa = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $sql = "SELECT nome_empresa FROM empresas WHERE nome_empresa = :nome";
        $resultado = $conn->prepare($sql);
        $resultado->bindValue(":nome", $empresa);
        $resultado->execute();
        if ($resultado->rowCount() > 0) {
            header("Location: ../empresas.php?list_empresa=$empresa&erro=nome-existe");
        }
        $sql = "SELECT telefone FROM empresas WHERE telefone = :telefone";
        $resultado = $conn->prepare($sql);
        $resultado->bindValue(":telefone", $telefone);
        $resultado->execute();
        if ($resultado->rowCount() > 0) {
            header("Location: ../empresas.php?telefone=$telefone&erro=telefone-existe");
        }
        $sql = "INSERT INTO empresas(nome_empresa, telefone) VALUES (:nome_empresa, :telefone)";
        $resultado = $conn->prepare($sql);
        $resultado -> bindValue("nome_empresa", $empresa);
        $resultado -> bindValue("telefone", $telefone);
        $resultado -> execute();
        header("Location: ../empresas.php?list_empresa=$empresa&sucesso=ok");

        exit();
    }else{
        header("Location: ../empresas.php?erro=campos_vazios");
    }
} 