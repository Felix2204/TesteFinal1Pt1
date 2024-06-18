<?php
if (isset($_POST['submit'])) {
    if (
        isset($_POST['id']) && !empty($_POST['id']) &&
        isset($_POST['trabalhador']) && !empty($_POST['trabalhador']) &&
        isset($_POST['servico']) && !empty($_POST['servico']) &&
        isset($_POST['preco']) && !empty($_POST['preco']) &&
        isset($_POST['empresa']) && !empty($_POST['empresa'])
    ) {
        require '../conexao.php';

        $id = $_POST['id'];
        $trabalhador = $_POST['trabalhador'];
        $servico = $_POST['servico'];
        $preco = $_POST['preco'];
        $empresa = $_POST['empresa'];

        $sql = "UPDATE servicos SET trabalhador = :trabalhador, servico = :servico, preco = :preco, id_empresa = :empresa WHERE id = :id";
        $resultado = $conn->prepare($sql);
        $resultado->bindValue("id", $id);
        $resultado->bindValue("trabalhador", $trabalhador);
        $resultado->bindValue("servico", $servico);
        $resultado->bindValue("preco", $preco);
        $resultado->bindValue("empresa", $empresa);
        $resultado->execute();

        header("Location: ../index.php?list_servico=$servico&editar=ok"); 
        exit();
    } else {
        header("Location: ../index.php?erro=campos_vazios");
    }

   
} 