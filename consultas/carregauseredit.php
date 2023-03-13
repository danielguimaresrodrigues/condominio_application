<?php
session_start();
include("../db/conexao.php");

$id_emp = (int)$_SESSION['id_emp'];
$id_user = (int)$_POST['id_user'];

$query = "SELECT * FROM login WHERE id = '$id_user' LIMIT 1";

$result = mysqli_query($conexao, $query);

$row = mysqli_num_rows($result);
$conf = mysqli_fetch_assoc($result);

if ($row == 1) {

    $result_blocos = "SELECT * FROM blocos WHERE id_empresa = '$id_emp'";
    $resultado_blocos = mysqli_query($conexao, $result_blocos);

    $id_bloco = $conf['id_bloco'];
    $result_unidade = "SELECT * FROM unidades WHERE id_bloco = '$id_bloco'";
    $resultado_unidade = mysqli_query($conexao, $result_unidade);

    echo "<form action='../edits/alterausuario.php' method='POST'>";
    echo "<input class='form-control' type='hidden' value='" . $id_user . "' name='id_edit' id='id_edit' required readonly>";
    echo "<div class='row'>";
    echo "<div class='mb-3 col-md-6'>";
    echo "<label for='nome'>Nome</label>";
    echo "<input class='form-control' type='text' value='" . $conf['nome'] . "' name='nome_edit' id='nome_edit' placeholder='Digite o nome' required>";
    echo "</div>";
    echo "<div class='mb-3 col-md-6'>";
    echo "<label for='nome'>E-mail</label>";
    echo "<input class='form-control' type='email' value='" . $conf['email'] . "' name='email_edit' id='email_edit' placeholder='Digite o e-mail' required readonly>";
    echo "</div>";
    echo "<div class='mb-3 col-md-3'>";
    echo "<label for='floatingInput'>Perfil de Acesso</label>";
    echo "<select class='form-select' name='perfil_edit' id='perfil_edit' required>";
    if ($conf['perfil'] === "0") {
        echo "<option value='0' selected='selected'>Adm Sistema</option>";
    } else {
        echo "<option value='0'>Adm Sistema</option>";
    }
    if ($conf['perfil'] === "1") {
        echo "<option value='1' selected='selected'>Administrador</option>";
    } else {
        echo "<option value='1'>Administrador</option>";
    }
    if ($conf['perfil'] === "2") {
        echo "<option value='2' selected='selected'>Síndico</option>";
    } else {
        echo "<option value='2'>Síndico</option>";
    }
    if ($conf['perfil'] === "3") {
        echo "<option value='3' selected='selected'>Condômino</option>";
    } else {
        echo "<option value='3'>Condômino</option>";
    }
    if ($conf['perfil'] === "4") {
        echo "<option value='4' selected='selected'>Morador</option>";
    } else {
        echo "<option value='4'>Morador</option>";
    }
    echo "</select>";

    echo "</div>";
    echo "<div class='mb-3 col-md-3'>";
    echo "<label for='nome'>Bloco</label>";
    echo "<select class='form-select fw-light col-md-2' name='bloco_edit' id='bloco_edit'>";
    echo "<option value=''>Selecione o bloco</option>";
    while ($row_blocoss = mysqli_fetch_assoc($resultado_blocos)) {
        if ($conf['id_bloco'] === $row_blocoss['id']) {
            echo "<option value='" . $row_blocoss['id'] . '|' . $row_blocoss['bloco'] . "' selected='selected'>" . $row_blocoss['bloco'] . "</option>";
        } else {
            echo "<option value='" . $row_blocoss['id'] . '|' . $row_blocoss['bloco'] . "'>" . $row_blocoss['bloco'] . "</option>";
        }
    }
    echo "</select>";
    echo "</div>";
    echo "<div class='mb-3 col-md-3'>";
    echo "<label for='nome'>Unidade</label>";
    echo "<select class='form-select fw-light col-md-2' name='unidade_edit' id='unidade_edit'>";
    echo "<option value=''>Selecione a unidade</option>";
    while ($row_unidade = mysqli_fetch_assoc($resultado_unidade)) {
        if ($conf['id_unidade'] === $row_unidade['id']) {
            echo "<option value='" . $row_unidade['id'] . '|' . $row_unidade['unidade'] . "' selected='selected'>" . $row_unidade['unidade'] . "</option>";
        } else {
            echo "<option value='" . $row_unidade['id'] . '|' . $row_unidade['unidade'] . "'>" . $row_unidade['unidade'] . "</option>";
        }
    }
    echo "</select>";
    echo "</div>";
    echo "<div class='mb-3 col-md-3'>";
    echo "<label for='nome'>cep</label>";
    echo "<input class='form-control' value='" . $conf['cep'] . "' type='text' name='cep_edit' id='cep_edit' placeholder='Digite o CEP' maxlength='30' onblur='pesquisacep(this.value);' required>";
    echo "</div>";
    echo "<div class='mb-3 col-md-3'>";
    echo "<label for='nome'>Número</label>";
    echo "<input class='form-control' type='text' value='" . $conf['numero'] . "' name='numero_edit' id='numero_edit' placeholder='Digite o número' required>";
    echo "</div>";
    echo "<div class='mb-3 col-md-6'>";
    echo "<label for='nome'>Rua</label>";
    echo "<input class='form-control' type='text' value='" . $conf['rua'] . "' name='rua' id='rua' placeholder='Digite a rua' required>";
    echo "</div>";
    echo "<div class='mb-3 col-md-3'>";
    echo "<label for='nome'>UF</label>";
    echo "<select class='form-select' name='uf' id='uf' required>";
    if ($conf['uf'] === 'AC') {
        echo "<option value='AC' selected='selected'>AC</option>";
    } else {
        echo "<option value='AC'>AC</option>";
    }
    if ($conf['uf'] === 'AL') {
        echo "<option value='AL' selected='selected'>AL</option>";
    } else {
        echo "<option value='AL'>AL</option>";
    }
    if ($conf['uf'] === 'AP') {
        echo "<option value='AP' selected='selected'>AP</option>";
    } else {
        echo "<option value='AP'>AP</option>";
    }
    if ($conf['uf'] === 'AM') {
        echo "<option value='AM' selected='selected'>AM</option>";
    } else {
        echo "<option value='AM'>AM</option>";
    }
    if ($conf['uf'] === 'BA') {
        echo "<option value='BA' selected='selected'>BA</option>";
    } else {
        echo "<option value='BA'>BA</option>";
    }
    if ($conf['uf'] === 'CE') {
        echo "<option value='CE' selected='selected'>CE</option>";
    } else {
        echo "<option value='CE'>CE</option>";
    }
    if ($conf['uf'] === 'DF') {
        echo "<option value='DF' selected='selected'>DF</option>";
    } else {
        echo "<option value='DF'>DF</option>";
    }
    if ($conf['uf'] === 'ES') {
        echo "<option value='ES' selected='selected'>ES</option>";
    } else {
        echo "<option value='ES'>ES</option>";
    }
    if ($conf['uf'] === 'GO') {
        echo "<option value='GO' selected='selected'>GO</option>";
    } else {
        echo "<option value='GO'>GO</option>";
    }
    if ($conf['uf'] === 'MA') {
        echo "<option value='MA' selected='selected'>MA</option>";
    } else {
        echo "<option value='MA'>MA</option>";
    }
    if ($conf['uf'] === 'MT') {
        echo "<option value='MT' selected='selected'>MT</option>";
    } else {
        echo "<option value='MT'>MT</option>";
    }
    if ($conf['uf'] === 'MS') {
        echo "<option value='MS' selected='selected'>MS</option>";
    } else {
        echo "<option value='MS'>MS</option>";
    }
    if ($conf['uf'] === 'MG') {
        echo "<option value='MG' selected='selected'>MG</option>";
    } else {
        echo "<option value='MG'>MG</option>";
    }
    if ($conf['uf'] === 'PA') {
        echo "<option value='PA' selected='selected'>PA</option>";
    } else {
        echo "<option value='PA'>PA</option>";
    }
    if ($conf['uf'] === 'PB') {
        echo "<option value='PB' selected='selected'>PB</option>";
    } else {
        echo "<option value='PB'>PB</option>";
    }
    if ($conf['uf'] === 'PR') {
        echo "<option value='PR' selected='selected'>PR</option>";
    } else {
        echo "<option value='PR'>PR</option>";
    }
    if ($conf['uf'] === 'PE') {
        echo "<option value='PE' selected='selected'>PE</option>";
    } else {
        echo "<option value='PE'>PE</option>";
    }
    if ($conf['uf'] === 'PI') {
        echo "<option value='PI' selected='selected'>PI</option>";
    } else {
        echo "<option value='PE'>PE</option>";
    }
    if ($conf['uf'] === 'RJ') {
        echo "<option value='RJ' selected='selected'>RJ</option>";
    } else {
        echo "<option value='RJ'>RJ</option>";
    }
    if ($conf['uf'] === 'RN') {
        echo "<option value='RN' selected='selected'>RN</option>";
    } else {
        echo "<option value='RN'>RN</option>";
    }
    if ($conf['uf'] === 'RS') {
        echo "<option value='RS' selected='selected'>RS</option>";
    } else {
        echo "<option value='RS'>RS</option>";
    }
    if ($conf['uf'] === 'RO') {
        echo "<option value='RO' selected='selected'>RO</option>";
    } else {
        echo "<option value='RO'>RO</option>";
    }
    if ($conf['uf'] === 'RR') {
        echo "<option value='RR' selected='selected'>RR</option>";
    } else {
        echo "<option value='RR'>RR</option>";
    }
    if ($conf['uf'] === 'SC') {
        echo "<option value='SC' selected='selected'>SC</option>";
    } else {
        echo "<option value='SC'>SC</option>";
    }
    if ($conf['uf'] === 'SP') {
        echo "<option value='SP' selected='selected'>SP</option>";
    } else {
        echo "<option value='SP'>SP</option>";
    }
    if ($conf['uf'] === 'SE') {
        echo "<option value='SE' selected='selected'>SE</option>";
    } else {
        echo "<option value='SE'>SE</option>";
    }
    if ($conf['uf'] === 'TO') {
        echo "<option value='TO' selected='selected'>TO</option>";
    } else {
        echo "<option value='TO'>TO</option>";
    }
    echo "</select>";
    echo "</div>";
    echo "<div class='mb-3 col-md-6'>";
    echo "<label for='nome'>Bairro</label>";
    echo "<input class='form-control' type='text' value='" . $conf['bairro'] . "' name='bairro' id='bairro' placeholder='Digite o bairro' required>";
    echo "</div>";
    echo "<div class='mb-3 col-md-6'>";
    echo "<label for='nome'>Cidade</label>";
    echo "<input class='form-control' type='text' value='" . $conf['cidade'] . "' name='cidade' id='cidade' placeholder='Digite a cidade' required>";
    echo "</div>";
    echo "<div class='mb-3 col-md-10'>";
    echo "<label for='floatingInput'>Observação</label>";
    echo "<textarea class='form-control' name='observacao_edit' id='observacao_edit' placeholder='Observação' style='height: 10vh;' maxlength='300'>" . $conf['observacao'] . "</textarea>";
    echo "</div>";
    echo "<div class='mb-3 col-md-2'>";
    echo "<label for='floatingInput'>Ativo</label>";
    echo "<div class='form-check form-switch'>";
    if ($conf['ativo'] === '1') {
        echo "<input class='form-check-input mb-3' name='ativo' id='ativo' type='checkbox' checked>";
    } else {
        echo "<input class='form-check-input mb-3' name='ativo' id='ativo' type='checkbox'>";
    }
    //echo "<label class='form-check-label' for='flexSwitchCheckDefault'></label>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "<div class='d-flex justify-content-center'>";
    echo "<div class='col-md-3 m-2'>";
    echo "<button type='submit' name='salvar' id='salva' class='btn btn-outline-primary'>Salvar</button>";
    echo "</div>";
    echo "<div class='col-md-3 m-2'>";
    echo "<button type='button' id='volta' class='btn btn-outline-secondary' data-bs-dismiss='modal'>Cancelar</button>";
    echo "</div>";
    echo "</div>";
    echo "</form>";
}
