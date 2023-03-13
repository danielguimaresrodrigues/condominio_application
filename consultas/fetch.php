<?php
session_start();
include('../db/conexao.php');

$id = (int)$_SESSION['id_emp'];

//fetch.php;

$result_quad = "SELECT count(*) as total FROM quadro WHERE id_empresa = '$id' AND visivel = '1' ORDER BY updated_at DESC";
$resultado_quad = mysqli_query($conexao, $result_quad);
$row_quad = mysqli_fetch_assoc($resultado_quad);
$count = $row_quad['total'];
if ($row_quad['total'] > 0) {
    $result_quadro = "SELECT * FROM quadro WHERE id_empresa = '$id' AND visivel = '1' ORDER BY datavenc_at";
    $resultado_quadro = mysqli_query($conexao, $result_quadro);

    echo "<a href='#' class='d-block link-dark text-decoration-none mt-3 me-4' id='dropdownUser2' data-bs-toggle='dropdown' aria-expanded='false'>";
    echo "<span class='d-inline-block' tabindex='0' data-bs-toggle='popover' data-bs-trigger='hover focus' data-bs-content='Notificações'>";
    echo "<i class='bi bi-bell text-secondary fs-3 position-relative'>";
    echo "<p class='text-center count' style='font-size: 1rem;'><span class='position-absolute top-0 start-100 translate-middle badge bg-danger mt-1'>";
    echo $row_quad['total'] . "</span></p>";
    echo "</i>";
    echo "</span>";
    echo "</a>";
    echo "<ul class='dropdown-menu text-small shadow overflow-auto' style='width: 350px; max-height: 80vh' aria-labelledby='dropdownUser2'>";

    while ($row_quadro = mysqli_fetch_assoc($resultado_quadro)) {
        //$output .= '
        echo "<li>";
        echo "<a class='dropdown-item text-wrap' href='#'>";
        echo "<strong>" . $row_quadro['titulo'] . "</strong><br /><small>" . $row_quadro['datavenc_at'] . "</small><br />";
        echo "<small><em>" . $row_quadro["mensagem"] . "</em></small>";
        echo "</a>";
        echo "</li>";
        echo "<li class='dropdown-divider'></li>";;
    }
} else {
    echo "<li><a class='dropdown-item' href='#' class='fw-bold'>No Notification Found</a></li>";
}
