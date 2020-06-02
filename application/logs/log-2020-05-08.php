<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-05-08 00:50:27 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-08 00:55:26 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-08 01:00:43 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-08 01:00:44 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-08 01:01:16 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-08 01:14:21 --> Query error: Unknown column '3#' in 'where clause' - Invalid query: SELECT `T1`.`name`, `T1`.`description`, `T1`.`avatar`
FROM `relationship` `T0`
JOIN `myuser` `T1` ON `T0`.`myuser_id` = `T1`.`id`
WHERE `T1`.`myrole_id` = 2 AND `T0`.`mycourse_id` = `3#`
ERROR - 2020-05-08 01:14:21 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\User_Model.php 164
ERROR - 2020-05-08 01:14:41 --> Query error: Unknown column '3#' in 'where clause' - Invalid query: SELECT `T1`.`name`, `T1`.`description`, `T1`.`avatar`
FROM `relationship` `T0`
JOIN `myuser` `T1` ON `T0`.`myuser_id` = `T1`.`id`
WHERE `T1`.`myrole_id` = 2 AND `T0`.`mycourse_id` = `3#`
ERROR - 2020-05-08 01:14:41 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\User_Model.php 164
ERROR - 2020-05-08 01:18:39 --> Query error: Unknown column '3#' in 'where clause' - Invalid query: SELECT `T1`.`name`, `T1`.`description`, `T1`.`avatar`
FROM `relationship` `T0`
JOIN `myuser` `T1` ON `T0`.`myuser_id` = `T1`.`id`
WHERE `T1`.`myrole_id` = 2 AND `T0`.`mycourse_id` = `3#`
ERROR - 2020-05-08 01:18:39 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\User_Model.php 164
ERROR - 2020-05-08 01:25:30 --> Query error: Unknown column 'products' in 'where clause' - Invalid query: SELECT `T1`.`name`, `T1`.`description`, `T1`.`avatar`
FROM `relationship` `T0`
JOIN `myuser` `T1` ON `T0`.`myuser_id` = `T1`.`id`
WHERE `T1`.`myrole_id` = 2 AND `T0`.`mycourse_id` = `products`
ERROR - 2020-05-08 01:25:30 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\User_Model.php 164
ERROR - 2020-05-08 01:51:42 --> Query error: Unknown column 'products' in 'where clause' - Invalid query: SELECT `T1`.`name`, `T1`.`description`, `T1`.`avatar`
FROM `relationship` `T0`
JOIN `myuser` `T1` ON `T0`.`myuser_id` = `T1`.`id`
WHERE `T1`.`myrole_id` = 2 AND `T0`.`mycourse_id` = `products`
ERROR - 2020-05-08 01:51:42 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\User_Model.php 164
ERROR - 2020-05-08 01:57:07 --> Query error: Unknown column 'products' in 'where clause' - Invalid query: SELECT `T1`.`name`, `T1`.`description`, `T1`.`avatar`
FROM `relationship` `T0`
JOIN `myuser` `T1` ON `T0`.`myuser_id` = `T1`.`id`
WHERE `T1`.`myrole_id` = 2 AND `T0`.`mycourse_id` = `products`
ERROR - 2020-05-08 01:57:07 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\User_Model.php 164
ERROR - 2020-05-08 02:08:23 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'index)' at line 3 - Invalid query: SELECT DISTINCT `T0`.`id` as `key`, `T0`.`name` as `label`
FROM `myuser` `T0`
WHERE `T0`.`id` not in (SELECT myuser_id FROM relationship WHERE mycourse_id = index)
ERROR - 2020-05-08 02:08:23 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Course_Model.php 248
ERROR - 2020-05-08 02:08:50 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'index)' at line 3 - Invalid query: SELECT DISTINCT `T0`.`id` as `key`, `T0`.`name` as `label`
FROM `myuser` `T0`
WHERE `T0`.`id` not in (SELECT myuser_id FROM relationship WHERE mycourse_id = index)
ERROR - 2020-05-08 02:08:50 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Course_Model.php 248
ERROR - 2020-05-08 02:08:59 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-08 02:28:27 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Course_Model.php 113
ERROR - 2020-05-08 02:28:27 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')' at line 5 - Invalid query: SELECT *
FROM `lesson_status`
WHERE `myuser_id` = 1
AND `status` = 'finished'
AND `mylesson_id` IN()
ERROR - 2020-05-08 02:28:27 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Course_Model.php 122
ERROR - 2020-05-08 02:29:11 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Course_Model.php 113
ERROR - 2020-05-08 02:29:11 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')' at line 5 - Invalid query: SELECT *
FROM `lesson_status`
WHERE `myuser_id` = 1
AND `status` = 'finished'
AND `mylesson_id` IN()
ERROR - 2020-05-08 02:29:12 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Course_Model.php 122
ERROR - 2020-05-08 02:46:04 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Course_Model.php 113
ERROR - 2020-05-08 02:46:04 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')' at line 5 - Invalid query: SELECT *
FROM `lesson_status`
WHERE `myuser_id` = 1
AND `status` = 'finished'
AND `mylesson_id` IN()
ERROR - 2020-05-08 02:46:05 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Course_Model.php 122
ERROR - 2020-05-08 02:47:35 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-08 04:03:57 --> Severity: Notice --> Undefined variable: release_date C:\xampp\htdocs\application\controllers\Course.php 66
ERROR - 2020-05-08 05:25:13 --> Severity: Notice --> Undefined variable: release_date C:\xampp\htdocs\application\controllers\Course.php 66
ERROR - 2020-05-08 05:25:18 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-08 05:25:30 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-08 05:25:30 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-08 05:26:10 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-08 05:26:10 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-08 05:26:40 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-05-08 05:26:40 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-05-08 05:26:42 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-05-08 05:27:01 --> Severity: Notice --> Undefined variable: release_date C:\xampp\htdocs\application\controllers\Course.php 66
ERROR - 2020-05-08 06:50:18 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-08 06:50:25 --> Severity: Notice --> Undefined variable: release_date C:\xampp\htdocs\application\controllers\Course.php 66
ERROR - 2020-05-08 17:19:36 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-08 17:19:36 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-08 17:19:45 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-08 17:20:24 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-05-08 17:20:24 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-05-08 17:20:26 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-05-08 17:20:43 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-08 17:20:44 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-08 18:02:10 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:02:22 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-08 18:02:22 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-08 18:02:42 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:03:33 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:06:27 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:06:43 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:06:48 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-05-08 18:07:29 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:10:22 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:10:43 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:34:28 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:34:32 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:34:44 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:34:54 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-08 18:34:54 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-08 18:34:59 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:35:15 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:35:15 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:35:31 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-05-08 18:35:49 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:35:49 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:35:51 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:36:03 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:36:04 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:36:06 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:36:07 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:36:18 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:36:19 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:37:14 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:37:16 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:37:27 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:39:23 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:41:38 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:42:42 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-08 18:42:42 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-08 18:42:49 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:42:52 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:42:54 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:42:55 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:43:10 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:43:14 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-05-08 18:43:21 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:43:32 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:44:11 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:44:23 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:44:53 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:45:03 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:45:46 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 18:45:51 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 22:09:48 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 22:10:08 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 22:57:28 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-08 22:57:29 --> Severity: Notice --> Undefined variable: release_date C:\xampp\htdocs\application\controllers\Course.php 66
ERROR - 2020-05-08 22:59:48 --> 404 Page Not Found: Settings/get
ERROR - 2020-05-08 23:12:16 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-08 23:20:25 --> Query error: Unknown column 'undefined' in 'where clause' - Invalid query: SELECT DISTINCT `T1`.`id` as `key`, `T1`.`title` as `label`
FROM `relationship` `T0`
JOIN `mycourse` `T1` ON `T0`.`mycourse_id` = `T1`.`id`
WHERE `T0`.`mygroup_id` != 'undefined'
AND T0.mycourse_id NOT IN (SELECT mycourse_id FROM relationship WHERE mygroup_id = undefined)
ERROR - 2020-05-08 23:20:25 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Group_Model.php 242
ERROR - 2020-05-08 23:29:51 --> 404 Page Not Found: Assets/uploads
