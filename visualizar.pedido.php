<?php 
ob_start();
require 'inc/config.php';
require 'inc/usuarios.class.php';
require 'inc/clientes.class.php';
require 'inc/produtos.class.php';
require 'inc/pedidos.class.php';
session_start();

if(empty($_SESSION['logado'])) {
    header('Location: '.BASE_URL."login");
}

$u = new usuarios($pdo);
$u->setUsuario($_SESSION['logado']);
$pd = new pedidos($pdo);
$pedidos = $pd->getPedidoVisualizar(explode('=',$_GET['cliente'])[1]);
$c = new clientes($pdo);
$clientes = $c->getClienteVisualizar(explode('?',$_GET['cliente'])[0]);
$p = new produtos($pdo);
$produtos = $p->getProduto();

$unidade_e_produto = array();
foreach($produtos as $produto) {
    array_push($unidade_e_produto, $produto['unidademedida']."*".$produto['nome']);
}

$produtos_v_array = array();
foreach($pedidos as $pedido) {
    if($pedido['produto'] != "") {
        $produtos_v_array = explode(",", $pedido['produto']);
    }
     $la_v_array = explode(",", $pedido['la']);
     $al_v_array = explode(",", $pedido['al']);
     $quantidade_v_array = explode(",", $pedido['quantidade']);   
     $valorunitario_v_array = explode("-", $pedido['valorunitario']);
     $subtotal_v_array = explode("-" , $pedido['subtotal']);
}

$array_unidade = array();
for($i = 0; $i < count($produtos_v_array); $i++) {
    for($j = 0; $j < count($unidade_e_produto); $j++) {
        if($produtos_v_array[$i] === explode("*", $unidade_e_produto[$j])[1]) {
            array_push($array_unidade, explode("*", $unidade_e_produto[$j])[0]);
        }
    }
}

$html = '
<table style="width: 100%;margin-bottom: 30px">
    <tbody> 
        <tr>
            <td style="text-align: left"><img width="200px" src="assets/imagens/logo_painel_visualizar.png"></td>
            <td style="text-align: right;"><strong>ELLEN LANUCCE SERVIÇOS</strong><br><p style="font-size: 8pt">Rua Panelas 18 A - Arthur Lundgren II - Paulista - PE - 53416-540 - 81 9 9591-0891</p></td>
        </tr>
    </tbody>
</table>
<table>
    <tbody style="width: 100%;">
        <tr>';
            foreach($pedidos as $pedido):
           $html .= '<td style="text-align: left;font-size: 8pt;text-transform:uppercase;">Ordem de serviço N° '.$pedido["id"].'</td>;
            </tr>
    </tbody>
</table>
<table style="margin-top: 30px;width: 100%;border-top: 1px solid;border-left: 1px solid; border-right: 1px solid;font-size: 8pt;">
    <tbody>
        <tr>';
        foreach($clientes as $cliente):
          $html.= '<td style="text-align: left;text-transform:uppercase;">Cliente: '.$cliente['nomecompleto'].'</td>
           <td style="text-align: right;text-transform:uppercase;">Fone: '.$cliente['fone'].'</td>';
       $html .= '</tr>
    </tbody>
</table>
<table style="width: 100%;border-top: 1px solid;border-left: 1px solid; border-right: 1px solid;font-size: 8pt;">
    <tbody>
        <tr>
            <td style="text-transform:uppercase;">Endereço: '.$cliente['rua'];
        if(!empty($cliente['numero'])):    
            $html .= ' Nº '.$cliente['numero'].'</td>';
        else:
            $html .= ' S/N</td>';
        endif;    
       $html .= '
            <td style="text-transform:uppercase;">BAIRRO: '.$cliente['bairro'].'</td>;
            <td style="text-transform:uppercase;">CIDADE: '.$cliente['cidade'].'</td>;
            <td style="text-transform:uppercase;">ESTADO: '.$cliente['uf'].'</td>;
            <td>CEP: '.$cliente['cep'].'</td>;
       </tr>
    </tbody>
</table>
<table style="width: 100%;border-top: 1px solid;border-left: 1px solid; border-right: 1px solid;font-size: 8pt;">
    <tbody>
        <tr>
            <td style="text-transform:uppercase;">Obs: '.$pedido['obs'].'</td>
        </tr>
    </tbody>
</table>
<table style="width: 100%;border: 1px solid;font-size: 8pt;">
    <theader>
        <tr>
            <th scope="col">PRODUTO</th>
            <th scope="col">Uni</th>
            <th scope="col">AL x LA</th>
            <th scope="col">QUATIDADE</th>
            <th scope="col">VALOR UNITÁRIO</th>
            <th scope="col">SUBTOTAL</th>
        </tr>
    </theader>
    <tbody>';
    if(count($produtos_v_array) > 0):
        for($i = 0; $i < count($produtos_v_array); $i++):
       $html .= '<tr>
            <td style="text-align: left;text-transform:uppercase;">'.$produtos_v_array[$i].'</td>            
            <td style="text-align: center;text-transform:uppercase;">'.$array_unidade[$i].'</td>';
            if($array_unidade[$i] === "m²"):
                $html .= '<td style="text-align: center;">'.$la_v_array[$i].'x'.$la_v_array[$i].'</td>';
            else:
                $html .= '<td style="text-align: center"></td>';
            endif;    
            $html .= '<td style="text-align: center;">'.$quantidade_v_array[$i].'</td>
            <td style="text-align: center;">'.$valorunitario_v_array[$i].'</td>
            <td style="text-align: center;">'.$subtotal_v_array[$i].'</td>;
        </tr>';
        endfor;endif;
    $html .= '</tbody>
</table>
<table style="margin-top: 10px;width: 100%;font-size: 8pt;">
    <theader>
        <tr>
            <th scope="col">VALOR FRETE</th>
            <th scope="col">TAXA CARTÃO</th>
            <th scope="col">DESCONTO</th>
            <th scope="col">TOTAL</th>
            <th scope="col">VALOR PAGO</th>
            <th scope="col">FALTA PAGAR</th>
        </tr>
    </theader>
    <tbody>
        <tr>';
            if(!empty($pedido['valorfrete'])):
                $html .= '<td style="text-align: center;">R$ '.number_format(str_replace(',', '.', $pedido['valorfrete']),2,',','.').'</td>';
            else:
                $html .= '<td style="text-align: center;">R$ 0,00</td>';
            endif;
            if(!empty($pedido['taxacartao'])):    
                $html .= '<td style="text-align: center;">'.number_format(str_replace(",", ".", $pedido['taxacartao']),2,',','.').' %</td>';
            else:
                $html .= '<td style="text-align: center;">0,00 %</td>';
            endif;
            if(!empty($pedido['desconto'])):
                $html  .= '<td style="text-align: center">R$ '.number_format(str_replace(',','.',$pedido['desconto']),2,',','.').'</td>';
            else:
                $html .= '<td style="text-align: center">R$ 0,00</td>';
            endif;
            if(!empty($pedido['total'])):        
                $html .= '<td style="text-align: center">'.explode(":", $pedido['total'])[1].'</td>';
            else:
                $html .= '<td style="text-align: center">R$ 0,00</td>';
            endif;        
            if(!empty($pedido['valorpago'])):    
                $html .= '<td style="text-align: center">R$ '.number_format(str_replace(',','.',$pedido['valorpago']),2,',','.').'</td>';
            else:
                $html .= '<td style="text-align: center">R$ 0,00</td>';
            endif;
            if(!empty($pedido['faltapagar'])):    
                $html .= '<td style="text-align: center">'.explode(":", $pedido['faltapagar'])[1].'</td>';
            else:
                $html .= '<td style="text-align: center"></td>';
            endif;                    
        $html .= '</tr>
    </tbody>
</table>
';
endforeach;endforeach;
require 'vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->SetHTMLFooter('
<table width="100%">
    <tr>
        <td>{DATE j-m-Y}</td>
        <td align="center">{PAGENO}/{nbpg}</td>
    </tr>
</table>');
$mpdf->WriteHTML($html);
$mpdf->Output('relatorio-pedido-'.explode('?',$_GET['cliente'])[0].'.pdf','I');   
?>