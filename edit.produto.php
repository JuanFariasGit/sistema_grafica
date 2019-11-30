<?php 
require 'inc/config.php';
require 'inc/usuarios.class.php';
require 'inc/produtos.class.php';
session_start();

if(empty($_SESSION['logado'])) {
    header('Location: '.BASE_URL.'login');
    exit;
}

$u = new usuarios($pdo);
$u->setUsuario($_SESSION['logado']);
$usuariologado = $u->getUsuarioNome($_SESSION['logado'])['nome'];

$p = new produtos($pdo);
$produtos = $p->getProdutoEdit($_GET['id']);
$categorias = $p->getCategoria();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_GET['id'];
    $nome = $_POST['nome'];
    $unidademedida = $_POST['unidademedida'];
    $categoria = explode("|", $_POST['categoria'])[1];
    $valor = "R$ ".number_format(str_replace(",", ".", $_POST['valor']),2,",",".");
    
    $p->upProduto($id, $nome, $unidademedida, $categoria, $valor);
    header("Location: ".BASE_URL."produto");
    exit;
}
?>

<?php require 'inc/header.php'; ?>
    
    <?php if(($u->temPermissao('ADMINISTRADOR')) || ($u->temPermissao('PADRÃO'))): ?>
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
                            <input class="form-control" type="text" name="valor" id="valor" value="<?php echo explode("R$", $produto['valor'])[1]; ?>">
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
            header("Location: ".BASE_URL."login");
            ?>
        <?php endif; ?>

<?php require 'inc/footer.php'; ?>    