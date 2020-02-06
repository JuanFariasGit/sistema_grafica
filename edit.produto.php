<?php 
require 'inc/config.php';
require 'inc/usuarios.class.php';
require 'inc/produtos.class.php';
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

$p = new produtos($pdo);
$produtos = $p->getProdutoEdit($_GET['id']);
$categorias = $p->getCategoria();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_GET['id'];
    $nome = $_POST['nome'];
    $unidademedida = $_POST['unidademedida'];
    $categoria = explode("|", $_POST['categoria'])[1];
    $valor = str_replace(',', '.', $_POST['valor']);
    
    $p->upProduto($id, $nome, $unidademedida, $categoria, $valor);
    header("Location: ".BASE_URL."produto");
    exit;
}
?>

<?php require 'inc/header.php'; ?>
    
    <?php if(($u->temPermissao('ADMINISTRADOR'))): ?>
        <?php require 'inc/menu.php'; ?>
        <div class="text-white bg-dark py-5">
            <div class="container">
                <?php foreach($produtos as $produto): ?>
                <form method="post" onsubmit="return validar_cadastro_produto()">
                    <div class="d-flex justify-content-center">
                        <h4 class="font-weight-bold">Produto (Editar)</h4>
                    </div>
                    <div class="form-row">
                        <div class="col-lg-6">
                            <label for="nome">Nome:</label>
                            <input class="form-control" type="text" name="nome" id="nome" value="<?php echo $produto['nome']; ?>">
                        </div>
                        <div class="col-lg-2">
                            <label for="unidademedida">Unidade de medida:</label>
                            <select class="form-control" name="unidademedida" id="unidademedida">
                                <option></option>
                                <option value="m²" <?php if($produto['unidademedida'] == 'm²') {echo "selected='selected'";}; ?>>m²</option>
                                <option value="uni" <?php if($produto['unidademedida'] == 'uni') {echo "selected='selected'";}; ?>>uni</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label for="categoria">Categoria:</label>
                            <select class="form-control" name="categoria" id="categoria">
                                <option></option>
                                <?php foreach($categorias as $categoria): ?>
                                    <option value="<?php echo $categoria['nome']; ?>|<?php echo $categoria['id']; ?>" <?php if($produto['categoria'] == $categoria['nome']) {echo  "selected='selected'";}; ?>><?php echo $categoria['nome']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label for="valor">Valor (R$):</label>
                            <input class="form-control" type="text" name="valor" id="valor" value="<?php echo str_replace(".", ",", $produto['valor']); ?>">
                        </div>
                        <div class="col-12 mt-4 d-flex justify-content-center">
                            <input class="btn-sm bg-primary text-white border-0 font-weight-bold" type="submit" value="SALVAR">
                        </div>
                        <?php endforeach; ?>
                    </div>
                </form>
            </div>    
        </div>
        <?php else:
              require 'inc/menu.php';
         echo    "<div class='d-flex flex-column justify-content-center align-items-center bg-dark text-white' style='min-height: 75vh'>
                     <h4 class='font-weight-bold'>É presiso ter permissão de administrador</h4>
                     <img class='my-2' width='100px' src='assets/imagens/logo.png'>
                 </div>
                "         
       ?>         
        <?php endif; ?>

<?php require 'inc/footer.php'; ?>    