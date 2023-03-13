<?php

/*session_start();*/

include('../db/verifica_login.php');

if (is_null($_SESSION['cpf'])) {

    header('Location: ../cadastros/personaldata');
    exit;
}

include('../db/conexao.php');

$id = (int)$_SESSION['id_emp'];
$result_empresa = "SELECT * FROM empresa WHERE id = '$id' AND ativo='1' LIMIT 1";
$resultado_empresa = mysqli_query($conexao, $result_empresa);
$row_empresa = mysqli_fetch_assoc($resultado_empresa);

$result_bloc = "SELECT count(*) as total FROM blocos WHERE id_empresa = '$id' AND ativo='1'";
$resultado_bloc = mysqli_query($conexao, $result_bloc);
$row_bloc = mysqli_fetch_assoc($resultado_bloc);

$result_blocos = "SELECT * FROM blocos WHERE id_empresa = '$id' AND ativo='1'";
$resultado_blocos = mysqli_query($conexao, $result_blocos);

$endereco = $row_empresa['rua'] . ", " . $row_empresa['numero'] . ", " . $row_empresa['bairro'] . ", "
    . $row_empresa['cidade'] . "-" . $row_empresa['uf'];

$cep = substr($row_empresa['cep'], 0, 2) . "." . substr($row_empresa['cep'], 2, 3) . "-" . substr($row_empresa['cep'], 5, 3);

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
                <p class=" fs-4 ms-3 py-3 text-secondary">Condomínio - Definição de unidades</p>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" href="../cadastros/dados-do-condominio">Dados do Condomínio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../cadastros/definicao-de-blocos" aria-current="page">Blocos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active">Unidades</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../cadastros/definicao-de-categorias">Categorias</a>
                    </li>
                </ul>
                <!--div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 p-3">
                    <div>
                        <p class="dados-cond">
                            <span class="fw-bold">Nome:</span>
                            <span class="d-inline fw-light ms-1"><!?php echo $row_empresa['nome']; ?></span>
                        </p>
                    </div>
                    <div>
                        <p class="dados-cond">
                            <span class="fw-bold">Endereço:</span>
                            <span class="d-inline fw-light ms-1"><!?php echo $endereco; ?></span>
                        </p>
                    </div>
                    <div>
                        <p class="dados-cond">
                            <span class="fw-bold">CEP:</span>
                            <span class="d-inline fw-light ms-1"><!?php echo $cep; ?></span>
                        </p>
                    </div>
                    <div>
                        <p class="dados-cond">
                            <span class="fw-bold">E-mail:</span>
                            <span class="fw-light ms-1"><!?php echo $row_empresa['email']; ?></span>
                        </p>
                    </div>
                    <div>
                        <p class="dados-cond">
                            <span class="fw-bold">Contato:</span>
                            <span class="fw-light ms-1"><!?php echo $row_empresa['celular']; ?></span>
                        </p>
                    </div>
                </div-->
                <div class="ms-3 mt-4">
                    <form class="row mb-3 px-3" name="" action="" method="">
                        <input class="form-control" type="hidden" name="id_empresa" id="id_empresa" required readonly>
                        <div class="d-flex">
                            <div class="input-group">
                                <!--label for="floatingInput">Bloco</label-->
                                <!--input class="form-control" type="text" name="pesquisar" id="pesquisar" required-->

                                <select class="form-select fw-light col-md-2" name="pesquisa" id="pesquisa">
                                    <option value="">Selecione o bloco</option>
                                    <?php
                                    while ($row_blocoss = mysqli_fetch_assoc($resultado_blocos)) { ?>
                                        <option value="<?php echo $row_blocoss['id'] . '|' . $row_blocoss['bloco']; ?>"><?php echo $row_blocoss['bloco']; ?></option>
                                    <?php } ?>
                                </select>
                                <a class="btnbtn btn-sm btn-outline-primary" id="busca" href="definicao-de-unidades"><i class="bi bi-x-lg my-auto"></i></a>
                            </div>
                            <!--button class="btn btn-sm btn-outline-primary" id="busca"><i class="fa fa-xmark"></i></button-->

                            <!--label for="floatingInput">Adicionar unidades</label-->
                            <?php if ($row_bloc['total'] > 5) : ?>
                                <button type="button" class="btn btn-sm btn-outline-primary center-block col-sm-3 mx-3" id="add" data-bs-toggle="modal" data-bs-target="#modal-adicionar" data-bs-trigger="hover focus" data-bs-content="Cadastrar cliente" disabled><i class='bi bi-plus-circle me-3' style="font-size: 1.2rem;"></i>Adicionar Unidade</button>
                            <?php else : ?>
                                <button type="button" class="btn btn-sm btn-outline-primary center-block col-sm-3 mx-3" id="add" data-bs-toggle="modal" data-bs-trigger="hover focus" data-bs-content="Cadastrar cliente" onclick="carrega_bloco()"><i class='bi bi-plus-circle me-3' style="font-size: 1.2rem;"></i>Adicionar Unidade</button>
                            <?php endif; ?>
                        </div>
                        <?php
                        if (isset($_SESSION['cadastro_unidade'])) :
                        ?>
                            <!--script type="text/javascript">
                                swal("Parabéns!", "Unidade cadastrada com sucesso!", "success");
                            </script-->
                            <script>
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Unidade cadastrada com sucesso!',
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            </script>
                        <?php
                        endif;
                        unset($_SESSION['cadastro_unidade']);
                        ?>
                        <script type="text/javascript">
                            document.addEventListener('DOMContentLoaded', function() {
                                setTimeout(function() {
                                    $("#msg_sucesso").fadeOut().empty();
                                }, 4000);
                            }, false);
                        </script>

                        <?php
                        if (isset($_SESSION['nao_alterou'])) :
                        ?>
                            <!--script type="text/javascript">
                                swal("Parabéns!", "Unidade alterada com sucesso!", "success");
                            </script-->
                            <script>
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Unidade alterada com sucesso!',
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
                                }, 4000);
                            }, false);
                        </script>

                        <?php
                        if (isset($_SESSION['status_deletabloc'])) :
                        ?>
                            <!--script type="text/javascript">
                                swal("Parabéns!", "Unidade exlcuída com sucesso!", "success");
                            </script-->
                            <script>
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Unidade exlcuída com sucesso!',
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            </script>
                            <!--div id="msg_sucesso" class="alert alert-success my-3" role="alert">
                                Unidade exlcuída com sucesso!
                            </div-->
                        <?php
                        endif;
                        unset($_SESSION['status_deletabloc']);
                        ?>
                        <script type="text/javascript">
                            document.addEventListener('DOMContentLoaded', function() {
                                setTimeout(function() {
                                    $("#msg_sucesso").fadeOut().empty();
                                }, 4000);
                            }, false);
                        </script>

                        <?php
                        if (isset($_SESSION['total_unidades'])) :
                        ?>
                            <!--script type="text/javascript">
                                swal("Atenção!", "Somente 16 unidades por bloco!", "warning");
                            </script-->
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Atenção!',
                                    text: 'Somente 16 unidades por bloco!',
                                    timer: 3000
                                })
                            </script>
                        <?php
                        endif;
                        unset($_SESSION['total_unidades']);
                        ?>
                        <script type="text/javascript">
                            document.addEventListener('DOMContentLoaded', function() {
                                setTimeout(function() {
                                    $("#msg_sucesso").fadeOut().empty();
                                }, 4000);
                            }, false);
                        </script>
                    </form>
                </div>

                <div class="scroll">
                    <?php
                    $sql = "SELECT * FROM unidades WHERE id_empresa = '$id' AND ativo='1' ORDER BY bloco, unidade";

                    $resultado_unidades = $conexao->query($sql);


                    $result_cont_unidades = "SELECT count(*) as total_unidades FROM unidades WHERE id_empresa = '$id' AND ativo='1'";
                    $resultado_cont_unidades = mysqli_query($conexao, $result_cont_unidades);
                    $row_cont_unidades = mysqli_fetch_assoc($resultado_cont_unidades);
                    ?>
                    <!--?php if (!empty($_GET['search'])) { ?-->
                    <?php if ($row_cont_unidades['total_unidades'] > 0) : ?>
                        <table class="table table-hover table-striped border-top">
                            <thead class="table-primary">
                                <tr>
                                    <!--th scope="col">ID</th-->
                                    <th style="width: 20vw;">Unidade</th>
                                    <th scope="col">Bloco</th>
                                    <th style="width: 2vw;"></th>
                                    <th style="width: 2vw;"></th>
                                    <!--th scope="col"></th-->
                                </tr>
                            </thead>
                            <tbody id="myTable">
                                <?php
                                /*$data = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_NUMBER_INT);
                            $result_unidades = "SELECT * FROM unidades WHERE id_empresa = '$id' AND bloco = '$data'";
                            $result_blocos = "SELECT * FROM unidades WHERE id_empresa = '$id' AND bloco = ";

                            $resultado_unidades = mysqli_query($conexao, $result_unidades);*/

                                while ($row_unidades = mysqli_fetch_assoc($resultado_unidades)) {
                                ?>
                                    <tr>
                                        <td class="fs-6" id="valor_bloco<?php echo $row_unidades['id']; ?>"><?php echo $row_unidades['unidade']; ?></td>
                                        <td class="fs-6" id="valor_unidade<?php echo $row_unidades['id']; ?>"><?php echo $row_unidades['bloco']; ?></td>
                                        <td>
                                            <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Editar projeto">
                                                <button type="button" class="btn btn-sm btn-outline-primary center-block" id="botao_editar<?php echo $row_unidades['id']; ?>" onclick="editar_registro(<?php echo $row_unidades['id']; ?>)" data-bs-toggle="modal" data-bs-target="#modal-edit" data-bs-trigger="hover focus" data-bs-content="Cadastrar cliente"><i class='bi bi-pencil-fill'></i></button>
                                                <!--button type="button" class="btn btn-sm btn-outline-primary center-block" id="botao_salvar" style="display: none;"><i class="fa fa-floppy-disk"></i></button-->
                                            </span>
                                        </td>
                                        <td>
                                            <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Excluir projeto">
                                                <!--?php echo "<a class='btn btn-outline-danger btn-sm center-block' href='editcolaboradores.php?id=" . $row_empresa['id'] . "'><i class='fa fa-trash'></i></a>"; ?-->
                                                <button type="button" class="btn btn-sm btn-outline-danger center-block" onclick="exclui_registro(<?php echo $row_unidades['id']; ?>)" data-bs-toggle="modal" data-bs-target="#exclui_bloco" data-bs-trigger="hover focus" data-bs-content="Excluir Bloco"><i class='bi bi-trash-fill'></i></button>
                                            </span>
                                        </td>
                                        <!--td>
                                                <div class="dropdown me-1">
                                                    <button type="button" class="btn btn-secondary" id="dropdownMenuOffset" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="10,20">
                                                        ...
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                    </ul>
                                                </div>
                                            </td-->
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>

                    <?php endif; ?>

                </div>
            </div>
    </section>
    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-light">Editar Unidade</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="../edits/alteraunidades.php" method="POST">
                        <div class="row px-3">

                            <input class="form-control" type="hidden" name="id_unidade" id="id_unidade" required readonly>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="nome">Bloco</label>
                                    <input class="form-control" type="text" name="bloco-edit" id="bloco-edit" placeholder="Digite o bloco" required readonly>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="nome">Unidade</label>
                                    <input class="form-control" type="text" name="unidade-edit" id="unidade-edit" placeholder="Digite a unidade" maxlength="30" required>
                                </div>
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
    <div class="modal fade" id="modal-adicionar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-light">Adicionar Unidade</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="../edits/addunidades.php" method="POST">

                        <input class="form-control" type="hidden" value='<?php echo $_SESSION['id_emp']; ?>' name="id_empresa" id="id_empresa" required readonly>
                        <input class="form-control" type="hidden" name="id_bloc" id="id_bloc" required readonly>
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label for="nome">Bloco</label>
                                <input class="form-control" type="text" name="bloco-add" id="bloco-add" placeholder="Digite o bloco" required readonly>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="nome">Unidade</label>
                                <input class="form-control" type="text" name="unidade-add" id="unidade-add" placeholder="Digite a unidade" maxlength="30" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="col-md-3 m-2">
                                <button type="submit" name="salva" id="salva" class="btn btn-outline-primary">Salvar</button>
                            </div>
                            <div class="col-md-3 m-2">
                                <button type="button" id="volta" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exclui_bloco">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-light">Exclusão de Unidades</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="fs-5 text-secondary fw-light mx-5">Confirma a exclusão da Unidade?</p>

                    <form action="../edits/excluiunidade.php" method="POST">
                        <div class="row px-3">
                            <div class="form-floating mb-3">
                                <input type="hidden" name="id_unidade_trash" class="form-control" placeholder="ID" id="id_unidade_trash">
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
            function editar_registro(id) {

                // Recuperar os valores do registro que esta na tabela
                var bloco = document.getElementById("valor_unidade" + id);
                var observacao = document.getElementById("valor_bloco" + id);
                document.getElementById("id_unidade").value = id;
                document.getElementById("bloco-edit").value = bloco.innerHTML;
                document.getElementById("unidade-edit").value = observacao.innerHTML;
            }

            function exclui_registro(id) {
                document.getElementById("id_unidade_trash").value = id;
            }

            function carrega_bloco() {
                if (document.getElementById('pesquisa').value != '') {
                    var resultado = document.getElementById('pesquisa').value;
                    var result = resultado.split("|", 2);

                    document.getElementById('id_bloc').value = result[0];
                    document.getElementById('bloco-add').value = result[1];
                    $(document).ready(function() {
                        $('#modal-adicionar').modal('show');
                    });
                } else {
                    swal("ATENÇÃO", "Você precisa indicar um bloco", "info");
                }
            }
        </script>

        <script>
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
            var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl)
            })
        </script>

        <script>
            $(document).ready(function() {
                $("#pesquisa").on("change", function() {
                    var str = $(this).val().toLowerCase();
                    var value = str.split("|", 2);
                    $("#myTable tr").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value[1]) > -1)
                    });
                });
            });
        </script>
        <!--script>
            $(document).ready(function() {
                $("#pesquisar").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $("#myTable tr").filter(function() {
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                });
            });
        </script-->
</body>

</html>