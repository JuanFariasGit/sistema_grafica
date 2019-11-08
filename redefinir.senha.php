<?php
require 'inc/config.php';
require 'inc/usuarios.class.php';

if(!empty($_GET['token'])) {
    $token = $_GET['token'];
    $u = new usuarios($pdo);

    $u->redefinirSenha($token);
} else {
    header("Location: ".BASE_URL."login");
}