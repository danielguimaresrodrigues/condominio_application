<?php
session_start();
include('../db/conexao.php');

$id = mysqli_real_escape_string($conexao, trim($_POST['id']));
$nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
//$perfil = mysqli_real_escape_string($conexao, trim($_POST['perfil']));
$celular = mysqli_real_escape_string($conexao, trim($_POST['celular']));
$nascimento = mysqli_real_escape_string($conexao, trim($_POST['nascimento']));
$cep = mysqli_real_escape_string($conexao, trim($_POST['cep']));
$rua = mysqli_real_escape_string($conexao, trim($_POST['rua']));
$cpf = mysqli_real_escape_string($conexao, trim($_POST['cpf']));
$rg = mysqli_real_escape_string($conexao, trim($_POST['rg']));
//$bloco = mysqli_real_escape_string($conexao, trim($_POST['bloco']));
$numero = mysqli_real_escape_string($conexao, trim($_POST['numero']));
//$complemento = mysqli_real_escape_string($conexao, trim($_POST['complemento']));
$bairro = mysqli_real_escape_string($conexao, trim($_POST['bairro']));
$estado = mysqli_real_escape_string($conexao, trim($_POST['uf']));
$cidade = mysqli_real_escape_string($conexao, trim($_POST['cidade']));
$nascimento = implode("-", array_reverse(explode("/", $nascimento)));

$nome = ucwords($nome);
$rua = ucwords($rua);
$bairro = ucwords($bairro);
$cidade = ucwords($cidade);
$cep = str_replace('.', '', $cep);
$cep = str_replace('-', '', $cep);

$cpf = str_replace('.', '', $cpf);
$cpf = str_replace('-', '', $cpf);

$sql_edit = "UPDATE login SET nome='$nome', celular='$celular', nascimento='$nascimento',
            cep='$cep', rua='$rua', numero='$numero', cpf='$cpf', rg='$rg',
            bairro='$bairro', uf='$estado', cidade='$cidade', updated_at=NOW()
	        WHERE id = '$id'";
/*$resultado = mysqli_query($conexao, $sql_edit);*/

if ($conexao->query($sql_edit) === true) {
    $_SESSION['nao_alterou'] = true;
    $_SESSION['cpf'] = $cpf;
    header('Location: ../cadastros/personaldata');
    mysqli_close($conexao);
    exit();
} else {
    $_SESSION['nao_alterou'] = false;
    header('Location: ../cadastros/personaldata');
    mysqli_close($conexao);
    exit();
}
