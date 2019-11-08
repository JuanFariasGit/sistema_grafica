<?php 
require 'inc/config.php';
require 'inc/usuarios.class.php';
session_start();


$nome = $email = $login_err = '';
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST['nomeouemail']) && count(explode('@',$_POST['nomeouemail'])) > 1) {
        $email = addslashes($_POST['nomeouemail']);
    } else {
        $nome = addslashes($_POST['nomeouemail']);
    }
    $senha = md5($_POST['senha']);
    $u = new usuarios($pdo);
    
    if($u->fazerLogin($nome, $email, $senha)) {
        header('Location: '.BASE_URL);
        exit;
    } else {
        $login_err = 'Nome de usuário e/ou E-mail e/ou senha estão errados!';
    }
}
if($_GET['url'] == 'login/logout') {
    unset($_SESSION['logado']);
    header('Location: '.BASE_URL.'login');
    exit;
}
?>

<?php require 'inc/header.php'; ?>

    <div class="d-flex flex-column justify-content-center align-items-center text-white bg-dark py-3">
        <form method="POST" onsubmit="return validar_login()">
            <img class="my-2" width="300px" src="<?php echo BASE_URL; ?>assets/imagens/logo.png">
            <div class="form-group">
                <label for="nomeouemail">Nome de usuário ou E-mail:</label>
                <input class="form-control" type="text" name="nomeouemail" id="nomeouemail">
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>    
                <input class="form-control" type="password" name="senha" id="senha">
            </div>
            <input class="btn-sm btn-primary font-weight-bold" type="submit" value="ENTRAR">
        </form>
        <a class="my-2" href='<?php BASE_URL; ?>esqueceu.senha'>Esqueceu a senha?</a>
        <span class='text-danger'><?php echo $login_err; ?></span>
        <footer class="font-italic text-center bg-dark text-white">Desenvolvido Por Gráfica Sua Impressora</footer>
    </div>       

<?php require 'inc/footer.php'; ?>