<?php 

require "inc/config.php";
require "inc/usuarios.class.php";
require "inc/historico.class.php";

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
$usuariologado = $u->getUsuarioNome($_SESSION['logado']);

$h = new historico($pdo);

if(!empty(explode("?usuario=", $_GET['id_acesso'])[0]) && $u->temPermissao("ADMINISTRADOR")) {
    $id = explode("?usuario=", $_GET['id_acesso'])[0];
    
    $h->delHistorico($id);

    header("Location: ".BASE_URL."historico");
} else {
    require 'inc/menu.php';
        echo    "<div class='d-flex flex-column justify-content-center align-items-center bg-dark text-white' style='min-height: 50vh'>
                    <h4 class='font-weight-bold'>É presiso ter permissão de administrador</h4>
                    <img class='my-2' width='300px' src='assets/imagens/logo.png'>
                </div>
            " ;        
}