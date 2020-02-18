<?php 
define('BASE_URL' , 'https://www.ramonfarias.com.br/grafica-demo/');

try {
	$pdo = new PDO('mysql:dbname=ramonfar_grafica-demo;host=localhost', 'ramonfar_SGD',  '(Sh@lin..)18'); 
	$pdo->exec('SET CHARACTER SET utf8');
} catch(PDOException $e) {
	echo "FALHA:  ".$e->getMessage();
}
