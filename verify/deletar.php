<?php 
    if(isset($_POST["id"])){

        require '../conexao.php';
        $servico= $_POST['servico'];
        $id = $_POST["id"];

        $sql = "DELETE FROM servicos WHERE id = :id";
        $resultado = $conn->prepare($sql);
        $resultado->bindValue(":id", $id);
        $resultado->execute();
        
        header("Location: ../index.php?list_servico=$servico&deletar=ok");
        
        exit();
    }
