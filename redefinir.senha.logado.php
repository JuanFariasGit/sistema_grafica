<?php 

require 'inc/config.php';

require 'inc/usuarios.class.php';

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


$redefinir_err = '';

if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(!empty($_POST['atualsenha']) && !empty($_POST['novasenha']) && !empty($_POST['novasenhanovamente']) && $u->getUsuarioSenha($_SESSION['logado'])['senha'] == md5($_POST['atualsenha']) && $_POST['novasenha'] == $_POST['novasenhanovamente']) {

		$id = $_GET['id'];

		$senha = md5($_POST['novasenha']);

		$u->redefineSenhaLogado($id, $senha);

		echo '<script>alert("Sua senha foi alterada com successo !"); location = "'.BASE_URL.'"</script>';

    } else {

        $redefinir_err = 'nova senha e/ou senha atual e/ou senha atual(novamente) estão errados!';

    }

}    

?>



<?php require 'inc/header.php'; ?>

    <?php require 'inc/menu.php'; ?>

	<div class='d-flex flex-column justify-content-center align-items-center bg-dark text-white py-3'>    

		<form class="col-3 mb-2" method="POST" onsubmit="return validar_redefinir_senha_logado()">

            <div class="form-group">

				<label for="atualsenha">Digite a senha atual:</label>

				<input class="form-control" type="password" name="atualsenha" id="atualsenha">

			</div>

			<div class="form-group">

				<label for="novasenha">Digite a nova senha:</label>

				<input class="form-control" type="password" name="novasenha" id="novasenha">

			</div>

            <div class="form-group">

				<label for="novasenha">Digite a nova senha(novamente):</label>

				<input class="form-control" type="password" name="novasenhanovamente" id="novasenhanovamente">

			</div>

			<input class="btn-sm btn-primary" type="submit" value="Mudar senha">

		</form>

        <span class="text-danger"><?php echo $redefinir_err; ?></span>

	</div> 

			 

<?php require 'inc/footer.php'; ?>