<?php 
    if(isset($_POST["id"])){

        require '../conexao.php';
        $empresa= $_POST['nome_empresa'];
        $id = $_POST["id"];

        $sql = "DELETE FROM empresas WHERE id = :id";
        $resultado = $conn->prepare($sql);
        $resultado->bindValue(":id", $id);
        $resultado->execute();
        
        header("Location: ../empresas.php?list_empresa=$empresa&deletar=ok");
        
        exit();
    }
    
    