<?php 

require 'inc/config.php';

require 'inc/usuarios.class.php';

session_start();

if(empty($_SESSION['logado'])) {

    header('Location: '.BASE_URL.'login');

}

$u = new usuarios($pdo);
$u->setUsuario($_SESSION['logado']);
$usuariologado = $u->getUsuarioNome($_SESSION['logado']);
?>



<?php require 'inc/header.php'; ?>

<?php require 'inc/menu.php'; ?>

<div class='d-flex flex-column justify-content-center align-items-center bg-dark px-3' style="min-height: 50vh">

    <h1 class="font-weight-bold text-white">Sistema Gráfico</h1>

    <img class="mt-3" src="<?php echo BASE_URL; ?>/assets/imagens/logo.png" style="max-width: 300px;">

</div>

<?php require 'inc/footer.php'; ?>