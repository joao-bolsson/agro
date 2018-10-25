SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `colheita` (
  `id_safra` int(10) UNSIGNED NOT NULL,
  `mao_de_obra` float NOT NULL,
  `maquinario` float NOT NULL,
  `transporte` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `defensivo` (
  `id_manutencao` int(10) UNSIGNED NOT NULL,
  `id_prod` int(10) UNSIGNED NOT NULL,
  `aplicacoes` tinyint(3) UNSIGNED NOT NULL,
  `valor` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `estoque` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `id_tipo` tinyint(3) UNSIGNED NOT NULL,
  `cod` varchar(10) NOT NULL,
  `descricao` varchar(80) NOT NULL,
  `unidade` varchar(5) DEFAULT NULL,
  `qtd` int(10) UNSIGNED NOT NULL,
  `vl_unitario` float NOT NULL,
  `vl_total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `implantacao` (
  `id_safra` int(10) UNSIGNED NOT NULL,
  `mao_de_obra` float NOT NULL,
  `maquinario` float NOT NULL,
  `adubacao` float NOT NULL,
  `semeadura` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `manutencao` (
  `id_safra` int(10) UNSIGNED NOT NULL,
  `mao_de_obra` float NOT NULL,
  `maquinario` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `safras` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `inicio` date NOT NULL,
  `fim` date DEFAULT NULL,
  `producao` int(10) UNSIGNED DEFAULT NULL,
  `saldo` int(10) UNSIGNED DEFAULT NULL,
  `total_venda` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tipo_prod` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `nome_tipo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `usuario` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `senha` varchar(34) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `usuario_permissoes` (
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `produtor` tinyint(1) NOT NULL,
  `agronomo` tinyint(1) NOT NULL,
  `cooperativa` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `colheita`
  ADD KEY `id_safra` (`id_safra`);

ALTER TABLE `defensivo`
  ADD PRIMARY KEY (`id_manutencao`,`id_prod`),
  ADD KEY `id_prod` (`id_prod`);

ALTER TABLE `estoque`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_tipo` (`id_tipo`);

ALTER TABLE `implantacao`
  ADD PRIMARY KEY (`id_safra`);

ALTER TABLE `manutencao`
  ADD PRIMARY KEY (`id_safra`);

ALTER TABLE `safras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

ALTER TABLE `tipo_prod`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `usuario_permissoes`
  ADD PRIMARY KEY (`id_usuario`);


ALTER TABLE `estoque`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `safras`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `usuario`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `colheita`
  ADD CONSTRAINT `colheita_ibfk_1` FOREIGN KEY (`id_safra`) REFERENCES `safras` (`id`);

ALTER TABLE `defensivo`
  ADD CONSTRAINT `defensivo_ibfk_1` FOREIGN KEY (`id_manutencao`) REFERENCES `manutencao` (`id_safra`),
  ADD CONSTRAINT `defensivo_ibfk_2` FOREIGN KEY (`id_prod`) REFERENCES `estoque` (`id`);

ALTER TABLE `estoque`
  ADD CONSTRAINT `estoque_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `estoque_ibfk_2` FOREIGN KEY (`id_tipo`) REFERENCES `tipo_prod` (`id`);

ALTER TABLE `implantacao`
  ADD CONSTRAINT `implantacao_ibfk_1` FOREIGN KEY (`id_safra`) REFERENCES `safras` (`id`);

ALTER TABLE `manutencao`
  ADD CONSTRAINT `manutencao_ibfk_1` FOREIGN KEY (`id_safra`) REFERENCES `safras` (`id`);

ALTER TABLE `safras`
  ADD CONSTRAINT `safras_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

ALTER TABLE `usuario_permissoes`
  ADD CONSTRAINT `usuario_permissoes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
