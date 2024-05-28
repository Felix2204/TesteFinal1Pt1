<?php
    if (isset($_POST['submit'])) {
        if (isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['senha']) && !empty($_POST['senha'])) {
            require '../conexao.php';
            $login = $_POST['login'];
            $senha = $_POST['senha'];

            $sql = "INSERT INTO usuarios(login,senha) VALUES (:login,:senha)";
            $resultado = $conn->prepare($sql);
            $resultado -> bindValue("login", $login);
            $resultado -> bindValue("senha", $senha);
            $resultado -> execute();
            header('Location: ../login.php');
        }
    }