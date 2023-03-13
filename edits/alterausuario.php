<?php
session_start();
include('../db/conexao.php');

$id = mysqli_real_escape_string($conexao, trim($_POST['id_edit']));
$nome = mysqli_real_escape_string($conexao, trim($_POST['nome_edit']));
$perfil = mysqli_real_escape_string($conexao, $_POST['perfil_edit']);
$cep = mysqli_real_escape_string($conexao, trim($_POST['cep_edit']));
$bloco_adds = mysqli_real_escape_string($conexao, trim($_POST['bloco_edit']));
$unidade_adds = mysqli_real_escape_string($conexao, trim($_POST['unidade_edit']));
$rua = mysqli_real_escape_string($conexao, trim($_POST['rua']));
$numero = mysqli_real_escape_string($conexao, trim($_POST['numero_edit']));
$bairro = mysqli_real_escape_string($conexao, trim($_POST['bairro']));
$estado = mysqli_real_escape_string($conexao, trim($_POST['uf']));
$cidade = mysqli_real_escape_string($conexao, trim($_POST['cidade']));
$observacao_edit = mysqli_real_escape_string($conexao, trim($_POST['observacao_edit']));
$ativo = (isset($_POST['ativo'])) ? '1' : '0';

if ($ativo === '0' && empty($observacao_edit)) {
    $_SESSION['preenche_obs'] = true;

    header('Location: ../cadastros/gerenciamento-de-usuarios');
    mysqli_close($conexao);
    exit();
}

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

$sql_edit = "UPDATE login SET nome='$nome', perfil='$perfil', cep='$cep', id_bloco='$id_bloco', bloco='$bloco_name',
            id_unidade='$id_unidade', unidade='$unidade_name', rua='$rua', numero='$numero', bairro='$bairro', uf='$estado',
            cidade='$cidade', observacao='$observacao_edit', ativo='$ativo',updated_at=NOW()
	        WHERE id = '$id'";
/*$resultado = mysqli_query($conexao, $sql_edit);*/

if ($conexao->query($sql_edit) === true) {
    $_SESSION['nao_alterou'] = true;
    header('Location: ../cadastros/gerenciamento-de-usuarios');
    mysqli_close($conexao);
    exit();
} else {
    $_SESSION['nao_alterou'] = false;
    header('Location: ../cadastros/gerenciamento-de-usuarios');
    mysqli_close($conexao);
    exit();
}
