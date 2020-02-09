<?php 
require 'inc/config.php'; 
require 'inc/usuarios.class.php';
require 'inc/clientes.class.php';
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

$c = new clientes($pdo);

if($_SERVER['REQUEST_METHOD'] == "POST") {
        $nomecompleto = $_POST['nomecompleto'];
        $fone = $_POST['fone'];
        $cep = $_POST['cep'];
        $rua = $_POST['rua'];
        $numero = $_POST['numero'];
        $complemento = $_POST['complemento'];
        $bairro = $_POST['bairro'];
        $cidade = $_POST['cidade'];
        $uf = $_POST['uf'];
        
        $c->addCliente($nomecompleto, $fone, $cep, $rua, $numero, $complemento, $bairro, $cidade, $uf);
        header("Location: ".BASE_URL."cliente");
        exit;
}

if(empty($_GET['buscarCliente'])) {
  $clientes = $c->getCliente();
} else {
  $nome = trim($_GET['buscarCliente']);
  $clientes = $c->getClienteBuscar($nome);
}
?>

<?php require 'inc/header.php'; ?>
            <?php if(($u->temPermissao('ADMINISTRADOR')) || ($u->temPermissao('PADRÃO'))): ?>
            <?php require 'inc/menu.php'; ?>
            <div class="text-white bg-dark py-5 d-flex justify-content-center container-fluid flex-column">
                <form method="POST" onsubmit="return validar_cadastro_cliente()">
                        <div class="d-flex justify-content-center">                            
                                <h4 class="font-weight-bold">CLIENTE</h4>
                        </div>  
                        <div class="form-row"> 
                                <div class="col-sm-8">
                                        <label for="nomecompleto">Nome completo :*</label>
                                        <input class="form-control" type="text" name="nomecompleto" id="nomecompleto">
                                </div>              
                                <div class="col-sm-4">
                                        <label for="fone">Fone:*</label>
                                        <input class="form-control" name="fone" type="tel" id="fone" maxlength="14" pattern="[0-9]{2}[\s][9]{1}[\s][0-9]{4}-[0-9]{4}" placeholder="XX 9 XXXX-XXXX">
                                </div> 
                                <div class="col-sm-4">
                                        <label for="cep">Cep :</label>
                                        <input class="form-control" type="text" name="cep" id="cep" maxlength="8">
                                </div>
                                <div class="col-sm-7">
                                        <label for="rua">Rua :</label>
                                        <input class="form-control" name="rua" type="text" id="rua">
                                </div>
                                <div class="col-sm-1">
                                        <label for="numero">Nº :</label>
                                        <input class="form-control" name="numero" type="text" id="numero">
                                </div>
                                <div class="col-sm-4">
                                        <label for="complemento">complemento :</label>
                                        <input class="form-control" name="complemento" type="text" id="complemento">
                                </div>
                                <div class="col-sm-4">
                                        <label fot="bairro">Bairro :</label>
                                        <input class="form-control" name="bairro" type="text" id="bairro">
                                </div>
                                <div class="col-sm-4">
                                        <label for="cidade">Cidade :</label>
                                        <input class="form-control" name="cidade" type="text" id="cidade">
                                </div>
                                <div class="col-sm-2">
                                        <label for="uf">Estado :</label>
                                        <input class="form-control" name="uf" type="text" id="uf">
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                        <input class="btn-sm font-weight-bold my-2 btn-primary text-white border-0" type="submit" value="CADASTRAR">
                                </div>        
                        </div>    
                </form>
                <form method="get">
                  <hr style="background-color:white;">      
                  <div class="form-group d-sm-flex align-items-center justify-content-center">
                    <input class="form-control my-1" type="search" name="buscarCliente" style="max-width: 500px">
                    <input class="btn-sm btn-primary m-1 font-weight-bold" type="submit" value="BUSCAR">
                  </div>
                </form>         
                <div class="table-responsive">
                  <table class="table table-dark text-center">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nome completo</th>
                        <th scope="col">Fone</th>
                        <th  scope="col">Cidade</th>
                        <th scope="col">Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($clientes as $cliente): ?>
                      <tr id="<?php echo $cliente['id'] ?>">
                        <td><p class='my-1'><?php echo $cliente['id'];?></p></td>
                        <td><p class='my-1'><?php echo $cliente['nomecompleto'];?></p></td>
                        <td><a class='my-1' href="https://wa.me/55<?php echo str_replace('-','',str_replace(' ','',$cliente['fone'])) ?>" target="_blank"><?php echo $cliente['fone'];?></a></td>
                        <td><p class='my-1'><?php echo $cliente['cidade'];?></p></td>
                        <td>
                          <a href="<?php echo BASE_URL; ?>edit.cliente?id=<?php echo $cliente['id']; ?>"><i class='fas fa-pen' style='font-size:12pt'></i></a>
                          <a id="<?php echo $cliente['id']; ?>" name="<?php echo $cliente['nomecompleto']; ?>" onclick="delCliente(this)" style="cursor:pointer"><i class='fas fa-trash-alt text-danger' style='font-size:12pt'></i></a>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
            </div>
        <?php else:
        header('Location: '.BASE_URL.'login');  
        ?>   
        <?php endif; ?>
<?php require 'inc/footer.php'; ?>