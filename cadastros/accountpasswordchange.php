<?php

session_start();

include('../db/verifica_login.php');

if (is_null($_SESSION['cpf'])) {

    header('Location: ../cadastros/personaldata');
    exit;
}
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
?>

<?php
include '../templates/header.php';
?>

<body>

    <?php
    include '../templates/basico.php';
    ?>

    <section class="vw-100">
        <div class="container-fluid px-5 py-1" id="fundo">
            <div class="col-md-6 mx-auto bg-white border shadow-sm rounded-3 px-5 py-3 my-5 align-self-center">
                <p class=" fs-4 py-3 text-secondary">Alteração de senha</p>
                <form class="form-floating mb-3 needs-validation" action="../edits/alterasenha.php" method="POST" id="alterasenha" novalidate>
                    <?php
                    if (isset($_SESSION['nao_confere'])) :
                    ?>
                        <!--script type="text/javascript">
                            swal("Atenção!", "Favor confirmar a nova senha igual!", "warning");
                        </script-->
                        <script>
                            Swal.fire({
                                icon: 'warning',
                                title: 'Favor confirmar a nova senha igual!',
                                showConfirmButton: false,
                                timer: 3000
                            })
                        </script>
                    <?php
                    endif;
                    unset($_SESSION['nao_confere']);
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
                                icon: 'warning',
                                title: 'A senha atual não confere!',
                                showConfirmButton: false,
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
                    <div class="mb-3">
                        <label for="floatingInput">E-mail</label>
                        <input class="form-control" type="email" value='<?php echo $_SESSION['email']; ?>' name="emaill" id="emaill" placeholder="Digite o e-mail cadastrado" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="floatingInput">Senha atual</label>
                        <input class="form-control" type="password" name="senhaatual" id="senhaatual" placeholder="Digite a senha atual" required>
                    </div>
                    <div class="mb-3">
                        <label for="floatingInput">Nova senha</label>
                        <input class="form-control" type="password" name="senha" id="senha" placeholder="Digite a nova senha" required>
                    </div>
                    <div class="mb-3">
                        <label for="floatingInput">Confirmar nova senha</label>
                        <input class="form-control" type="password" name="repsenha" id="repsenha" placeholder="Confirme a nova senha" required>
                    </div>
                    <!--div class="g-recaptcha mb-3" data-sitekey="6LeDPB8gAAAAAKeMkKe3FK6ZB6nGfSdxydvu51bE"></div-->
                    <div class="d-flex justify-content-center">
                        <div class="col-md-3 m-2">
                            <input type="submit" value="Salvar" class="btn btn-outline-primary rounded-3" id="salva">
                        </div>
                        <div class="col-md-3 m-2">
                            <button type="button" id="volta" class="btn btn-outline-primary" onclick="window.location.href='../dashboards/painel'">Cancela</button>
                        </div>
                    </div>
                    <div class="alert alert-danger d-none">
                        Preencha o campo <span id="campo-erro"></span>!
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script src="../assets/js/app.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../assets/js/jquery.mask.min.js"></script>
    <!--script src="../assets/js/alterasenha.js"></script-->

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>

</html>