<?php
session_start();
include('../db/conexao.php');

$email = mysqli_real_escape_string($conexao, trim($_POST['emaill']));

$comb = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
$pass = array();
$combLen = strlen($comb) - 1;
for ($i = 0; $i < 8; $i++) {
    $n = rand(0, $combLen);
    $pass[] = $comb[$n];
}

$senha_prov2 = implode($pass);
$_SESSION['senha_provi'] = $senha_prov2;

$hash = password_hash($senha_prov2, PASSWORD_DEFAULT);

$sql = "SELECT count(*) as total FROM login WHERE email = '{$email}'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['total'] == 1) {
    $sql2 = "SELECT * FROM login WHERE email = '{$email}'";
    $result2 = mysqli_query($conexao, $sql2);
    $row2 = mysqli_fetch_assoc($result2);

    $sql_edit = "UPDATE login SET senha='$hash' WHERE email='{$email}'";
    /*$resultado = mysqli_query($conexao, $sql_edit);*/

    if ($conexao->query($sql_edit) === true) {
        $_SESSION['email_alt'] = $email;
        $_SESSION['nome_colaborad'] = $row2['nome'];

        header('Location: ../resetasenha');
        mysqli_close($conexao);
        exit;
        /*$sql_conf = "INSERT INTO login (id_empresa, nome, email, proprietario, permissao, ativo, senha, created_at, updated_at) VALUES ('$id_emp','$nome', '$email', '$proprietario',
'$permissao', '1', '$hash', NOW(), NOW())";

    if ($conexao->query($sql_conf) === true) {
    }*/
    } else {
        echo "Não editado";
    }
} else {
    $_SESSION['reseta_senha'] = true;
    header('Location: ../');
}


exit;
