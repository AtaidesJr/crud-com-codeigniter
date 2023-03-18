-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02-Fev-2023 às 01:02
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ordem`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupos`
--

CREATE TABLE `grupos` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `descricao` varchar(240) NOT NULL,
  `exibir` tinyint(1) NOT NULL,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `grupos`
--

INSERT INTO `grupos` (`id`, `nome`, `descricao`, `exibir`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'Administrador', 'Grupo com acesso total ao sistema', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(2, '2023-01-10-224833', 'App\\Database\\Migrations\\CriaTabelaUsuarios', 'default', 'App', 1673561390, 1),
(3, '2023-02-01-225303', 'App\\Database\\Migrations\\CriaTabelaGrupos', 'default', 'App', 1675292504, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(5) UNSIGNED NOT NULL,
  `nome` varchar(128) NOT NULL,
  `email` varchar(240) NOT NULL,
  `senha_hash` varchar(240) NOT NULL,
  `reset_hash` varchar(80) DEFAULT NULL,
  `reset_expira_em` datetime DEFAULT NULL,
  `imagem` varchar(240) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL,
  `criado_em` datetime DEFAULT NULL,
  `atualizado_em` datetime DEFAULT NULL,
  `deletado_em` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha_hash`, `reset_hash`, `reset_expira_em`, `imagem`, `ativo`, `criado_em`, `atualizado_em`, `deletado_em`) VALUES
(1, 'Otilia Bradtke', 'heaney.phoebe@mills.com', '123456', NULL, NULL, NULL, 1, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(2, 'Emilie Bosco ', 'swolff@keeling.biz.com.br', '$2y$10$/ymwI.C.8zMxkceddcLq2uvQ2ubYEJMqVq9D34zo52HqrWR2xcFEG', NULL, NULL, NULL, 1, '2023-01-12 16:10:44', '2023-01-22 12:41:19', NULL),
(3, 'Prof. Celia Spinka II', 'boyer.genesis@heaney.com', '123456', NULL, NULL, NULL, 1, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(4, 'Hattie Wunschy Little', 'qleuschke@gmail.com.br', '123456', NULL, NULL, NULL, 1, '2023-01-12 16:10:44', '2023-01-21 16:21:22', NULL),
(5, 'Dr. Mary Quitzon', 'weissnat.winifred@jenkins.com', '123456', NULL, NULL, NULL, 0, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(6, 'Danielle Turcotte', 'danielle.turcotte@gmail.com.br', '123456', NULL, NULL, NULL, 0, '2023-01-12 16:10:44', '2023-01-21 16:30:01', NULL),
(7, 'Rosetta McLaughlin', 'becker.delilah@mills.com', '123456', NULL, NULL, NULL, 1, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(8, 'Gillian Hand Sr.', 'andreanne.leuschke@yahoo.com', '123456', NULL, NULL, NULL, 1, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(9, 'Evans Osinski', 'maggio.kaylee@yahoo.com', '123456', NULL, NULL, NULL, 1, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(10, 'Mayra Breitenberg', 'mayra.smitham@hotmail.com', '123456', NULL, NULL, NULL, 0, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(11, 'Shawna Hackett', 'ktrantow@runte.org', '123456', NULL, NULL, NULL, 0, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(12, 'Dr. Linwood Huels V', 'rosa.ondricka@yahoo.com', '123456', NULL, NULL, NULL, 1, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(13, 'Vergie Goyette', 'leo07@feest.info', '123456', NULL, NULL, NULL, 0, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(14, 'Esmeralda Graham', 'leannon.imogene@schaefer.com', '123456', NULL, NULL, NULL, 0, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(15, 'Corbin Paucek IV', 'ward.nannie@gmail.com', '123456', NULL, NULL, NULL, 1, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(16, 'Prof. Alejandrin Huel', 'hgulgowski@yahoo.com', '123456', NULL, NULL, NULL, 0, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(17, 'Queenie Mohr', 'brekke.roel@kuphal.com', '123456', NULL, NULL, NULL, 0, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(18, 'Shana Farrell', 'eveline10@walker.info', '123456', NULL, NULL, NULL, 1, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(19, 'Dr. Adonis Smith', 'jeffrey04@auer.com', '123456', NULL, NULL, NULL, 1, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(20, 'Tito Pagac', 'strantow@hotmail.com', '123456', NULL, NULL, NULL, 0, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(21, 'Mr. Johan Lesch DVM', 'lind.isabel@gmail.com', '123456', NULL, NULL, NULL, 0, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(22, 'Eleanora Pfannerstill', 'jacobs.dana@dietrich.com', '123456', NULL, NULL, NULL, 0, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(23, 'Judson Hoeger', 'madie45@hotmail.com', '123456', NULL, NULL, NULL, 0, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(24, 'Dr. Stefanie Pacocha Sr.', 'ubaldo31@heaney.com', '123456', NULL, NULL, NULL, 1, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(25, 'Bill Emmerich', 'bruen.mae@gmail.com', '123456', NULL, NULL, NULL, 1, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(26, 'Lola Rodriguez III', 'mcdermott.elinore@gmail.com', '123456', NULL, NULL, NULL, 0, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(27, 'Taylor Price', 'graciela52@predovic.com', '123456', NULL, NULL, NULL, 1, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(28, 'Nayeli Altenwerth III', 'dillan64@hotmail.com', '123456', NULL, NULL, NULL, 0, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(29, 'Mr. Madyson Mayert', 'zboncak.richard@mosciski.com', '123456', NULL, NULL, NULL, 0, '2023-01-12 16:10:44', '2023-01-12 16:10:44', NULL),
(30, 'Dr. Percival Gusikowski', 'haag.jewel@hotmail.com', '123456', NULL, NULL, '1674694661_89c1f1aca165042a4517.jpg', 0, '2023-01-12 16:10:44', '2023-01-31 19:07:16', '2023-01-31 19:07:16'),
(31, 'Ataides Junior Ferreira Da Silva', 'juniorferreira020@gmail.com', '$2y$10$h6u5d46V.TT8s43gLmOezeaOUuULBGbNVT7Cdx7vn5mKHxQIXf/Te', NULL, NULL, '1674774334_e7c04df96a25ea900842.jpg', 1, '2023-01-24 21:45:17', '2023-01-26 20:05:34', NULL),
(32, 'teste', 'teste@gmail.com.br', '$2y$10$4wmNVlZO0BGbCXaUWQGptu1rXM41j0CXDro1doJQZCHu2fwDyhHQ2', NULL, NULL, NULL, 0, '2023-01-24 21:56:19', '2023-01-31 20:22:38', '2023-01-31 20:22:38');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices para tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
