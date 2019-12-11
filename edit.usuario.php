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
$usuariologado = $u->getUsuarioNome($_SESSION['logado']);
$dados_u = $u->getUsuarioEdit($_GET['id']);
$array_u = $u->getUsuario();

$array_nome  = array();
foreach ($array_u as $nome_u) {
    array_push($array_nome, strtolower($nome_u['nome']));
}

$array_email = array();
foreach ($array_u as $email_u) {
    array_push($array_email, strtolower($email_u['email']));
}

$array_permissao_adm = array();
foreach ($array_u as $permissao_u) {
    if($permissao_u['permissao'] == 'ADMINISTRADOR') {
        array_push($array_permissao_adm, $permissao_u['permissao']);
    }
}

$nome = $email = $senha = $permissao = $nome_exist = $email_exist = $nome_err = $email_err = '';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = addslashes($_GET['id']);
    if($dados_u[0]['nome'] != $_POST['nome']) {
        if(in_array(strtolower($_POST['nome']), $array_nome)) {
            $nome_err = 'Já existe um usuário com o nome '.$_POST['nome'];
        } else {
            $nome  = addslashes($_POST['nome']);
        }
    } else {
        $nome  = addslashes($_POST['nome']); 
    }
    if($dados_u[0]['email'] != $_POST['email']) { 
        if(in_array(strtolower($_POST['email']), $array_email)) {
            $email_err   = 'Já existe um usuário com o e-mail '.$_POST['email'];
        } else {
            $email = addslashes($_POST['email']);
        }
    } else {
        $email = addslashes($_POST['email']);
    }
    if(count($array_permissao_adm) == 1 && $dados_u[0]['permissao'] == 'ADMINISTRADOR' && $_POST['checkbox'] == 'PADRÃO') {
        echo "<script>alert('O usuário ".$dados_u[0]['nome']." é o único Administrador. Não será possível alterar para usuário PADRÃO.');</script>";
    } else {
        $permissao = addslashes($_POST['checkbox']);
    }
    if(!empty($nome) && !empty($email) && !empty($permissao)) {
        $u->upUsuario($id , $nome, $email, $permissao);
        header("Location: ".BASE_URL."usuario");
        exit; 
    }   
}
?>

<?php require 'inc/header.php'; ?>

<?php if($u->temPermissao('ADMINISTRADOR')): ?>
    <?php foreach($dados_u as $dados_u): ?>
                <?php require 'inc/menu.php'; ?> 
                <div class="d-flex flex-column text-white bg-dark py-5">
                    <form method="POST" class="my-auto" onsubmit="return validar_usuario()">
                        <div class="d-flex flex-column align-items-center">                           
                            <h4 class="font-weight-bold text-center">USUÁRIO (Editar)</h4>
                        </div>    
                        <div class="form-group col-sm-6 col-12 mx-auto">
                        <label for="nome">Nome de usuário:  <span class="text-danger"><?php echo $nome_err; ?></span></label>
                        <input class="form-control" type="nome" name="nome" id="nome" value="<?php if(!empty($dados_u['nome'])) { echo $dados_u['nome']; }; ?>">
                        </div>
                        <div class="form-group col-sm-6 col-12 mx-auto">
                        <label for="email">E-mail: <span class="text-danger"><?php echo $email_err; ?></span></label>
                        <input class="form-control" type="email" name="email" id="email" value="<?php if(!empty($dados_u['email'])) { echo $dados_u['email']; }; ?>">
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="form-group form-check-inline">
                                <input type="radio" class="form-check-input" id="checkbox0" name="checkbox" value="ADMINISTRADOR" <?php if($dados_u['permissao'] == 'ADMINISTRADOR') { echo 'checked="checked"';} ?>>
                                <label class="form-check-label" for="checkbox0">Administrador</label>
                            </div>
                            <div class="form-group form-check-inline">
                                <input type="radio" class="form-check-input" id="checkbox1" name="checkbox" value="PADRÃO" <?php if($dados_u['permissao'] == 'PADRÃO') { echo 'checked="checked"';} ?>>
                                <label class="form-check-label" for="checkbox1">Padrão</label>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <input class="btn-sm btn-primary font-weight-bold border-0" type="submit" value="SALVAR">
                        </div>
                    </form>
                </div>
        <?php endforeach; ?>
        <?php else:
              require 'inc/menu.php';
         echo    "<div class='d-flex flex-column justify-content-center align-items-center bg-dark text-white' style='min-height: 75vh'>
                     <h4 class='font-weight-bold'>É presiso ter permissão de administrador</h4>
                     <img class='my-2' width='100px' src='assets/imagens/logo.png'>
                 </div>
                "         
       ?>         
     <?php endif; ?>
     
<?php require 'inc/footer.php'; ?>
