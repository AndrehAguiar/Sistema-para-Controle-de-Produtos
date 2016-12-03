-- phpMyAdmin SQL Dump
-- version 2.10.1
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tempo de Geração: Dez 02, 2016 as 11:49 PM
-- Versão do Servidor: 5.0.41
-- Versão do PHP: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Banco de Dados: `controller_products`
-- 

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `categoria`
-- 
-- Criação: Nov 29, 2016 as 09:18 AM
-- 

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL auto_increment,
  `descricao` varchar(45) NOT NULL,
  `data_cadastro` varchar(45) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `descricao` (`descricao`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 PACK_KEYS=0 AUTO_INCREMENT=13 ;

-- 
-- Extraindo dados da tabela `categoria`
-- 

INSERT DELAYED IGNORE INTO `categoria` (`id`, `descricao`, `data_cadastro`, `usuario_id`) VALUES 
(1, 'Papelaria', '2016/12/01', 2),
(2, 'Informatica', '2016/12/01', 2),
(3, 'Escritorio', '2016/12/01', 2),
(4, 'Produtos de Limpeza', '2016/12/01', 2),
(6, 'Estoque', '2016/12/02', 2),
(7, 'Vestuario', '2016/12/02', 2),
(8, 'Alimentacao', '2016/12/02', 2),
(9, 'Esporte', '2016/12/02', 2),
(10, 'Automotivo', '2016/12/02', 2),
(11, 'Logistica', '2016/12/02', 2),
(12, 'Recreacao', '2016/12/02', 2);

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `produto`
-- 
-- Criação: Nov 29, 2016 as 09:15 AM
-- 

DROP TABLE IF EXISTS `produto`;
CREATE TABLE IF NOT EXISTS `produto` (
  `id` int(11) NOT NULL auto_increment,
  `descricao` varchar(45) NOT NULL,
  `quantidade` varchar(45) NOT NULL,
  `valorproduto` varchar(45) default NULL,
  `usuario_id` int(11) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `categoria_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`,`categoria_id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `categoria_id` (`categoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 PACK_KEYS=0 AUTO_INCREMENT=31 ;

-- 
-- Extraindo dados da tabela `produto`
-- 

INSERT DELAYED IGNORE INTO `produto` (`id`, `descricao`, `quantidade`, `valorproduto`, `usuario_id`, `data_cadastro`, `categoria_id`) VALUES 
(1, 'Caneta BIC Preta', '150', '1,50', 1, '2016-12-01 18:46:40', 1),
(6, 'Cadeira com braÃ§os', '20', '120,90', 1, '2016-12-02 10:53:09', 3),
(7, 'Arquivo', '101', '300,75', 1, '2016-12-02 10:44:25', 4),
(12, 'Impressoras', '25', '350,00', 2, '2016-12-02 11:34:56', 2),
(13, 'Computadores', '15', '2500,90', 2, '2016-12-02 11:35:27', 2),
(14, 'Detergente', '25', '153,23', 2, '2016-12-02 13:56:32', 4),
(15, 'Sabonete', '100', '35,30', 2, '2016-12-02 13:57:29', 4),
(16, 'Uniforme', '150', '35,35', 2, '2016-12-02 13:57:55', 12),
(17, 'Jogos Computadores', '35', '150,68', 2, '2016-12-02 13:58:56', 12),
(18, 'Mouse computador', '90', '560,35', 2, '2016-12-02 13:59:36', 2),
(19, 'CD/RW 4,7GB', '800', '500,00', 2, '2016-12-02 14:00:14', 6),
(20, 'Camisas', '50000', '10.000,00', 2, '2016-12-02 14:00:58', 7),
(21, 'Calsas', '50000', '300.000,00', 2, '2016-12-02 14:01:30', 7),
(22, 'Biscoitos', '60', '230,50', 2, '2016-12-02 14:02:09', 8),
(23, 'Chamex A4', '300', '60.000,00', 2, '2016-12-02 14:02:27', 1),
(24, 'Sabao em Po', '60', '300,00', 2, '2016-12-02 14:03:22', 4),
(25, 'Caixas', '900000', '3.000,00', 2, '2016-12-02 14:03:56', 11),
(26, 'Rodas 17''''', '80', '50.000,00', 2, '2016-12-02 14:04:24', 10),
(27, 'Estofado', '50', '3.500,00', 2, '2016-12-02 14:04:53', 10),
(28, 'Bicicletas', '10', '60.000,00', 2, '2016-12-02 14:05:14', 9),
(29, 'Cadernos', '50', '300,00', 2, '2016-12-02 14:06:09', 1),
(30, 'Mesas para escritorio', '50', '600,00', 1, '2016-12-02 14:08:04', 3);

-- --------------------------------------------------------

-- 
-- Estrutura da tabela `usuario`
-- 
-- Criação: Nov 29, 2016 as 09:10 AM
-- 

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL auto_increment,
  `login` varchar(45) NOT NULL default '',
  `pass` varchar(45) NOT NULL default '',
  `firstname` varchar(45) NOT NULL default '',
  `lastname` varchar(45) default NULL,
  `data_cadastro` varchar(45) NOT NULL,
  `status` int(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 PACK_KEYS=0 AUTO_INCREMENT=8 ;

-- 
-- Extraindo dados da tabela `usuario`
-- 

INSERT DELAYED IGNORE INTO `usuario` (`id`, `login`, `pass`, `firstname`, `lastname`, `data_cadastro`, `status`) VALUES 
(1, 'Admin', 'e10adc3949ba59abbe56e057f20f883e', 'Administrador', 'Master', '2016/11/30', 0),
(2, 'Tester', 'e10adc3949ba59abbe56e057f20f883e', 'Administrador', 'Tester', '2016/12/01', 0),
(7, 'Master', 'e10adc3949ba59abbe56e057f20f883e', 'WebMaster', 'Developer', '2016/12/02', 0);

-- 
-- Restrições para as tabelas dumpadas
-- 

-- 
-- Restrições para a tabela `categoria`
-- 
ALTER TABLE `categoria`
  ADD CONSTRAINT `categoria_fk1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

-- 
-- Restrições para a tabela `produto`
-- 
ALTER TABLE `produto`
  ADD CONSTRAINT `produto_fk1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `produto_fk2` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`);
