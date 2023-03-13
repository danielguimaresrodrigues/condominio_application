<?php
session_start();
include("../db/conexao.php");

$cnpj = mysqli_real_escape_string($conexao, trim($_POST['cnpj']));
$nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
$natureza_juridica = mysqli_real_escape_string($conexao, trim($_POST['natureza_juridica']));
$cpf = mysqli_real_escape_string($conexao, trim($_POST['cpf']));
$responsavel = mysqli_real_escape_string($conexao, trim($_POST['responsavel']));
$email = mysqli_real_escape_string($conexao, trim($_POST['email']));
$celular = mysqli_real_escape_string($conexao, trim($_POST['celular']));
$cep = mysqli_real_escape_string($conexao, trim($_POST['cep']));
$rua = mysqli_real_escape_string($conexao, trim($_POST['rua']));
$numero = mysqli_real_escape_string($conexao, trim($_POST['numero']));
$complemento = mysqli_real_escape_string($conexao, trim($_POST['complemento']));
$bairro = mysqli_real_escape_string($conexao, trim($_POST['bairro']));
$estado = mysqli_real_escape_string($conexao, trim($_POST['uf']));
$cidade = mysqli_real_escape_string($conexao, trim($_POST['cidade']));

$nome = ucwords($nome);
$natureza_juridica = ucwords($natureza_juridica);
$responsavel = ucwords($responsavel);
$rua = ucwords($rua);
$bairro = ucwords($bairro);
$cidade = ucwords($cidade);

$cpf = str_replace('.', '', $cpf);
$cpf = str_replace('-', '', $cpf);
$cep = str_replace('.', '', $cep);
$cep = str_replace('-', '', $cep);
$cnpj = str_replace('.', '', $cnpj);
$cnpj = str_replace('-', '', $cnpj);
$cnpj = str_replace('/', '', $cnpj);
//$hash = password_hash($senha, PASSWORD_DEFAULT);

$sql = "SELECT count(*) as total FROM empresa WHERE cnpj = '$cnpj'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['total'] == 1) {
    $_SESSION['usuario_existe'] = true;
    header('Location: solicitaAcesso');
    exit;
}

$sql = "INSERT INTO empresa (cnpj, nome, cpf, responsavel, natureza_juridica, email, celular, cep, rua, numero, complemento, bairro,
 uf, cidade, ativo, created_at, updated_at) VALUES ('$cnpj', '$nome', '$cpf', '$responsavel', '$natureza_juridica', '$email', '$celular',
  '$cep', '$rua', '$numero', '$complemento', '$bairro', '$estado', '$cidade', '1', NOW(), NOW())";
/*$resultado_sql = mysqli_query($conexao, $sql);*/
if ($conexao->query($sql) === true) {
    $_SESSION['status_cadastro'] = true;
    $_SESSION['id_empresa'] = mysqli_insert_id($conexao);
    $_SESSION['cpfResp'] = $cpf;
    $_SESSION['responsavel'] = $responsavel;
    $_SESSION['celular'] = $celular;
    /*$idInser = mysqli_insert_id($conexao);
    /*cadastro das permissõ<es*/
    /*$sql_def = "INSERT INTO configura_acesso (id_user, id_empresa, acess_all, projeto_geral, projeto_cronograma, projeto_feed, projeto_propostas,
     projeto_orcamento, clientes, fornecedores, empresa_ver, empresa_editar, created_at, updated_at) VALUES 
     ('$idInser','0','1','1', '1', '1', '1', '1', '1', '1', '1', '1', NOW(), NOW())";
    /*$resultado_sql = mysqli_query($conexao, $sql);
    if ($conexao->query($sql_def) === true) {
    }*/
} else {
    $_SESSION['status_cadastro'] = false;
}

$conexao->close();

header('Location: ../cadastros/responsavel');
exit;
