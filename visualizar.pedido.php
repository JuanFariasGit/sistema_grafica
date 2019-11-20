<?php ob_start();?>

<h1>Vizualizar Pedido</h1>

<?php
$html = ob_get_contents();
ob_get_clean();

require 'vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf(); 
$mpdf->WriteHTML($html);
$mpdf->Output();
?>