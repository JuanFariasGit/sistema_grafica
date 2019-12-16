<?php
require 'inc/config.php';
require 'inc/usuarios.class.php';
require 'inc/pedidos.class.php';
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

$pd= new pedidos($pdo);

if(!empty($_GET['id']) &&  ($u->temPermissao('ADMINISTRADOR') || !empty($_GET['id']) && ($u->temPermissao('PADRÃO')))) {
    $id = $_GET['id'];
    $pd->delPedido($id);
    header('Location: '.BASE_URL.'pedido');
    exit;
} else {
    header('Location: '.BASE_URL.'login');
    exit;  
}
