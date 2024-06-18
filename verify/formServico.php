<?php
if (isset($_POST['submit'])) {
    if (
        
        isset($_POST['trabalhador']) && !empty($_POST['trabalhador']) &&
        isset($_POST['servico']) && !empty($_POST['servico']) &&
        isset($_POST['preco']) && !empty($_POST['preco']) &&
        isset($_POST['empresa']) && !empty($_POST['empresa'])
        ) {
        require '../conexao.php';

        $trabalhador = $_POST['trabalhador'];
        $servico = $_POST['servico'];
        $preco = $_POST['preco'];
        $empresa = $_POST['empresa'];
        
        $sql = "INSERT INTO servicos(trabalhador,servico,preco,id_empresa) VALUES (:trabalhador,:servico,:preco,:empresa)";
        $resultado = $conn->prepare($sql);
        $resultado -> bindValue("trabalhador", $trabalhador);
        $resultado -> bindValue("servico", $servico);
        $resultado -> bindValue("preco", $preco);
        $resultado -> bindValue("empresa", $empresa);
        $resultado -> execute();
        header("Location: ../index.php?list_servico=$servico&sucesso=ok");

        exit();
    }
}