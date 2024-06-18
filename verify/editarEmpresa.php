<?php
if (isset($_POST['submit'])) {
    if (
        isset($_POST['id']) && !empty($_POST['id']) &&
        isset($_POST['nome_empresa']) && !empty($_POST['nome_empresa']) &&
        isset($_POST['telefone']) && !empty($_POST['telefone'])
    ) {
        require '../conexao.php';

        $id = $_POST['id'];
        $empresa = $_POST['nome_empresa'];
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

        $sql = "UPDATE empresas SET nome_empresa = :nome_empresa, telefone = :telefone WHERE id = :id";
        $resultado = $conn->prepare($sql);
        $resultado->bindValue("id", $id);
        $resultado->bindValue("nome_empresa", $empresa);
        $resultado->bindValue("telefone", $telefone);
        $resultado->execute();

        header("Location: ../empresas.php?list_empresa=$empresa&editar=ok");
        exit();
    } else {
        header("Location: ../empresas.php?erro=campos_vazios");
    }


}
