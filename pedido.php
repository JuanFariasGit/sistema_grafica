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

$produtospedido = $quantidade = $al = $la = $valorunitario = $id_produtos = ""; 
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
    $valor_arte  = $_POST['valor_arte'];
    $valor_outros = $_POST['valor_outros'];
    $taxa_cartao = $_POST['taxa_cartao'];
    $desconto = $_POST['desconto'];
    $total = str_replace(',','.', explode("Total: R$", $_POST['total']))[1];
    $valor_pago = $_POST['valor_pago'];
    $falta_pagar = str_replace(",",".", explode("Falta Pagar: R$", $_POST['falta_pagar']))[1];
    $situacao = explode("|",$_POST['situacao'])[1];  
    
    $pd->addPedido($id, $cliente_id, $datahora, $obs, $produtospedido, $id_produtos, $al, $la, $quantidade, $valorunitario, $valor_frete, $valor_arte, $valor_outros, $taxa_cartao, $desconto, $total, $valor_pago, $falta_pagar, $situacao);
    header("Location: ".BASE_URL."pedido");
}

if(empty($_GET['buscarPedido'])) {
  $pedidos = $pd->getPedido();
} else {
  $nome = trim($_GET['buscarPedido']);
  $pedidos = $pd->getPedidoBuscar($nome);
}

$id_pedido = $pd->getIdPedido();
?>

<?php require 'inc/header.php'; ?>
    <?php if(($u->temPermissao('ADMINISTRADOR')) || ($u->temPermissao('PADRÃO'))): ?>
    <?php require 'inc/menu.php'; ?>
    <div class="text-white bg-dark py-5">
        <div class="container-fluid">
            <form method="POST" onsubmit="return validar_pedido()">
                <div class="d-flex justify-content-center">
                    <h4 class="font-weight-bold">PEDIDO</h4>
                </div>
                <div class="form-row d-flex justify-content-center">
                    <div class="col-sm-12 d-sm-flex justify-content-sm-center">
                        <div class="col-sm-1">
                        <label for="id_pedido">ID:</label>
                            <input id="id_pedido" class="form-control" name="id_pedido" value="<?php echo $id_pedido; ?>" readonly='readonly'>
                        </div>
                        <div class="col-sm-3">
                            <label for="datahora">Data e Hora:</label>
                            <input class="form-control" type="text" name="datahora" id="datahora" maxlength="16" onkeydown="mascara_datahora(this, datahora, event)" value="<?php date_default_timezone_set('America/Recife');
$date = date('d/m/Y H:i');echo $date; ?>"> 
                        </div>
                        <div class="col-sm-4">
                            <label for="cliente">Cliente:</label>
                            <select class="form-control" name="cliente" id="cliente">
                                <option></option>
                                <?php foreach($clientes as $cliente): ?>
                                <option value="<?php echo $cliente['id']; ?>"><?php echo $cliente['nomecompleto']; ?></option>
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
                                <option value="<?php echo "R$ ".number_format($produto['valor'], 2, ',', '.'); ?>|<?php echo $produto['nome']; ?>|<?php echo $produto['unidademedida']; ?>"><?php echo $produto['nome']; ?></option>
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
                                <label for="valor_frete" style="font-size: 12px">Valor Do Frete (R$)</label>
                                <input id="valor_frete" class="form-control" type="number" name="valor_frete" step="0.01" onkeyup="mudouvalor()" style="width: 80px">
                            </div>
                            <div class="col-lg py-2">
                                <label for="valor_arte" style="font-size: 12px">Valor De Arte (R$)</label>
                                <input id="valor_arte" class="form-control" type="number" name="valor_arte" step="0.01" onkeyup="mudouvalor()" style="width: 80px">
                            </div>
                            <div class="col-lg py-2">
                                <label for="valor_outros" style="font-size: 12px">Outros (R$)</label>
                                <input id="valor_outros" class="form-control" type="number" name="valor_outros" step="0.01" onkeyup="mudouvalor()" style="width: 80px">
                            </div>
                            <div class="col-lg py-2">
                                <label for="taxa_cartao" style="font-size: 12px">Taxa De Cartão (%)</label>
                                <input id="taxa_cartao" class="form-control" type="number" name="taxa_cartao" step="0.01" onkeyup="mudouvalor()" style="width: 80px">
                            </div>
                            <div class="col-lg py-2">
                                <label for="desconto" style="font-size: 12px">Desconto (R$):</label>
                                <input class="form-control" id="desconto" type="number" name="desconto" step="0.01" style="width: 80px" onkeyup="mudouvalor()">
                            </div>
                            <div class="col-lg d-flex align-items-center">
                                <input id="total" class="bg-dark text-white border-0" type="text" name="total" value="Total: R$ 0,00" readonly='readonly' style="font-size: 12px">
                            </div>
                            <div class="col-lg py-2">
                                <label for="valor_pago" style="font-size: 12px">Valor Pago (R$)</label>
                                <input id="valor_pago" class="form-control" type="number" name="valor_pago" step="0.01" onkeyup="mudouvalor()" style="width: 80px">
                            </div>
                            <div class="col-lg d-flex align-items-center py-2">
                                <input id="falta_pagar" class="bg-dark text-white border-0" type="text" name="falta_pagar" value="Falta pagar: R$ 0,00" readonly='readonly' style="font-size: 12px">
                            </div>
                            <div class="col-lg py-2">
                                <label for="situacao" style="font-size: 12px">Situação: <a class="text-success" onclick="addSituacao()" style="cursor: pointer">(+)</a> <a class="text-primary" onclick="upSituacao()" style="cursor: pointer">(#)</a> <a class="text-danger" onclick="delSituacao()" style="cursor: pointer">(-)</a></label>
                                <select class="form-control mb-2" name="situacao" id="situacao" style="max-width: 150px">
                                    <option></option>
                                    <?php foreach($situacoes as $situacao): ?>
                                    <option value="<?php echo $situacao['nome']; ?>|<?php echo $situacao['id']; ?>"><?php echo $situacao["nome"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>            
                    </div>
                    <input class="btn btn-sm btn-primary font-weight-bold" type="submit" value="CADASTRAR">
                    </div>            
            </form>
            <hr style="background-color:white;"> 
        </div>
        <form method="get">
          <div class="form-group d-sm-flex align-items-center justify-content-center container">
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
                    <tr id="<?php echo $pedido['id']; ?>">
                        <td><?php echo $pedido['id']; ?></td>
                        <td><?php echo date('d/m/Y H:i',strtotime($pedido['datahora'])); ?></td>
                        <td><?php echo $pedido['cliente']; ?></td>
                        <td><?php echo "R$ ".str_replace(".",",", $pedido['total']); ?></td>
                        <td><?php echo "R$ ".str_replace(".",",", $pedido['faltapagar']); ?></td>
                        <td>
                            <select class="form-control mb-2 mx-auto bg-dark text-white border-0 rounded-0" name="situacao_ajax" style="max-width: 150px">
                                <?php foreach($situacoes as $situacao): ?>
                                <option value="<?php echo $situacao['id']; ?>|<?php echo $pedido['id']; ?>|<?php echo $situacao['nome']; ?>" <?php echo ($pedido['situacao'] == $situacao['nome']) ? "selected='selected'" : ""; ?>><?php echo $situacao["nome"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><?php echo $pedido['obs']; ?></td>
                        <td>
                          <a href="<?php echo BASE_URL; ?>edit.pedido?id=<?php echo $pedido['id']; ?>"><i class='fas fa-pen' style='font-size:24px'></i></a>
                          <a href="<?php echo BASE_URL; ?>visualizar.pedido?cliente=<?php echo $pedido['cliente'].'?id='.$pedido['id']; ?>" target="_blank"><i class='fas fa-file-alt text-warning' style='font-size:24px'></i></a>
                          <a id="<?php echo $pedido['id']; ?>" name="<?php echo $pedido['cliente']; ?>" onclick="delPedido(this)" style="cursor:pointer"><i class='fas fa-trash-alt text-danger' style='font-size:24px'></i></a>
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