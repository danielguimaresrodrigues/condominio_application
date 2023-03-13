<?php
session_start();

ob_start();
if (!isset($_SESSION['nao_autenticado'])) {
    header('Location: ../');
    session_destroy();
}
