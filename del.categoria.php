<?php
require 'inc/config.php';
require 'inc/usuarios.class.php';
require 'inc/produtos.class.php';
session_start();

if(empty($_SESSION['logado'])) {
    header("Location: ".BASE_URL."login");
    exit;
}

$u = new usuarios($pdo);
$u->setUsuario($_SESSION['logado']);


$p = new produtos($pdo);

if(!empty($_GET['nome']) &&  ($u->temPermissao('ADMINISTRADOR') || !empty($_GET['nome']) && ($u->temPermissao('PADRÃO')))) {
    $nome = $_GET['nome'];

    $p->delCategoria($nome);
    header("Location: ".BASE_URL."cadastra.produto");
    exit;
}