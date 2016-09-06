-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 30-Ago-2016 às 15:21
-- Versão do servidor: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `entrust`
--

--
-- Extraindo dados da tabela `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrador', 'Administrador do Sistema', '2016-08-29 19:00:11', '2016-08-29 19:00:11'),
(2, 'view-medications', 'Visualizar Medicamentos', 'Visualizar Medicamentos das doenças', '2016-08-29 19:01:17', '2016-08-29 19:02:34'),
(3, 'view-procedures', 'Visualizar Procedimentos', 'Visualizar Procedimentos das doenças', '2016-08-29 19:02:05', '2016-08-29 19:02:05'),
(4, 'show', 'Show all', 'Apenas ambiente principal - visualizar', '2016-08-30 20:02:41', '2016-08-30 20:03:10'),
(5, 'crud', 'Crud all', 'Crud nos cadastros do sistema', '2016-08-30 20:22:58', '2016-08-30 20:23:34');


--
-- Extraindo dados da tabela `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'med', 'Médico', 'Médico relacionado a doenças raras', '2016-08-29 19:20:34', '2016-08-29 19:20:34'),
(2, 'admin', 'Administrador', 'Administrador', '2016-08-30 00:31:45', '2016-08-30 00:31:45'),
(3, 'user', 'Usuário comum', 'Usuário comum do sistema', '2016-08-30 20:03:46', '2016-08-30 20:03:46'),
(4, 'tec', 'Técnico', 'Técnico', '2016-08-30 20:23:24', '2016-08-30 20:23:24');



--
-- Extraindo dados da tabela `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 2),
(2, 1),
(3, 1),
(4, 1),
(4, 3),
(5, 4);



--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', 'admin@admin.com', '$2y$10$VtkpSKHZqf8Crx7ADSaNvuiCP5OA.3Rj6Jxlbyng6wM.WKIU9ik0e', 'oyO0CF7sTrYcVG701ig3hdZ8oU2OWjv9x49oCnZhI9gWTTsygeLqUx67qGMM', '2016-08-29 18:53:39', '2016-08-30 20:39:53');



--
-- Extraindo dados da tabela `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
