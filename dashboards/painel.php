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
        <div class="container-fluid" id="fundo">
            <div class="col-sm-9 mx-auto bg-white border shadow-sm rounded-3 my-5 p-3 align-self-center">
                <?php
                if (isset($_SESSION['nao_altersen'])) :
                ?>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Senha alterada com sucesso!',
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
                            $("#msg_sucesso").fadeOut().empty();
                        }, 6000);
                    }, false);
                </script>
                <p class="text-secondary">Dados do condomínio</p>
                <!--div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 py-1"-->
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 py-1">
                    <div>
                        <p class="dados-cond">
                            <span class="fw-bold">Nome:</span>
                            <span class="d-inline fw-light ms-1"><?php echo $row_empresa['nome']; ?></span>
                        </p>
                    </div>
                    <div>
                        <p class="dados-cond">
                            <span class="fw-bold">Endereço:</span>
                            <span class="d-inline fw-light ms-1"><?php echo $endereco; ?></span>
                        </p>
                    </div>
                    <div>
                        <p class="dados-cond">
                            <span class="fw-bold">CEP:</span>
                            <span class="d-inline fw-light ms-1"><?php echo $cep; ?></span>
                        </p>
                    </div>
                    <div>
                        <p class="dados-cond">
                            <span class="fw-bold">E-mail:</span>
                            <span class="fw-light ms-1"><?php echo $row_empresa['email']; ?></span>
                        </p>
                    </div>
                    <div>
                        <p class="dados-cond">
                            <span class="fw-bold">Contato:</span>
                            <span class="fw-light ms-1"><?php echo $row_empresa['celular']; ?></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!--script src="../assets/js/app.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../assets/js/jquery.mask.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</body>

</html>