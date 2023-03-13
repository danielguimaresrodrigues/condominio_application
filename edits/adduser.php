<?php
session_start();
include('../db/conexao.php');

$id_emp = (int)$_SESSION['id_emp'];
$nome = mysqli_real_escape_string($conexao, trim($_POST['nome_add']));
$email = mysqli_real_escape_string($conexao, trim($_POST['email_add']));
$perfil = mysqli_real_escape_string($conexao, $_POST['perfil']);
$cep = mysqli_real_escape_string($conexao, trim($_POST['cep']));
$bloco_adds = mysqli_real_escape_string($conexao, trim($_POST['bloco_adds']));
$unidade_adds = mysqli_real_escape_string($conexao, trim($_POST['unidade_adds']));
$rua = mysqli_real_escape_string($conexao, trim($_POST['rua']));
$numero = mysqli_real_escape_string($conexao, trim($_POST['numero']));
$bairro = mysqli_real_escape_string($conexao, trim($_POST['bairro']));
$estado = mysqli_real_escape_string($conexao, trim($_POST['uf']));
$cidade = mysqli_real_escape_string($conexao, trim($_POST['cidade']));

$nome = ucwords($nome);
$rua = ucwords($rua);
$bairro = ucwords($bairro);
$cidade = ucwords($cidade);
$cpf = str_replace('.', '', $cpf);
$cpf = str_replace('-', '', $cpf);
$cep = str_replace('.', '', $cep);
$cep = str_replace('-', '', $cep);

$unidade = explode("|", $unidade_adds);
$bloco = explode("|", $bloco_adds);

$id_unidade = $unidade[0];
$unidade_name = $unidade[1];

$id_bloco = $bloco[0];
$bloco_name = $bloco[1];

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
    header('Location: ../cadastros/gerenciamento-de-usuarios');
    mysqli_close($conexao);
    exit;
}

$sql_insert = "INSERT INTO login (id_empresa, nome, email, perfil, ativo, senha,
cep, rua, numero, id_bloco, bloco, id_unidade, unidade, bairro, uf, cidade, 
data_cadastro, updated_at) VALUES ('$id_emp','$nome', '$email', '$perfil', '1', '$hash',
'$cep', '$rua', '$numero', '$id_bloco', '$bloco_name', '$id_unidade', '$unidade_name',
'$bairro', '$estado', '$cidade', NOW(), NOW())";
/*$resultado_sql = mysqli_query($conexao, $sql);*/
if ($conexao->query($sql_insert) === true) {
    $idInser = mysqli_insert_id($conexao);

    $sql_conf = "INSERT INTO configuracoes (id_empresa, itens_pag, id_usuario, created_at, updated_at)
        VALUES ('$id_emp', '25', '$idInser', NOW(), NOW())";

    if ($conexao->query($sql_conf) === true) {
    }
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
    header('Location: ../cadastros/gerenciamento-de-usuarios');
    mysqli_close($conexao);
    exit;
}

exit;
