<?php
session_start();
include('../db/conexao.php');

$id = mysqli_real_escape_string($conexao, trim($_POST['id']));
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
$data_pagamento = mysqli_real_escape_string($conexao, trim($_POST['pagamento']));
$ativo = (isset($_POST['ativo'])) ? '1' : '0';
$usuario = $_SESSION['id_user_log'];

$data_vencimento = date('d/m/Y', strtotime('+365 days', strtotime($data_pagamento)));

$data_pagamento = implode("-", array_reverse(explode("/", $data_pagamento)));
$data_vencimento = implode("-", array_reverse(explode("/", $data_vencimento)));

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

$sql_edit = "UPDATE empresa SET nome='$nome', natureza_juridica='$natureza_juridica', cpf='$cpf',
            responsavel='$responsavel', email='$email', celular='$celular',
            cep='$cep', rua='$rua', numero='$numero', complemento='$complemento',
            bairro='$bairro', uf='$estado', cidade='$cidade', datapg_at='$data_pagamento', expirated_at='$data_vencimento', id_usuario='$usuario', ativo='$ativo',updated_at=NOW()
	        WHERE id = '$id'";
/*$resultado = mysqli_query($conexao, $sql_edit);*/

if ($conexao->query($sql_edit) === true) {
    $_SESSION['nao_alterou'] = false;
    header('Location: ../cadastros/dados-do-condominio');
    mysqli_close($conexao);
    exit();
} else {
    $_SESSION['nao_alterou'] = false;
    header('Location: ../dados-do-condominio');
    mysqli_close($conexao);
    exit();
}
