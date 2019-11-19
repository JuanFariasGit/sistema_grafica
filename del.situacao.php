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

if(!empty($_GET['nome']) &&  ($u->temPermissao('ADMINISTRADOR') || !empty($_GET['nome']) && ($u->temPermissao('PADRÃO')))) {
    $nome = $_GET['nome'];

    $pd->delSituacao($nome);
    header("Location: ".BASE_URL."pedido");
    exit;
}