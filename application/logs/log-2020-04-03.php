<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-04-03 01:48:35 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`eadtoolsv2`.`mycourse`, CONSTRAINT `fk_mycourse_mycategory1` FOREIGN KEY (`mycategory_id`) REFERENCES `mycategory` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION) - Invalid query: UPDATE `mycourse` SET `title` = 'Curso de teste', `description` = 'Testando curso', `photo` = '', `price` = ' 0,00 ', `release_date` = NULL, `expiration_date` = NULL, `spotlight` = NULL, `validity` = NULL, `preview` = '', `comments` = NULL, `mycategory_id` = NULL, `certificate_id` = 1
WHERE `id` = '6'
ERROR - 2020-04-03 01:49:06 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-04-03 01:49:06 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-04-03 01:49:06 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-04-03 01:59:06 --> Severity: Notice --> Undefined property: User::$ddb C:\xampp\htdocs\system\core\Model.php 73
ERROR - 2020-04-03 01:59:06 --> Severity: error --> Exception: Call to a member function join() on null C:\xampp\htdocs\application\models\User_Model.php 109
ERROR - 2020-04-03 01:59:34 --> Severity: Notice --> Undefined property: User::$ddb C:\xampp\htdocs\system\core\Model.php 73
ERROR - 2020-04-03 01:59:34 --> Severity: error --> Exception: Call to a member function join() on null C:\xampp\htdocs\application\models\User_Model.php 109
ERROR - 2020-04-03 01:59:35 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-04-03 01:59:51 --> Query error: Column 'id' in where clause is ambiguous - Invalid query: SELECT `T0`.`id`, `T0`.`name`, `T0`.`email`, `T1`.`id` as `role`
FROM `myuser` `T0`
JOIN `myrole` `T1` ON `T0`.`myrole_id` = `T1`.`id`
WHERE `excluded` IS NULL
AND `id` != 1
ERROR - 2020-04-03 01:59:51 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\User_Model.php 113
ERROR - 2020-04-03 02:01:24 --> Query error: Column 'id' in where clause is ambiguous - Invalid query: SELECT `T0`.`id`, `T0`.`name`, `T0`.`email`, `T1`.`name` as `role`
FROM `myuser` `T0`
JOIN `myrole` `T1` ON `T0`.`myrole_id` = `T1`.`id`
WHERE `excluded` IS NULL
AND `id` != 1
ERROR - 2020-04-03 02:01:24 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\User_Model.php 113
ERROR - 2020-04-03 03:06:46 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Course_Model.php 89
ERROR - 2020-04-03 03:06:46 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')' at line 5 - Invalid query: SELECT *
FROM `lesson_status`
WHERE `myuser_id` = 1
AND `status` = 'finished'
AND `mylesson_id` IN()
ERROR - 2020-04-03 03:06:46 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Course_Model.php 98
ERROR - 2020-04-03 03:29:24 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 50
ERROR - 2020-04-03 03:29:44 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:29:44 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:29:46 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`eadtoolsv2`.`lesson_status`, CONSTRAINT `fk_lesson_status_mycourse1` FOREIGN KEY (`mycourse_id`) REFERENCES `mycourse` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION) - Invalid query: INSERT INTO `lesson_status` (`myuser_id`, `mylesson_id`) VALUES ('1', '2')
ERROR - 2020-04-03 03:32:36 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:32:36 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:32:44 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 50
ERROR - 2020-04-03 03:32:55 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:32:55 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:33:16 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:33:16 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:33:18 --> Query error: Duplicate entry '2' for key 'PRIMARY' - Invalid query: INSERT INTO `lesson_status` (`myuser_id`, `mylesson_id`, `mycourse_id`) VALUES ('1', '4', '2')
ERROR - 2020-04-03 03:33:44 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:33:44 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:33:46 --> Query error: Duplicate entry '2' for key 'PRIMARY' - Invalid query: INSERT INTO `lesson_status` (`myuser_id`, `mylesson_id`, `mycourse_id`) VALUES ('1', '5', '2')
ERROR - 2020-04-03 03:35:43 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:35:43 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:35:49 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 50
ERROR - 2020-04-03 03:35:58 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:35:58 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:36:30 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:36:30 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:36:32 --> Query error: Duplicate entry '1' for key 'PRIMARY' - Invalid query: INSERT INTO `lesson_status` (`myuser_id`, `mylesson_id`, `mycourse_id`) VALUES ('1', '3', '1')
ERROR - 2020-04-03 03:36:52 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:36:52 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:36:54 --> Query error: Duplicate entry '1' for key 'PRIMARY' - Invalid query: INSERT INTO `lesson_status` (`myuser_id`, `mylesson_id`, `mycourse_id`) VALUES ('1', '4', '1')
ERROR - 2020-04-03 03:37:59 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:37:59 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:38:01 --> Query error: Duplicate entry '1' for key 'PRIMARY' - Invalid query: INSERT INTO `lesson_status` (`myuser_id`, `mylesson_id`, `mycourse_id`) VALUES ('1', '5', '1')
ERROR - 2020-04-03 03:39:18 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:39:18 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:39:27 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 50
ERROR - 2020-04-03 03:39:34 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:39:34 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:39:42 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:39:42 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:40:20 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:40:20 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:40:29 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:40:29 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:40:34 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`eadtoolsv2`.`mycourse`, CONSTRAINT `fk_mycourse_mycategory1` FOREIGN KEY (`mycategory_id`) REFERENCES `mycategory` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION) - Invalid query: UPDATE `mycourse` SET `title` = 'Javascript', `description` = '', `photo` = '20200403033919mwWdDot0SnKI9G9T.jpg', `price` = NULL, `release_date` = NULL, `expiration_date` = NULL, `spotlight` = NULL, `validity` = NULL, `preview` = '', `comments` = NULL, `mycategory_id` = NULL, `certificate_id` = 1
WHERE `id` = '1'
ERROR - 2020-04-03 03:56:55 --> 404 Page Not Found: Assets/uploads
ERROR - 2020-04-03 03:58:45 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:58:45 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:58:52 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 50
ERROR - 2020-04-03 03:58:59 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:58:59 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:59:09 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:59:09 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-03 03:59:15 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`eadtoolsv2`.`mycourse`, CONSTRAINT `fk_mycourse_mycategory1` FOREIGN KEY (`mycategory_id`) REFERENCES `mycategory` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION) - Invalid query: UPDATE `mycourse` SET `title` = 'SAP', `description` = 'Testando&nbsp;', `photo` = '20200403035845zP6LolOyDwWOgiHjQ6.jpg', `price` = NULL, `release_date` = NULL, `expiration_date` = NULL, `spotlight` = NULL, `validity` = NULL, `preview` = '', `comments` = NULL, `mycategory_id` = NULL, `certificate_id` = 1
WHERE `id` = '2'
ERROR - 2020-04-03 04:17:41 --> 404 Page Not Found: Settings/get
ERROR - 2020-04-03 07:26:32 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 50
ERROR - 2020-04-03 07:26:34 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`eadtoolsv2`.`mycourse`, CONSTRAINT `fk_mycourse_mycategory1` FOREIGN KEY (`mycategory_id`) REFERENCES `mycategory` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION) - Invalid query: UPDATE `mycourse` SET `title` = 'SAP', `description` = 'Testando&nbsp;', `photo` = '20200403035845zP6LolOyDwWOgiHjQ6.jpg', `price` = NULL, `release_date` = NULL, `expiration_date` = NULL, `spotlight` = NULL, `validity` = NULL, `preview` = '', `comments` = NULL, `mycategory_id` = NULL, `certificate_id` = 1
WHERE `id` = '2'
ERROR - 2020-04-03 07:26:38 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`eadtoolsv2`.`mycourse`, CONSTRAINT `fk_mycourse_mycategory1` FOREIGN KEY (`mycategory_id`) REFERENCES `mycategory` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION) - Invalid query: UPDATE `mycourse` SET `title` = 'SAP', `description` = 'Testando&nbsp;', `photo` = '20200403035845zP6LolOyDwWOgiHjQ6.jpg', `price` = NULL, `release_date` = NULL, `expiration_date` = NULL, `spotlight` = NULL, `validity` = NULL, `preview` = '', `comments` = NULL, `mycategory_id` = NULL, `certificate_id` = 1
WHERE `id` = '2'
ERROR - 2020-04-03 19:35:22 --> 404 Page Not Found: Group/getCourses
ERROR - 2020-04-03 20:35:20 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-04-03 20:35:20 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-04-03 20:35:20 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-04-03 20:46:15 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-04-03 20:46:15 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-04-03 20:46:15 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-04-03 21:06:45 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 50
ERROR - 2020-04-03 21:06:47 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`eadtoolsv2`.`mycourse`, CONSTRAINT `fk_mycourse_mycategory1` FOREIGN KEY (`mycategory_id`) REFERENCES `mycategory` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION) - Invalid query: UPDATE `mycourse` SET `title` = 'SAP', `description` = 'Testando&nbsp;', `photo` = '20200403035845zP6LolOyDwWOgiHjQ6.jpg', `price` = NULL, `release_date` = NULL, `expiration_date` = NULL, `spotlight` = NULL, `validity` = NULL, `preview` = '', `comments` = NULL, `mycategory_id` = NULL, `certificate_id` = 1
WHERE `id` = '2'
