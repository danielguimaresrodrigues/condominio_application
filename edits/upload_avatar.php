<?php
session_start();
include("../db/conexao.php");

$nomefoto = 'Foto' . $_SESSION['id_user_log'] . '.gif';
$id_financeiro_upload = $_SESSION['id_user_log'];

if (isset($_POST['image'])) {
    $data = $_POST['image'];

    $image_array_1 = explode(";", $data);

    $image_array_2 = explode(",", $image_array_1[1]);

    $data = base64_decode($image_array_2[1]);

    $image_name = '../assets/avatars/' . $nomefoto;

    file_put_contents($image_name, $data);

    $sql_edit = "UPDATE login SET foto='$nomefoto', updated_at=NOW()
    WHERE id = '$id_financeiro_upload'";

    if ($conexao->query($sql_edit) === true) {
        $_SESSION['foto'] = $nomefoto;
    }
    mysqli_close($conexao);

    echo $image_name;
}
