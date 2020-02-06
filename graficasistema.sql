-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 06-Fev-2020 às 02:25
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
(12, 'Ramon De Oliveira Farias', '81 9 9999-9747', '', '', '', '', '', 'Paulista', ''),
(15, 'Juan De Oliveira Farias', '81 9 9999-9747', '', '', '81', '', '', 'Paulista', '');

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
(26, 1, '2019-12-18 13:53:00', '::1', 'Windows 10', 'Firefox'),
(27, 1, '2019-12-18 22:40:00', '::1', 'Windows 10', 'Firefox'),
(28, 1, '2019-12-19 08:31:00', '::1', 'Windows 10', 'Firefox'),
(29, 1, '2019-12-19 08:32:00', '::1', 'Windows 10', 'Firefox'),
(30, 1, '2019-12-19 08:32:00', '::1', 'Windows 10', 'Firefox'),
(31, 4, '2019-12-19 08:32:00', '::1', 'Windows 10', 'Firefox'),
(32, 1, '2019-12-19 08:34:00', '::1', 'Windows 10', 'Firefox'),
(33, 1, '2019-12-19 08:42:00', '::1', 'Windows 10', 'Firefox'),
(34, 1, '2019-12-19 08:46:00', '::1', 'Windows 10', 'Firefox'),
(35, 1, '2019-12-19 10:08:00', '::1', 'Windows 10', 'Firefox'),
(36, 1, '2019-12-19 13:57:00', '::1', 'Windows 10', 'Firefox'),
(37, 1, '2019-12-19 15:39:00', '::1', 'Windows 10', 'Firefox'),
(38, 1, '2019-12-19 18:00:00', '::1', 'Windows 10', 'Firefox'),
(39, 1, '2019-12-19 20:06:00', '::1', 'Windows 10', 'Firefox'),
(40, 1, '2019-12-19 20:30:00', '::1', 'Windows 10', 'Firefox'),
(57, 1, '2019-12-27 21:02:00', '127.0.0.1', 'Windows 10', 'Firefox'),
(58, 1, '2019-12-28 11:04:00', '::1', 'Windows 10', 'Firefox'),
(59, 1, '2019-12-28 11:28:00', '::1', 'Windows 10', 'Firefox'),
(60, 1, '2019-12-28 20:11:00', '::1', 'Windows 10', 'Firefox'),
(61, 1, '2020-01-01 10:25:00', '::1', 'Windows 10', 'Firefox'),
(62, 1, '2020-01-12 11:13:00', '::1', 'Windows 10', 'Firefox'),
(63, 1, '2020-01-20 12:47:00', '::1', 'Windows 10', 'Firefox'),
(64, 1, '2020-01-20 13:10:00', '::1', 'Windows 10', 'Firefox'),
(65, 1, '2020-01-27 00:13:00', '::1', 'Windows 10', 'Firefox'),
(66, 1, '2020-01-28 13:02:00', '::1', 'Windows 10', 'Opera'),
(67, 1, '2020-01-30 00:28:00', '::1', 'Windows 10', 'Opera'),
(68, 1, '2020-02-02 10:29:00', '::1', 'Windows 10', 'Opera'),
(69, 1, '2020-02-02 12:13:00', '::1', 'Windows 10', 'Firefox'),
(70, 1, '2020-02-02 13:13:00', '::1', 'Windows 10', 'Firefox'),
(71, 1, '2020-02-02 19:35:00', '::1', 'Windows 10', 'Firefox'),
(72, 1, '2020-02-02 22:16:00', '::1', 'Windows 10', 'Firefox'),
(73, 1, '2020-02-02 22:37:00', '::1', 'Windows 10', 'Firefox'),
(74, 1, '2020-02-02 22:43:00', '::1', 'Windows 10', 'Firefox'),
(75, 1, '2020-02-03 05:47:00', '::1', 'Windows 10', 'Firefox'),
(76, 1, '2020-02-03 09:27:00', '::1', 'Windows 10', 'Opera'),
(77, 1, '2020-02-03 09:34:00', '::1', 'Windows 10', 'Firefox'),
(78, 1, '2020-02-03 10:28:00', '::1', 'Windows 10', 'Firefox'),
(79, 1, '2020-02-03 10:55:00', '::1', 'Windows 10', 'Firefox'),
(80, 1, '2020-02-03 10:58:00', '::1', 'Windows 10', 'Firefox'),
(81, 1, '2020-02-03 12:02:00', '::1', 'Windows 10', 'Firefox'),
(82, 1, '2020-02-03 12:05:00', '::1', 'Windows 10', 'Firefox'),
(83, 1, '2020-02-03 12:23:00', '::1', 'Windows 10', 'Google Chrome'),
(84, 1, '2020-02-03 12:32:00', '::1', 'Windows 10', 'Firefox'),
(85, 1, '2020-02-03 14:01:00', '::1', 'Windows 10', 'Firefox'),
(86, 1, '2020-02-03 15:25:00', '::1', 'Windows 10', 'Firefox'),
(87, 1, '2020-02-03 16:24:00', '::1', 'Windows 10', 'Firefox'),
(88, 1, '2020-02-04 09:08:00', '::1', 'Windows 10', 'Firefox'),
(89, 1, '2020-02-05 10:36:00', '127.0.0.1', 'Windows 10', 'Firefox'),
(90, 1, '2020-02-05 11:05:00', '::1', 'Windows 10', 'Opera'),
(91, 1, '2020-02-05 12:24:00', '::1', 'Windows 10', 'Firefox'),
(92, 1, '2020-02-05 12:28:00', '::1', 'Windows 10', 'Opera'),
(93, 4, '2020-02-05 21:21:00', '::1', 'Windows 10', 'Firefox'),
(94, 4, '2020-02-05 21:22:00', '::1', 'Windows 10', 'Firefox'),
(95, 1, '2020-02-05 21:27:00', '::1', 'Windows 10', 'Firefox'),
(96, 4, '2020-02-05 21:30:00', '::1', 'Windows 10', 'Firefox'),
(97, 4, '2020-02-05 21:30:00', '::1', 'Windows 10', 'Firefox'),
(98, 4, '2020-02-05 21:33:00', '::1', 'Windows 10', 'Firefox'),
(99, 1, '2020-02-05 21:37:00', '::1', 'Windows 10', 'Firefox'),
(100, 4, '2020-02-05 21:39:00', '::1', 'Windows 10', 'Firefox'),
(101, 1, '2020-02-05 21:44:00', '::1', 'Windows 10', 'Firefox'),
(102, 1, '2020-02-05 22:23:00', '::1', 'Windows 10', 'Firefox');

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
  `valorarte` float(9,2) NOT NULL,
  `valoroutros` float(9,2) NOT NULL,
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

INSERT INTO `pedidos` (`id`, `id_cliente`, `datahora`, `obs`, `valorfrete`, `valorarte`, `valoroutros`, `taxacartao`, `desconto`, `total`, `valorpago`, `faltapagar`, `situacao`) VALUES
(38, 15, '2020-02-05 11:07:00', '', 0.00, 0.00, 0.00, 0.00, 0.00, 146.80, 0.00, 146.80, 27),
(39, 15, '2020-02-05 12:28:00', '', 0.00, 0.00, 0.00, 0.00, 0.00, 6.00, 0.00, 6.00, 28),
(40, 12, '2020-02-05 22:23:00', '', 0.00, 0.00, 0.00, 0.00, 0.00, 105.00, 0.00, 105.00, 27);

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
(73, 39, 'Banner', 'm²', 1.00, 1.00, 1, 6.00),
(96, 38, 'Banner', 'm²', 1.50, 1.52, 10, 6.00),
(97, 38, 'Caneca', 'uni', 1.00, 1.00, 1, 10.00),
(98, 40, 'Caneca', 'uni', 1.00, 1.00, 10, 10.00);

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
(279, 'Banner', 36, 'm²', 6.00),
(280, 'Caneca', 36, 'uni', 10.50);

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
  `ip` varchar(15) NOT NULL
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `historico`
--
ALTER TABLE `historico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT de tabela `historico_senha`
--
ALTER TABLE `historico_senha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de tabela `pedido_produtos`
--
ALTER TABLE `pedido_produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;

--
-- AUTO_INCREMENT de tabela `situacao`
--
ALTER TABLE `situacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
