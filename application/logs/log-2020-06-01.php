<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-06-01 19:22:46 --> 404 Page Not Found: Faviconico/index
ERROR - 2020-06-01 22:34:30 --> Query error: Unknown column '4#' in 'where clause' - Invalid query: SELECT `T1`.`name`, `T1`.`description`, `T1`.`avatar`
FROM `relationship` `T0`
JOIN `myuser` `T1` ON `T0`.`myuser_id` = `T1`.`id`
WHERE `T1`.`myrole_id` = 2 AND `T0`.`mycourse_id` = `4#`
ERROR - 2020-06-01 22:34:30 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\User_Model.php 164
ERROR - 2020-06-01 23:38:17 --> Severity: Warning --> file_get_contents(default/application/language/en/lang.json): failed to open stream: No such file or directory C:\xampp\htdocs\application\helpers\email_helper.php 26
ERROR - 2020-06-01 23:38:18 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-06-01 23:38:18 --> Severity: Notice --> Undefined variable: title C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-06-01 23:38:18 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-06-01 23:38:18 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-06-01 23:40:33 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
