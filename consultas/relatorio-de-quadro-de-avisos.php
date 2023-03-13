<?php

/*session_start();*/

include('../db/verifica_login.php');
include('../db/conexao.php');

$id = (int)$_SESSION['id_emp'];
$result_empresa = "SELECT * FROM empresa WHERE id = '$id' AND ativo='1' LIMIT 1";
$resultado_empresa = mysqli_query($conexao, $result_empresa);
$row_empresa = mysqli_fetch_assoc($resultado_empresa);

$_SESSION['dt_inicio'] = "00-00-0000";
$_SESSION['dt_final'] = "00-00-0000";
$conexao->close();

include '../templates/print_base_avisos.php';
?>

<section class="vw-100 mx-auto">
    <div class="container-fluid px-5" id="fundo">
        <div class="bg-white border border-top-0 border-start-0 border-end-0 border-secondary pb-3 d-flex">
            <div><img class="img-fluid" src="../assets/img/Symbol-gestorr-horizontal.svg" style="width: 10vw; height: auto;"></div>
            <p class="nome_cond"><span style="font-weight: bold;"><?php echo $row_empresa['nome']; ?></span> | <?php echo $row_empresa['email']; ?> </p>
            <!--p class="fs-6">Saldo: <span class="fs-6 fw-bold"><?php echo $_SESSION['saldo'] ?></span></p>
            <p class="ms-1"> | Recebido <i class='bi bi-arrow-up-circle ms-1 text-success' style='font-size: 1.3rem;'></i></p>
            <p class="ms-1"> | Pago <i class='bi bi-arrow-down-circle ms-1' style='font-size: 1.3rem; color:brown;'></i></p-->
        </div>
        <div class="table_rp mx-auto">
            <div class="mx-auto bg-white border border-top-0 border-start-0 border-end-0 border-secondary py-1">
                <p class="text-center mx-auto"><span style="font-weight: bold;">Relatório de Quadro de Avisos</span></p>
                <p class="text-center mx-auto" id="sub_titulo"><span style="font-weight: 500;">Período de: <?php echo $_SESSION['dt_inicio']; ?> a <?php echo $_SESSION['dt_final']; ?></span></p>
            </div>


        </div>
    </div>
</section>


<script>
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    })
</script>

</body>

</html>