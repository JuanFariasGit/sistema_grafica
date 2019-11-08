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

$p = new produtos($pdo);

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
      <div class="d-flex flex-column align-items-center justify-content-center text-white bg-dark" style='min-height: 50vh'>    
        <h4 class="font-weight-bold">Produtos Cadastrados</h4> 
        <form method="get">
          <div class="form-group d-sm-flex align-items-center">
            <input class="form-control my-1" type="search" name="buscarProduto">
            <input class="btn-sm btn-primary m-1 font-weight-bold" type="submit" value="BUSCAR">
          </div>
        </form>         
        <div class="table-responsive">
          <table class="table table-dark text-center">
            <thead>
              <tr>
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
      <?php else:
        header('Location: '.BASE_URL.'login');  
        ?>   
    <?php endif; ?>

<?php require 'inc/footer.php'; ?>
