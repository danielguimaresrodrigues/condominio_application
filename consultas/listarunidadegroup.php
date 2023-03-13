<?php
session_start();
include("../db/conexao.php");

$id = (int)$_SESSION['id_emp'];
$blocoss_group = $_POST['bloco_group'];

$result_unit = "SELECT count(*) as total FROM unidades WHERE id_empresa = '$id' AND bloco='$blocoss_group' AND ativo='1'";
$resultado_unit = mysqli_query($conexao, $result_unit);
$row_unit = mysqli_fetch_assoc($resultado_unit);

if ($row_unit['total'] != 0) {
    echo "<label for='nome'>Unidades</label>";
    echo "<div class='input-group'>";
    $result_unidades = "SELECT * FROM unidades WHERE id_empresa = '$id' AND bloco='$blocoss_group' AND ativo='1' ORDER BY unidade";
    $resultado_unidades = mysqli_query($conexao, $result_unidades);

    while ($row_unidades = mysqli_fetch_assoc($resultado_unidades)) {
        //echo '<tr>';
        //echo '<td><div class="form-check form-switch"><input class="form-check-input" type="checkbox" id="check_unidade_group' . ' value="' . $row_unidades['id'] . '" id="flexCheckDefault"></div></td>';
        //echo '<td id="id_unidade_group' . $row_unidades['id'] . '  value=' . $row_unidades['id'] . '|' . $row_unidades['unidade'] . '>' . $row_unidades['unidade'] . '</td>';
        //echo '<td class="fs-6" id="valor_unidade_group' . $row_unidades['id'] . '">' . $row_unidades['unidade'] . '</td>';
        //echo '</tr>';
        if ($row_unidades['unidade'] != "Todas") {
            echo "<div class='form-check'>";
            echo "<input class='form-check-input' name='unidades_groupp' type='checkbox' onclick='listar();' value='" . $row_unidades['id'] . "|" . $row_unidades['unidade'] . "' id='flexCheckDefault" . $row_unidades['id'] . "'>";
            echo "<label class='form-check-label me-4' for='flexCheckDefault'>";
            echo $row_unidades['unidade'];
            echo "</label>";
            echo "</div>";
        }
    }
    echo "</div>";
} else {
    //echo '<tr>';
    //echo '<td>-</td>';
    //echo '<td class="d-none">-</td>';
    //echo '<td>Selecione um grupo ao lado.</td>';
    //echo '</tr>';
}
$_SESSION['seleciona_bloco'] = true;
$conexao->close();
