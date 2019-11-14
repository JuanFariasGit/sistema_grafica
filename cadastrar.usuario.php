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

$array_nome  = array();
foreach ($array_u as $nome_u) {
    array_push($array_nome, strtolower($nome_u['nome']));
}

$array_email = array();
foreach ($array_u as $email_u) {
    array_push($array_email, strtolower($email_u['email']));
}

$nome = $email = $senha = $permissao = $nome_exist = $email_exist = $nome_err = $email_err = '';

if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(in_array(strtolower($_POST['nome']), $array_nome)) {
        $nome_err = 'Já existe um usuário com o nome '.$_POST['nome'];
    } else {
        $nome  = addslashes($_POST['nome']);
    }
    
    if(in_array(strtolower($_POST['email']), $array_email)) {
        $email_err   = 'Já existe um usuário com o email '.$_POST['email'];
    } else {
        $email = addslashes($_POST['email']);
    }
    
    $permissao = addslashes($_POST['checkbox']);            
    $senha = md5($_POST['senha']);

    if(!empty($nome) && !empty($email)) {
        $u->addUsuario($nome, $email, $senha, $permissao);
        header("Location: ".BASE_URL."usuarios.cadastrados");
        exit;
    }    
}
?>

<?php require 'inc/header.php'; ?>

    <?php if($u->temPermissao('ADMINISTRADOR')): ?>
                <?php require 'inc/menu.php'; ?>
                <div class="text-white bg-dark py-5">
                    <form method="POST" class="my-auto" onsubmit="return validar_usuario()">
                        <div class="d-flex justify-content-center">                            
                            <h4 class="font-weight-bold">Cadastrar usuário</h4>
                        </div>    
                        <div class="form-group col-sm-6 col-12 mx-auto">
                            <label for="nome">Nome de usuário:  <span class="text-danger"><?php echo $nome_err; ?></span></label>
                            <input class="form-control" type="nome" name="nome" id="nome" value="<?php if(!empty($nome)) { echo $nome; }; ?>">
                        </div>
                        <div class="form-group col-sm-6 col-12 mx-auto">
                            <label for="email">E-mail: <span class="text-danger"><?php echo $email_err; ?></span></label>
                            <input class="form-control" type="email" name="email" id="email" value="<?php if(!empty($email)) { echo $email; }; ?>">
                        </div>
                        <div class="form-group col-sm-6 col-12 mx-auto">
                            <label for="senha">Senha:</label>    
                            <input class="form-control" type="password" name="senha" id="senha">
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="form-group form-check-inline">
                                <input type="radio" class="form-check-input" id="checkbox0" name="checkbox" value="ADMINISTRADOR" <?php if($permissao == 'ADMINISTRADOR') { echo 'checked="checked"';} ?>>
                                <label class="form-check-label" for="checkbox0">Administrador</label>
                            </div>
                            <div class="form-group form-check-inline">
                                <input type="radio" class="form-check-input" id="checkbox1" name="checkbox" value="PADRÃO" <?php if($permissao == 'PADRÃO') { echo 'checked="checked"';} ?>>
                                <label class="form-check-label" for="checkbox1">Padrão</label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12 mx-auto">
                            <input class="btn-block btn-sm btn-primary font-weight-bold border-0" type="submit" value="CADASTRAR">
                        </div>
                    </form>
                </div>       
        <?php else:
            require 'inc/menu.php';
        echo    "<div class='d-flex flex-column justify-content-center align-items-center bg-dark text-white' style='min-height: 50vh'>
                    <h4 class='font-weight-bold'>É presiso ter permissão de administrador</h4>
                    <img class='my-2' width='300px' src='assets/imagens/logo.png'>
                </div>
            "         
    ?>         
    <?php endif; ?>

<?php require 'inc/footer.php'; ?>
