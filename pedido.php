<?php
require 'inc/config.php';
require 'inc/usuarios.class.php';
require 'inc/clientes.class.php';
require 'inc/produtos.class.php';
require 'inc/pedidos.class.php';
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
$pd = new pedidos($pdo);
$situacoes = $pd->getSituacao();

$produtospedido = $quantidade = $al = $la = $valorunitario = $subtotal = ""; 
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $clientenome = $_POST['cliente'];
    $datahora = $_POST['datahora'];
    $obs = $_POST['obs'];
    if(!empty($_POST['produtospedido'])) {
        $produtospedido = implode(',', $_POST['produtospedido']);
    }
    if(!empty($_POST['quantidade'])) {
        $quantidade = implode(',', $_POST['quantidade']);
    }
    if(!empty($_POST['al'])) {
        $al = implode(',', $_POST['al']);
    }
    if(!empty($_POST['la'])) {
        $la = implode(',', $_POST['la']);
    }
    if(!empty($_POST['valorunitario'])) {
        $valorunitario = implode('-', $_POST['valorunitario']);
    }
    if(!empty($_POST['subtotal'])) {
        $subtotal = implode('-', $_POST['subtotal']);
    }
    $valor_frete = $_POST['valor_frete'];
    $taxa_cartao = $_POST['taxa_cartao'];
    $desconto = $_POST['desconto'];
    $total = $_POST['total'];
    $valor_pago = $_POST['valor_pago'];
    $falta_pagar = $_POST['falta_pagar'];
    $situacao = $_POST['situacao'];

    $pd->addPedido($clientenome, $datahora, $obs, $produtospedido, $al, $la, $quantidade, $valorunitario, $subtotal, $valor_frete, $taxa_cartao, $desconto,$total, $valor_pago, $falta_pagar, $situacao);
    header("Location: ".BASE_URL."pedido");
}

if(empty($_GET['buscarPedido'])) {
  $pedidos = $pd->getPedido();
} else {
  $nome = trim($_GET['buscarPedido']);
  $pedidos = $pd->getPedidoBuscar($nome);
}
?>

<?php require 'inc/header.php'; ?>
    <?php if(($u->temPermissao('ADMINISTRADOR')) || ($u->temPermissao('PADRÃO'))): ?>
    <?php require 'inc/menu.php'; ?>
    <div class="text-white bg-dark py-5">
        <div class="container-fluid">
            <form method="POST">
                <div class="d-flex justify-content-center">
                    <h4 class="font-weight-bold">PEDIDO</h4>
                </div>
                <div class="form-row d-flex justify-content-center">
                    <div class="col-sm-12 d-sm-flex justify-content-sm-center">
                        <div class="col-sm-4">
                            <label for="datahora">Data e Hora</label>
                            <input class="form-control" type="text" name="datahora" id="datahora" maxlength="16" onkeydown="mascara_datahora(this, datahora, event)" value="<?php date_default_timezone_set('America/Recife');
$date = date('d/m/Y H:i');echo $date; ?>"> 
                        </div>
                        <div class="col-sm-4">
                            <label for="cliente">Cliente:</label>
                            <select class="form-control" name="cliente" id="cliente">
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
                        <div class="col-sm-4">
                            <label for="produtos">Produtos:</label>
                            <select class="form-control mb-2" name="produtos" id="produtos">
                                <option></option>
                                <?php foreach($produtos as $produto): ?>
                                <option value="<?php echo $produto['valor']; ?>|<?php echo $produto['nome']; ?>|<?php echo $produto['unidademedida']; ?>"><?php echo $produto['nome']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <a class="btn-sm btn btn-success text-white border-0" href="javascript:void(0);" onclick="addproduto()">ADICIONAR</a>
                        </div>
                        <div class="col-sm-4">
                            
                        </div>
                    </div>
                    <div class="col-sm-12 d-flex justify-content-center flex-column my-2">  
                        <div class="table-responsive">
                            <table class="table table-dark text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Produto</th>
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
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-lg py-2">
                                <label for="valor_frete">Valor Do Frete (R$)</label>
                                <input id="valor_frete" class="form-control" type="number" name="valor_frete" step="0.01" onkeyup="mudouvalor()" style="width: 80px">
                            </div>
                            <div class="col-lg py-2">
                                <label for="taxa_cartao">Taxa De Cartão (%)</label>
                                <input id="taxa_cartao" class="form-control" type="number" name="taxa_cartao" step="0.01" onkeyup="mudouvalor()" style="width: 80px">
                            </div>
                            <div class="col-lg py-2">
                                <label for="desconto">Desconto (R$):</label>
                                <input class="form-control" id="desconto" type="number" name="desconto" step="0.01" style="width: 80px" onkeyup="mudouvalor()">
                            </div>
                            <div class="col-lg d-flex align-items-center">
                                <input id="total" class="bg-dark text-white border-0" type="text" name="total" value="Total: R$ 0,00" readonly='readonly'>
                            </div>
                            <div class="col-lg py-2">
                                <label for="valor_pago">Valor Pago (R$)</label>
                                <input id="valor_pago" class="form-control" type="number" name="valor_pago" step="0.01" onkeyup="mudouvalor()" style="width: 80px">
                            </div>
                            <div class="col-lg d-flex align-items-center py-2">
                                <input id="falta_pagar" class="bg-dark text-white border-0" type="text" name="falta_pagar" value="Falta pagar: R$ 0,00" readonly='readonly'>
                            </div>
                            <div class="col-lg py-2">
                                <label for="situacao">Situação: <a class="text-success" onclick="addSituacao()" style="cursor: pointer">( + )</a> <a class="text-danger" onclick="delSituacao()" style="cursor: pointer">( - )</a></label>
                                <select class="form-control mb-2" name="situacao" id="situacao">
                                    <option></option>
                                    <?php foreach($situacoes as $situacao): ?>
                                    <option value="<?php echo $situacao["nome"]; ?>"><?php echo $situacao["nome"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>            
                    </div>
                    <input class="btn btn-sm btn-primary font-weight-bold" type="submit" value="CADASTRAR">
                    </div>            
            </form> 
        </div>
        <form method="get">
          <div class="form-group d-sm-flex align-items-center justify-content-center">
            <input class="form-control my-2" type="search" name="buscarPedido" style="max-width: 500px">
            <input class="btn-sm btn-primary m-1 font-weight-bold" type="submit" value="BUSCAR">
          </div>
        </form>         
        <div class="table-responsive">
          <table class="table table-dark text-center">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Data e Hora</th>
                <th scope="col">Cliente</th>
                <th scope="col">Total</th>
                <th scope="col">Falta Pagar</th>
                <th scope="col">Situação</th>
                <th scope="col">Obs</th>
                <th scope="col">Ações</th>
              </tr>
            </thead>
            <tbody>
            <?php if(count($pedidos) > 0): ?>
                <?php foreach($pedidos as $pedido): ?>
                    <tr>
                        <td><?php echo $pedido['id']; ?></td>
                        <td><?php echo date('d/m/Y H:i',strtotime($pedido['datahora'])); ?></td>
                        <td><?php echo $pedido['cliente']; ?></td>
                        <td><?php echo explode(":", $pedido['total'])[1]; ?></td>
                        <td><?php echo explode(":", $pedido['faltapagar'])[1]; ?></td>
                        <td><?php echo $pedido['situacao']; ?></td>
                        <td><?php echo $pedido['obs']; ?></td>
                        <td>
                          <a class="btn btn-sm btn-success my-1" href="<?php echo BASE_URL; ?>edit.pedido?id=<?php echo $pedido['id']; ?>">EDIT</a>
                          <a class="btn btn-sm btn-warning my-1" href="<?php echo BASE_URL; ?>visualizar.pedido?cliente=<?php echo $pedido['cliente'].'?id='.$pedido['id']; ?>" target="_blank">VISUALIZAR</a>
                          <a id="<?php echo $pedido['id']; ?>" name="<?php echo $pedido['cliente']; ?>" class="btn btn-danger btn-sm" onclick="delPedido(this)" style="cursor:pointer">DEL</a>
                        </td>
                    </tr>
                <?php endforeach; ?> 
                <?php else: echo "<h5 class='text-danger text-center'>Não há nenhum cadastro !!!</h5>"?>  
              <?php endif; ?> 
            </tbody>
          </table>
        </div>
    </div>
    <?php endif; ?>
<?php require 'inc/footer.php'; ?>