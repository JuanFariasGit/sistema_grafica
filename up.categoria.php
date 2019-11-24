<?php
require 'inc/config.php';
require 'inc/usuarios.class.php';
require 'inc/produtos.class.php';
session_start();

if(empty($_SESSION['logado'])) {
    header("Location: ".BASE_URL."login");
}

$u = new usuarios($pdo);
$u->setUsuario($_SESSION['logado']);

$p = new produtos($pdo);

if(($u->temPermissao("ADMINISTRADOR")) || ($u->temPermissao("PADRÃO"))) {
    if(!empty($_GET['nome'])) {       
        $id = explode("?id=", $_GET['nome'])[1];
        $nomecategoria = explode("?id=", $_GET['nome'])[0];
        $p->upCategoria($id, $nomecategoria);
        header("Location: ".BASE_URL."produto");
    }
} else {
    header("Location: ".BASE_URL."login");
}