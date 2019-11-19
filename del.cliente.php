<?php
require 'inc/config.php';
require 'inc/usuarios.class.php';
require 'inc/clientes.class.php';
session_start();


if(empty($_SESSION['logado'])) {
	header('Location: '.BASE_URL.'login');
	exit;
}

$u = new usuarios($pdo);
$u->setUsuario($_SESSION['logado']);

$c= new clientes($pdo);

if(!empty($_GET['id']) &&  ($u->temPermissao('ADMINISTRADOR') || !empty($_GET['id']) && ($u->temPermissao('PADRÃO')))) {
    $id = $_GET['id'];
    $c->delCliente($id);
    header('Location: '.BASE_URL.'cliente');
    exit;
} else {
    header('Location: '.BASE_URL.'login');
    exit;  
}

