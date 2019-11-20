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
$pedidos = $pd->getPedidoEdit($_GET['id']);

$unidade_e_produto = array();
foreach($produtos as $produto) {
    array_push($unidade_e_produto, $produto['unidademedida']."*".$produto['nome']);
}

$produtos_edit_array = array();
foreach($pedidos as $pedido) {
    if($pedido['produto'] != "") {
        $produtos_edit_array = explode(",", $pedido['produto']);
    }
     $la_edit_array = explode(",", $pedido['la']);
     $al_edit_array = explode(",", $pedido['al']);
     $quantidade_edit_array = explode(",", $pedido['quantidade']);   
     $valorunitario_edit_array = explode("-", $pedido['valorunitario']);
     $subtotal_edit_array = explode("-" , $pedido['subtotal']);
}

$verificar_unidade = array();
for($i = 0; $i < count($produtos_edit_array); $i++) {
    for($j = 0; $j < count($unidade_e_produto); $j++) {
        if($produtos_edit_array[$i] === explode("*", $unidade_e_produto[$j])[1]) {
            array_push($verificar_unidade, explode("*", $unidade_e_produto[$j])[0]);
        }
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_GET['id'];
    $clientenome = $_POST['cliente'];
    $datahora = $_POST['datahora'];
    $obs = $_POST['obs'];
    $produtospedido = implode(',', $_POST['produtospedido']);
    $quantidade = implode(',', $_POST['quantidade']);
    $al = implode(',', $_POST['al']);
    $la = implode(',', $_POST['la']);
    $valorunitario = implode('-', $_POST['valorunitario']);
    $subtotal = implode('-', $_POST['subtotal']);
    $valor_frete = $_POST['valor_frete'];
    $taxa_cartao = $_POST['taxa_cartao'];
    $desconto = $_POST['desconto'];
    $total = $_POST['total'];
    $valor_pago = $_POST['valor_pago'];
    $falta_pagar = $_POST['falta_pagar'];
    $situacao = $_POST['situacao'];
    
    $pd->upPedido($id, $clientenome, $datahora, $obs, $produtospedido, $al, $la, $quantidade, $valorunitario, $subtotal, $valor_frete, $taxa_cartao, $desconto,$total, $valor_pago, $falta_pagar, $situacao);
    header("Location: ".BASE_URL."pedido");
}
?>

<?php require 'inc/header.php'; ?>
    <?php if(($u->temPermissao('ADMINISTRADOR')) || ($u->temPermissao('PADRÃO'))): ?>
    <?php require 'inc/menu.php'; ?>
    <div class="text-white bg-dark py-5">
        <div class="container-fluid">
            <form method="POST">
                <div class="d-flex justify-content-center">
                    <h4 class="font-weight-bold">PEDIDO (Editar)</h4>
                </div>
                <div class="form-row d-flex justify-content-center">
                    <?php foreach($pedidos as $pedido): ?>
                    <div class="col-sm-12 d-sm-flex justify-content-sm-center">
                        <div class="col-sm-4">
                            <label for="datahora">Data e Hora</label>
                            <input class="form-control" type="text" name="datahora" id="datahora" maxlength="16" onkeydown="mascara_datahora(this, datahora, event)" value="<?php echo date('d/m/Y H:i',strtotime($pedido['datahora'])); ?>"> 
                        </div>
                        <div class="col-sm-4">
                            <label for="cliente">Cliente:</label>
                            <select class="form-control" name="cliente" id="cliente">
                                <option></option>
                                <?php foreach($clientes as $cliente): ?>
                                <option value="<?php echo $cliente['nomecompleto']; ?>" <?php if($pedido['cliente'] == $cliente['nomecompleto']) {echo "selected = 'selected'";}; ?>><?php echo $cliente['nomecompleto']; ?></option>
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
                                <option value="<?php echo $produto['valor']; ?>|<?php echo $produto['nome']; ?>|<?php echo $produto['unidademedida']; ?>"><?php echo $produto['nome']; ?></option>
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
                                <?php if(count($produtos_edit_array) > 0): ?>    
                                    <?php for($i = 0; $i < sizeof($produtos_edit_array); $i++): ?>
                                        <tr id='<?php echo $produtos_edit_array[$i]; ?>' class='items'><td><input class='form-control border-0 rounded-0 bg-dark text-white mx-auto text-center' type='text' name='produtospedido[]' value='<?php echo $produtos_edit_array[$i]; ?>' readonly='readonly' style="width: 500px"></td>
                                        <td><input class='al mx-2 rounded border-0 py-2' type='number' name='al[]' step='0.01' value='<?php echo $al_edit_array[$i]; ?>' onkeyup='mudouvalor()' style='width: 80px;<?php if($verificar_unidade[$i] == "uni") {echo "background-color: #AAA";}; ?>' <?php if($verificar_unidade[$i] == "uni") {echo "readonly='readonly'";}; ?>><input class='la mx-2 rounded border-0 py-2' type='number' name='la[]' step='0.01' value='<?php echo $la_edit_array[$i]; ?>' onkeyup='mudouvalor()' style='width: 80px;<?php if($verificar_unidade[$i] == "uni") {echo "background-color: #AAA";}; ?>' <?php if($verificar_unidade[$i] == "uni") {echo "readonly='readonly'";}; ?>></td>
                                        <td><input class='quantidade rounded border-0 py-2' type='number' name='quantidade[]' min='1' value='<?php echo $quantidade_edit_array[$i]; ?>' onkeyup='mudouvalor()' style='width: 80px'></td>
                                        <td><input class='valor_unitario bg-dark text-white border-0' type='text' name='valorunitario[]' value='<?php echo $valorunitario_edit_array[$i]; ?>' style='width: 80px' readonly='readonly'></td>
                                        <td><input class='subtotal bg-dark text-white border-0' type='text' name='subtotal[]' value='<?php echo $subtotal_edit_array[$i]; ?>' style='width: 80px' readonly='readonly'></td>
                                        <td><a id='<?php echo $produtos_edit_array[$i]; ?>' class='text-danger' href='javascript:void(0)' onclick='delItem(this)'>[x]</a></td></tr>
                                    <?php endfor; ?>
                                <?php else: echo "<h5 class='text-center text-danger'>Não há produtos cadastrados no pedido !!</h5>"; endif; ?>
                            </tbody>
                            </table>
                        </div>
                        <?php foreach($pedidos as $pedido): ?>
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-lg py-2">
                                <label for="valor_frete">Valor Do Frete (R$)</label>
                                <input id="valor_frete" class="form-control" type="number" name="valor_frete" step="0.01" onkeyup="mudouvalor()" style="width: 80px" value="<?php echo $pedido['valorfrete']; ?>">
                            </div>
                            <div class="col-lg py-2">
                                <label for="taxa_cartao">Taxa De Cartão (%)</label>
                                <input id="taxa_cartao" class="form-control" type="number" name="taxa_cartao" step="0.01" onkeyup="mudouvalor()" style="width: 80px" value="<?php echo $pedido['taxacartao']; ?>">
                            </div>
                            <div class="col-lg py-2">
                                <label for="desconto">Desconto (R$):</label>
                                <input class="form-control" id="desconto" type="number" name="desconto" step="0.01" style="width: 80px" onkeyup="mudouvalor()" value="<?php echo $pedido['desconto']; ?>">
                            </div>
                            <div class="col-lg d-flex align-items-center">
                                <input id="total" class="bg-dark text-white border-0" type="text" name="total" readonly='readonly' value="<?php echo $pedido['total']; ?>">
                            </div>
                            <div class="col-lg py-2">
                                <label for="valor_pago">Valor Pago (R$)</label>
                                <input id="valor_pago" class="form-control" type="number" name="valor_pago" step="0.01" onkeyup="mudouvalor()" style="width: 80px" value="<?php echo $pedido['valorpago']; ?>">
                            </div>
                            <div class="col-lg d-flex align-items-center py-2">
                                <input id="falta_pagar" class="bg-dark text-white border-0" type="text" name="falta_pagar" value="<?php echo $pedido['faltapagar']; ?>" readonly='readonly'>
                            </div>
                            <div class="col-lg py-2">
                                <label for="situacao">Situação: <a class="text-success" onclick="addSituacao()" style="cursor: pointer">( + )</a> <a class="text-danger" onclick="delSituacao()" style="cursor: pointer">( - )</a></label>
                                <select class="form-control mb-2" name="situacao" id="situacao">
                                    <option></option>
                                    <?php foreach($situacoes as $situacao): ?>
                                    <option value="<?php echo $situacao["nome"]; ?>" <?php if($pedido['situacao'] == $situacao["nome"]) {echo "selected='selected'";}; ?>><?php echo $situacao["nome"]; ?></option>
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