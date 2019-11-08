<?php 
define('BASE_URL' , 'http://localhost/sistema_grafica/');

try {
	$pdo = new PDO('mysql:dbname=graficasistema;host=localhost', 'root',  ''); 
	$pdo->exec('SET CHARACTER SET utf8');
} catch(PDOException $e) {
	echo "FALHA:  ".$e->getMessage();
}
