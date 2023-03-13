<?php
session_start();
include('conexao.php');

/*$_SESSION['IP_User'] = $_SERVER['REMOTE_ADDR'];*/

$usuario = mysqli_real_escape_string($conexao, $_POST['email']);
$senha = mysqli_real_escape_string($conexao, $_POST['senha']);

$query = "SELECT * FROM login WHERE email = '{$usuario}' LIMIT 1";

$result = mysqli_query($conexao, $query);

$row = mysqli_num_rows($result);
$conf = mysqli_fetch_assoc($result);
if ($conf['ativo'] === '0') {
    $_SESSION['inativo'] = true;
    $_SESSION['msg'] = $conf['observacao'];
    header('Location: ../');
    mysqli_close($conexao);
    exit();
}

if ($row == 1) {

    if (password_verify($senha, $conf['senha'])) {
        /*while ($registro = mysqli_fetch_array($result))*/

        $_SESSION['nome'] = $conf['nome'];
        $_SESSION['email'] = $conf['email'];
        $_SESSION['perfil'] = $conf['perfil'];
        $_SESSION['id_user_log'] = $conf['id'];
        $_SESSION['id_emp'] = $conf['id_empresa'];
        $_SESSION['cpf'] = $conf['cpf'];
        $_SESSION['rg'] = $conf['rg'];
        $_SESSION['foto'] = $conf['foto'];

        $_SESSION['nao_autenticado'] = false;
        header('Location: ../dashboards/painel');
        mysqli_close($conexao);
        exit();
    } else {
        $_SESSION['nao_autenticado'] = true;
        header('Location: ../');
        mysqli_close($conexao);
        exit();
    }
} else {
    $_SESSION['nao_autenticado'] = true;
    header('Location: ../');
    mysqli_close($conexao);
    exit();
}
