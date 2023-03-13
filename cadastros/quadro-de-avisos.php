<?php

/*session_start();*/

include('../db/verifica_login.php');

if (is_null($_SESSION['cpf'])) {

    header('Location: ../cadastros/personaldata');
    exit;
}

include('../db/conexao.php');

$id = (int)$_SESSION['id_emp'];
$id_usuario = $_SESSION['id_user_log'];
$result_empresa = "SELECT * FROM empresa WHERE id = '$id' AND ativo='1' LIMIT 1";
$resultado_empresa = mysqli_query($conexao, $result_empresa);
$row_empresa = mysqli_fetch_assoc($resultado_empresa);

$result_expirado = "SELECT * FROM quadro WHERE id_empresa = '$id' AND visivel = '1' AND fixo='0' AND datavenc_at < NOW()";
$resultado_expirado = mysqli_query($conexao, $result_expirado);

while ($row_expirado = mysqli_fetch_assoc($resultado_expirado)) {
    $id_temp = $row_expirado['id'];
    $sql_edit = "UPDATE quadro SET visivel='0', updated_at=NOW()
    WHERE id = '$id_temp'";
    if ($conexao->query($sql_edit) === true) {
    }
}

include '../templates/header.php';
?>

<body>

    <?php
    include '../templates/basico.php';
    ?>

    <section class="vw-100">
        <div class="container-fluid px-2 py-1" id="fundo">
            <div class="col-sm-9 mx-auto bg-white border border-secondary shadow-sm rounded-3 px-2 py-1 align-self-center">
                <p class="nome_cond text-center py-2"><span style="font-weight: bold;"><?php echo $row_empresa['nome']; ?></span> | <?php echo $row_empresa['email']; ?></p>
            </div>
        </div>
        <div class="container-fluid mt-1">
            <div class="col-sm-9 mx-auto px-3 border border-secondary bg-white shadow rounded-3 align-self-center">
                <p class=" fs-4 ms-3 py-2 text-secondary">Quadro de avisos</p>

                <div class="row px-2 pb-3 justify-content-center gap-3">
                    <div class="mx-3 mt-4">
                        <form class="row mb-3 px-3 gap-3 no_print" name="meu-form" action="../edits/alteraconfig.php" method="POST">
                            <div class="row d-grid gap-1 d-flex justify-content-between">
                                <div class="col-md-4 d-grid gap-2 d-flex">
                                    <?php if ($_SESSION['perfil'] === '0' || $_SESSION['perfil'] === '1' || $_SESSION['perfil'] === '2') { ?>
                                        <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Novo Aviso">
                                            <button type="button" class="btn btn-sm btn-outline-primary center-block px-5" id="add" data-bs-toggle="modal" data-bs-target="#modal-adicionar" data-bs-trigger="hover focus" data-bs-content="Cadastrar cliente"><i class='bi bi-plus-circle' style="font-size: 1.2rem;"></i></button>
                                        </span>
                                    <?php } else { ?>
                                        <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Novo Aviso">
                                            <button type="button" class="btn btn-sm btn-outline-primary center-block px-5" id="add" data-bs-toggle="modal" data-bs-target="#modal-adicionar" data-bs-trigger="hover focus" data-bs-content="Cadastrar cliente" disabled><i class='bi bi-plus-circle' style="font-size: 1.2rem;"></i></button>
                                        </span>
                                    <?php } ?>
                                    <span>
                                        <button type="button" class="btn btn-sm btn-outline-primary center-block px-5" id="add_csv" onclick="window.location.href='../consultas/relatorio-de-quadro-de-avisos'"><i class="bi bi-printer-fill" style="font-size: 1.2rem;"></i></button>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                if (isset($_SESSION['status_cadastro'])) :
                ?>
                    <!--script type="text/javascript">
                                swal("Parabéns!", "Lançamento efetuado!", "success");
                            </script-->
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Lançamento efetuado com sucesso!',
                            showConfirmButton: false,
                            timer: 3000
                        })
                    </script>
                <?php
                endif;
                unset($_SESSION['status_cadastro']);
                ?>

                <?php
                if (isset($_SESSION['nao_alterou'])) :
                ?>
                    <!--script type="text/javascript">
                                swal("Parabéns!", "Lançamento efetuado!", "success");
                            </script-->
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Aviso alterado com sucesso!',
                            showConfirmButton: false,
                            timer: 3000
                        })
                    </script>
                <?php
                endif;
                unset($_SESSION['nao_alterou']);
                ?>

                <?php
                if (isset($_SESSION['status_deletabloc'])) :
                ?>
                    <!--script type="text/javascript">
                                swal("Parabéns!", "Lançamento efetuado!", "success");
                            </script-->
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Aviso excluído com sucesso!',
                            showConfirmButton: false,
                            timer: 3000
                        })
                    </script>
                <?php
                endif;
                unset($_SESSION['status_deletabloc']);
                ?>
            </div>
        </div>

        <?php
        $result_quad = "SELECT count(*) as total FROM quadro WHERE id_empresa = '$id' AND visivel = '1' ORDER BY updated_at DESC";
        $resultado_quad = mysqli_query($conexao, $result_quad);
        $row_quad = mysqli_fetch_assoc($resultado_quad);

        if ($row_quad['total'] > 0) {
            $result_quadro = "SELECT * FROM quadro WHERE id_empresa = '$id' AND visivel = '1' ORDER BY datavenc_at";
            $resultado_quadro = mysqli_query($conexao, $result_quadro);

            while ($row_quadro = mysqli_fetch_assoc($resultado_quadro)) {
        ?>
                <div class="container-fluid mt-2">
                    <div class="col-sm-9 mx-auto px-3 border border-secondary shadow-sm rounded-3 align-self-center <?php echo $row_quadro['bgcolor']; ?>">
                        <div class="row d-flex justify-content-between <?php echo $row_quadro['bgcolor']; ?>">
                            <div class="col-sm-12">
                                <h6 class="fw-bold pt-3"><?php echo $row_quadro['titulo']; ?></h6>
                            </div>
                            <div class="col-sm-9 d-flex">
                                <span><i class="bi bi-calendar3 text-primary fs-3 me-1"></i></span><span class="fs-6 fst-normal text-secondary mx-2"><?php echo date('d/m/Y', strtotime($row_quadro['datavenc_at'])); ?><span class="mx-2">|</span><span><i class="bi bi-person-fill text-primary fs-3"></i></span><span class="ms-1"><?php echo $row_quadro['usuario']; ?></span>
                            </div>

                            <div class="col-sm-9">
                                <p class="fw-normal pt-2" style="font-size: medium;"><?php echo $row_quadro['mensagem']; ?></p>
                            </div>
                            <?php if ($_SESSION['id_user_log'] === $row_quadro['id_usuario'] || $_SESSION['perfil'] === '0' || $_SESSION['perfil'] === '1') { ?>
                                <div class="col-sm-3 text-end pb-3">
                                    <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Enviar e-mail">
                                        <button type="button" class="btn btn-lg btn-outline-primary center-block px-3" id="add" data-bs-toggle="modal" data-bs-target="#modal-adicionar" data-bs-trigger="hover focus" data-bs-content="Cadastrar cliente"><i class="bi bi-envelope-fill"></i></button>
                                    </span>
                                    <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Editar Aviso">
                                        <button type="button" class="btn btn-lg btn-primary center-block px-3" id="botao_editar" onclick="editar_aviso(<?php echo $row_quadro['id']; ?>)" data-bs-toggle="modal" data-bs-target="#modal_edit" data-bs-trigger="hover focus" data-bs-content="Cadastrar cliente"><i class='bi bi-pencil-fill'></i></button>
                                    </span>
                                    <span tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Excluir Aviso">
                                        <button type="button" class="btn btn-lg btn-danger center-block px-3" id="exclui" onclick="excluir_aviso(<?php echo $row_quadro['id']; ?>)" data-bs-toggle="modal" data-bs-target="#modal_excluir" data-bs-trigger="hover focus" data-bs-content="Cadastrar cliente"><i class='bi bi-trash-fill'></i></button>
                                    </span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
        <?php
            }
        } ?>
    </section>

    <div class="modal fade" id="modal-adicionar">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-light">Novo Aviso</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="../edits/addaviso.php" method="POST">
                        <div class="row px-3">
                            <div class="mb-3 col-md-6">
                                <label for="nome">Título</label>
                                <textarea class="form-control" type="text" name="titulo_add" id="titulo_add" maxlength="150" placeholder="Digite o título" required></textarea>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label for="nome">Data</label>
                                <input class="form-control" type="date" name="data_adds" id="data_adds" placeholder="Data" required>
                            </div>
                            <div class="mb-3 col-md-1">
                                <label for="floatingInput">Exibir</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input mb-3" name="ativo" id="ativo" type="checkbox" checked disabled>
                                </div>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="floatingInput">Ocultar aviso após data</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input mb-3" name="fixo" id="fixo" type="checkbox">
                                </div>
                            </div>
                            <div class="mb-3 col-md-9">
                                <label for="nome">Descrição</label>
                                <textarea class="form-control" name="descricao_adds" id="descricao_adds" placeholder="(Opcional)" style="height: 10vh;" maxlength="600"></textarea>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="nome">Fundo do card</label>
                                <select class="form-select fw-light" name="bgcolors" id="bgcolors">
                                    <option class="bg-white" value="bg-white">bg-white</option>
                                    <option class="bg-atencao" value="bg-atencao">bg-atencao</option>
                                    <option class="bg-taleturquoise" value="bg-taleturquoise">bg-taleturquoise</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="col-md-3 m-2">
                                    <button type="submit" name="salva" id="salva" class="btn btn-outline-primary">Salvar</button>
                                </div>
                                <div class="col-md-3 m-2">
                                    <button type="button" id="volta" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_edit">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-light">Editar Aviso</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="dados_edit">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_excluir">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-light">Exclusão de Aviso</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="fs-5 text-secondary fw-light mx-5">Confirma a exclusão do aviso?</p>

                    <form action="../edits/excluiaviso.php" method="POST">
                        <div class="row px-3">
                            <div class="form-floating mb-3">
                                <input type="hidden" name="id_aviso_trash" class="form-control" placeholder="ID" id="id_aviso_trash">
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="col-md-3 m-2">
                                    <button type="submit" id="salva" name="salva" class="btn btn-danger">Confirma</button>
                                </div>
                                <div class="col-md-3 m-2">
                                    <button type="button" id="volta" name="volta" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php $conexao->close(); ?>
        <script>
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
            var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl)
            })
        </script>

        <script>
            function editar_aviso(id) {
                var id = id;

                $.ajax({
                    url: '../consultas/carregaavisoedit.php',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $("#dados_edit").html(data);
                    }
                })
            }

            function excluir_aviso(id) {
                var id = id;

                document.getElementById("id_aviso_trash").value = id;
            }
        </script>
</body>

</html>