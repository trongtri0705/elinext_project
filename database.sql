-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 15 Décembre 2015 à 12:27
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `staff_manager`
--

-- --------------------------------------------------------

--
-- Structure de la table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT '1',
  `level_id` smallint(6) NOT NULL,
  `department_id` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=38 ;

--
-- Contenu de la table `staff`
--

INSERT INTO `staff` (`id`, `email`, `password`, `remember_token`, `name`, `phone`, `birthday`, `role_id`, `level_id`, `department_id`, `active`) VALUES
(1, 'trongtri0705@gmail.com', '$2y$10$2Lv1pPVRlf2xQZamIzdwx.E9kwiSLlIUIKyDblvTLF8k1a/HrX9rW', 'ccXkprwERSbPQmzuIFwaR8WdEWX2m4yGsoNMTkg2GLwnY0rVcMcHtnF6BZJd', 'Nguyễn Trọng Tri', '01672193808', '1994-05-07', 4, 0, 0, 1),
(2, 'tn070594@gmail.com', '$2y$10$GwF4fIjcRMGD35FwDDo5aO8mwztpQOj18pfCYEGYAW0nkrf.pGS6y', 'T0sZgGpDBmLhwCE0vBsspyXDTjUgpK9E65N4IeLgUkOs0hejPAzhQzK8RTU2', 'Christ Nguyen', '01672193808', '1994-05-06', 3, 11, 2, 1),
(3, 'n.trongtri.00@gmail.com', '$2y$10$ZJ55DSPrw69T8LzKIALlXeCHCWeWCaF5RVk4vFPit0d2TB8P5Nnrq', 'pwfyJ9JJfLMCaHe6sg3YH7Nr2PLNeULYWorr91xoPPGbN5meHPf8pSUH9qka', 'Steven Nguyen', '1234556778', '1994-05-07', 3, 12, 2, 1),
(4, 'trongtri073@yahoo.com', '$2y$10$JzL9wGPw7FnbN/MsDwSEY.mcj2logn/9fRBj3pCYWEmwbIKSmtJwK', 'GViM3ME2eWGmIAk7kW24KdBXKgmu2p283yzdBwSS0fLStbxBQyAkk5YYrRZ7', 'Kelvin Nguyen', '4354656456', '1996-11-19', 2, 10, 3, 1),
(5, 'email@email.com', '$2y$10$O5spNHMkpHLxEwPXVMj/TuvzjKc/Zs9GB8lTSD5yp/RMJrcUxtmuK', 'JUidHh4UUADR6cPrOKls8Y6fObVa7TWQpk4GQiyPShcOuED6HoyE3qoq2ZpX', 'Name 1', '1234567890', '1996-11-13', 1, 9, 1, 1),
(6, 'demo@demo.com', '$2y$10$4ui3RgOB8ayE.n/PoYzZk.px2f5G9w2rgtmGV5d/d1R3cBx7nem.i', 'ywYUH4ejbr2XVIuWrYN6ndDrgvEWlCbK90VC1vLXk3dPzN6Zq5MDC6GAzbN3', 'Demo', '0123456789', '1996-11-12', 1, 0, 3, 1),
(7, 'test@test.com', '$2y$10$lcNn2Owcl4NWoghAG2I8S.oBnMgAhEnUGqZQ1RIVT8o6.tO3tetWC', 'pSNJ5OZ13iuAyiBFem0GT5oREeumpFSKBO9KIyJUpLUmMguU4tEYyVZ8gbIu', 'Test', '', '1996-11-12', 1, 9, 5, 1),
(8, 'trongtri073@gmail.com', '$2y$10$Xco4diy6brgdiblTMsK8w.g3KKR6oYUF.yFV8eyRVzX1l4BbiyQLK', 'eN5sDYU8MqmbwBkAHD1UTmkXg36jCoWRn0xNvHhzCDmMAXhhN8rsvE3DFEN4', 'Eric Nguyen', '0987654321', '1994-12-19', 1, 8, 0, 1),
(9, 'newuser@gmail.com', '$2y$10$xJbFUAqnboz4/5KLH0hV9uKVc8w/X3hyGIS9OzMQOuiwnznxTxgum', 'kQCYfbGsHMOElOzedMrgqMYPTEdJnOevmccx5cXIzE4XreFY11Y2bEshGjN8', 'New User', '1234567890', '1995-12-06', 1, 9, 1, 1),
(10, 'NewDemo@demo.com', '$2y$10$iAtFHICfobFbv3pBDe55IuEO4KHUNgixAyS6EAgr9/PqivwAE5/ru', 'yjpzyML5DiKIo4AZdKtjHkcKRv4D7C9MQVk94E5t1Y8X9OWNrIpUtsM0OfdB', 'New Demo', '34645756454', '1995-12-12', 2, 10, 4, 1),
(12, 'abcd@gmail.com', '$2y$10$IZk0XbFNQz4QRjFM3LEUTeO8/TMLFpZuI89mWPhOHRHPwShOSbHka', 'af0TwAfziIyhZjyxSAcouMTj0uYhfjMynuoxeaDSZykvDg1Udx8wfpb9U89l', 'ABCD', '54657645534', '1994-12-19', 2, 10, 4, 1),
(13, 'ng.trongtri.0@gmail.com', '$2y$10$TCDa7mqjRTmSTEo8UPmLaukgI0LWyIcrg1fs3venomwkx7YfeK7nG', '', 'Truong Nam Thanh', '3454654656', '1997-12-22', 1, 8, 1, 1),
(14, 'ng.trgtri.00@gmail.com', '$2y$10$OQv0nxJYLqXmCvXAtajCHOtwHDKEdOTPLGNjS.X7g3kcgK4XNuNx6', '', 'Ho Vinh Khoa', '43546546576', '1990-12-12', 1, 8, 1, 1),
(16, 'ng.trongtri.00@gmail.com', '$2y$10$9k1rDEM21Cs2w38SfzUSLOa.3lpazuKp5VsK7gNRqBo4wNCUjjRwy', '', 'Tran Thanh', '43546546576', '1990-12-12', 1, 8, 1, 1),
(17, 'trongtri0705@mail.com', '$2y$10$6xVSJQHc7zcVYgMtYQ4AkuoFnHy5J1ymEYGSfFPy6s70yKJyREbW2', '8rRDMbSBowdnQaX1oM8t5SJLn6BP44y8xkvhlaDXPlMN5OgxlVuCNIjvmI1m', 'Nguyen Van A', '4546456563', '1997-12-16', 2, 4, 2, 1),
(25, 'sdfsdhfjsdf@dsfds.com', '$2y$10$VFOD2/gx58ZlY4nlObAFWe.PNX.MJNhNbgsZC6RxktrSSZYhUSKUS', 'g6KvJ3Q3A3WZzJt0G0xv1UNHvdPDBujMSndQPlyx1m8AKNbPSAvhHDZ7qplE', 'Phan Dai Hai', '', '1997-12-08', 1, 8, 3, 1),
(26, 'mnbvcxz@gmail.com', '$2y$10$qJyf0yE.95iJN3D.PVQYjeBXDdz8tu750IhVRUcCU7gkRi.Zi4B0e', 'TEzUHQpTlnVNYjKziiOvfzSAOqYUIfBFvVQqHZq2T5gwXDR2CjjtkCInqHKk', 'Le Hong Phong', '', '2015-12-15', 2, 3, 10, 1),
(27, 'lkjhgfdsa@gmail.com', '$2y$10$/uMq9JofwVylwFRcX7fM0OAQ.nS8BZh67fzClVC0LUTviijoclMQK', 'BCD5hxZJFvc6gOXSP0uaTEuEYFDIY14T31bXwoazAJipfRlRamFDrAfnlQZH', 'Le Van Can', '', '2015-12-13', 2, 3, 10, 1),
(30, 'sdfds@fsdfsdf.com', '$2y$10$HXkBGb8TEP6a/3XsMbtMYOnTJy64vajZyyrCsxJFLvGWZ7nJLOhMy', 'z4cU5IgGxYkaxHrEp4Scvg3VZITXO6vVKQg0gK2eG2VkkGBosm9sswZaV2Tj', 'Victor Nam', '', '2015-12-06', 1, 8, 10, 1),
(31, 'asdfgh@gmail.com', '$2y$10$ym/VPjp2dJLFHvGEO1.pzuDELuTeV209Qdyj71DugJURE5OHPvjeK', '2dDm7FGDdBxytMUSBUcTLqMN7M7vy2z0vmOsFhZv2at8G0vfH5tqaQL3uo2Y', 'David Vu', '', '2015-12-01', 1, 8, 10, 1),
(32, 'newnew@new.com', '$2y$10$k1IzO4yycddMyy3pphLRvuApY8WHQ6jQwFrf56YK6VeSkHWJj4Zai', '', 'John nguyen', '', '2015-12-06', 2, 3, 3, 1),
(35, 'sdfsdf@fdsf.com', '$2y$10$1y3Bee2WjF0pNZfewVsQZ.hDeDHHsxD4tNPQ3BRMNhh44vz9SrB36', '', 'Ly Hai', '', '2015-12-06', 2, 3, 4, 1),
(36, 'sdfsdf@kjshfsdf.com', '$2y$10$rFsGcqlw9VTdSWWl04t92OXccuafG.2fpKwLB18TbDbzJuR7f0dxa', '', 'Dan Truong', '', '2015-12-02', 2, 3, 1, 1),
(37, 'sdfdshf@fsdfdsf.com', '$2y$10$yqIFkh79VyU14StQ4y1w2uwSlhdwU.xnD.L4L8wg3zbkf4a1RGIau', '', 'Lam Vinh Hai', '', '2015-12-13', 3, 11, 2, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
