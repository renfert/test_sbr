<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-06-10 00:33:11 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 00:33:11 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 00:33:31 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 00:33:31 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 00:36:19 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 00:36:19 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 01:28:55 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 01:28:55 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 01:36:22 --> Query error: Unknown column 'undefined' in 'where clause' - Invalid query: SELECT DISTINCT `T0`.`id` as `key`, `T0`.`name` as `label`
FROM `myuser` `T0`
WHERE `T0`.`id` not in (SELECT myuser_id FROM relationship WHERE program_id = undefined)
ERROR - 2020-06-10 01:36:22 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Program_Model.php 179
ERROR - 2020-06-10 01:44:44 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ')' at line 3 - Invalid query: SELECT DISTINCT `T0`.`id` as `key`, `T0`.`name` as `label`
FROM `myuser` `T0`
WHERE `T0`.`id` not in (SELECT myuser_id FROM relationship WHERE program_id = )
ERROR - 2020-06-10 01:44:44 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Program_Model.php 179
ERROR - 2020-06-10 01:57:07 --> Query error: Unknown column 'undefined' in 'where clause' - Invalid query: SELECT DISTINCT `T1`.`id` as `key`, `T1`.`title` as `label`
FROM `relationship` `T0`
JOIN `mycourse` `T1` ON `T0`.`mycourse_id` = `T1`.`id`
WHERE `T0`.`mygroup_id` != 'undefined'
AND T0.mycourse_id NOT IN (SELECT mycourse_id FROM relationship WHERE mygroup_id = undefined)
ERROR - 2020-06-10 01:57:07 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Group_Model.php 243
ERROR - 2020-06-10 03:50:53 --> Query error: Unknown column 'undefined' in 'where clause' - Invalid query: SELECT DISTINCT `T1`.`id` as `key`, `T1`.`title` as `label`
FROM `relationship` `T0`
JOIN `mycourse` `T1` ON `T0`.`mycourse_id` = `T1`.`id`
WHERE `T0`.`mygroup_id` != 'undefined'
AND T0.mycourse_id NOT IN (SELECT mycourse_id FROM relationship WHERE mygroup_id = undefined)
ERROR - 2020-06-10 03:50:53 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Group_Model.php 243
ERROR - 2020-06-10 04:14:12 --> Severity: error --> Exception: Call to undefined method Course_Model::listingCoursesToViewProgram() C:\xampp\htdocs\application\controllers\Program.php 41
ERROR - 2020-06-10 04:52:41 --> Query error: Unknown column 'undefined' in 'where clause' - Invalid query: SELECT DISTINCT `T1`.`id` as `key`, `T1`.`title` as `label`
FROM `relationship` `T0`
JOIN `mycourse` `T1` ON `T0`.`mycourse_id` = `T1`.`id`
WHERE `T0`.`mygroup_id` != 'undefined'
AND T0.mycourse_id NOT IN (SELECT mycourse_id FROM relationship WHERE mygroup_id = undefined)
ERROR - 2020-06-10 04:52:41 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Group_Model.php 243
ERROR - 2020-06-10 05:27:40 --> Severity: Warning --> call_user_func_array() expects parameter 1 to be a valid callback, class 'Pages' does not have a method '404' C:\xampp\htdocs\system\core\CodeIgniter.php 532
ERROR - 2020-06-10 05:27:41 --> Severity: Warning --> call_user_func_array() expects parameter 1 to be a valid callback, class 'Pages' does not have a method '404' C:\xampp\htdocs\system\core\CodeIgniter.php 532
ERROR - 2020-06-10 06:22:42 --> Query error: Unknown column 'undefined' in 'where clause' - Invalid query: SELECT DISTINCT `T1`.`id` as `key`, `T1`.`title` as `label`
FROM `relationship` `T0`
JOIN `mycourse` `T1` ON `T0`.`mycourse_id` = `T1`.`id`
WHERE `T0`.`mygroup_id` != 'undefined'
AND T0.mycourse_id NOT IN (SELECT mycourse_id FROM relationship WHERE mygroup_id = undefined)
ERROR - 2020-06-10 06:22:42 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Group_Model.php 243
ERROR - 2020-06-10 06:33:13 --> Query error: Unknown column 'undefined' in 'where clause' - Invalid query: SELECT DISTINCT `T1`.`id` as `key`, `T1`.`title` as `label`
FROM `relationship` `T0`
JOIN `mycourse` `T1` ON `T0`.`mycourse_id` = `T1`.`id`
WHERE `T0`.`mygroup_id` != 'undefined'
AND T0.mycourse_id NOT IN (SELECT mycourse_id FROM relationship WHERE mygroup_id = undefined)
ERROR - 2020-06-10 06:33:13 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Group_Model.php 243
ERROR - 2020-06-10 06:36:37 --> Query error: Unknown column 'undefined' in 'where clause' - Invalid query: SELECT DISTINCT `T1`.`id` as `key`, `T1`.`title` as `label`
FROM `relationship` `T0`
JOIN `mycourse` `T1` ON `T0`.`mycourse_id` = `T1`.`id`
WHERE `T0`.`mygroup_id` != 'undefined'
AND T0.mycourse_id NOT IN (SELECT mycourse_id FROM relationship WHERE mygroup_id = undefined)
ERROR - 2020-06-10 06:36:37 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Group_Model.php 243
ERROR - 2020-06-10 06:53:08 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 06:53:08 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 06:53:42 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-06-10 06:53:42 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-06-10 06:53:46 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-06-10 06:53:49 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-06-10 06:53:52 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-06-10 06:54:23 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-06-10 06:54:24 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-06-10 06:54:24 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-06-10 06:54:28 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-06-10 06:54:28 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-06-10 06:54:31 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-06-10 06:54:31 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-06-10 06:54:34 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-06-10 06:54:34 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-06-10 06:54:40 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-06-10 06:54:40 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-06-10 06:54:40 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-06-10 06:54:44 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-06-10 06:54:44 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-06-10 06:54:44 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-06-10 00:54:29 --> Severity: Warning --> file_get_contents(default/application/language/en/lang.json): failed to open stream: No such file or directory C:\xampp\htdocs\application\helpers\email_helper.php 26
ERROR - 2020-06-10 00:54:29 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-06-10 00:54:29 --> Severity: Notice --> Undefined variable: title C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-06-10 00:54:29 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-06-10 00:54:29 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-06-10 00:54:41 --> Severity: Warning --> file_get_contents(default/application/language/en/lang.json): failed to open stream: No such file or directory C:\xampp\htdocs\application\helpers\email_helper.php 26
ERROR - 2020-06-10 00:54:41 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-06-10 00:54:41 --> Severity: Notice --> Undefined variable: title C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-06-10 00:54:41 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-06-10 00:54:41 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-06-10 00:54:42 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 00:54:43 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 00:54:43 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 00:54:43 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 00:54:43 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 00:54:44 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 00:54:44 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 00:54:44 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 00:54:44 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 00:54:45 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 00:54:45 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 00:54:45 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 00:54:45 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 00:54:46 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 00:54:46 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 00:54:46 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 00:54:46 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 00:54:47 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 00:54:47 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 00:54:47 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 00:54:47 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 00:54:48 --> Severity: Notice --> fwrite(): send of 5 bytes failed with errno=10054 An existing connection was forcibly closed by the remote host.
 C:\xampp\htdocs\system\libraries\Email.php 2268
ERROR - 2020-06-10 07:55:32 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 07:55:32 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 07:55:43 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 07:55:43 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 07:55:51 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 07:55:51 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 01:02:45 --> Severity: Warning --> file_get_contents(default/application/language/en/lang.json): failed to open stream: No such file or directory C:\xampp\htdocs\application\helpers\email_helper.php 26
ERROR - 2020-06-10 01:02:45 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-06-10 01:02:45 --> Severity: Notice --> Undefined variable: title C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-06-10 01:02:45 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-06-10 01:02:45 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-06-10 01:02:58 --> Severity: Warning --> file_get_contents(default/application/language/en/lang.json): failed to open stream: No such file or directory C:\xampp\htdocs\application\helpers\email_helper.php 26
ERROR - 2020-06-10 01:02:58 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-06-10 01:02:58 --> Severity: Notice --> Undefined variable: title C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-06-10 01:02:58 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-06-10 01:02:58 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-06-10 08:03:17 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 08:03:17 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 08:03:34 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 08:03:34 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 08:03:44 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 08:03:44 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 08:03:55 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 08:03:55 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-06-10 08:19:54 --> Severity: Notice --> Undefined property: Chart::$sb C:\xampp\htdocs\system\core\Model.php 73
ERROR - 2020-06-10 08:19:54 --> Severity: error --> Exception: Call to a member function from() on null C:\xampp\htdocs\application\models\Chart_Model.php 41
