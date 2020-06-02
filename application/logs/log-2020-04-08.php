<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-04-08 00:07:35 --> Severity: error --> Exception: Too few arguments to function Course_Model::enrollUserIntoCourse(), 0 passed in C:\xampp\htdocs\application\models\Group_Model.php on line 125 and exactly 2 expected C:\xampp\htdocs\application\models\Course_Model.php 108
ERROR - 2020-04-08 01:05:30 --> Severity: Notice --> Array to string conversion C:\xampp\htdocs\application\models\Course_Model.php 111
ERROR - 2020-04-08 01:05:30 --> Severity: Notice --> Array to string conversion C:\xampp\htdocs\application\models\Course_Model.php 111
ERROR - 2020-04-08 01:32:23 --> Severity: error --> Exception: Too few arguments to function Course_Model::getLessonsListFromCourse(), 0 passed in C:\xampp\htdocs\application\models\Course_Model.php on line 115 and exactly 1 expected C:\xampp\htdocs\application\models\Course_Model.php 97
ERROR - 2020-04-08 01:35:34 --> 404 Page Not Found: Assets/uploads
ERROR - 2020-04-08 01:35:34 --> 404 Page Not Found: Assets/uploads
ERROR - 2020-04-08 01:35:34 --> 404 Page Not Found: Assets/uploads
ERROR - 2020-04-08 01:36:23 --> 404 Page Not Found: Assets/uploads
ERROR - 2020-04-08 01:36:23 --> 404 Page Not Found: Assets/uploads
ERROR - 2020-04-08 01:36:23 --> 404 Page Not Found: Assets/uploads
ERROR - 2020-04-08 01:58:14 --> Query error: Column 'myrole_id' cannot be null - Invalid query: INSERT INTO `relationship` (`myuser_id`, `myrole_id`, `mycourse_id`, `mymodule_id`, `mylesson_id`, `mygroup_id`, `program_id`, `question_id`, `answer_id`) VALUES ('', NULL, 1, 1, 1, '2', 1, 1, 1)
ERROR - 2020-04-08 01:58:14 --> Query error: Column 'myrole_id' cannot be null - Invalid query: INSERT INTO `relationship` (`myuser_id`, `myrole_id`, `mycourse_id`, `mymodule_id`, `mylesson_id`, `mygroup_id`, `program_id`, `question_id`, `answer_id`) VALUES ('', NULL, '3', 1, 1, 1, 1, 1, 1)
ERROR - 2020-04-08 01:58:14 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`eadtoolsv2`.`lesson_status`, CONSTRAINT `fk_lesson_status_myuser1` FOREIGN KEY (`myuser_id`) REFERENCES `myuser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION) - Invalid query: INSERT INTO `lesson_status` (`myuser_id`, `mylesson_id`, `mycourse_id`) VALUES ('', '8', '3')
ERROR - 2020-04-08 01:58:14 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`eadtoolsv2`.`lesson_status`, CONSTRAINT `fk_lesson_status_myuser1` FOREIGN KEY (`myuser_id`) REFERENCES `myuser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION) - Invalid query: INSERT INTO `lesson_status` (`myuser_id`, `mylesson_id`, `mycourse_id`) VALUES ('', '9', '3')
ERROR - 2020-04-08 01:58:14 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`eadtoolsv2`.`lesson_status`, CONSTRAINT `fk_lesson_status_myuser1` FOREIGN KEY (`myuser_id`) REFERENCES `myuser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION) - Invalid query: INSERT INTO `lesson_status` (`myuser_id`, `mylesson_id`, `mycourse_id`) VALUES ('', '10', '3')
ERROR - 2020-04-08 01:58:14 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`eadtoolsv2`.`lesson_status`, CONSTRAINT `fk_lesson_status_myuser1` FOREIGN KEY (`myuser_id`) REFERENCES `myuser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION) - Invalid query: INSERT INTO `lesson_status` (`myuser_id`, `mylesson_id`, `mycourse_id`) VALUES ('', '11', '3')
ERROR - 2020-04-08 01:58:14 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`eadtoolsv2`.`lesson_status`, CONSTRAINT `fk_lesson_status_myuser1` FOREIGN KEY (`myuser_id`) REFERENCES `myuser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION) - Invalid query: INSERT INTO `lesson_status` (`myuser_id`, `mylesson_id`, `mycourse_id`) VALUES ('', '12', '3')
ERROR - 2020-04-08 01:59:09 --> Query error: Column 'myrole_id' cannot be null - Invalid query: INSERT INTO `relationship` (`myuser_id`, `myrole_id`, `mycourse_id`, `mymodule_id`, `mylesson_id`, `mygroup_id`, `program_id`, `question_id`, `answer_id`) VALUES ('', NULL, 1, 1, 1, '2', 1, 1, 1)
ERROR - 2020-04-08 01:59:09 --> Query error: Column 'myrole_id' cannot be null - Invalid query: INSERT INTO `relationship` (`myuser_id`, `myrole_id`, `mycourse_id`, `mymodule_id`, `mylesson_id`, `mygroup_id`, `program_id`, `question_id`, `answer_id`) VALUES ('', NULL, '3', 1, 1, 1, 1, 1, 1)
ERROR - 2020-04-08 01:59:09 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`eadtoolsv2`.`lesson_status`, CONSTRAINT `fk_lesson_status_myuser1` FOREIGN KEY (`myuser_id`) REFERENCES `myuser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION) - Invalid query: INSERT INTO `lesson_status` (`myuser_id`, `mylesson_id`, `mycourse_id`) VALUES ('', '8', '3')
ERROR - 2020-04-08 01:59:09 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`eadtoolsv2`.`lesson_status`, CONSTRAINT `fk_lesson_status_myuser1` FOREIGN KEY (`myuser_id`) REFERENCES `myuser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION) - Invalid query: INSERT INTO `lesson_status` (`myuser_id`, `mylesson_id`, `mycourse_id`) VALUES ('', '9', '3')
ERROR - 2020-04-08 01:59:09 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`eadtoolsv2`.`lesson_status`, CONSTRAINT `fk_lesson_status_myuser1` FOREIGN KEY (`myuser_id`) REFERENCES `myuser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION) - Invalid query: INSERT INTO `lesson_status` (`myuser_id`, `mylesson_id`, `mycourse_id`) VALUES ('', '10', '3')
ERROR - 2020-04-08 01:59:09 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`eadtoolsv2`.`lesson_status`, CONSTRAINT `fk_lesson_status_myuser1` FOREIGN KEY (`myuser_id`) REFERENCES `myuser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION) - Invalid query: INSERT INTO `lesson_status` (`myuser_id`, `mylesson_id`, `mycourse_id`) VALUES ('', '11', '3')
ERROR - 2020-04-08 01:59:09 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`eadtoolsv2`.`lesson_status`, CONSTRAINT `fk_lesson_status_myuser1` FOREIGN KEY (`myuser_id`) REFERENCES `myuser` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION) - Invalid query: INSERT INTO `lesson_status` (`myuser_id`, `mylesson_id`, `mycourse_id`) VALUES ('', '12', '3')
ERROR - 2020-04-08 02:03:51 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-04-08 02:03:51 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-04-08 02:03:51 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-04-08 02:06:18 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-04-08 02:06:18 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-04-08 02:06:18 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-04-08 02:06:37 --> Severity: 4096 --> Object of class stdClass could not be converted to string C:\xampp\htdocs\application\models\Group_Model.php 127
ERROR - 2020-04-08 02:06:37 --> Severity: 4096 --> Object of class stdClass could not be converted to string C:\xampp\htdocs\application\models\Group_Model.php 127
ERROR - 2020-04-08 02:27:34 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-08 02:27:34 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-08 02:27:41 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 50
ERROR - 2020-04-08 02:27:50 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-08 02:27:50 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-08 02:28:02 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-08 02:28:02 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-08 02:28:21 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-08 02:28:21 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-08 02:28:26 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`eadtoolsv2`.`mycourse`, CONSTRAINT `fk_mycourse_mycategory1` FOREIGN KEY (`mycategory_id`) REFERENCES `mycategory` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION) - Invalid query: UPDATE `mycourse` SET `title` = 'Javascript', `description` = 'Testando criação do curso', `photo` = '20200408022734VSAJCo593cLnyqYp.jpg', `price` = NULL, `release_date` = NULL, `expiration_date` = NULL, `spotlight` = NULL, `validity` = NULL, `preview` = '', `comments` = NULL, `mycategory_id` = NULL, `certificate_id` = 1
WHERE `id` = '2'
ERROR - 2020-04-08 02:34:55 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-08 02:34:55 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-08 02:35:04 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 50
ERROR - 2020-04-08 02:35:15 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-08 02:35:15 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-08 02:35:25 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-08 02:35:25 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-08 02:38:18 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-04-08 02:38:18 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-04-08 02:38:18 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-04-08 04:05:12 --> 404 Page Not Found: Group/removeStudentFromGroup
ERROR - 2020-04-08 04:20:36 --> Severity: Notice --> Undefined variable: student C:\xampp\htdocs\application\models\Group_Model.php 235
ERROR - 2020-04-08 04:20:36 --> Severity: Notice --> Trying to get property 'id' of non-object C:\xampp\htdocs\application\models\Group_Model.php 235
ERROR - 2020-04-08 04:20:36 --> Query error: Column 'myuser_id' cannot be null - Invalid query: INSERT INTO `relationship` (`myuser_id`, `myrole_id`, `mycourse_id`, `mymodule_id`, `mylesson_id`, `mygroup_id`, `program_id`, `question_id`, `answer_id`) VALUES (NULL, NULL, '2', 1, 1, 1, 1, 1, 1)
ERROR - 2020-04-08 04:20:37 --> Query error: Column 'myuser_id' cannot be null - Invalid query: INSERT INTO `lesson_status` (`myuser_id`, `mylesson_id`, `mycourse_id`) VALUES (NULL, '2', '2')
ERROR - 2020-04-08 04:20:37 --> Query error: Column 'myuser_id' cannot be null - Invalid query: INSERT INTO `lesson_status` (`myuser_id`, `mylesson_id`, `mycourse_id`) VALUES (NULL, '3', '2')
ERROR - 2020-04-08 04:20:37 --> Query error: Column 'myuser_id' cannot be null - Invalid query: INSERT INTO `lesson_status` (`myuser_id`, `mylesson_id`, `mycourse_id`) VALUES (NULL, '4', '2')
ERROR - 2020-04-08 05:42:08 --> 404 Page Not Found: Group/getInstructorsInsideTheGroup
ERROR - 2020-04-08 05:42:08 --> 404 Page Not Found: Group/getInstructorsOutsideTheGroup
ERROR - 2020-04-08 05:52:12 --> 404 Page Not Found: Group/getInstructorsInsideTheGroup
ERROR - 2020-04-08 05:52:12 --> 404 Page Not Found: Group/getInstructorsOutsideTheGroup
ERROR - 2020-04-08 05:52:21 --> 404 Page Not Found: Group/getInstructorsInsideTheGroup
ERROR - 2020-04-08 05:52:22 --> 404 Page Not Found: Group/getInstructorsOutsideTheGroup
ERROR - 2020-04-08 05:52:46 --> 404 Page Not Found: Group/getInstructorsOutsideTheGroup
ERROR - 2020-04-08 05:52:46 --> 404 Page Not Found: Group/getInstructorsInsideTheGroup
ERROR - 2020-04-08 05:59:20 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-04-08 05:59:20 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-04-08 05:59:21 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-04-08 06:04:23 --> 404 Page Not Found: Settings/get
ERROR - 2020-04-08 07:58:33 --> 404 Page Not Found: Program/list
ERROR - 2020-04-08 08:05:19 --> Severity: error --> Exception: C:\xampp\htdocs\application\models/Program_Model.php exists, but doesn't declare class Program_Model C:\xampp\htdocs\system\core\Loader.php 340
