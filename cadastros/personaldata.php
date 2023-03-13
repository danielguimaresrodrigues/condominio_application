<?php

/*session_start();*/

include('../db/verifica_login.php');

include('../db/conexao.php');

$id = (int)$_SESSION['id_user_log'];
$result_usuario = "SELECT * FROM login WHERE id = '$id' AND ativo='1' LIMIT 1";
$resultado_usuario = mysqli_query($conexao, $result_usuario);
$row_usuario = mysqli_fetch_assoc($resultado_usuario);

$id = (int)$_SESSION['id_emp'];
$result_empresa = "SELECT * FROM empresa WHERE id = '$id' AND ativo='1' LIMIT 1";
$resultado_empresa = mysqli_query($conexao, $result_empresa);
$row_empresa = mysqli_fetch_assoc($resultado_empresa);
$conexao->close();
/*include('../db/conexao.php');

$nome = preg_split("/((de|da|do|dos|das)?)[\s,_-]+/", $_SESSION['nome']);
$iniciais = "";
foreach ($nome as $n) {
    if (strlen($n) > 0) {
        $iniciais .= $n[0];
    }
}
$id = $_SESSION['id'];
$emaill = $_SESSION['email'];*/

include '../templates/header.php';
?>

<body>

    <?php
    include '../templates/basico.php';
    ?>

    <?php if (is_null($_SESSION['cpf'])) { ?>

        <script>
            Swal.fire({
                icon: 'info',
                title: 'Conclua o cadastro dos seus dados!',
                showConfirmButton: false,
                timer: 3000
            })
        </script>
    <?php
    }
    ?>

    <section class="vw-100">
        <div class="container-fluid px-3 py-1" id="fundo">
            <div class="col-sm-9 mx-auto bg-white border shadow-sm rounded-3 px-5 py-1 align-self-center">
                <p class="nome_cond text-center py-2"><span style="font-weight: bold;"><?php echo $row_empresa['nome']; ?></span> | <?php echo $row_empresa['email']; ?></p>
            </div>
        </div>
        <div class="container-fluid px-3 py-1 mt-1">
            <div class="col-sm-9 mx-auto bg-white border shadow-sm rounded-3 px-5 align-self-center">
                <div class="image_area">
                    <form class="row mb-3" method="POST">
                        <div class="d-flex">
                            <p class=" fs-4 pt-1 text-secondary">Dados Pessoais</p>
                        </div>

                        <div class="row">
                            <div class="text-center mx-auto">
                                <!--div class="overlay">
                                    <div class="text">Click para trocar a imagem</div>
                                </div-->

                                <?php if (is_null($row_usuario['foto'])) { ?>
                                    <img id="uploaded_image" class="rounded-circle border border-secondary" src="../assets/img/people-circle-outline.svg" style="width: 150px; height: auto;">
                                <?php } else { ?>
                                    <img id="uploaded_image" class="rounded-circle border border-secondary" src="../assets/avatars/<?php echo $_SESSION['foto']; ?>" style="width: 150px; height: auto;">
                                <?php } ?>

                                <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Excluir avatar">
                                    <button type="button" class="btn btn-danger  text-center" onclick="excluir_avatar(<?php echo $row_usuario['id']; ?>)"><i class="bi bi-trash"></i></button>
                                </span>
                                <div class="col-sm-6 mt-3 text-center mx-auto">
                                    <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Trocar avatar">
                                        <input class="form-control form-control-sm image" type="file" name="image" id="upload_image" placeholder="Selecione uma imagem" required>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <form class="row mb-3" action="../edits/alteradadospessoais.php" method="POST" id="alteradados">
                    <?php
                    if (isset($_SESSION['nao_alterou'])) :
                    ?>
                        <!--script type="text/javascript">
                            swal("Parabéns!", "Dados alterados com sucesso!", "success");
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
                            }, 6000);
                        }, false);
                    </script>

                    <?php
                    if (isset($_SESSION['nao_altersen'])) :
                    ?>
                        <!--script type="text/javascript">
                            swal("Atenção!", "A senha atual não confere!", "warning");
                        </script-->
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Atenção!',
                                text: 'A senha atual não confere!',
                                timer: 3000
                            })
                        </script>
                    <?php
                    endif;
                    unset($_SESSION['nao_altersen']);
                    ?>

                    <script type="text/javascript">
                        document.addEventListener('DOMContentLoaded', function() {
                            setTimeout(function() {
                                $("#msg_errado").fadeOut().empty();
                            }, 6000);
                        }, false);
                    </script>
                    <span id="msgAlertErroLogin"></span>
                    <div class="overlay">
                        <div class="text">Click to Change Profile Image</div>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" type="hidden" value='<?php echo $row_usuario['id']; ?>' name="id" id="id" required readonly>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" type="hidden" value='<?php echo $row_usuario['foto']; ?>' name="foto" id="foto" required readonly>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="nome">Nome</label>
                        <input class="form-control" type="text" value="<?php echo $row_usuario['nome']; ?>" name="nome" id="nome" placeholder="Digite o nome" required>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="floatingInput">CPF</label>
                        <?php if (is_null($_SESSION['cpf'])) { ?>
                            <input class="form-control" type="text" value="<?php echo $row_usuario['cpf']; ?>" name="cpf" id="cpf" placeholder="Digite o cpf" required>
                        <?php } else { ?>
                            <input class="form-control" type="text" value="<?php echo $row_usuario['cpf']; ?>" name="cpf" id="cpf" placeholder="Digite o cpf" required readonly>
                        <?php } ?>
                    </div>
                    <!--div class="mb-3 col-md-3">
                        <label for="floatingInput">Perfil de Acesso</label>
                        <label class="visually-hidden" for="perfil">Estado</label>
                        <select class="form-select" name="perfil" id="perfil" required>
                            <!?php
                            if ($row_usuario['perfil'] === '0') :
                            ?>
                                <option value="0" <!?php if ($row_usuario['perfil'] == '0') echo 'selected="selected"'; ?>>Adm Sistema</option>
                            <!?php endif; ?>
                            <!?php
                            if ($row_usuario['perfil'] === '0' || $row_usuario['perfil'] === '1') :
                            ?>
                                <option value="1" <!?php if ($row_usuario['perfil'] == '1') echo 'selected="selected"'; ?>>Administrador</option>
                            <!?php endif; ?>
                            <option value="2" <!?php if ($row_usuario['perfil'] == '2') echo 'selected="selected"'; ?>>Síndico</option>
                            <option value="3" <!?php if ($row_usuario['perfil'] == '3') echo 'selected="selected"'; ?>>Condômino</option>
                        </select>

                    </div-->
                    <div class="mb-3 col-md-3">
                        <label for="floatingInput">Perfil</label>
                        <?php if ($row_usuario['perfil'] === '0') : ?>
                            <input class="form-control" type="text" value="Adm Sistema" name="perfil" id="perfil" required readonly>
                        <?php endif; ?>
                        <?php if ($row_usuario['perfil'] === '1') : ?>
                            <input class="form-control" type="text" value="Administrador" name="perfil" id="perfil" required readonly>
                        <?php endif; ?>
                        <?php if ($row_usuario['perfil'] === '2') : ?>
                            <input class="form-control" type="text" value="Síndico" name="perfil" id="perfil" required readonly>
                        <?php endif; ?>
                        <?php if ($row_usuario['perfil'] === '3') : ?>
                            <input class="form-control" type="text" value="Condômino" name="perfil" id="perfil" required readonly>
                        <?php endif; ?>
                        <?php if ($row_usuario['perfil'] === '4') : ?>
                            <input class="form-control" type="text" value="Morador" name="perfil" id="perfil" required readonly>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="floatingInput">E-mail</label>
                        <input class="form-control" type="email" value='<?php echo $_SESSION['email']; ?>' name="emaill" id="emaill" placeholder="Digite o e-mail cadastrado" required readonly>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="floatingInput">Celular</label>
                        <input class="form-control" type="text" value="<?php echo $row_usuario['celular']; ?>" name="celular" id="celular" placeholder="Digite o celular" required>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="floatingInput">RG</label>
                        <?php if (is_null($_SESSION['rg'])) : ?>
                            <input class="form-control" type="text" name="rg" id="rg_id" placeholder="Digite o RG">
                        <?php else : ?>
                            <input class="form-control" type="text" value="<?php echo $row_usuario['rg']; ?>" name="rg" id="rg_id" placeholder="Digite o RG" required readonly>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="floatingInput">Data nasc.</label>
                        <input class="form-control" type="date" value="<?php echo $row_usuario['nascimento']; ?>" name="nascimento" id="nascimento" placeholder="Data nascimento" required>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="floatingInput">CEP</label>
                        <input class="form-control" type="text" value="<?php echo $row_usuario['cep']; ?>" name="cep" onblur="pesquisacep(this.value);" id="cep" placeholder="Digite o CEP" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="floatingInput">Rua</label>
                        <input class="form-control" type="text" value="<?php echo $row_usuario['rua']; ?>" name="rua" id="rua" placeholder="Digite a rua" required>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="floatingInput">Número</label>
                        <input class="form-control" type="text" value="<?php echo $row_usuario['numero']; ?>" name="numero" id="numero" placeholder="Digite o número" required>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="floatingInput">Unidade</label>
                        <input class="form-control" type="text" value="<?php echo $row_usuario['unidade']; ?>" name="unidade" id="unidade" placeholder="Digite a unidade" readonly>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="floatingInput">Bloco</label>
                        <input class="form-control" type="text" value="<?php echo $row_usuario['bloco']; ?>" name="bloco" id="bloco" placeholder="Digite o bloco" readonly>
                    </div>
                    <div class="mb-3 col-md-3">
                        <label for="floatingInput">Estado</label>
                        <select class="form-select fw-light" name="uf" id="uf" required>
                            <option value="AC" <?php if ($row_usuario['uf'] == 'AC') echo 'selected="selected"'; ?>>AC</option>
                            <option value="AL" <?php if ($row_usuario['uf'] == 'AL') echo 'selected="selected"'; ?>>AL</option>
                            <option value="AP" <?php if ($row_usuario['uf'] == 'AP') echo 'selected="selected"'; ?>>AP</option>
                            <option value="AM" <?php if ($row_usuario['uf'] == 'AM') echo 'selected="selected"'; ?>>AM</option>
                            <option value="BA" <?php if ($row_usuario['uf'] == 'BA') echo 'selected="selected"'; ?>>BA</option>
                            <option value="CE" <?php if ($row_usuario['uf'] == 'CE') echo 'selected="selected"'; ?>>CE</option>
                            <option value="DF" <?php if ($row_usuario['uf'] == 'DF') echo 'selected="selected"'; ?>>DF</option>
                            <option value="ES" <?php if ($row_usuario['uf'] == 'ES') echo 'selected="selected"'; ?>>ES</option>
                            <option value="GO" <?php if ($row_usuario['uf'] == 'GO') echo 'selected="selected"'; ?>>GO</option>
                            <option value="MA" <?php if ($row_usuario['uf'] == 'MA') echo 'selected="selected"'; ?>>MA</option>
                            <option value="MT" <?php if ($row_usuario['uf'] == 'MT') echo 'selected="selected"'; ?>>MT</option>
                            <option value="MS" <?php if ($row_usuario['uf'] == 'MS') echo 'selected="selected"'; ?>>MS</option>
                            <option value="MG" <?php if ($row_usuario['uf'] == 'MG') echo 'selected="selected"'; ?>>MG</option>
                            <option value="PA" <?php if ($row_usuario['uf'] == 'PA') echo 'selected="selected"'; ?>>PA</option>
                            <option value="PB" <?php if ($row_usuario['uf'] == 'PB') echo 'selected="selected"'; ?>>PB</option>
                            <option value="PR" <?php if ($row_usuario['uf'] == 'PR') echo 'selected="selected"'; ?>>PR</option>
                            <option value="PE" <?php if ($row_usuario['uf'] == 'PE') echo 'selected="selected"'; ?>>PE</option>
                            <option value="PI" <?php if ($row_usuario['uf'] == 'PI') echo 'selected="selected"'; ?>>PI</option>
                            <option value="RJ" <?php if ($row_usuario['uf'] == 'RJ') echo 'selected="selected"'; ?>>RJ</option>
                            <option value="RN" <?php if ($row_usuario['uf'] == 'RN') echo 'selected="selected"'; ?>>RN</option>
                            <option value="RS" <?php if ($row_usuario['uf'] == 'RS') echo 'selected="selected"'; ?>>RS</option>
                            <option value="RO" <?php if ($row_usuario['uf'] == 'RO') echo 'selected="selected"'; ?>>RO</option>
                            <option value="RR" <?php if ($row_usuario['uf'] == 'RR') echo 'selected="selected"'; ?>>RR</option>
                            <option value="SC" <?php if ($row_usuario['uf'] == 'SC') echo 'selected="selected"'; ?>>SC</option>
                            <option value="SP" <?php if ($row_usuario['uf'] == 'SP') echo 'selected="selected"'; ?>>SP</option>
                            <option value="SE" <?php if ($row_usuario['uf'] == 'SE') echo 'selected="selected"'; ?>>SE</option>
                            <option value="TO" <?php if ($row_usuario['uf'] == 'TO') echo 'selected="selected"'; ?>>TO</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="floatingInput">Bairro</label>
                        <input class="form-control" type="text" value="<?php echo $row_usuario['bairro']; ?>" name="bairro" id="bairro" placeholder="Digite o bairro" required>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="floatingInput">Cidade</label>
                        <input class="form-control" type="text" value="<?php echo $row_usuario['cidade']; ?>" name="cidade" id="cidade" placeholder="Digite a cidade" required>
                    </div>
                    <!--div class="g-recaptcha mb-3" data-sitekey="6LeDPB8gAAAAAKeMkKe3FK6ZB6nGfSdxydvu51bE"></div-->
                    <div class="d-flex justify-content-center">
                        <div class="col-md-3 m-2">
                            <input type="submit" value="Salvar" class="btn btn-outline-primary rounded-3 ms-2" id="salva">
                        </div>
                        <div class="col-md-3 m-2">
                            <button type="button" id="volta" class="btn btn-outline-primary" onclick="window.location.href='../dashboards/painel'">Voltar</button>
                        </div>
                    </div>
                    <div class="alert alert-danger d-none">
                        Preencha o campo <span id="campo-erro"></span>!
                    </div>
                </form>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modal_avatar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-light">Seleção de foto</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row px-3">
                            <label for="floatingInput">Foto</label>
                            <div class="mb-3 col-md-12">

                                <!--button type="button" name="crop" id="crop" class="btn btn-primary btn-sm ms-1"><i class="fa-solid fa-crop-simple"></i></button-->
                            </div>

                            <!--div id="preview"></div-->
                            <div class="img py-2 d-flex justify-content-center">
                                <div class="col-sm-6">
                                    <img src="" id="sample_image" class="img-fluid img">
                                </div>
                                <div class="preview"></div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <div class="col-md-3 m-2">
                                    <button type="button" name="crop" id="crop" class="btn btn-outline-primary">Salvar</button>
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

    <!--script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script-->
    <!--script src="../assets/js/avatar.js"></script-->
    <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })
    </script>

    <script>
        $(document).ready(function() {

            var $modal = $('#modal_avatar');

            var image = document.getElementById('sample_image');

            var cropper;

            $('#upload_image').change(function(event) {
                var files = event.target.files;

                var done = function(url) {
                    image.src = url;
                    $modal.modal('show');
                };

                if (files && files.length > 0) {
                    reader = new FileReader();
                    reader.onload = function(event) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files[0]);
                }
            });

            $modal.on('shown.bs.modal', function() {
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 3,
                    preview: '.preview'
                });
            }).on('hidden.bs.modal', function() {
                cropper.destroy();
                cropper = null;
            });

            $('#crop').click(function() {
                canvas = cropper.getCroppedCanvas({
                    width: 400,
                    height: 400
                });

                canvas.toBlob(function(blob) {
                    url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function() {
                        var base64data = reader.result;
                        $.ajax({
                            url: '../edits/upload_avatar.php',
                            method: 'POST',
                            data: {
                                image: base64data
                            },
                            success: function(data) {
                                $modal.modal('hide');
                                //$('#uploaded_image').attr('src', data);
                                location.reload(true);
                            }
                        });
                    };
                });
            });

        });
    </script>

    <script>
        function excluir_avatar(id) {
            var id = id;
            var arquivo = document.getElementById("foto").value;

            $.ajax({
                url: "../edits/excluir_avatar.php", // Enviar os dados para o arquivo upload.php
                type: "POST", // Método utilizado para enviar os dados
                data: { // Dados que deve ser enviado
                    "id": id
                },
                success: function() {
                    // sweetalert - https://celke.com.br/artigo/como-usar-sweetalert-no-formulario-com-javascript-e-php
                    location.reload(true);
                }
            });
        }
    </script>
</body>

</html>