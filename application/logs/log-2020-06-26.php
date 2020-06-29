<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-06-26 01:19:40 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Course_Model.php 139
ERROR - 2020-06-26 01:19:40 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')' at line 5 - Invalid query: SELECT *
FROM `lesson_status`
WHERE `myuser_id` = 1
AND `status` = 'finished'
AND `mylesson_id` IN()
ERROR - 2020-06-26 01:19:40 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Course_Model.php 148
ERROR - 2020-06-26 03:14:05 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Course_Model.php 139
ERROR - 2020-06-26 03:14:05 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')' at line 5 - Invalid query: SELECT *
FROM `lesson_status`
WHERE `myuser_id` = 1
AND `status` = 'finished'
AND `mylesson_id` IN()
ERROR - 2020-06-26 03:14:05 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Course_Model.php 148
