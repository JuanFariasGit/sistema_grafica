<?php
require 'inc/config.php';
require 'inc/usuarios.class.php';
session_start();

if(empty($_SESSION['logado'])) {
	header('Location: '.BASE_URL.'login');
	exit;
}

$u = new usuarios($pdo);
$u->setUsuario($_SESSION['logado']);
$array_u = $u->getUsuario();

$array_permissao = array();
foreach ($array_u as $permissao_u) {
    array_push($array_permissao, $permissao_u['permissao']);
}

$cont = 0;
for($i = 0; $i < count($array_permissao); $i++) {
    if($array_permissao[$i] == 'ADMINISTRADOR') {
            $cont++;
    }    
}

if($cont == 1 && $u->temPermissao('ADMINISTRADOR') && !empty($_GET['id'])) {
   echo "<script>alert('O usuário ".$u->getUsuarioNome($_SESSION['logado'])['nome']." é o único Administrador. Não será possível deletá-lo.'); location = 'usuarios.cadastrados'</script>";
} else {
    if(!empty($_GET['id']) && $u->temPermissao('ADMINISTRADOR')) {
        $id = $_GET['id'];
        if($id == $_SESSION['logado']) {
            $u->delUsuario($id);
            header("Location: ".BASE_URL."login/logout");
            exit;
        } else {
            $u->delUsuario($id);
            header("Location: ".BASE_URL."usuario");
            exit;   
        }
    } else {
        require 'inc/header.php';
                    require 'inc/menu.php';
            echo "<div class='d-flex flex-column justify-content-center align-items-center bg-dark text-white' style='min-height: 50vh'>
                        <h4 class='font-weight-bold'>É presiso ter permissão de administrador</h4>
                        <img class='my-2' width='300px' src='assets/imagens/logo.png'>
                    </div>
                    " ;   
        require 'inc/footer.php';     
    }      
}

if(empty($_GET['id'])) {
    header('Location: '.BASE_URL);
    exit;
}