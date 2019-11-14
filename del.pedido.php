<?php
require 'inc/config.php';
require 'inc/usuarios.class.php';
require 'inc/pedidos.class.php';
session_start();


if(empty($_SESSION['logado'])) {
	header('Location: '.BASE_URL.'login');
	exit;
}

$u = new usuarios($pdo);
$u->setUsuario($_SESSION['logado']);

$pd= new pedidos($pdo);

if(!empty($_GET['id']) &&  ($u->temPermissao('ADMINISTRADOR') || !empty($_GET['id']) && ($u->temPermissao('PADRÃO')))) {
    $id = $_GET['id'];
    $pd->delPedido($id);
    header('Location: '.BASE_URL.'pedidos.cadastrados');
    exit;
} else {
    header('Location: '.BASE_URL.'login');
    exit;  
}
