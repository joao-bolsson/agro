SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


INSERT INTO `cultura` (`id`, `id_tipo`, `nome`) VALUES
(1, 1, 'Soja'),
(2, 1, 'Trigo'),
(3, 2, 'Pessego');

INSERT INTO `tipo_cultura` (`id`, `nome`) VALUES
(1, 'Graos'),
(2, 'Hortifruti');

INSERT INTO `tipo_prod` (`id`, `nome_tipo`) VALUES
(1, 'Herbicida'),
(2, 'Fungicida'),
(3, 'Inseticida');

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`) VALUES
(1, 'JoÃ£o', 'joaovictorbolsson@gmail.com', '$1$j:[]bols$MXCmGwMWlocdbU1iET18W0');

INSERT INTO `usuario_permissoes` (`id_usuario`, `produtor`, `agronomo`, `cooperativa`) VALUES
(1, 1, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
