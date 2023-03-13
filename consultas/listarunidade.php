<?php
session_start();
include("../db/conexao.php");

$id = (int)$_SESSION['id_emp'];
$bloco = $_POST['bloco'];

$result_unidades = "SELECT * FROM unidades WHERE id_empresa = '$id' AND bloco='$bloco' AND ativo='1' ORDER BY unidade";
$resultado_unidades = mysqli_query($conexao, $result_unidades);

echo '<option value="">Selecione um item</option>';
while ($row_unidades = mysqli_fetch_assoc($resultado_unidades)) {
    echo '<option value=' . $row_unidades['id'] . '|' . $row_unidades['unidade'] . '>' . $row_unidades['unidade'] . '</option>';
}
