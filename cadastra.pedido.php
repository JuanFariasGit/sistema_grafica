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
    $nome = $_POST['nomes'];
    $quantidade = $_POST['quantidade'];
    $al = $_POST['al'];
    $la = $_POST['la'];
    $valor_unitario = $_POST['valorunitario'];
    for($i = 0; $i < count($quantidade); $i++) {
       echo "Nome: ".$nome[$i]."<br>";
       echo "Al: ".$al[$i]."<br>";
       echo "LA: ".$la[$i]."<br>";
       echo "Quantidade: ".$quantidade[$i]."<br>";
       echo "Valor Unitário: ".$valor_unitario[$i]."<br>";
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
                        <div class="row">
                            <div class="col-lg-2 py-2">
                                <label for="valor_frete">Valor Do Frete (R$)</label>
                                <input id="valor_frete" class="form-control" type="number" name="valor_frete" step="0.01" onkeyup="mudouvalor()" style="width: 80px">
                            </div>
                            <div class="col-lg-2 py-2">
                                <label for="taxa_cartao">Taxa De Cartão (%)</label>
                                <input id="taxa_cartao" class="form-control" type="number" name="taxa_cartao" step="0.01" onkeyup="mudouvalor()" style="width: 80px">
                            </div>
                            <div class="col-lg-2 d-flex align-items-center">
                                <input id="total" class="bg-dark text-white border-0" type="text" name="total" value="Total: R$ 0,00" readonly='readonly'>
                            </div>
                            <div class="col-lg-2 py-2">
                                <label for="valor_pago">Valor Pago</label>
                                <input id="valor_pago" class="form-control" type="number" name="valor_pago" step="0.01" style="width: 80px">
                            </div>
                            <div id="falta_paga" class="col-lg-2 d-flex align-items-center py-2"></div>
                        </div>            
                    </div>
                    <input class="btn btn-sm btn-block btn-primary font-weight-bold" type="submit" value="CADASTRAR">
                    </div>            
            </form> 
        </div>       
    </div>
    <?php endif; ?>
<?php require 'inc/footer.php'; ?>