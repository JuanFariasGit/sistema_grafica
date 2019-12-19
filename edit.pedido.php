<?php
require 'inc/config.php';
require 'inc/usuarios.class.php';
require 'inc/clientes.class.php';
require 'inc/produtos.class.php';
require 'inc/pedidos.class.php';
session_start();

if(!empty($_SESSION['logado'])) {
    $id = $_SESSION['logado'];
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id AND ip = :ip");
    $sql->bindValue(":id", $id);
    $sql->bindValue(":ip", $ip);
    $sql->execute();
    
    if($sql->rowCount() == 0) {
        header("Location: ".BASE_URL."login");
        exit;
    }
  } else {
    header("Location: ".BASE_URL."login");
    exit;
  }

$u = new usuarios($pdo);
$u->setUsuario($_SESSION['logado']);
$usuariologado = $u->getUsuarioNome($_SESSION['logado']);
$c = new clientes($pdo);
$clientes = $c->getCliente();
$p = new produtos($pdo);
$produtos = $p->getProduto();
$pd = new pedidos($pdo);
$situacoes = $pd->getSituacao();
$pedidos = $pd->getPedidoEdit($_GET['id']);
$pedido_produtos = $pd->getPedidoProdutosEdit($_GET['id']);

$produtospedido = $quantidade = $al = $la = $valorunitario = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id_pedido'];
    $cliente_id = $_POST['cliente'];
    $datahora = $_POST['datahora'];
    $obs = $_POST['obs'];
    if(!empty($_POST['produtospedido'])) {
        $produtospedido = $_POST['produtospedido'];
        $id_produtos    = $p->getIdProduto($_POST['produtospedido']);
    }
    if(!empty($_POST['quantidade'])) {
        $quantidade = $_POST['quantidade'];
    }
    if(!empty($_POST['al'])) {
        $al = $_POST['al'];
    }
    if(!empty($_POST['la'])) {
        $la = $_POST['la'];
    }
    if(!empty($_POST['valorunitario'])) {
        $valorunitario = $_POST['valorunitario'];
    }
    
    $valor_frete = $_POST['valor_frete'];
    $taxa_cartao = $_POST['taxa_cartao'];
    $desconto = $_POST['desconto'];
    $total = str_replace(',','.', explode("Total: R$", $_POST['total']))[1];
    $valor_pago = $_POST['valor_pago'];
    $falta_pagar = str_replace(",",".", explode("Falta Pagar: R$", $_POST['falta_pagar']))[1];
    $situacao = explode("|",$_POST['situacao'])[1];  
       
    
    $pd->upPedido($id, $cliente_id, $datahora, $obs, $produtospedido, $id_produtos, $al, $la, $quantidade, $valorunitario, $valor_frete, $taxa_cartao, $desconto, $total, $valor_pago, $falta_pagar, $situacao);
    header("Location: ".BASE_URL."pedido");
}
?>

<?php require 'inc/header.php'; ?>
    <?php if(($u->temPermissao('ADMINISTRADOR')) || ($u->temPermissao('PADRÃO'))): ?>
    <?php require 'inc/menu.php'; ?>
    <div class="text-white bg-dark py-5">
        <div class="container-fluid">
            <form method="POST" onsubmit="return validar_pedido()">
                <div class="d-flex justify-content-center">
                    <h4 class="font-weight-bold">PEDIDO (Editar)</h4>
                </div>
                <div class="form-row d-flex justify-content-center">
                    <?php foreach($pedidos as $pedido): ?>
                    <div class="col-sm-12 d-sm-flex justify-content-sm-center">
                        <div class="col-sm-1">
                            <label for="id_pedido">ID:</label>
                                <input id="id_pedido" class="form-control" name="id_pedido" value="<?php echo $pedido['id']; ?>" readonly='readonly' >
                        </div>
                        <div class="col-sm-3">
                            <label for="datahora">Data e Hora</label>
                            <input class="form-control" type="text" name="datahora" id="datahora" maxlength="16" onkeydown="mascara_datahora(this, datahora, event)" value="<?php echo date('d/m/Y H:i',strtotime($pedido['datahora'])); ?>"> 
                        </div>
                        <div class="col-sm-4">
                            <label for="cliente">Cliente:</label>
                            <select class="form-control" name="cliente" id="cliente">
                                <option></option>
                                <?php foreach($clientes as $cliente): ?>
                                <option value="<?php echo $cliente['id']; ?>" <?php if($pedido['cliente'] == $cliente['nomecompleto']) {echo "selected = 'selected'";}; ?>><?php echo $cliente['nomecompleto']; ?></option>
                                <?php endforeach; ?>
                            </select>  
                        </div>
                    </div> 
                    <div class="col-sm-12 d-flex justify-content-center">    
                        <div class="col-sm-8">
                            <label for="obs">Obs:</label>
                            <textarea class="form-control" name="obs" id="obs"><?php echo $pedido['obs']; ?></textarea>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <div class="col-sm-12 d-sm-flex justify-content-sm-center">    
                        <div class="col-sm-4">
                            <label for="produtos">Produtos:</label>
                            <select class="form-control mb-2" name="produtos" id="produtos">
                                <option></option>
                                <?php foreach($produtos as $produto): ?>
                                <option value="<?php echo "R$ ".number_format($produto['valor'], 2, ',', '.'); ?>|<?php echo $produto['nome']; ?>|<?php echo $produto['unidademedida']; ?>"><?php echo $produto['nome']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <a class="btn-sm btn btn-success text-white border-0" href="javascript:void(0);" onclick="addproduto()">ADICIONAR</a>
                        </div>
                        <div class="col-sm-4"></div>
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
                                <tbody id="addproduto">
                                 <?php foreach($pedido_produtos as $pedido_produto): ?>
                                    <tr id='<?php echo $pedido_produto['produto']; ?>' class='items'>
                                        <td><input class='border-0 rounded-0 bg-dark text-white text-center' type='text' name='produtospedido[]' value='<?php echo $pedido_produto['produto']; ?>' readonly='readonly' style='width: 500px'></td>
                                        <td><input class='al mx-2 rounded border-0 py-2' type='number' name='al[]' step='0.01' value='<?php echo $pedido_produto['al']; ?>' onkeyup='mudouvalor()' style='width: 80px;<?php if($pedido_produto['uni'] == 'uni') {echo "background-color:  #AAA";}; ?>' <?php if($pedido_produto['uni'] == 'uni') {echo "readonly='readonly'";}; ?>><input class='la mx-2 rounded border-0 py-2' type='number' name='la[]' step='0.01' value='<?php echo $pedido_produto['la']; ?>' onkeyup='mudouvalor()' style='width: 80px;<?php if($pedido_produto['uni'] == 'uni') {echo "background-color:  #AAA";}; ?>' <?php if($pedido_produto['uni'] == 'uni') {echo "readonly='readonly'";}; ?>></td>
                                        <td><input class='quantidade rounded border-0 py-2' type='number' name='quantidade[]' min='1' value='<?php echo $pedido_produto['quantidade']; ?>' onkeyup='mudouvalor()' style='width: 80px'></td>
                                        <td><input class='valor_unitario bg-dark text-white border-0' type='text' name='valorunitario[]' value='<?php echo "R$ ".number_format($pedido_produto['valoruni'], 2, ",", "."); ?>' style='width: 80px' readonly='readonly'></td>
                                        <td><input class='subtotal bg-dark text-white border-0' type='text' name='subtotal[]' value='<?php echo "R$ ".number_format($pedido_produto['subtotal'], 2, ",", "."); ?>' style='width: 80px' readonly='readonly'></td>
                                        <td><a id='<?php echo $pedido_produto['produto']; ?>' class='text-danger' href='javascript:void(0)' onclick='delItem(this)'>[x]</a></td></td>
                                    </tr>
                                 <?php endforeach;?>    
                                </tbody>
                            </table>
                        </div>
                        <?php foreach($pedidos as $pedido): ?>
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-lg py-2">
                                <label for="valor_frete">Valor Do Frete (R$)</label>
                                <input id="valor_frete" class="form-control" type="number" name="valor_frete" step="0.01" onkeyup="mudouvalor()" style="width: 80px" value="<?php if($pedido['valorfrete'] > 0) {echo $pedido['valorfrete'];} else {echo "";} ?>">
                            </div>
                            <div class="col-lg py-2">
                                <label for="taxa_cartao">Taxa De Cartão (%)</label>
                                <input id="taxa_cartao" class="form-control" type="number" name="taxa_cartao" step="0.01" onkeyup="mudouvalor()" style="width: 80px" value="<?php if($pedido['taxacartao'] > 0) {echo $pedido['taxacartao'];} else {echo "";} ?>">
                            </div>
                            <div class="col-lg py-2">
                                <label for="desconto">Desconto (R$):</label>
                                <input class="form-control" id="desconto" type="number" name="desconto" step="0.01" style="width: 80px" onkeyup="mudouvalor()" value="<?php if($pedido['desconto'] > 0) {echo $pedido['desconto'];} else {echo "";} ?>">
                            </div>
                            <div class="col-lg d-flex align-items-center">
                                <input id="total" class="bg-dark text-white border-0" type="text" name="total" readonly='readonly' value="<?php echo "Total: R$ ".str_replace(".",",", $pedido['total']); ?>">
                            </div>
                            <div class="col-lg py-2">
                                <label for="valor_pago">Valor Pago (R$)</label>
                                <input id="valor_pago" class="form-control" type="number" name="valor_pago" step="0.01" onkeyup="mudouvalor()" style="width: 80px" value="<?php if($pedido['valorpago'] > 0) {echo $pedido['valorpago'];} else {echo "";} ?>">
                            </div>
                            <div class="col-lg d-flex align-items-center py-2">
                                <input id="falta_pagar" class="bg-dark text-white border-0" type="text" name="falta_pagar" value="<?php echo "Falta Pagar: R$ ".str_replace(".",",", $pedido['faltapagar']); ?>" readonly='readonly'>
                            </div>
                            <div class="col-lg py-2">
                                <label for="situacao">Situação:</label>
                                <select class="form-control mb-2" name="situacao" id="situacao">
                                    <option></option>
                                    <?php foreach($situacoes as $situacao): ?>
                                    <option value="<?php echo $situacao["nome"]; ?>|<?php echo $situacao["id"]; ?>" <?php if($pedido['situacao'] == $situacao["nome"]) {echo "selected='selected'";}; ?>><?php echo $situacao["nome"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <?php endforeach; ?>            
                    </div>
                    <input class="btn btn-sm btn-primary font-weight-bold mt-3" type="submit" value="SALVAR">
                    </div>            
            </form> 
        </div>       
    </div>
    <?php endif; ?>
<?php require 'inc/footer.php'; ?>