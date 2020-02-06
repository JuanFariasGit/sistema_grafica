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

$c= new produtos($pdo);

if(!empty($_GET['id']) &&  ($u->temPermissao('ADMINISTRADOR'))){
    $id = $_GET['id'];
    $c->delProduto($id);
    header('Location: '.BASE_URL.'produto');
    exit;
} else {
    echo    "<div class='d-flex flex-column justify-content-center align-items-center bg-dark text-white' style='min-height: 50vh'>
                     <h4 class='font-weight-bold'>É presiso ter permissão de administrador</h4>
                     <img class='my-2' width='100px' src='assets/imagens/logo.png'>
                 </div>
                ";
                exit;  
}
