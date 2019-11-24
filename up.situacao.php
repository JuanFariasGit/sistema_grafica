<?php
require 'inc/config.php';
require 'inc/usuarios.class.php';
require 'inc/pedidos.class.php';
session_start();

if(empty($_SESSION['logado'])) {
    header("Location: ".BASE_URL."login");
}

$u = new usuarios($pdo);
$u->setUsuario($_SESSION['logado']);

$pd = new pedidos($pdo);

if(($u->temPermissao("ADMINISTRADOR")) || ($u->temPermissao("PADRÃO"))) {
    if(!empty($_GET['nome'])) {       
        $id = explode("?id=", $_GET['nome'])[1];
        $nomesituacao = explode("?id=", $_GET['nome'])[0];
        $pd->upSituacao($id, $nomesituacao);
        header("Location: ".BASE_URL."pedido");
    }
} else {
    header("Location: ".BASE_URL."login");
}