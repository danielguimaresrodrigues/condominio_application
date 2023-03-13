<?php

/*session_start();*/

include('../db/verifica_login.php');

if (is_null($_SESSION['cpf'])) {

    header('Location: ../cadastros/personaldata');
    exit;
}

include('../db/conexao.php');

$id = (int)$_SESSION['id_emp'];
$result_empresa = "SELECT * FROM empresa WHERE id = '$id' LIMIT 1";
$resultado_empresa = mysqli_query($conexao, $result_empresa);
$row_empresa = mysqli_fetch_assoc($resultado_empresa);
$conexao->close();
?>

<?php
include '../templates/header.php';
?>

<body>

    <?php
    include '../templates/basico.php';
    ?>

    <section class="vw-100">
        <div class="container-fluid px-3 py-1" id="fundo">
            <div class="col-sm-9 mx-auto bg-white border shadow-sm rounded-3 px-5 py-1 align-self-center">
                <p class="nome_cond text-center py-2"><span style="font-weight: bold;"><?php echo $row_empresa['nome']; ?></span> | <?php echo $row_empresa['email']; ?></p>
            </div>
        </div>
        <div class="container-fluid mt-1">
            <div class="col-sm-9 mx-auto bg-white border shadow-sm rounded-3 px-5 py-1 align-self-center">
                <p class=" fs-4 ms-3 py-3 text-secondary">Condomínio</p>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page">Dados do Condomínio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../cadastros/definicao-de-blocos">Blocos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../cadastros/definicao-de-unidades">Unidades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../cadastros/definicao-de-categorias">Categorias</a>
                    </li>
                </ul>
                <form class="row mb-3 px-3" action="../edits/alteracondominio.php" method="POST">
                    <?php
                    if (isset($_SESSION['nao_alterou'])) :
                    ?>
                        <!--script type="text/javascript">
                            swal("Parabéns!", "Dados alterados com sucesso!", "success");
                        </script-->
                        <script>
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Dados alterados com sucesso!',
                                showConfirmButton: false,
                                timer: 3000
                            })
                        </script>
                    <?php
                    endif;
                    unset($_SESSION['nao_alterou']);
                    ?>
                    <script type="text/javascript">
                        document.addEventListener('DOMContentLoaded', function() {
                            setTimeout(function() {
                                $("#msg_sucesso").fadeOut().empty();
                            }, 6000);
                        }, false);
                    </script>

                    <span id="msgAlertErroLogin"></span>
                    <div class="form-floating mb-3">
                        <input class="form-control" type="hidden" value='<?php echo $_SESSION['id_emp']; ?>' name="id" id="id" required readonly>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="nome">CNPJ</label>
                        <input class="form-control" type="text" value="<?php echo $row_empresa['cnpj']; ?>" name="cnpj" id="cnpj" placeholder="Digite o CNPJ" required readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="nome">Nome</label>
                        <input class="form-control" type="text" value="<?php echo $row_empresa['nome']; ?>" name="nome" id="nome" placeholder="Digite o nome" required>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="floatingInput">CPF responsável</label>
                        <input class="form-control" type="text" value="<?php echo $row_empresa['cpf']; ?>" name="cpf" id="cpf" placeholder="Digite o cpf" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="nome">Nome responsável</label>
                        <input class="form-control" type="text" value="<?php echo $row_empresa['responsavel']; ?>" name="responsavel" id="responsavel" placeholder="Digite o responsável" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="nome">Natureza Jurídica</label>
                        <input class="form-control" type="text" value="<?php echo $row_empresa['natureza_juridica']; ?>" name="natureza_juridica" id="natureza_juridica" placeholder="Digite a Natureza Jurídica" required readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="floatingInput">E-mail</label>
                        <input class="form-control" type="email" value='<?php echo $row_empresa['email']; ?>' name="email" id="email" placeholder="E-mail do condomínio" required readonly>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="floatingInput">Celular</label>
                        <input class="form-control" type="text" value="<?php echo $row_empresa['celular']; ?>" name="celular" id="celular" placeholder="Digite o celular" required>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="floatingInput">CEP</label>
                        <input class="form-control" type="text" value="<?php echo $row_empresa['cep']; ?>" name="cep" onblur="pesquisacep(this.value);" id="cep" placeholder="Digite o CEP" required readonly>
                    </div>
                    <div class="mb-3 col-md-9">
                        <label for="floatingInput">Rua</label>
                        <input class="form-control" type="text" value="<?php echo $row_empresa['rua']; ?>" name="rua" id="rua" placeholder="Digite a rua" required readonly>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="floatingInput">Número</label>
                        <input class="form-control" type="text" value="<?php echo $row_empresa['numero']; ?>" name="numero" id="numero" placeholder="Digite o número" required readonly>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="floatingInput">Complemento (opcional)</label>
                        <input class="form-control" type="text" value="<?php echo $row_empresa['complemento']; ?>" name="complemento" id="complemento" placeholder="Digite o complemento">
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="floatingInput">Estado</label>
                        <select class="form-select fw-light" name="uf" id="uf" required>
                            <option value="AC" <?php if ($row_empresa['uf'] == 'AC') echo 'selected="selected"'; ?>>AC</option>
                            <option value="AL" <?php if ($row_empresa['uf'] == 'AL') echo 'selected="selected"'; ?>>AL</option>
                            <option value="AP" <?php if ($row_empresa['uf'] == 'AP') echo 'selected="selected"'; ?>>AP</option>
                            <option value="AM" <?php if ($row_empresa['uf'] == 'AM') echo 'selected="selected"'; ?>>AM</option>
                            <option value="BA" <?php if ($row_empresa['uf'] == 'BA') echo 'selected="selected"'; ?>>BA</option>
                            <option value="CE" <?php if ($row_empresa['uf'] == 'CE') echo 'selected="selected"'; ?>>CE</option>
                            <option value="DF" <?php if ($row_empresa['uf'] == 'DF') echo 'selected="selected"'; ?>>DF</option>
                            <option value="ES" <?php if ($row_empresa['uf'] == 'ES') echo 'selected="selected"'; ?>>ES</option>
                            <option value="GO" <?php if ($row_empresa['uf'] == 'GO') echo 'selected="selected"'; ?>>GO</option>
                            <option value="MA" <?php if ($row_empresa['uf'] == 'MA') echo 'selected="selected"'; ?>>MA</option>
                            <option value="MT" <?php if ($row_empresa['uf'] == 'MT') echo 'selected="selected"'; ?>>MT</option>
                            <option value="MS" <?php if ($row_empresa['uf'] == 'MS') echo 'selected="selected"'; ?>>MS</option>
                            <option value="MG" <?php if ($row_empresa['uf'] == 'MG') echo 'selected="selected"'; ?>>MG</option>
                            <option value="PA" <?php if ($row_empresa['uf'] == 'PA') echo 'selected="selected"'; ?>>PA</option>
                            <option value="PB" <?php if ($row_empresa['uf'] == 'PB') echo 'selected="selected"'; ?>>PB</option>
                            <option value="PR" <?php if ($row_empresa['uf'] == 'PR') echo 'selected="selected"'; ?>>PR</option>
                            <option value="PE" <?php if ($row_empresa['uf'] == 'PE') echo 'selected="selected"'; ?>>PE</option>
                            <option value="PI" <?php if ($row_empresa['uf'] == 'PI') echo 'selected="selected"'; ?>>PI</option>
                            <option value="RJ" <?php if ($row_empresa['uf'] == 'RJ') echo 'selected="selected"'; ?>>RJ</option>
                            <option value="RN" <?php if ($row_empresa['uf'] == 'RN') echo 'selected="selected"'; ?>>RN</option>
                            <option value="RS" <?php if ($row_empresa['uf'] == 'RS') echo 'selected="selected"'; ?>>RS</option>
                            <option value="RO" <?php if ($row_empresa['uf'] == 'RO') echo 'selected="selected"'; ?>>RO</option>
                            <option value="RR" <?php if ($row_empresa['uf'] == 'RR') echo 'selected="selected"'; ?>>RR</option>
                            <option value="SC" <?php if ($row_empresa['uf'] == 'SC') echo 'selected="selected"'; ?>>SC</option>
                            <option value="SP" <?php if ($row_empresa['uf'] == 'SP') echo 'selected="selected"'; ?>>SP</option>
                            <option value="SE" <?php if ($row_empresa['uf'] == 'SE') echo 'selected="selected"'; ?>>SE</option>
                            <option value="TO" <?php if ($row_empresa['uf'] == 'TO') echo 'selected="selected"'; ?>>TO</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="floatingInput">Bairro</label>
                        <input class="form-control" type="text" value="<?php echo $row_empresa['bairro']; ?>" name="bairro" id="bairro" placeholder="Digite o bairro" required readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="floatingInput">Cidade</label>
                        <input class="form-control" type="text" value="<?php echo $row_empresa['cidade']; ?>" name="cidade" id="cidade" placeholder="Digite a cidade" required readonly>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="floatingInput">Data pagamento</label>
                        <input class="form-control" type="date" value="<?php echo $row_empresa['datapg_at']; ?>" name="pagamento" id="pagamento" placeholder="Data pagamento">
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="floatingInput">Data vencimento</label>
                        <input class="form-control" type="date" value="<?php echo $row_empresa['expirated_at']; ?>" name="vencimento" id="vencimento" placeholder="Data vencimento" readonly>
                    </div>
                    <div class="mb-3 col-md-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input mb-3" name="ativo" <?php if ($row_empresa['ativo'] == '1') echo 'checked="checked"'; ?> type="checkbox" id="flexSwitchCheckDefault">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Ativo</label>
                        </div>
                    </div>

                    <!--div class="g-recaptcha mb-3" data-sitekey="6LeDPB8gAAAAAKeMkKe3FK6ZB6nGfSdxydvu51bE"></div-->
                    <div class="d-flex justify-content-center">
                        <div class="col-md-3 m-2">
                            <input type="submit" value="Salvar" class="btn btn-outline-primary rounded-3 ms-2 col-md-3" id="salva">
                        </div>
                        <div class="col-md-3 m-2">
                            <button type="button" id="volta" class="btn btn-outline-primary col-md-3" onclick="window.location.href='../dashboards/painel'">Voltar</button>
                        </div>
                    </div>
                    <div class="alert alert-danger d-none">
                        Preencha o campo <span id="campo-erro"></span>!
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!--script src="../assets/js/addvencimento.js"></script-->

    <!--script>
        function formatarData(data) {
            let newDate = new Date(data);
            return `${newDate.getDate()}/${newDate.getMonth()+1}/${newDate.getFullYear()}`;
        }

        function retornaData() {
            var data = Date(getElementById("pagamento").value);
            let quantidadeDeDias = 12;
            data.setMonth(data.getMonth() + quantidadeDeDias);
            document.getElementById("vencimento").value = "teste";
        }
    </script-->
</body>

</html>