-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 09-Fev-2020 às 22:10
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
(65, 'Serviço'),
(66, 'Festa');

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
(20, 'Juan De Oliveira Farias', '81 9 9999-9747', '', '', '', '', '', '', '');

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
(128, 62, '2020-02-08 20:50:00', '::1', 'Windows 10', 'Firefox'),
(129, 62, '2020-02-08 21:41:00', '::1', 'Windows 10', 'Firefox'),
(130, 62, '2020-02-08 23:49:00', '::1', 'Windows 10', 'Opera'),
(131, 62, '2020-02-08 23:50:00', '::1', 'Windows 10', 'Google Chrome'),
(132, 62, '2020-02-09 01:09:00', '::1', 'Windows 10', 'Firefox'),
(133, 62, '2020-02-09 01:13:00', '::1', 'Windows 10', 'Google Chrome'),
(134, 62, '2020-02-09 10:00:00', '::1', 'Windows 10', 'Firefox'),
(135, 62, '2020-02-09 10:09:00', '::1', 'Windows 10', 'Firefox'),
(136, 62, '2020-02-09 10:13:00', '::1', 'Windows 10', 'Firefox'),
(137, 62, '2020-02-09 12:29:00', '::1', 'Windows 10', 'Firefox'),
(138, 62, '2020-02-09 13:49:00', '::1', 'Windows 10', 'Firefox'),
(139, 62, '2020-02-09 16:27:00', '::1', 'Windows 10', 'Firefox'),
(140, 62, '2020-02-09 18:09:00', '::1', 'Windows 10', 'Firefox');

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
  `emissao` datetime NOT NULL,
  `obs` text NOT NULL,
  `valorfrete` float(9,2) NOT NULL,
  `valorarte` float(9,2) NOT NULL,
  `valoroutros` float(9,2) NOT NULL,
  `taxacartao` float(9,2) NOT NULL,
  `desconto` float(9,2) NOT NULL,
  `total` float(9,2) NOT NULL,
  `valorpago` float(9,2) NOT NULL,
  `faltapagar` float(9,2) NOT NULL,
  `situacao` int(11) DEFAULT NULL,
  `entrega` date NOT NULL,
  `vendedor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_cliente`, `emissao`, `obs`, `valorfrete`, `valorarte`, `valoroutros`, `taxacartao`, `desconto`, `total`, `valorpago`, `faltapagar`, `situacao`, `entrega`, `vendedor`) VALUES
(54, 19, '2020-02-08 20:59:00', '', 0.00, 0.00, 0.00, 0.00, 0.00, 50.00, 25.00, 25.00, 28, '2020-05-04', 'Juan Farias'),
(55, 20, '2020-02-09 11:38:00', 'Entregar só na segunda porque estou esperando uma resposta do cliente.', 0.00, 0.00, 0.00, 0.00, 10.00, 40.00, 0.00, 40.00, 67, '2020-05-08', 'Juan Farias');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido_produtos`
--

CREATE TABLE `pedido_produtos` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `produto` varchar(100) NOT NULL,
  `uni` varchar(10) NOT NULL,
  `al` float(3,2) NOT NULL,
  `la` float(3,2) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `valoruni` float(9,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pedido_produtos`
--

INSERT INTO `pedido_produtos` (`id`, `id_pedido`, `produto`, `uni`, `al`, `la`, `quantidade`, `valoruni`) VALUES
(131, 54, 'Banner', 'm²', 1.00, 1.00, 1, 50.00),
(136, 55, 'Banner', 'm²', 1.00, 1.00, 1, 50.00);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `categoria` int(11) DEFAULT NULL,
  `unidademedida` varchar(10) NOT NULL,
  `valor` float(9,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `categoria`, `unidademedida`, `valor`) VALUES
(285, 'Banner', 65, 'm²', 50.00);

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
(28, 'Concluído'),
(67, 'Aguardando Resposta');

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
  `ip` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `permissao`, `ip`) VALUES
(62, 'Juan Farias', 'juanfarias580@gmail.com', '202cb962ac59075b964b07152d234b70', 'ADMINISTRADOR', '::1'),
(87, 'Ramon Farias', 'irmaoramonfarias@gmail.com', 'd9b1d7db4cd6e70935368a1efb10e377', 'PADRÃO', '');

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
(3, 5, '43a1433c1d1f87ec3209855faae0bd3d', 0),
(4, 1, '905b75acc8e53a18006dbe417486eede', 0);

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
  ADD KEY `historico_ibfk_1` (`id_usuario`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_produtos_ibfk_1` (`id_pedido`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `historico`
--
ALTER TABLE `historico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT de tabela `historico_senha`
--
ALTER TABLE `historico_senha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de tabela `pedido_produtos`
--
ALTER TABLE `pedido_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=286;

--
-- AUTO_INCREMENT de tabela `situacao`
--
ALTER TABLE `situacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de tabela `usuarios_token`
--
ALTER TABLE `usuarios_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `historico`
--
ALTER TABLE `historico`
  ADD CONSTRAINT `historico_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

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
