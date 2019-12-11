<?php
require 'inc/config.php';
require 'inc/usuarios.class.php';
require 'inc/pedidos.class.php';
session_start();

if(empty($_SESSION['logado'])) {
    header('Location: '.BASE_URL.'login');
    exit;
}

$u = new usuarios($pdo);
$u->setUsuario($_SESSION['logado']);
$usuariologado = $u->getUsuarioNome($_SESSION['logado']);

$p = new pedidos($pdo);

if(!empty($_GET['gerar_relatorio'])) {
    $array = explode('/', $_GET['gerar_relatorio']);
    $array_r = array_reverse($array);
    $anomes = implode('-', $array_r);
    $relatorio_geral = $p->gerarRelatorioGeral($anomes);
    $relatorio_devedores = $p->gerarRelatorioDevedores($anomes);
}
?>

<?php require 'inc/header.php'; ?>
    <?php if($u->temPermissao('ADMINISTRADOR')): ?>
        <?php require 'inc/menu.php'; ?>
        <div class="bg-dark py-5">
            <h4 class="text-center text-white font-weight-bold">RELATÓRIO</h4>
            <form method="get">
                <div class="form-group d-sm-flex justify-content-center container-fluid">
                    <input class="form-control mx-sm-0 mx-auto" type="search" name="gerar_relatorio" style="max-width: 200px" placeholder="MÊS/ANO">
                    <button class="btn btn-sm btn-block btn-success mx-sm-2 my-sm-0 mx-auto my-2 font-weight-bold"style ="max-width: 150px">GERAR RELATÓRIO</button>
                </div>    
            </form>
            <?php if(isset($relatorio_geral) && isset($relatorio_devedores)): ?>
            <h4 class="text-center text-white font-weight-bold">GERAL</h4>
            <table class="table table-dark text-center">
                <thead>
                    <tr>
                        <th scope="col">Mês E Ano</th>
                        <th scope="col">Total</th>
                        <th scope="col">Total Pago</th>
                        <th scope="col">Falta Pagar</th>
                    </tr>
                </thead>
                <tbody>
                   <?php foreach($relatorio_geral as $r): ?>
                    <tr>
                        <td><?php echo date('m/Y',strtotime($r['datahora'])); ?></td>
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
                        <th scope="col">Data E Hora</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Total</th>
                        <th scope="col">Valor Pago</th>
                        <th scope="col">Falta Pagar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($relatorio_devedores as $r): ?> 
                    <tr>
                        <td><?php echo date('d/m/Y H:i',strtotime($r['datahora'])); ?></td>
                        <td><?php echo $r['cliente']; ?></td>
                        <td><?php echo "R$ ".number_format($r['total'],2,',','.'); ?></td>
                        <td><?php echo "R$ ".number_format($r['valorpago'],2,',','.'); ?></td>
                        <td><?php echo "R$ ".number_format($r['faltapagar'],2,',','.'); ?></td>
                    </tr>
                    <?php endforeach; ?> 
                </tbody>
            </table>
        <?php endif; ?>
        </div>
    <?php endif; ?>
<?php require 'inc/footer.php'; ?>