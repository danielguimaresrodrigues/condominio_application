<?php
session_start();
include('../db/conexao.php');

$id_emp = mysqli_real_escape_string($conexao, trim($_POST['idcond']));
$_session['condominio'] = mysqli_real_escape_string($conexao, trim($_POST['nome']));
$nome = mysqli_real_escape_string($conexao, trim($_POST['nomeresp']));
$cpf = mysqli_real_escape_string($conexao, trim($_POST['cpf']));
$email = mysqli_real_escape_string($conexao, trim($_POST['email']));
$perfil = mysqli_real_escape_string($conexao, $_POST['perfil']);
$celular = mysqli_real_escape_string($conexao, $_POST['celular']);
$rg = mysqli_real_escape_string($conexao, $_POST['rg_id']);
$nascimento = mysqli_real_escape_string($conexao, $_POST['nasc']);
$cep = mysqli_real_escape_string($conexao, trim($_POST['cep']));
$complemento = mysqli_real_escape_string($conexao, trim($_POST['complemento']));
$bloco = mysqli_real_escape_string($conexao, trim($_POST['bloco']));
$rua = mysqli_real_escape_string($conexao, trim($_POST['rua']));
$numero = mysqli_real_escape_string($conexao, trim($_POST['numero']));
$complemento = mysqli_real_escape_string($conexao, trim($_POST['complemento']));
$bairro = mysqli_real_escape_string($conexao, trim($_POST['bairro']));
$estado = mysqli_real_escape_string($conexao, trim($_POST['uf']));
$cidade = mysqli_real_escape_string($conexao, trim($_POST['cidade']));
$nascimento = implode("-", array_reverse(explode("/", $nascimento)));

$nome = ucwords($nome);
$rua = ucwords($rua);
$bairro = ucwords($bairro);
$cidade = ucwords($cidade);
$cpf = str_replace('.', '', $cpf);
$cpf = str_replace('-', '', $cpf);
$cep = str_replace('.', '', $cep);
$cep = str_replace('-', '', $cep);

$comb = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
$pass = array();
$combLen = strlen($comb) - 1;
for ($i = 0; $i < 8; $i++) {
    $n = rand(0, $combLen);
    $pass[] = $comb[$n];
}

$senha_prov = implode($pass);
$_SESSION['senha_prov'] = $senha_prov;

$hash = password_hash($senha_prov, PASSWORD_DEFAULT);

$sql = "SELECT count(*) as total FROM login WHERE email = '$email'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['total'] == 1) {
    $_SESSION['colaborador_existe'] = true;
    header('Location: /responsavel');
    mysqli_close($conexao);
    exit;
}

$sql_insert = "INSERT INTO login (id_empresa, nome, email, perfil, ativo, senha, celular,
cpf, rg, nascimento, cep, rua, numero, apartamento, bloco, bairro, uf, cidade, 
data_cadastro, updated_at) VALUES ('$id_emp','$nome', '$email', '$perfil', '1', '$hash',
'$celular', '$cpf', '$rg', '$nascimento', '$cep', '$rua', '$numero', '$complemento', '$bloco',
'$bairro', '$estado', '$cidade', NOW(), NOW())";
/*$resultado_sql = mysqli_query($conexao, $sql);*/
if ($conexao->query($sql_insert) === true) {
    $idInser = mysqli_insert_id($conexao);
    $_SESSION['email_responsavel'] = $email;
    $_SESSION['nome_responsavel'] = $nome;

    $_SESSION['colaborador_cad'] = true;
    header('Location: ../emails/emailresp.php');
    mysqli_close($conexao);
    exit;
    /*$sql_conf = "INSERT INTO login (id_empresa, nome, email, proprietario, permissao, ativo, senha, created_at, updated_at) VALUES ('$id_emp','$nome', '$email', '$proprietario',
'$permissao', '1', '$hash', NOW(), NOW())";

    if ($conexao->query($sql_conf) === true) {
    }*/
} else {
    $_SESSION['colaborador_cad'] = false;
    header('Location: ../');
    mysqli_close($conexao);
    exit;
}

exit;
