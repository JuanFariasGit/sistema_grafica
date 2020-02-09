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
$pd = new pedidos($pdo);
$pedidos = $pd->getPedidoVisualizar(explode('=',$_GET['cliente'])[1]);
$pedido_produtos = $pd->getPedidoProdutosEdit(explode('=',$_GET['cliente'])[1]);
$c = new clientes($pdo);
$clientes = $c->getClienteVisualizar(explode('?',$_GET['cliente'])[0]);

$html = '<img width="64px" src="assets/imagens/logo_painel_visualizar.png"><br><br>';

$html .= '';

/*$html = '
<table style="width: 100%;margin-bottom: 30px">
    <tbody> 
        <tr>
            <td style="text-align: left"><img width="200px" src="assets/imagens/logo_painel_visualizar.png"></td>
            <td style="text-align: right;"><strong>ELLEN LANUCCE SERVIÇOS</strong><br><p style="font-size: 8pt;">Rua Panelas 18 A - Arthur Lundgren II - Paulista - PE - 53416-540 - 81 9 9591-0891</p><br><p style="font-size: 8pt;">suaimpressora@gmail.com - CNPJ 25.986.182/0001-42</p></td>
        </tr>
    </tbody>
</table>
<table>
    <tbody style="width: 100%;">
        <tr>';
            foreach($pedidos as $pedido):
           $html .= '<td style="text-align: left;font-size: 8pt;text-transform:uppercase;">Ordem de serviço Nº '.$pedido["id"].'</td>;
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
            $html .= ' '.$cliente['numero'].'</td>';
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
            <th scope="col">Qtd</th>
            <th scope="col">Valor Uni</th>
            <th scope="col">SUBTOTAL</th>
        </tr>
    </theader>
    <tbody>';
    foreach($pedido_produtos as $pedido_produto):
       $html .= '<tr>
            <td style="text-align: left;text-transform:uppercase;">'.$pedido_produto['produto'].'</td>            
            <td style="text-align: center;text-transform:uppercase;">'.$pedido_produto['uni'].'</td>';
            if($pedido_produto['uni'] === "m²"):
                $html .= '<td style="text-align: center;">'.str_replace('.', ',', $pedido_produto['al']).'x'.str_replace('.',',', $pedido_produto['la']).'</td>';
            else:
                $html .= '<td style="text-align: center"></td>';
            endif;    
            $html .= '<td style="text-align: center;">'.$pedido_produto['quantidade'].'</td>
            <td style="text-align: center;">'."R$ ".number_format($pedido_produto['valoruni'], 2, ',', '.').'</td>
            <td style="text-align: center;">'."R$ ".number_format($pedido_produto['subtotal'], 2, ',', '.').'</td>;
        </tr>';
        endforeach;
    $html .= '</tbody>
</table>
<table style="margin-top: 10px; width: 100%;font-size: 8pt;">
    <theader>
        <tr>
            <th scope="col">VALOR FRETE</th>
            <th scope="col">VALOR ARTE</th>
            <th scope="col">VALOR OUTROS</th>
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
            if(!empty($pedido['valorarte'])):    
                $html .= '<td style="text-align: center;">R$ '.number_format(str_replace(",", ".", $pedido['valorarte']),2,',','.').'</td>';
            else:
                $html .= '<td style="text-align: center;">R$ 0,00</td>';
            endif;
            if(!empty($pedido['valoroutros'])):    
                $html .= '<td style="text-align: center;">R$ '.number_format(str_replace(",", ".", $pedido['valoroutros']),2,',','.').'</td>';
            else:
                $html .= '<td style="text-align: center;">R$ 0,00</td>';
            endif;
            if(!empty($pedido['taxacartao'])):    
                $html .= '<td style="text-align: center;">'.number_format(str_replace(",", ".", $pedido['taxacartao']),2,',','.').' %</td>';
            else:
                $html .= '<td style="text-align: center;">0,00 %</td>';
            endif;
            if(!empty($pedido['desconto'])):
                $html  .= '<td style="text-align: center;">R$ '.number_format(str_replace(',','.',$pedido['desconto']),2,',','.').'</td>';
            else:
                $html .= '<td style="text-align: center;">R$ 0,00</td>';
            endif;
            if(!empty($pedido['total'])):        
                $html .= '<td style="text-align: center;">R$ '.str_replace(".",",", $pedido['total']).'</td>';
            else:
                $html .= '<td style="text-align: center;">R$ 0,00</td>';
            endif;        
            if(!empty($pedido['valorpago'])):    
                $html .= '<td style="text-align: center;">R$ '.number_format(str_replace(',','.',$pedido['valorpago']),2,',','.').'</td>';
            else:
                $html .= '<td style="text-align: center;">R$ 0,00</td>';
            endif;
            if(!empty($pedido['faltapagar'])):    
                $html .= '<td style="text-align: center;">R$ '.str_replace(".",",", $pedido['faltapagar']).'</td>';
            else:
                $html .= '<td style="text-align: center;"></td>';
            endif;                    
        $html .= '</tr>
    </tbody>
</table>
';
endforeach;endforeach; */
require 'vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [48, 210]]);
$mpdf->WriteHTML($html);
$mpdf->Output('relatorio-pedido-'.explode('?id=',$_GET['cliente'])[1].'_'.explode("?", $_GET['cliente'])[0].'.pdf','I');   
?>