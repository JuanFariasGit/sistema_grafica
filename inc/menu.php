<nav class="navbar navbar-expand-md navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#"><img class="my-2" width="70px" src="<?php echo BASE_URL; ?>assets/imagens/logo_painel.png"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alterna navegação">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>usuario">Usuário</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" href="<?php echo BASE_URL; ?>cliente">Cliente</a>
        </li> 
        <li class="nav-item">
            <a class="nav-link" href="<?php echo BASE_URL; ?>produto">Produto</a>
        </li>
        <li class="nav-item">
           <a class="nav-link" href="<?php echo BASE_URL; ?>pedido">Pedido</a>
        </li>              
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img width="25px" src="<?php BASE_URL; ?>assets/imagens/config.png">
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="<?php echo BASE_URL; ?>redefinir.senha.logado?id=<?php echo $_SESSION['logado']; ?>">Alterar Senha</a>
              <a class="dropdown-item" href="<?php echo BASE_URL; ?>login/logout">Sair</a>
            </div>
        </li>
        <span class="navbar-text"><?php echo $u->getUsuarioNome($_SESSION['logado'])['nome']; ?></span>        
      </ul>  
    </div>
  </div>
</nav>