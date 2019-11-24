<?php
require 'inc/config.php';
require 'inc/usuarios.class.php';
require 'inc/pedidos.class.php';
session_start();

if(empty($_SESSION['logado'])) {
    header("Location: ".BASE_URL."login");
    exit;
}

$u = new usuarios($pdo);
$u->setUsuario($_SESSION['logado']);


$pd = new pedidos($pdo);

if(!empty($_GET['id']) &&  ($u->temPermissao('ADMINISTRADOR') || !empty($_GET['id']) && ($u->temPermissao('PADRÃO')))) {
    $id = $_GET['id'];

    $pd->delSituacao($id);
    header("Location: ".BASE_URL."pedido");
    exit;
}