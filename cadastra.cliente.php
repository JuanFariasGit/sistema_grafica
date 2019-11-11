<?php 
require 'inc/config.php'; 
require 'inc/usuarios.class.php';
require 'inc/clientes.class.php';
session_start();

if(empty($_SESSION['logado'])) {
        header('Location: '.BASE_URL.'login');
        exit;
}

$u = new usuarios($pdo);
$u->setUsuario($_SESSION['logado']);

$c = new clientes($pdo);

if($_SERVER['REQUEST_METHOD'] == "POST") {
        $nomecompleto = $_POST['nomecompleto'];
        $fone = $_POST['fone'];
        $cep = $_POST['cep'];
        $rua = $_POST['rua'];
        $numero = $_POST['numero'];
        $complemento = $_POST['complemento'];
        $bairro = $_POST['bairro'];
        $cidade = $_POST['cidade'];
        $uf = $_POST['uf'];
        
        $c->addCliente($nomecompleto, $fone, $cep, $rua, $numero, $complemento, $bairro, $cidade, $uf);
        header("Location: ".BASE_URL."clientes.cadastrados");
        exit;
}
?>

<?php require 'inc/header.php'; ?>
        <?php if(($u->temPermissao('ADMINISTRADOR')) || ($u->temPermissao('PADRÃO'))): ?>
        <?php require 'inc/menu.php'; ?>
        <div class="text-white bg-dark py-5 d-flex justify-content-center">
                <form method="POST" onsubmit="return validar_cadastro_cliente()">
                        <div class="d-flex justify-content-center">                            
                                <h4 class="font-weight-bold">Cadastro de cliente</h4>
                        </div>  
                        <div class="form-row container"> 
                                <div class="col-sm-8">
                                        <label for="nomecompleto">Nome completo :*</label>
                                        <input class="form-control" type="text" name="nomecompleto" id="nomecompleto">
                                </div>              
                                <div class="col-sm-4">
                                        <label for="fone">Fone :*</label>
                                        <input class="form-control" name="fone" type="text" id="fone" maxlength="14" onkeydown="mascara_fone(this, fone, event)">
                                </div> 
                                <div class="col-sm-4">
                                        <label for="cep">Cep :*</label>
                                        <input class="form-control" type="text" name="cep" id="cep" maxlength="8">
                                </div>
                                <div class="col-sm-7">
                                        <label for="rua">Rua :</label>
                                        <input class="form-control" name="rua" type="text" id="rua">
                                </div>
                                <div class="col-sm-1">
                                        <label for="numero">Nº :</label>
                                        <input class="form-control" name="numero" type="text" id="numero">
                                </div>
                                <div class="col-sm-4">
                                        <label for="complemento">complemento :</label>
                                        <input class="form-control" name="complemento" type="text" id="complemento">
                                </div>
                                <div class="col-sm-4">
                                        <label fot="bairro">Bairro :</label>
                                        <input class="form-control" name="bairro" type="text" id="bairro">
                                </div>
                                <div class="col-sm-4">
                                        <label for="cidade">Cidade :</label>
                                        <input class="form-control" name="cidade" type="text" id="cidade">
                                </div>
                                <div class="col-sm-2">
                                        <label for="uf">Estado :</label>
                                        <input class="form-control" name="uf" type="text" id="uf">
                                </div>
                                <div class="col-12">
                                        <input class="btn-block btn-sm font-weight-bold my-2 btn-primary text-white border-0" type="submit" value="CADASTRAR">
                                </div>        
                        </div>        
                </form>
        </div>
        <?php else:
        header('Location: '.BASE_URL.'login');  
        ?>   
        <?php endif; ?>
<?php require 'inc/footer.php'; ?>