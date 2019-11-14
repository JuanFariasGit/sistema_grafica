<?php
require 'inc/config.php';
require 'inc/usuarios.class.php';
require 'inc/produtos.class.php';
session_start();

if(empty($_SESSION['logado'])) {
    header("Location: ".BASE_URL."login");
    exit;
}

$u = new usuarios($pdo);
$u->setUsuario($_SESSION['logado']);

$p = new produtos($pdo);
$categorias = $p->getCategoria();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $unidademedida = $_POST['unidademedida'];
    $categoria = $_POST['categoria'];
    $valor = $_POST['valor'];

    $p->addProduto($nome, $unidademedida, $categoria, $valor);
    header("Location: ".BASE_URL."produtos.cadastrados");
}
?>

<?php require 'inc/header.php'; ?>
    
    <?php if(($u->temPermissao('ADMINISTRADOR')) || ($u->temPermissao('PADRÃO'))): ?>
        <?php require 'inc/menu.php'; ?>
        <div class="text-white bg-dark py-5">
            <div class="container">
                <form method="post" onsubmit="return validar_cadastro_produto()">
                    <div class="d-flex justify-content-center">
                        <h4 class="font-weight-bold">Cadastrar produto</h4>
                    </div>
                    <div class="form-row">
                        <div class="col-lg-6">
                            <label for="nome">Nome:</label>
                            <input class="form-control" type="text" name="nome" id="nome">
                        </div>
                        <div class="col-lg-2">
                            <label for="unidademedida">Unidade de medida:</label>
                            <select class="form-control" name="unidademedida" id="unidademedida">
                                <option></option>
                                <option value="m²">m²</option>
                                <option value="uni">uni</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label for="categoria">Categoria:<a class="text-success px-1" onclick="addCategoria()" style="cursor: pointer">( + )</a><a class="text-danger px-1" onclick="delCategoria()" style="cursor: pointer">( - )</a></label>
                            <select class="form-control" name="categoria" id="categoria">
                                <option></option>
                                <?php foreach($categorias as $categoria): ?>
                                    <option id="<?php echo $categoria['id']; ?>" value="<?php echo $categoria['nome']; ?>"><?php echo $categoria['nome']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label for="valor">Valor:</label>
                            <input class="form-control" type="text" name="valor" id="valor" onkeydown="mascara_valor(this, valor, event)">
                        </div>
                        <div class="col-12 my-2">
                            <input class="btn-block btn-sm btn-primary text-white border-0 font-weight-bold" type="submit" value="CADASTRAR">
                        </div>
                    </div>
                </form>
            </div>    
        </div>
        <?php else: 
            header("Location: ".BASE_URL."login");
            ?>
        <?php endif; ?>

<?php require 'inc/footer.php'; ?>    