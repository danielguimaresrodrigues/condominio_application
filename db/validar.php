<?php
session_start();
include('../db/conexao.php');

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

$dados['email'];

$query = "SELECT * FROM login WHERE email=:email LIMIT 1";

$result_usuario = $conexao->prepare($query);
$result_usuario->bind_param(':email', $dados['email'], PDO::PARAM_STR);
$result_usuario->execute();

if (($result_usuario) and ($result_usuario->num_rows() != 0)) {
    $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
} else {
}
