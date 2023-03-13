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

$endereco = $row_empresa['rua'] . ", " . $row_empresa['numero'] . ", " . $row_empresa['bairro'] . ", "
    . $row_empresa['cidade'] . "-" . $row_empresa['uf'];

$cep = substr($row_empresa['cep'], 0, 2) . "." . substr($row_empresa['cep'], 2, 3) . "-" . substr($row_empresa['cep'], 5, 3);

$_SESSION['tela'] = '../cadastros/gerenciamento-de-usuarios';
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
                <p class=" fs-4 ms-3 py-3 text-secondary">Gerenciamento de Usuários</p>

                <div class="mt-4">
                    <form class="row mb-3" name="" action="" method="">
                        <div class="d-flex">
                            <button type="button" class="btn btn-sm btn-outline-primary center-block col-sm-3" id="add" data-bs-toggle="modal" data-bs-target="#modal-adicionar" data-bs-trigger="hover focus" data-bs-content="Cadastrar cliente"><i class='bi bi-person-plus me-3' style="font-size: 1.2rem;"></i>Adicionar Usuário</button>
                        </div>
                        <?php
                        if (isset($_SESSION['colaborador_cad'])) :
                        ?>
                            <!--script type="text/javascript">
                                swal("Parabéns!", "Unidade cadastrada com sucesso!", "success");
                            </script-->
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Usuário cadastrado com sucesso!',
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                            </script>
                        <?php
                        endif;
                        unset($_SESSION['colaborador_cad']);
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
                                    icon: 'success',
                                    title: 'Usuário exlcuído com sucesso!',
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
                        if (isset($_SESSION['preenche_obs'])) :
                        ?>
                            <!--script type="text/javascript">
                                swal("Atenção!", "Somente 16 unidades por bloco!", "warning");
                            </script-->
                            <script>
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Atenção!',
                                    text: 'Preencher observação do motivo da desativação',
                                    timer: 3000
                                })
                            </script>
                        <?php
                        endif;
                        unset($_SESSION['preenche_obs']);
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
                    $sql = "SELECT * FROM login WHERE id_empresa = '$id' ORDER BY nome";

                    $resultado_usuarios = $conexao->query($sql);


                    $result_cont_usuarios = "SELECT count(*) as total_usuarios FROM login WHERE id_empresa = '$id'";
                    $resultado_cont_usuarios = mysqli_query($conexao, $result_cont_usuarios);
                    $row_cont_usuarios = mysqli_fetch_assoc($resultado_cont_usuarios);
                    ?>
                    <!--?php if (!empty($_GET['search'])) { ?-->
                    <?php if ($row_cont_usuarios['total_usuarios'] > 0) : ?>
                        <table class="table table-hover table-striped border-top">
                            <thead class="table-primary">
                                <tr>
                                    <!--th scope="col">ID</th-->
                                    <th style="width: 20%;">Nome</th>
                                    <th style="width: 20%;">E-mail</th>
                                    <th class="d-none">id bloco</th>
                                    <th style="width: 10%;">Bloco</th>
                                    <th class="d-none">id unidade</th>
                                    <th style="width: 5%;">Unidade</th>
                                    <th style="width: 10%;">Perfil</th>
                                    <th scope="col">Observação</th>
                                    <th style="width: 2%;">Ativo</th>
                                    <th style="width: 2%;"></th>
                                    <th style="width: 2%;"></th>
                                    <!--th scope="col"></th-->
                                </tr>
                            </thead>
                            <tbody id="myTable">
                                <?php
                                /*$data = filter_input(INPUT_GET, 'pesquisar', FILTER_SANITIZE_NUMBER_INT);
                            $result_unidades = "SELECT * FROM unidades WHERE id_empresa = '$id' AND bloco = '$data'";
                            $result_blocos = "SELECT * FROM unidades WHERE id_empresa = '$id' AND bloco = ";

                            $resultado_unidades = mysqli_query($conexao, $result_unidades);*/

                                while ($row_usuarios = mysqli_fetch_assoc($resultado_usuarios)) {
                                ?>
                                    <tr>
                                        <td class="fs-6" id="valor_nome<?php echo $row_usuarios['id']; ?>"><?php echo $row_usuarios['nome']; ?></td>
                                        <td class="fs-6 text-break" id="valor_email<?php echo $row_usuarios['id']; ?>"><?php echo $row_usuarios['email']; ?></td>
                                        <td class="d-none" id="valor_id_bloco<?php echo $row_usuarios['id']; ?>"><?php echo $row_usuarios['id_bloco']; ?></td>
                                        <td class="fs-6" id="valor_bloco<?php echo $row_usuarios['id']; ?>"><?php echo $row_usuarios['bloco']; ?></td>
                                        <td class="d-none" id="valor_id_unidade<?php echo $row_usuarios['id']; ?>"><?php echo $row_usuarios['id_unidade']; ?></td>
                                        <td class="fs-6" id="valor_unidade<?php echo $row_usuarios['id']; ?>"><?php echo $row_usuarios['unidade']; ?></td>
                                        <?php if ($row_usuarios['perfil'] === '0') { ?>
                                            <td class="fs-6" id="valor_perfil<?php echo $row_usuarios['id']; ?>">Adm Sistema</td>
                                        <?php } elseif ($row_usuarios['perfil'] === '1') { ?>
                                            <td class="fs-6" id="valor_perfil<?php echo $row_usuarios['id']; ?>">Administrador</td>
                                        <?php } elseif ($row_usuarios['perfil'] === '2') { ?>
                                            <td class="fs-6" id="valor_perfil<?php echo $row_usuarios['id']; ?>">Síndico</td>
                                        <?php } elseif ($row_usuarios['perfil'] === '3') { ?>
                                            <td class="fs-6" id="valor_perfil<?php echo $row_usuarios['id']; ?>">Condômino</td>
                                        <?php } elseif ($row_usuarios['perfil'] === '4') { ?>
                                            <td class="fs-6" id="valor_perfil<?php echo $row_usuarios['id']; ?>">Morador</td>
                                        <?php } ?>
                                        <td class="fs-6" id="valor_obs<?php echo $row_usuarios['id']; ?>"><?php echo $row_usuarios['observacao']; ?></td>
                                        <?php if ($row_usuarios['ativo'] === '0') { ?>
                                            <td><i class="bi bi-toggle-off ms-1 text-secondary" style="font-size: 1.3rem;"></i></td>
                                        <?php } else { ?>
                                            <td><i class="bi bi-toggle-on ms-1 text-primary" style="font-size: 1.3rem;"></i></td>
                                        <?php } ?>
                                        <td>
                                            <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Editar Usuário">
                                                <button type="button" class="btn btn-sm btn-outline-primary center-block" id="botao_editar<?php echo $row_usuarios['id']; ?>" onclick="editar_usuario(<?php echo $row_usuarios['id']; ?>)" data-bs-toggle="modal" data-bs-target="#modal-edit" data-bs-trigger="hover focus" data-bs-content="Cadastrar cliente"><i class='bi bi-pencil-fill'></i></button>
                                                <!--button type="button" class="btn btn-sm btn-outline-primary center-block" id="botao_salvar" style="display: none;"><i class="fa fa-floppy-disk"></i></button-->
                                            </span>
                                        </td>
                                        <td>
                                            <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Excluir Usuário">
                                                <!--?php echo "<a class='btn btn-outline-danger btn-sm center-block' href='editcolaboradores.php?id=" . $row_empresa['id'] . "'><i class='fa fa-trash'></i></a>"; ?-->
                                                <button type="button" class="btn btn-sm btn-outline-danger center-block" onclick="exclui_registro(<?php echo $row_usuarios['id']; ?>)" data-bs-toggle="modal" data-bs-target="#exclui_user" data-bs-trigger="hover focus" data-bs-content="Excluir Bloco"><i class='bi bi-trash-fill'></i></button>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-light">Editar Usuário</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="dados_edit">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-adicionar">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-light">Adicionar Usuário</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="../edits/adduser.php" method="POST">

                        <input class="form-control" type="hidden" value='<?php echo $_SESSION['id_emp']; ?>' name="id_empresa" id="id_empresa" required readonly>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="nome">Nome</label>
                                <input class="form-control" type="text" name="nome_add" id="nome_add" placeholder="Digite o nome" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="nome">E-mail</label>
                                <input class="form-control" type="email" name="email_add" id="email_add" placeholder="Digite o e-mail" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="floatingInput">Perfil de Acesso</label>
                                <label class="visually-hidden" for="perfil">Estado</label>
                                <select class="form-select" name="perfil" id="perfil" required>
                                    <option value="0">Adm Sistema</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Síndico</option>
                                    <option value="3">Condômino</option>
                                    <option value="4">Morador</option>
                                </select>

                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="nome">Bloco</label>
                                <select class="form-select fw-light col-md-2" name="bloco_adds" id="bloco_adds">
                                    <option value="">Selecione o bloco</option>
                                    <?php
                                    while ($row_blocoss = mysqli_fetch_assoc($resultado_blocos)) { ?>
                                        <option value="<?php echo $row_blocoss['id'] . '|' . $row_blocoss['bloco']; ?>"><?php echo $row_blocoss['bloco']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="nome">Unidade</label>
                                <select class="form-select fw-light col-md-2" name="unidade_adds" id="unidade_adds">
                                    <option value="">Selecione um bloco antes</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="nome">cep</label>
                                <input class="form-control" type="text" name="cep" id="cep" placeholder="Digite o CEP" maxlength="30" onblur="pesquisacep(this.value);" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="nome">Número</label>
                                <input class="form-control" type="text" name="numero" id="numero" placeholder="Digite o número" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="nome">Rua</label>
                                <input class="form-control" type="text" name="rua" id="rua" placeholder="Digite a rua" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="nome">UF</label>
                                <select class="form-select" name="uf" id="uf" required>
                                    <option value="AC">AC</option>
                                    <option value="AL">AL</option>
                                    <option value="AP">AP</option>
                                    <option value="AM">AM</option>
                                    <option value="BA">BA</option>
                                    <option value="CE">CE</option>
                                    <option value="DF">DF</option>
                                    <option value="ES">ES</option>
                                    <option value="GO">GO</option>
                                    <option value="MA">MA</option>
                                    <option value="MT">MT</option>
                                    <option value="MS">MS</option>
                                    <option value="MG">MG</option>
                                    <option value="PA">PA</option>
                                    <option value="PB">PB</option>
                                    <option value="PR">PR</option>
                                    <option value="PE">PE</option>
                                    <option value="PI">PI</option>
                                    <option value="RJ">RJ</option>
                                    <option value="RN">RN</option>
                                    <option value="RS">RS</option>
                                    <option value="RO">RO</option>
                                    <option value="RR">RR</option>
                                    <option value="SC">SC</option>
                                    <option value="SP">SP</option>
                                    <option value="SE">SE</option>
                                    <option value="TO">TO</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="nome">Bairro</label>
                                <input class="form-control" type="text" name="bairro" id="bairro" placeholder="Digite o bairro" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="nome">Cidade</label>
                                <input class="form-control" type="text" name="cidade" id="cidade" placeholder="Digite a cidade" required>
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
    <div class="modal fade" id="exclui_user">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-light">Exclusão de Usuários</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="fs-5 text-secondary fw-light mx-5">Confirma a exclusão do usuário?</p>

                    <form action="../edits/excluiusuario.php" method="POST">
                        <div class="row px-3">
                            <div class="form-floating mb-3">
                                <input type="hidden" name="id_user_trash" class="form-control" placeholder="ID" id="id_user_trash">
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
                var nome = document.getElementById("valor_nome" + id);
                var email = document.getElementById("valor_email" + id);
                var bloco = document.getElementById("valor_bloco" + id);
                var unidade = document.getElementById("valor_unidade" + id);
                var observacao = document.getElementById("valor_obs" + id);

                document.getElementById("id_edit").value = id;
                document.getElementById("nome_edit").value = nome.innerHTML;
                document.getElementById("email_edit").value = email.innerHTML;
                document.getElementById("bloco_edit").value = bloco.innerHTML;
                document.getElementById("unidade_edit").value = unidade.innerHTML;
                document.getElementById("observacao_edit").value = observacao.innerHTML;
            }

            function exclui_registro(id) {
                document.getElementById("id_user_trash").value = id;
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

        <script type="text/javascript">
            $("#cep_edit").mask("00.000-000");
        </script>

        <script>
            $("#bloco_adds").on("change", function() {
                var blocoss = $("#bloco_adds").val();
                blocoss = blocoss.split("|", 2);

                $.ajax({
                    url: '../consultas/listarunidade.php',
                    type: 'POST',
                    data: {
                        bloco: blocoss[1]
                    },
                    success: function(data) {
                        $("#unidade_adds").html(data);
                    }
                })
            });

            function validaObs() {
                let observacao = document.getElementsByName("observacao_edit").value;
                let ativo = document.getElementsByName("ativo");

                if (ativo.checked) {

                } else {
                    if (observacao.length == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Atenção!',
                            text: 'Preencher observação do motivo da desativação!',
                            timer: 3000
                        })
                        return false
                    }

                }
            };

            function editar_usuario(id) {
                var id_user = id;

                $.ajax({
                    url: '../consultas/carregauseredit.php',
                    type: 'POST',
                    data: {
                        id_user: id_user
                    },
                    success: function(data) {
                        $("#dados_edit").html(data);
                    }
                })
            }
        </script>
</body>

</html>