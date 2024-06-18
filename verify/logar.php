<?php

if (isset($_POST['submit'])) {
        if (isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['senha']) && !empty($_POST['senha'])) { 
            
            session_start();
            require '../conexao.php';
            $login = $_POST['login'];
            $senha = $_POST['senha'];

            $sql = "SELECT * FROM usuarios WHERE login = :login AND senha = :senha";
            $resultado = $conn->prepare($sql);
            $resultado -> bindValue("login", $login);
            $resultado -> bindValue("senha", $senha);
            $resultado -> execute();

            if($resultado->rowCount() > 0){
                $dado = $resultado -> fetch();

                $_SESSION['id'] = $dado['id'];
                $_SESSION['user'] = $dado['login'];

               header('Location: ../index.php');
            }else{
                header('location: ../login.php?errado');
            }

        }
    }