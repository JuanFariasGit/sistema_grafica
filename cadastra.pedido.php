<?php
require 'inc/config.php';
require 'inc/usuarios.class.php';
require 'inc/clientes.class.php';
require 'inc/produtos.class.php';
session_start();

if(empty($_SESSION['logado'])) {
    header('Location: '.BASE_URL.'login');
    exit;
}

$u = new usuarios($pdo);
$u->setUsuario($_SESSION['logado']);
$c = new clientes($pdo);
$clientes = $c->getCliente();
$p = new produtos($pdo);
$produtos = $p->getProduto();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $quantidade = $_POST['quantidade'];
    $al = $_POST['al'];
    $la = $_POST['la'];
    for($i = 0; $i < count($quantidade); $i++) {
        
    }
    exit;
}
?>

<?php require 'inc/header.php'; ?>
    <?php if(($u->temPermissao('ADMINISTRADOR')) || ($u->temPermissao('PADRÃO'))): ?>
    <?php require 'inc/menu.php'; ?>
    <div class="text-white bg-dark py-5">
        <div class="container">
            <form method="POST">
                <div class="d-flex justify-content-center">
                    <h4 class="font-weight-bold">Cadastra Pedido</h4>
                </div>
                <div class="form-row d-flex justify-content-center">
                    <div class="col-sm-12 d-sm-flex justify-content-sm-center">
                        <div class="col-sm-4">
                            <label for="datahora">Data e Hora</label>
                            <input class="form-control" type="text" name="datahora" id="datahora" maxlength="16" onkeydown="mascara_datahora(this, datahora, event)"> 
                        </div>
                        <div class="col-sm-4">
                            <label for="clientenome">Cliente:</label>
                            <select class="form-control" name="clientenome" id="clientenome">
                                <option></option>
                                <?php foreach($clientes as $cliente): ?>
                                <option value="<?php echo $cliente['nomecompleto']; ?>"><?php echo $cliente['nomecompleto']; ?></option>
                                <?php endforeach; ?>
                            </select>  
                        </div>
                    </div> 
                    <div class="col-sm-12 d-flex justify-content-center">    
                        <div class="col-sm-8">
                            <label for="obs">Obs:</label>
                            <textarea class="form-control" name="obs" id="obs"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 d-sm-flex justify-content-sm-center">    
                        <div class="col-sm-8">
                            <label for="produtos">Produtos:</label>
                            <select class="form-control mb-2" name="produtos" id="produtos">
                                <option></option>
                                <?php foreach($produtos as $produto): ?>
                                <option value="<?php echo $produto['valor']; ?>|<?php echo $produto['nome']; ?>|<?php echo $produto['unidademedida']; ?>"><?php echo $produto['nome']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <a class="btn-sm btn btn-success text-white border-0" href="javascript:void(0);" onclick="addproduto()">ADICIONAR</a>
                        </div>
                    </div>
                    <div class="col-sm-12 d-flex justify-content-center flex-column my-2">  
                        <div class="table-responsive">
                            <table class="table table-dark text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Al x LA</th>
                                    <th  scope="col">Quantidade</th>
                                    <th  scope="col">Valor Unitário</th>
                                    <th  scope="col">Subtotal</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody id="addproduto"></tbody>
                            </table>
                        </div>
                        <div class="ml-auto mt-2" id="res">Total: R$ 0,00</div>            
                    </div>
                    <input class="btn btn-sm btn-block btn-primary font-weight-bold" type="submit" value="CADASTRAR">
                    </div>            
            </form> 
        </div>       
    </div>
    <?php endif; ?>
<?php require 'inc/footer.php'; ?>