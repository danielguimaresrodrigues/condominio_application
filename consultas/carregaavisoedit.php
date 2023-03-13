<?php
session_start();
include("../db/conexao.php");

$id = (int)$_POST['id'];

$query = "SELECT * FROM quadro WHERE id = '$id' LIMIT 1";

$result = mysqli_query($conexao, $query);

$row = mysqli_num_rows($result);
$conf = mysqli_fetch_assoc($result);

if ($row == 1) {

    echo "<form action='../edits/alteraaviso.php' method='POST'>";
    echo "<div class='row px-3'>";
    echo "<input class='form-control' type='hidden' value='" . $id . "' name='id_edit' id='id_edit' placeholder='Data' required>";
    echo "<div class='mb-3 col-md-6'>";
    echo "<label for='nome'>Título</label>";
    echo "<textarea class='form-control' type='text' name='titulo_edit' id='titulo_edit' maxlength='150' placeholder='Digite o título' required>" . $conf['titulo'] . "</textarea>";
    echo "</div>";
    echo "<div class='mb-3 col-md-2'>";
    echo "<label for='nome'>Data</label>";
    echo "<input class='form-control' type='date' value='" . $conf['datavenc_at'] . "' name='data_edit' id='data_edit' placeholder='Data' required>";
    echo "</div>";
    echo "<div class='mb-3 col-md-1'>";
    echo "<label for='floatingInput'>Exibir</label>";
    echo "<div class='form-check form-switch'>";
    if ($conf['visivel'] === '1') {
        echo "<input class='form-check-input mb-3' name='ativo_edit' id='ativo_edit' type='checkbox' checked>";
    } else {
        echo "<input class='form-check-input mb-3' name='ativo_edit' id='ativo_edit' type='checkbox'>";
    }
    echo "</div>";
    echo "</div>";
    echo "<div class='mb-3 col-md-3'>";
    echo "<label for='floatingInput'>Ocultar aviso após data</label>";
    echo "<div class='form-check form-switch'>";
    if ($conf['fixo'] === '1') {
        echo "<input class='form-check-input mb-3' name='fixo_edit' id='fixo_edit' type='checkbox' checked>";
    } else {
        echo "<input class='form-check-input mb-3' name='fixo_edit' id='fixo_edit' type='checkbox'>";
    }
    echo "</div>";
    echo "</div>";
    echo "<div class='mb-3 col-md-9'>";
    echo "<label for='nome'>Descrição</label>";
    echo "<textarea class='form-control' name='descricao_edit' id='descricao_edit' placeholder='' style='height: 10vh;' maxlength='600'>" . $conf['mensagem'] . "</textarea>";
    echo "</div>";
    echo "<div class='mb-3 col-md-3'>";
    echo "<label for='nome'>Fundo do card</label>";
    echo "<select class='form-select fw-light' name='bgcolors_edit' id='bgcolors_edit'>";
    if ($conf['bgcolor'] === 'bg-white') {
        echo "<option class='bg-white' value='bg-white' selected='selected'>bg-white</option>";
    } else {
        echo "<option class='bg-white' value='bg-white'>bg-white</option>";
    }
    if ($conf['bgcolor'] === 'bg-atencao') {
        echo "<option class='bg-atencao' value='bg-atencao' selected='selected'>bg-atencao</option>";
    } else {
        echo "<option class='bg-atencao' value='bg-atencao'>bg-atencao</option>";
    }
    if ($conf['bgcolor'] === 'bg-taleturquoise') {
        echo "<option class='bg-taleturquoise' value='bg-taleturquoise' selected='selected'>bg-taleturquoise</option>";
    } else {
        echo "<option class='bg-taleturquoise' value='bg-taleturquoise'>bg-taleturquoise</option>";
    }
    echo "</select>";
    echo "</div>";
    echo "<div class='d-flex justify-content-center'>";
    echo "<div class='col-md-3 m-2'>";
    echo "<button type='submit' name='salva' id='salva' class='btn btn-outline-primary'>Salvar</button>";
    echo "</div>";
    echo "<div class='col-md-3 m-2'>";
    echo "<button type='button' id='volta' class='btn btn-outline-secondary' data-bs-dismiss='modal'>Cancelar</button>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</form>";
}
