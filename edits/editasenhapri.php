<?php
session_start();
include('../db/conexao.php');

$email = mysqli_real_escape_string($conexao, trim($_POST['email']));
$senhatual = mysqli_real_escape_string($conexao, trim($_POST['senha']));
$senha = mysqli_real_escape_string($conexao, trim($_POST['senhanova']));

$hash = password_hash($senha, PASSWORD_DEFAULT);

$query = "SELECT * FROM login WHERE email = '$email'";

$result = mysqli_query($conexao, $query);

$row = mysqli_num_rows($result);
$conf = mysqli_fetch_assoc($result);

if ($row == 1) {

    if (password_verify($senhatual, $conf['senha'])) {
        $sql_edit = "UPDATE login SET senha='$hash',updated_at=NOW()
	        WHERE email = '$email'";
        /*$resultado = mysqli_query($conexao, $sql_edit);*/

        if ($conexao->query($sql_edit) === true) {
            $_SESSION['nao_altersenpri'] = false;
            header('Location: ../');
            mysqli_close($conexao);
            exit();
        }
    } else {
        $_SESSION['nao_altersenpri'] = true;
        header('Location: ../cadastros/primeiroacesso');
        mysqli_close($conexao);
        exit();
    }
} else {
    $_SESSION['nao_encontrou'] = true;
    header('Location: ../cadastros/primeiroacesso');
    mysqli_close($conexao);
    exit();
}
