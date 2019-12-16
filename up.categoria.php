<?php
require 'inc/config.php';
require 'inc/usuarios.class.php';
require 'inc/produtos.class.php';
session_start();

if(!empty($_SESSION['logado'])) {
    $id = $_SESSION['logado'];
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id AND ip = :ip");
    $sql->bindValue(":id", $id);
    $sql->bindValue(":ip", $ip);
    $sql->execute();
    
    if($sql->rowCount() == 0) {
        header("Location: ".BASE_URL."login");
        exit;
    }
  } else {
    header("Location: ".BASE_URL."login");
    exit;
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