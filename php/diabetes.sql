-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24-Nov-2024 às 01:17
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.1.12

SET SQL_MODE
= "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone
= "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `diabetes`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `controle_dt`
--

CREATE TABLE `controle_dt`
(
  `ID_DT` int
(3) NOT NULL,
  `GLICOSE` float DEFAULT NULL,
  `GORD_FIG` float NOT NULL,
  `CPA` float NOT NULL,
  `RED_PESO` float NOT NULL,
  `paciente_ID_PC` varchar
(45) NOT NULL,
  `Date` datetime DEFAULT current_timestamp
()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Extraindo dados da tabela `controle_dt`


INSERT INTO `controle_dt` (`
ID_DT`,
`GLICOSE
`, `GORD_FIG`, `CPA`, `RED_PESO`, `paciente_ID_PC`, `Date`) VALUES
(9, NULL, 0, 0, 0, '', '2024-10-19 23:11:39'),
(13, 250, 0, 0, 0, '5', '2024-10-23 12:09:59');


-- Estrutura da tabela `medicamento`

CREATE TABLE `medicamento`
(
  `ID_MED` int
(3) NOT NULL,
  `medicamento` varchar
(45) NOT NULL,
  `dose_med` float NOT NULL,
  `tipo` varchar
(20) DEFAULT NULL,
  `paciente_ID_PC` int
(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Extraindo dados da tabela `medicamento`

INSERT INTO `medicamento` (`
ID_MED`,
`medicamento
`, `dose_med`, `tipo`, `paciente_ID_PC`) VALUES
(12, 'insulina', 10, NULL, 5),
(14, 'metaformina', 850, NULL, 5),
(15, 'glicasida', 30, NULL, 5),
(16, 'forgiga', 0, NULL, 5),
(17, 'losartana', 50, NULL, 5),
(18, 'propanalol', 40, NULL, 5),
(19, 'hidroclorodiazida', 25, NULL, 5),
(20, 'sinvastatina', 20, NULL, 5);

-- Estrutura da tabela `paciente`

CREATE TABLE `paciente`
(
  `ID_PC` int
(11) NOT NULL,
  `NOME_PC` varchar
(50) NOT NULL,
  `IDADE` int
(3) NOT NULL,
  `PESO` float NOT NULL,
  `ALTURA` float NOT NULL,
  `SEXO` varchar
(14) DEFAULT NULL,
  `NATF` int
(4) NOT NULL,
  `controle_dt_ID_DT` int
(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Extraindo dados da tabela `paciente`

INSERT INTO `paciente` (`
ID_PC`,
`NOME_PC
`, `IDADE`, `PESO`, `ALTURA`, `SEXO`, `NATF`, `controle_dt_ID_DT`) VALUES
(5, 'toninha', 51, 96, 170, 'feminino', 0, 9);

--
-- Índices para tabelas despejadas
--
CREATE TABLE glicemia (
  ID_GLIC INT AUTO_INCREMENT PRIMARY KEY,
  paciente_ID_PC INT NOT NULL,
  GLICEMIA DECIMAL(6,2) NOT NULL,
  DATA DATE NOT NULL,
  HORA TIME NOT NULL,
  FOREIGN KEY (paciente_ID_PC) REFERENCES paciente(ID_PC)
);

  --
  -- Índices para tabela `controle_dt`
  --
  ALTER TABLE `controle_dt`
  ADD PRIMARY KEY
  (`ID_DT`);

  -- Índices para tabela `medicamento`

  ALTER TABLE `medicamento`
  ADD PRIMARY KEY
  (`ID_MED`),
  ADD KEY `fk_medicamento_paciente1_idx`
  (`paciente_ID_PC`);

  ALTER TABLE `medicamento`
  MODIFY `ID_MED` int
  (3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

  ALTER TABLE `medicamento`
  ADD CONSTRAINT `fk_medicamento_paciente` FOREIGN KEY
  (`paciente_ID_PC`) REFERENCES `paciente`
  (`ID_PC`) ON
  DELETE CASCADE ON
  UPDATE CASCADE;
  COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


  -- Índices para tabela `paciente`

  ALTER TABLE `paciente`
  ADD PRIMARY KEY
  (`ID_PC`),
  ADD KEY `fk_paciente_controle_dt_idx`
  (`controle_dt_ID_DT`);

  --
  -- AUTO_INCREMENT de tabelas despejadas
  --

  --
  -- AUTO_INCREMENT de tabela `controle_dt`
  ALTER TABLE `controle_dt`
  MODIFY `ID_DT` int
  (3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;


  -- AUTO_INCREMENT de tabela `medicamento`
  ALTER TABLE `medicamento`
  MODIFY `ID_MED` int
  (3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;


  -- AUTO_INCREMENT de tabela `paciente`
  ALTER TABLE `paciente`
  MODIFY `ID_PC` int
  (11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

  --
  -- Restrições para despejos de tabelas
  --

  --
  -- Limitadores para a tabela `medicamento`
  ALTER TABLE `medicamento`
  ADD CONSTRAINT `fk_medicamento_paciente1` FOREIGN KEY
  (`paciente_ID_PC`) REFERENCES `paciente`
  (`ID_PC`) ON
  DELETE NO ACTION ON
  UPDATE NO ACTION;


  -- Limitadores para a tabela `paciente`
  ALTER TABLE `paciente`
  ADD CONSTRAINT `fk_paciente_controle_dt` FOREIGN KEY
  (`controle_dt_ID_DT`) REFERENCES `controle_dt`
  (`ID_DT`) ON
  DELETE NO ACTION ON
  UPDATE NO ACTION;
  COMMIT;




