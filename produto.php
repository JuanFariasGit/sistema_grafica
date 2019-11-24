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
    $categoria = explode("|", $_POST['categoria'])[0];
    $valor = "R$ ".number_format(str_replace(",", ".", $_POST['valor']),2,",",".");

    $p->addProduto($nome, $unidademedida, $categoria, $valor);
    header("Location: ".BASE_URL."produto");
}

if(empty($_GET['buscarProduto'])) {
  $produtos = $p->getProduto();
} else {
  $nome = trim($_GET['buscarProduto']);
  $produtos = $p->getProdutoBuscar($nome);
}
?>

<?php require 'inc/header.php'; ?>
    
    <?php if(($u->temPermissao('ADMINISTRADOR')) || ($u->temPermissao('PADRÃO'))): ?>
        <?php require 'inc/menu.php'; ?>
        <div class="text-white bg-dark py-5">
            <div class="container-fluid">
                <form method="post" onsubmit="return validar_cadastro_produto()">
                    <div class="d-flex justify-content-center">
                        <h4 class="font-weight-bold">PRODUTO</h4>
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
                            <label for="categoria">Categoria:<a class="text-success px-1" onclick="addCategoria()" style="cursor: pointer">(+)</a><a class="text-primary" onclick="upCategoria()" style="cursor: pointer">(#)</a><a class="text-danger px-1" onclick="delCategoria()" style="cursor: pointer">(-)</a></label>
                            <select class="form-control" name="categoria" id="categoria">
                                <option></option>
                                <?php foreach($categorias as $categoria): ?>
                                    <option value="<?php echo $categoria['nome']; ?>|<?php echo $categoria['id']; ?>"><?php echo $categoria['nome']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label for="valor">Valor (R$):</label>
                            <input class="form-control" type="text" name="valor" id="valor">
                        </div>
                        <div class="col-12 my-2 d-flex justify-content-center">
                            <input class="btn-sm btn-primary text-white border-0 font-weight-bold" type="submit" value="CADASTRAR">
                        </div>
                    </div>
                </form>
                <form method="get">
                  <div class="form-group d-sm-flex align-items-center justify-content-center">
                    <input class="form-control my-1" type="search" name="buscarProduto" style="max-width: 500px">
                    <input class="btn-sm btn-primary m-1 font-weight-bold" type="submit" value="BUSCAR">
                  </div>
                </form>         
                <div class="table-responsive">
                  <table class="table table-dark text-center">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th  scope="col">Nome</th>
                        <th  scope="col">Unidade de medida</th>
                        <th  scope="col">Categoria</th>
                        <th  scope="col">Valor</th>
                        <th scope="col">Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if(count($produtos) > 0): ?>
                      <?php foreach($produtos as $produto): ?>
                      <tr>
                        <td><p class="my-1"><?php echo $produto['id']; ?></p></td>
                        <td><p class='my-1'><?php echo $produto['nome'];?></p></td>
                        <td><p class='my-1'><?php echo $produto['unidademedida'];?></p></td>
                        <td><p class='my-1'><?php echo $produto['categoria'];?></p></td>
                        <td><p class='my-1'><?php echo $produto['valor'];?></p></td>
                        <td>
                          <a class="btn btn-sm btn-success my-1" href="<?php echo BASE_URL; ?>edit.produto?id=<?php echo $produto['id']; ?>">EDIT</a>
                          <a id="<?php echo $produto['id']; ?>" name="<?php echo $produto['nome']; ?>" class="btn btn-danger btn-sm" onclick="delProduto(this)" style="cursor:pointer">DEL</a>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                      <?php else: echo "<h5 class='text-center text-danger'>Não há nenhum cadastro !!!</h5>"; ?>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
        <?php else: 
            header("Location: ".BASE_URL."login");
            ?>
        <?php endif; ?>

<?php require 'inc/footer.php'; ?>    