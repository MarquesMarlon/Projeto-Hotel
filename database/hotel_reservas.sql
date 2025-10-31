-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 31/10/2025 às 02:31
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `hotel_reservas`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `quartos`
--

CREATE TABLE `quartos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `descricao` text DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `quartos`
--

INSERT INTO `quartos` (`id`, `nome`, `numero`, `tipo`, `preco`, `descricao`, `ativo`, `created_at`) VALUES
(20, 'Casal 01', '12', 'Standard', 350.00, '', 1, '2025-10-26 20:19:42'),
(21, 'Solteiro 01', '13', 'Luxo', 350.00, '', 1, '2025-10-26 20:27:33'),
(23, 'Patrão', '20', 'Standard', 900.00, '', 0, '2025-10-26 23:56:19'),
(24, 'Casal 02', '06', 'Luxo', 299.00, '', 1, '2025-10-31 00:11:58');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `quarto_id` int(11) NOT NULL,
  `nome_cliente` varchar(100) NOT NULL,
  `adultos` int(2) NOT NULL,
  `criancas` int(2) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `cpf` varchar(15) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `data_checkin` date DEFAULT NULL,
  `data_checkout` date DEFAULT NULL,
  `status` enum('confirmada','cancelada') DEFAULT 'confirmada',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `reservas`
--

INSERT INTO `reservas` (`id`, `quarto_id`, `nome_cliente`, `adultos`, `criancas`, `email`, `cpf`, `telefone`, `data_checkin`, `data_checkout`, `status`, `created_at`) VALUES
(21, 20, 'Jafe Marlon Souza Marques', 1, 1, 'jafe@marlon.com.br', '10280179952', '45998424684', '2025-10-30', '2025-10-31', 'confirmada', '2025-10-29 05:03:22'),
(25, 21, 'Jafe Marlon Souza Marques', 1, 1, 'marlonmarques6989@gmail.com', '10280179952', '45998424684', '2025-10-30', '2025-11-01', 'confirmada', '2025-10-29 07:16:46');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `data_cadastro`) VALUES
(2, 'leonardo.doose', 'leonardo@essentia.com.br', '$2y$10$H6CLQhq8M2AgEOe0qz6DB.fmCWPNnzyjSvjA2UNTW7tAetw4i.XbW', '2025-10-30 10:41:53'),
(5, 'jafe.marlon', 'jafe.marlon@essentia.com.br', '$2y$10$eSwZlXNOFupX7q2EgfcXp.U8lQ0zhtyNl5lJ9i77/pRnjKkiz5Ksi', '2025-10-30 22:56:11');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `quartos`
--
ALTER TABLE `quartos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Rel Quartos/Reserva` (`quarto_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `quartos`
--
ALTER TABLE `quartos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
