<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-04-29 02:47:02 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-04-29 02:47:02 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-04-29 02:47:02 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-04-29 02:47:16 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-04-29 02:47:16 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-04-29 02:47:16 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-04-29 02:49:39 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-29 02:49:39 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-29 02:49:50 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-04-29 02:50:02 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-29 02:50:03 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-29 02:50:32 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-04-29 02:50:32 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-04-29 02:50:34 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-04-29 02:51:06 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-29 02:51:06 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-29 02:53:34 --> 404 Page Not Found: Settings/get
ERROR - 2020-04-29 02:54:37 --> Severity: error --> Exception: Too few arguments to function Lesson_Model::finish(), 1 passed in C:\xampp\htdocs\application\controllers\Lesson.php on line 115 and exactly 2 expected C:\xampp\htdocs\application\models\Lesson_Model.php 210
ERROR - 2020-04-29 03:16:40 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-04-29 03:16:53 --> 404 Page Not Found: Settings/get
ERROR - 2020-04-29 04:22:04 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Corrections_Model.php 15
ERROR - 2020-04-29 04:22:04 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')' at line 9 - Invalid query: SELECT DISTINCT `T1`.`title` as `exam`, `T2`.`title` as `course`, `T3`.`name` as `student`, `T3`.`id` as `studentId`, `T1`.`id`, `T1`.`approval`
FROM `lesson_status` `T0`
JOIN `mylesson` `T1` ON `T0`.`mylesson_id` = `T1`.`id`
JOIN `mycourse` `T2` ON `T0`.`mycourse_id` = `T2`.`id`
JOIN `myuser` `T3` ON `T0`.`myuser_id` = `T3`.`id`
WHERE `T0`.`status` IS NULL
AND `T1`.`type_mylesson_id` = 8
AND `T3`.`myrole_id` = 3
AND `T0`.`mycourse_id` IN()
ERROR - 2020-04-29 04:22:04 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Corrections_Model.php 32
ERROR - 2020-04-29 04:26:21 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-04-29 04:26:22 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-04-29 04:26:22 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-04-29 04:26:59 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-04-29 04:26:59 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-04-29 04:26:59 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-04-29 04:28:11 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-29 04:28:11 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-29 04:28:30 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-04-29 04:28:43 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-29 04:28:43 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-29 04:29:41 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-04-29 04:29:41 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-04-29 04:29:43 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-04-29 04:30:54 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-29 04:30:54 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-29 04:31:40 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-04-29 04:31:59 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-04-29 21:54:54 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-04-29 21:54:54 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-04-29 21:54:54 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-04-29 21:55:15 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
