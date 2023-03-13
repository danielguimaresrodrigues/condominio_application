<?php
session_start();
include('../db/conexao.php');

$id = $_SESSION['id'];
$email = mysqli_real_escape_string($conexao, trim($_POST['email']));
$senhatual = mysqli_real_escape_string($conexao, trim($_POST['senhaatual']));
$senha = mysqli_real_escape_string($conexao, trim($_POST['senha']));
$repsenha = mysqli_real_escape_string($conexao, trim($_POST['repsenha']));

if ($senha != $repsenha) {
    $_SESSION['nao_confere'] = false;
    header('Location: ../cadastros/accountpasswordchange');
    mysqli_close($conexao);
    $_SESSION['senhaatual'] = $senhatual;
    $_SESSION['senha'] = $senha;
    $_SESSION['repsenha'] = $repsenha;
    exit();
}

$hash = password_hash($senha, PASSWORD_DEFAULT);


$query = "SELECT * FROM login WHERE id = '$id'";

$result = mysqli_query($conexao, $query);

$row = mysqli_num_rows($result);
$conf = mysqli_fetch_assoc($result);

if ($row == 1) {

    if (password_verify($senhatual, $conf['senha'])) {
        $sql_edit = "UPDATE login SET senha='$hash',updated_at=NOW()
	        WHERE id = '$id'";
        /*$resultado = mysqli_query($conexao, $sql_edit);*/

        if ($conexao->query($sql_edit) === true) {
            $_SESSION['nao_altersen'] = false;
            header('Location: ../dashboards/painel');
            mysqli_close($conexao);
            exit();
        }
    } else {
        $_SESSION['nao_altersen'] = true;
        header('Location: ../cadastros/accountpasswordchange');
        mysqli_close($conexao);
        exit();
    }
}
