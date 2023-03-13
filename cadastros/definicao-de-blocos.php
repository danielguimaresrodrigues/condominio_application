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

$result_blocos = "SELECT * FROM blocos WHERE id_empresa = '$id' AND ativo='1'";
$resultado_blocos = mysqli_query($conexao, $result_blocos);

$result_bloc = "SELECT count(*) as total FROM blocos WHERE id_empresa = '$id' AND ativo='1'";
$resultado_bloc = mysqli_query($conexao, $result_bloc);
$row_bloc = mysqli_fetch_assoc($resultado_bloc);

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
                <p class=" fs-4 ms-3 py-3 text-secondary">Condomínio - Definição de Blocos</p>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" href="../cadastros/dados-do-condominio">Dados do Condomínio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page">Blocos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../cadastros/definicao-de-unidades">Unidades</a>
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
                    <form class="row mb-3 px-3" name="meu-form" action="" method="POST">
                        <?php if ($row_bloc['total'] > 5) : ?>
                            <button type="button" class="btn btn-sm btn-outline-primary center-block col-sm-3" id="add" data-bs-toggle="modal" data-bs-target="#modal-adicionar" data-bs-trigger="hover focus" data-bs-content="Cadastrar cliente" disabled><i class='bi bi-plus-circle me-3' style="font-size: 1.2rem;"></i>Adicionar Bloco</button>
                        <?php else : ?>
                            <button type="button" class="btn btn-sm btn-outline-primary center-block col-sm-3" id="add" data-bs-toggle="modal" data-bs-target="#modal-adicionar" data-bs-trigger="hover focus" data-bs-content="Cadastrar cliente"><i class='bi bi-plus-circle me-3' style="font-size: 1.2rem;"></i>Adicionar Bloco</button>
                        <?php endif; ?>
                        <p class="col-sm-6">* Total de 6 blocos por condomínio.</p>
                        <?php
                        if (isset($_SESSION['cadastro_bloco'])) :
                        ?>
                            <!--script type="text/javascript">
                                swal("Parabéns!", "Bloco cadastrado com sucesso!", "success");
                            </script-->
                            <script>
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Bloco cadastrado com sucesso!',
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            </script>
                        <?php
                        endif;
                        unset($_SESSION['cadastro_bloco']);
                        ?>
                        <script type="text/javascript">
                            document.addEventListener('DOMContentLoaded', function() {
                                setTimeout(function() {
                                    $("#msg_sucesso").fadeOut().empty();
                                }, 6000);
                            }, false);
                        </script>

                        <?php
                        if (isset($_SESSION['nao_alterou'])) :
                        ?>
                            <!--script type="text/javascript">
                                swal("Parabéns!", "Bloco alterado com sucesso!", "success");
                            </script-->
                            <script>
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Bloco alterado com sucesso!',
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

                        <?php
                        if (isset($_SESSION['status_deletabloc'])) :
                        ?>
                            <!--script type="text/javascript">
                                swal("Parabéns!", "Bloco exlcuído com sucesso!", "success");
                            </script-->
                            <script>
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Bloco exlcuído com sucesso!',
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            </script>
                        <?php
                        endif;
                        unset($_SESSION['status_deletabloc']);
                        ?>
                        <script type="text/javascript">
                            document.addEventListener('DOMContentLoaded', function() {
                                setTimeout(function() {
                                    $("#msg_sucesso").fadeOut().empty();
                                }, 6000);
                            }, false);
                        </script>

                        <?php
                        if (isset($_SESSION['exist_unidades'])) :
                        ?>
                            <!--script type="text/javascript">
                                swal("Atenção!", "Unidade exlcuída com sucesso!", "warning");
                            </script-->
                            <script>
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'warning',
                                    title: 'Unidade exlcuída com sucesso!',
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            </script>
                        <?php
                        endif;
                        unset($_SESSION['exist_unidades']);
                        ?>
                        <script type="text/javascript">
                            document.addEventListener('DOMContentLoaded', function() {
                                setTimeout(function() {
                                    $("#msg_sucesso").fadeOut().empty();
                                }, 6000);
                            }, false);
                        </script>
                    </form>
                </div>

                <div class="scroll">
                    <table class="table table-hover table-striped border-top">
                        <thead class="table-primary">
                            <tr>
                                <!--th scope="col">ID</th-->
                                <th style="width: 15vw;">Nome do bloco</th>
                                <th style="width: 15vw;">Taxa condomínio</th>
                                <th scope="col">Observação</th>
                                <th style="width: 2vw;"></th>
                                <th style="width: 2vw;"></th>
                                <!--th scope="col"></th-->
                            </tr>
                        </thead>
                        <tbody id="myTable">
                            <?php
                            while ($row_blocos = mysqli_fetch_assoc($resultado_blocos)) {
                            ?>
                                <tr>
                                    <?php $taxa = $row_blocos['taxa_cond'];
                                    $taxa = str_replace('.', ',', $taxa);
                                    ?>
                                    <td class="fs-6" id="valor_bloco<?php echo $row_blocos['id']; ?>"><?php echo $row_blocos['bloco']; ?></td>
                                    <td class="fs-6" id="valor_taxa<?php echo $row_blocos['id']; ?>"><?php echo $taxa; ?></td>
                                    <td class="fs-6" id="valor_observacao<?php echo $row_blocos['id']; ?>"><?php echo $row_blocos['observacao']; ?></td>
                                    <td>
                                        <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Editar bloco">
                                            <button type="button" class="btn btn-sm btn-outline-primary center-block" id="botao_editar<?php echo $row_blocos['id']; ?>" onclick="editar_registro(<?php echo $row_blocos['id']; ?>)" data-bs-toggle="modal" data-bs-target="#modal-edit" data-bs-trigger="hover focus" data-bs-content="Cadastrar cliente"><i class='bi bi-pencil-fill'></i></button>
                                            <!--button type="button" class="btn btn-sm btn-outline-primary center-block" id="botao_salvar" style="display: none;"><i class="fa fa-floppy-disk"></i></button-->
                                        </span>
                                    </td>
                                    <td>
                                        <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" title="Excluir bloco" data-bs-trigger="hover focus" data-bs-content="Exclui o bloco e os dados pertencentes a ele.">
                                            <!--?php echo "<a class='btn btn-outline-danger btn-sm center-block' href='editcolaboradores.php?id=" . $row_empresa['id'] . "'><i class='fa fa-trash'></i></a>"; ?-->
                                            <button type="button" class="btn btn-sm btn-outline-danger center-block" onclick="exclui_registro(<?php echo $row_blocos['id']; ?>)" data-bs-toggle="modal" data-bs-target="#exclui_bloco" data-bs-trigger="hover focus" data-bs-content="Excluir Bloco"><i class='bi bi-trash-fill'></i></button>
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
                    <!--?php endif; ?-->
                    <?php $conexao->close(); ?>
                </div>
            </div>
    </section>
    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-light">Editar Bloco</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="../edits/alterablocos.php" method="POST">
                        <div class="row px-3">

                            <span id="msgAlertErroLogin"></span>
                            <div class="form-floating mb-3">
                                <input class="form-control" type="hidden" name="id_bloco" id="id_bloco" required readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="nome">Bloco</label>
                                <input class="form-control" type="text" name="bloco" id="bloco" placeholder="Digite o bloco" required>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label for="nome">Taxa cond.</label>
                                <input class="form-control" type="text" name="taxa_edit" id="valor" placeholder="Digite o valor">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="floatingInput">Observação</label>
                                <textarea class="form-control" name="observacao" id="observacao" placeholder="Observação" style="height: 10vh;" maxlength="300"></textarea>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-light">Adicionar Bloco</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="../edits/addblocos.php" method="POST">
                        <div class="row px-3">

                            <div class="form-floating mb-3">
                                <input class="form-control" type="hidden" value='<?php echo $_SESSION['id_emp']; ?>' name="id_empresa" id="id_empresa" required readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label for="nome">Bloco</label>
                                <input class="form-control" type="text" name="bloco_add" id="bloco_add" placeholder="Digite o bloco" maxlength="30" required>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label for="nome">Taxa cond.</label>
                                <input class="form-control" type="text" name="taxa_add" id="moeda" placeholder="Digite o valor">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="floatingInput">Observação</label>
                                <textarea class="form-control" name="observacao_add" id="observacao_add" placeholder="Observação" style="height: 15vh;" maxlength="300"></textarea>
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
    <div class="modal fade" id="exclui_bloco">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-light">Exclusão de Blocos</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="fs-5 text-secondary fw-light mx-5">Confirma a exclusão do Bloco?<br>
                        O bloco e suas Unidades serão removidos.<br>
                        Esta ação não poderá ser desfeita.</p>

                    <form action="../edits/excluibloco.php" method="POST">
                        <div class="row px-3">
                            <div class="form-floating mb-3">
                                <input type="hidden" name="id_bloco_trash" class="form-control" placeholder="ID" id="id_bloco_trash">
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

        <script>
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
            var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl)
            })
        </script>

        <script>
            var numb = document.forms['meu-form']['num_blocos'];

            function validatio_bloc() {
                if (numb.value == '') {
                    alert("Número de blocos não pode ser vazio");
                    return false;
                }
                if (numb.value > 6) {
                    document.getElementById("num_blocos").value = 6;
                    return false;
                }
                if (numb.value < 1) {
                    document.getElementById("num_blocos").value = 1;
                    return false;
                }

                return true;
            }
        </script>
        <!--script src="../assets/js/addvencimento.js"></script-->

        <script>
            function editar_registro(id) {
                // Ocultar o botao editar
                //document.getElementById("botao_editar" + id).style.display = "none";
                //console.log("Acessou: " + id);
                // Apresentar o botao salvar
                //document.getElementById("botao_salvar" + id).style.display = "block";

                // Recuperar os valores do registro que esta na tabela
                var bloco = document.getElementById("valor_bloco" + id);
                var taxa = document.getElementById("valor_taxa" + id);
                var observacao = document.getElementById("valor_observacao" + id);
                document.getElementById("id_bloco").value = id;
                document.getElementById("valor").value = taxa.innerHTML;
                document.getElementById("bloco").value = bloco.innerHTML;
                document.getElementById("observacao").value = observacao.innerHTML;
                // Substituir o texto pelo campo e atribuir para o campo o valor que estava na tabela
                //nome.innerHTML = "<input type='text' id='nome_text" + id + "' value='" + nome.innerHTML + "'>";
                //email.innerHTML = "<input type='text' id='email_text" + id + "' value='" + email.innerHTML + "'>";

            }

            function exclui_registro(id) {
                document.getElementById("id_bloco_trash").value = id;
            }
        </script>

</body>

</html>