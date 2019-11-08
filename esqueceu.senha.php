<?php 
require 'inc/config.php';
require 'inc/usuarios.class.php';

if(!empty($_POST['email'])) {
    $email = addslashes($_POST['email']);
    $u = new usuarios($pdo);
    
    $u->esqueceuSenha($email);
}
?>

<?php require 'inc/header.php'; ?>

    <div class='d-flex flex-column justify-content-center align-items-center bg-dark text-white py-3'>    
        <form method="POST">
            <img class="my-2" width="300px" src="<?php echo BASE_URL; ?>assets/imagens/logo.png">
            <div class="form-group">
                <label for="email">Qual seu e-mail?</label>
                <input class="form-control" type="email" name="email" id="email">
            </div>
            <input class="btn-sm btn-primary font-weight-bold" type="submit" value="ENVIAR">
        </form>
    </div>  

<?php require 'inc/footer.php'; ?>