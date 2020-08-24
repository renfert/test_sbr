<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-06-06 00:19:39 --> Severity: Warning --> file_get_contents(default/application/language/en/lang.json): failed to open stream: No such file or directory C:\xampp\htdocs\application\helpers\email_helper.php 26
ERROR - 2020-06-06 00:19:39 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-06-06 00:19:39 --> Severity: Notice --> Undefined variable: title C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-06-06 00:19:39 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-06-06 00:19:39 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-06-06 00:19:48 --> Query error: Unknown column 'undefined' in 'where clause' - Invalid query: SELECT DISTINCT `T1`.`id` as `key`, `T1`.`title` as `label`
FROM `relationship` `T0`
JOIN `mycourse` `T1` ON `T0`.`mycourse_id` = `T1`.`id`
WHERE `T0`.`mygroup_id` != 'undefined'
AND T0.mycourse_id NOT IN (SELECT mycourse_id FROM relationship WHERE mygroup_id = undefined)
ERROR - 2020-06-06 00:19:48 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Group_Model.php 243
