-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 18-Dez-2019 às 05:00
-- Versão do servidor: 10.3.16-MariaDB
-- versão do PHP: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `graficasistema`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`) VALUES
(34, 'Serviço'),
(36, 'Festa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nomecompleto` varchar(100) NOT NULL,
  `fone` varchar(50) NOT NULL,
  `cep` varchar(50) NOT NULL,
  `rua` varchar(100) NOT NULL,
  `numero` varchar(50) NOT NULL,
  `complemento` varchar(100) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `uf` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nomecompleto`, `fone`, `cep`, `rua`, `numero`, `complemento`, `bairro`, `cidade`, `uf`) VALUES
(12, 'Ramon De Oliveira Farias', '81 9 9999-9747', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `historico`
--

CREATE TABLE `historico` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `datahora` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  `so` varchar(30) NOT NULL,
  `Navegador` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `historico`
--

INSERT INTO `historico` (`id`, `id_usuario`, `datahora`, `ip`, `so`, `Navegador`) VALUES
(20, 1, '2019-12-17 10:12:00', '::1', 'Windows 10', 'Firefox'),
(21, 1, '2019-12-17 23:11:00', '::1', 'Windows 10', 'Firefox'),
(22, 1, '2019-12-18 00:18:00', '::1', 'Windows 10', 'Firefox');

-- --------------------------------------------------------

--
-- Estrutura da tabela `historico_senha`
--

CREATE TABLE `historico_senha` (
  `id` int(11) NOT NULL,
  `senha` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `historico_senha`
--

INSERT INTO `historico_senha` (`id`, `senha`) VALUES
(1, 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `datahora` datetime NOT NULL,
  `obs` text NOT NULL,
  `valorfrete` float(9,2) NOT NULL,
  `taxacartao` float(9,2) NOT NULL,
  `desconto` float(9,2) NOT NULL,
  `total` float(9,2) NOT NULL,
  `valorpago` float(9,2) NOT NULL,
  `faltapagar` float(9,2) NOT NULL,
  `situacao` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_cliente`, `datahora`, `obs`, `valorfrete`, `taxacartao`, `desconto`, `total`, `valorpago`, `faltapagar`, `situacao`) VALUES
(31, 12, '2019-12-17 22:14:00', '', 2.00, 5.00, 4.00, 11.39, 6.50, 4.89, 28),
(32, 12, '2019-12-18 00:37:00', '', 0.00, 5.00, 0.00, 12.86, 10.00, 2.86, 27);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido_produtos`
--

CREATE TABLE `pedido_produtos` (
  `id_pedido` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `quantidade` varchar(10) NOT NULL,
  `al` varchar(10) NOT NULL,
  `la` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pedido_produtos`
--

INSERT INTO `pedido_produtos` (`id_pedido`, `id_produto`, `quantidade`, `al`, `la`) VALUES
(31, 263, '1', '1.25', '1'),
(31, 270, '1', '1', '1'),
(32, 263, '1', '1', '1'),
(32, 270, '1', '1', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `categoria` int(11) DEFAULT NULL,
  `unidademedida` varchar(100) NOT NULL,
  `valor` float(9,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `categoria`, `unidademedida`, `valor`) VALUES
(263, 'Banner', 34, 'm²', 7.00),
(270, 'Copo de porcelana', 36, 'uni', 5.25);

-- --------------------------------------------------------

--
-- Estrutura da tabela `situacao`
--

CREATE TABLE `situacao` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `situacao`
--

INSERT INTO `situacao` (`id`, `nome`) VALUES
(27, 'Em Produção'),
(28, 'Concluído');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(32) NOT NULL,
  `permissao` varchar(100) NOT NULL,
  `ip` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `permissao`, `ip`) VALUES
(1, 'Juan Farias', 'juanfarias580@gmail.com', '202cb962ac59075b964b07152d234b70', 'ADMINISTRADOR', '::1'),
(4, 'Ramon Farias', 'irmaoramonfarias@gmail.com', '202cb962ac59075b964b07152d234b70', 'PADRÃO', '::1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios_token`
--

CREATE TABLE `usuarios_token` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `used` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios_token`
--

INSERT INTO `usuarios_token` (`id`, `id_usuario`, `hash`, `used`) VALUES
(1, 1, '080abe484ef46ee4123f2a769f132314', 0),
(2, 1, '23bce75d9df17047f66e30e75a08b7e4', 1),
(3, 5, '43a1433c1d1f87ec3209855faae0bd3d', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `historico`
--
ALTER TABLE `historico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `historico_senha`
--
ALTER TABLE `historico_senha`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cod_situacao` (`situacao`) USING BTREE,
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Índices para tabela `pedido_produtos`
--
ALTER TABLE `pedido_produtos`
  ADD KEY `id_pedido` (`id_pedido`) USING BTREE,
  ADD KEY `id_produto` (`id_produto`) USING BTREE;

--
-- Índices para tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `produtos_ibfk_1` (`categoria`);

--
-- Índices para tabela `situacao`
--
ALTER TABLE `situacao`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios_token`
--
ALTER TABLE `usuarios_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `historico`
--
ALTER TABLE `historico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `historico_senha`
--
ALTER TABLE `historico_senha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=271;

--
-- AUTO_INCREMENT de tabela `situacao`
--
ALTER TABLE `situacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuarios_token`
--
ALTER TABLE `usuarios_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `historico`
--
ALTER TABLE `historico`
  ADD CONSTRAINT `historico_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);

--
-- Limitadores para a tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`situacao`) REFERENCES `situacao` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limitadores para a tabela `pedido_produtos`
--
ALTER TABLE `pedido_produtos`
  ADD CONSTRAINT `pedido_produtos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `categorias` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
