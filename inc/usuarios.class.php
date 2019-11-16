<?php 

class usuarios {

    private $pdo;
	private $id;
	private $permissao;

	public function __construct($pdo) {
		$this->pdo = $pdo;
	}
    
	public function fazerLogin($nome, $email, $senha) {
		$sql = "SELECT * FROM usuarios WHERE email = :email AND senha = :senha OR nome = :nome AND senha = :senha";
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(":nome", $nome);
		$sql->bindValue(":email", $email);
		$sql->bindValue(":senha", $senha);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$sql = $sql->fetch();

			$_SESSION['logado'] = $sql['id'];

			return true;
		}

		return false;
	}

	public function setUsuario($id) {
		$this->id = $id;
		
		$sql = "SELECT * FROM usuarios WHERE id = :id";
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(":id", $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$sql = $sql->fetch();
			$this->permissao = $sql['permissao'];
		}
	}

	public function getPermissao() {
		return $this->permissao;
	}

	public function temPermissao($p) {
		if($p == $this->permissao) {
			return true;
		} else {
			return false;
		}
	}
	
    public function addUsuario($nome, $email, $senha, $permissao) {
		$sql = 'INSERT INTO usuarios SET nome = :nome, email = :email, senha = :senha, permissao = :permissao';
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(':nome', $nome);
		$sql->bindValue(':email', $email);
		$sql->bindValue(':senha', $senha);
		$sql->bindValue(':permissao', $permissao);
		$sql->execute();
	}
	
	public function getUsuario() {
		$array = array();
		$sql = 'SELECT * FROM usuarios ORDER BY nome ASC';
		$sql = $this->pdo->prepare($sql);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}
		return $array;
	}

	public function getUsuarioNome($id) {
		$sql = 'SELECT nome FROM usuarios WHERE id = :id';
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$nome = $sql->fetch();
		}
		return $nome;
	}

	public function getUsuarioSenha($id) {
		$sql = 'SELECT senha FROM usuarios WHERE id = :id';
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$senha = $sql->fetch();
		}
		return $senha;
	}

	public function getUsuarioEdit($id) {
		$array = array();
		$sql = 'SELECT * FROM usuarios WHERE id = :id';
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(":id", $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}
		return $array;
	}

	public function upUsuario($id , $nome, $email, $permissao) {	
		$sql = 'UPDATE usuarios SET nome = :nome, email = :email, permissao = :permissao WHERE id = :id';
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->bindValue(':nome', $nome);
		$sql->bindValue(':email', $email);
		$sql->bindValue(':permissao', $permissao);
		$sql->execute();
	}	 

	public function delUsuario($id) {
		$sql = 'DELETE FROM usuarios WHERE id = :id';
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();
	}

	public function esqueceuSenha($email) {
		$sql = "SELECT * FROM usuarios WHERE email = :email";
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(":email", $email);
		$sql->execute();

		if($sql->rowCount() > 0) {

			$sql = $sql->fetch();
			$id = $sql['id'];

			$token = md5(time().rand(0, 99999).rand(0, 99999));

			$sql = "INSERT INTO usuarios_token SET id_usuario = :id_usuario, hash = :hash ";
			$sql = $this->pdo->prepare($sql);
			$sql->bindValue(":id_usuario", $id);
			$sql->bindValue(":hash", $token);
			$sql->execute();

			$link = "http://localhost/sistema_grafica/redefinir.senha?token=".$token;

			$mensagem = "Clique no link para redefinir sua senha:<br/>".$link;

			$assunto = "Redefinição de senha";

			$headers = 'From: seuemail@seusite.com.br'."\r\n".'X-Mailer: PHP/'.phpversion();
			//mail($email, $assunto, $mensagem, $headers);
			echo $mensagem;
			exit;
		} else {
			echo "<script>alert('Não existe nenhum usuário gadastrado com esse email !!!');</script>";
		}
	}

	public function redefinirSenha($token) {
		$sql = "SELECT * FROM usuarios_token WHERE hash = :hash AND used = 0";
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(":hash", $token);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$sql = $sql->fetch();
			$id = $sql['id_usuario'];

			if(!empty($_POST['senha'])) {
				$senha = $_POST['senha'];

				$sql = "UPDATE usuarios SET senha = :senha WHERE id = :id";
				$sql = $this->pdo->prepare($sql);
				$sql->bindValue(":senha", md5($senha));
				$sql->bindValue(":id", $id);
				$sql->execute();

				$sql = "UPDATE usuarios_token SET used = 1 WHERE hash = :hash";
				$sql = $this->pdo->prepare($sql);
				$sql->bindValue(":hash", $token);
				$sql->execute();

				echo "<script>alert('SENHA ALTERADA COM SUCESSO!'); location='login'</script>";
				exit;
			}
			?>
			<?php require 'inc/header.php'; ?>

				<div class='d-flex flex-column justify-content-center align-items-center bg-dark text-white py-3'>    
					<form method="POST">
						<img class="my-2" width="300px" src="<?php echo BASE_URL; ?>assets/imagens/logo.png">
						<div class="form-group">
							<label for="senha">Digite a nova senha:</label>
							<input class="form-control" type="password" name="senha" id="senha">
						</div>
							<input class="btn-sm btn-primary" type="submit" value="Mudar senha">
					</form>
				</div> 
			 
			<?php require 'inc/footer.php'; ?>			
		<?php		
		} else {
			echo "Token inválido ou usado!";
			exit;
		}
	}
	
	public function getUsuarioBuscar($nome) {
		$array = array();
		
		$sql = 'SELECT * FROM usuarios WHERE nome LIKE CONCAT(:nome, "%")';
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(":nome", $nome);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}
		return $array;
	}

	public function redefineSenhaLogado($id, $senha) {
		$sql = 'UPDATE usuarios SET senha = :senha WHERE id = :id';
		$sql = $this->pdo->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->bindValue(':senha', $senha);
		$sql->execute();
	}
}
