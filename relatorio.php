<?php
require 'inc/config.php';
require 'inc/usuarios.class.php';
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
$usuarios = $u->getUsuario();
$usuariologado = $u->getUsuarioNome($_SESSION['logado']);
$p = new pedidos($pdo);

$vendedor = (!empty($_GET['vendedor']) && isset($_GET['vendedor'])) ? $_GET['vendedor'] : $usuariologado;

if(!empty($_GET['gerar_relatorio'])) {
    $array = explode('/', trim($_GET['gerar_relatorio']));
    $array_r = array_reverse($array);
    $anomes = implode('-', $array_r);
    $relatorio_geral = $p->gerarRelatorioGeral($anomes, $vendedor);
    $relatorio_devedores = $p->gerarRelatorioDevedores($anomes, $vendedor);
    $relatorio_pedidos_quantidade_clientes = $p->getRelatorioQuatidadePedidosClientes($anomes, $vendedor);
}
?>

<?php require 'inc/header.php'; ?>
        <?php require 'inc/menu.php'; ?>
        <div class="bg-dark py-5">
            <h4 class="text-center text-white font-weight-bold">RELATÓRIO</h4>
            <form method="get">
                <div class="form-row d-sm-flex flex-column justify-content-center align-items-center container-fluid">
                    <div class="col-lg-4">
                        <input class="form-control mx-sm-0 mx-auto" type="search" name="gerar_relatorio" placeholder="MÊS/ANO OU DIA/MÊS/ANO">
                    </div>
                    <?php if($u->temPermissao('ADMINISTRADOR')): ?> 
                        '<div class="col-lg-4">
                            <select class="form-control" name="vendedor" id="vendedor" placeholder="vendedor">
                                <option></option>
                                 <?php foreach($usuarios as $usuario): ?>
                                    <option value="<?php echo $usuario['nome']; ?>" <?php ; ?>><?php echo $usuario['nome']; ?></option>
                                 <?php endforeach; ?>      
                            '</select>
                        </div>
                    <?php endif; ?>    
                    <button class="btn btn-sm btn-success col-lg-2 col-6 mx-auto mt-2 font-weight-bold">GERAR RELATÓRIO</button>
                </div>    
            </form>

            <?php if(!empty($_GET['gerar_relatorio'])): ?>
                <?php if(isset($relatorio_geral) && $relatorio_geral[0]['emissao'] != ""): ?>
                <h3 class="text-primary text-center font-weight-bold my-5">Relatório de <?php echo $vendedor; ?></h3>
                <h4 class="text-center text-white font-weight-bold">GERAL</h4>
                <table class="table table-dark text-center">
                    <thead>
                        <tr>
                            <th scope="col"><?php echo (strlen(trim($_GET['gerar_relatorio'])) == 7) ? "Mês/Ano" : "Dia/Mês/Ano"; ?></th>
                            <th scope="col">Total</th>
                            <th scope="col">Total Recebido</th>
                            <th scope="col">Falta Receber</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($relatorio_geral as $r): ?>
                        <tr>
                            <td><?php echo (strlen(trim($_GET['gerar_relatorio'])) == 7) ? date('m/Y',strtotime($r['emissao'])) : date('d/m/Y',strtotime($r['emissao'])); ?></td>
                            <td><?php echo "R$ ".number_format($r['total_'],2,',','.'); ?></td>
                            <td><?php echo "R$ ".number_format($r['valor_pago'],2,',','.'); ?></td>
                            <td><?php echo "R$ ".number_format($r['falta_pagar'],2,',','.'); ?></td>
                        </tr>
                    <?php endforeach; ?> 
                    </tbody>
                </table>
                <h4 class="text-center text-white font-weight-bold">DEVEDORES</h4>
                <table class="table table-dark text-center">
                    <thead>
                        <tr>
                            <th scope="col">Emissão</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Total</th>
                            <th scope="col">Valor Pago</th>
                            <th scope="col">Falta Pagar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($relatorio_devedores as $r): ?> 
                        <tr>
                            <td><?php echo date('d/m/Y H:i',strtotime($r['emissao'])); ?></td>
                            <td><?php echo $r['cliente']; ?></td>
                            <td><?php echo "R$ ".number_format($r['total'],2,',','.'); ?></td>
                            <td><?php echo "R$ ".number_format($r['valorpago'],2,',','.'); ?></td>
                            <td><?php echo "R$ ".number_format($r['faltapagar'],2,',','.'); ?></td>
                        </tr>
                        <?php endforeach; ?> 
                    </tbody>
                </table>
                <h4 class="text-center text-white font-weight-bold">QUANTIDADE DE PEDIDOS POR CLIENTE</h4>
                <table class="table table-dark text-center">
                    <thead>
                        <tr>
                            <th scope="col">Emissão</th>
                            <th>Cliente</th>
                            <th>Quantidade</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($relatorio_pedidos_quantidade_clientes as $r): ?>
                        <tr>
                            <td><?php echo date('d/m/Y H:i',strtotime($r['emissao'])); ?></td>
                            <td><?php echo $r['cliente']; ?></td>
                            <td><?php echo $r['quantidade']; ?></td>
                        </tr>
                    <?php endforeach; ?>    
                    </tbody>
                </table>
                    <?php else: echo "<div class='text-danger text-center mt-5'>Não houve vendas neste período para o vendedor ".$vendedor."</div>"; ?>          
                <?php endif;endif; ?>
        </div>
<?php require 'inc/footer.php'; ?>