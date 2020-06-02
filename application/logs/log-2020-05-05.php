<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-05-05 00:57:56 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 00:57:56 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 01:36:45 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 01:36:45 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 02:17:17 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 02:17:17 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 02:17:56 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-05 02:18:05 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 02:18:05 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 02:18:16 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 02:18:16 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 02:19:52 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 02:19:52 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 02:20:16 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-05 02:20:24 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 02:20:24 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 02:28:45 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 02:28:45 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 02:28:46 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`eadtoolsv2`.`program_has_mycourse`, CONSTRAINT `fk_program_has_mycourse_mycourse1` FOREIGN KEY (`mycourse_id`) REFERENCES `mycourse` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION) - Invalid query: INSERT INTO `program_has_mycourse` (`program_id`, `mycourse_id`, `position`) VALUES ('2', '', 0)
ERROR - 2020-05-05 02:28:46 --> Severity: error --> Exception: Call to undefined method Course_Model::enrollAdm() C:\xampp\htdocs\application\models\Program_Model.php 105
ERROR - 2020-05-05 02:31:04 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 02:31:04 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 02:31:05 --> Severity: error --> Exception: Call to undefined method Course_Model::enrollAdm() C:\xampp\htdocs\application\models\Program_Model.php 105
ERROR - 2020-05-05 03:42:13 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 03:42:13 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 03:42:15 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Course_Model.php 148
ERROR - 2020-05-05 03:42:18 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<' at line 5 - Invalid query: SELECT DISTINCT `T0`.`id` as `key`, `T0`.`name` as `label`
FROM `myuser` `T0`
WHERE T0.id not in (SELECT myuser_id FROM relationship WHERE mycourse_id = 

<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>A PHP Error was encountered</h4>

<p>Severity: Warning</p>
<p>Message:  Invalid argument supplied for foreach()</p>
<p>Filename: models/Course_Model.php</p>
<p>Line Number: 148</p>


	<p>Backtrace:</p>
	
		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\application\models\Course_Model.php<br />
			Line: 148<br />
			Function: _error_handler			</p>

		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\application\models\Course_Model.php<br />
			Line: 20<br />
			Function: enrollUserIntoCourse			</p>

		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\application\controllers\Course.php<br />
			Line: 34<br />
			Function: create			</p>

		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\index.php<br />
			Line: 316<br />
			Function: require_once			</p>

		
	

</div>"2")
ERROR - 2020-05-05 03:42:18 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Course_Model.php 238
ERROR - 2020-05-05 03:42:51 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Course_Model.php 148
ERROR - 2020-05-05 03:42:51 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<' at line 5 - Invalid query: SELECT DISTINCT `T0`.`id` as `key`, `T0`.`name` as `label`
FROM `myuser` `T0`
WHERE T0.id not in (SELECT myuser_id FROM relationship WHERE mycourse_id = 

<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>A PHP Error was encountered</h4>

<p>Severity: Warning</p>
<p>Message:  Invalid argument supplied for foreach()</p>
<p>Filename: models/Course_Model.php</p>
<p>Line Number: 148</p>


	<p>Backtrace:</p>
	
		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\application\models\Course_Model.php<br />
			Line: 148<br />
			Function: _error_handler			</p>

		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\application\models\Course_Model.php<br />
			Line: 20<br />
			Function: enrollUserIntoCourse			</p>

		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\application\controllers\Course.php<br />
			Line: 34<br />
			Function: create			</p>

		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\index.php<br />
			Line: 316<br />
			Function: require_once			</p>

		
	

</div>"3")
ERROR - 2020-05-05 03:42:51 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Course_Model.php 238
ERROR - 2020-05-05 03:48:11 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 03:48:11 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 03:48:13 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Course_Model.php 149
ERROR - 2020-05-05 03:48:13 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<' at line 5 - Invalid query: SELECT DISTINCT `T0`.`id` as `key`, `T0`.`name` as `label`
FROM `myuser` `T0`
WHERE T0.id not in (SELECT myuser_id FROM relationship WHERE mycourse_id = 

<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>A PHP Error was encountered</h4>

<p>Severity: Warning</p>
<p>Message:  Invalid argument supplied for foreach()</p>
<p>Filename: models/Course_Model.php</p>
<p>Line Number: 149</p>


	<p>Backtrace:</p>
	
		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\application\models\Course_Model.php<br />
			Line: 149<br />
			Function: _error_handler			</p>

		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\application\models\Course_Model.php<br />
			Line: 20<br />
			Function: enrollUserIntoCourse			</p>

		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\application\controllers\Course.php<br />
			Line: 34<br />
			Function: create			</p>

		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\index.php<br />
			Line: 316<br />
			Function: require_once			</p>

		
	

</div>"2")
ERROR - 2020-05-05 03:48:13 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Course_Model.php 239
ERROR - 2020-05-05 03:48:30 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Course_Model.php 149
ERROR - 2020-05-05 03:48:30 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<' at line 5 - Invalid query: SELECT DISTINCT `T0`.`id` as `key`, `T0`.`name` as `label`
FROM `myuser` `T0`
WHERE T0.id not in (SELECT myuser_id FROM relationship WHERE mycourse_id = 

<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>A PHP Error was encountered</h4>

<p>Severity: Warning</p>
<p>Message:  Invalid argument supplied for foreach()</p>
<p>Filename: models/Course_Model.php</p>
<p>Line Number: 149</p>


	<p>Backtrace:</p>
	
		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\application\models\Course_Model.php<br />
			Line: 149<br />
			Function: _error_handler			</p>

		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\application\models\Course_Model.php<br />
			Line: 20<br />
			Function: enrollUserIntoCourse			</p>

		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\application\controllers\Course.php<br />
			Line: 34<br />
			Function: create			</p>

		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\index.php<br />
			Line: 316<br />
			Function: require_once			</p>

		
	

</div>"3")
ERROR - 2020-05-05 03:48:30 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Course_Model.php 239
ERROR - 2020-05-05 03:50:55 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Course_Model.php 151
ERROR - 2020-05-05 03:50:55 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h' at line 5 - Invalid query: SELECT DISTINCT `T0`.`id` as `key`, `T0`.`name` as `label`
FROM `myuser` `T0`
WHERE T0.id not in (SELECT myuser_id FROM relationship WHERE mycourse_id = 
41
<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>A PHP Error was encountered</h4>

<p>Severity: Warning</p>
<p>Message:  Invalid argument supplied for foreach()</p>
<p>Filename: models/Course_Model.php</p>
<p>Line Number: 151</p>


	<p>Backtrace:</p>
	
		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\application\models\Course_Model.php<br />
			Line: 151<br />
			Function: _error_handler			</p>

		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\application\models\Course_Model.php<br />
			Line: 20<br />
			Function: enrollUserIntoCourse			</p>

		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\application\controllers\Course.php<br />
			Line: 34<br />
			Function: create			</p>

		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\index.php<br />
			Line: 316<br />
			Function: require_once			</p>

		
	

</div>"4")
ERROR - 2020-05-05 03:50:55 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Course_Model.php 241
ERROR - 2020-05-05 03:51:59 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Course_Model.php 150
ERROR - 2020-05-05 03:52:00 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h' at line 6 - Invalid query: SELECT DISTINCT `T0`.`id` as `key`, `T0`.`name` as `label`
FROM `myuser` `T0`
WHERE T0.id not in (SELECT myuser_id FROM relationship WHERE mycourse_id = 
NULL

<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>A PHP Error was encountered</h4>

<p>Severity: Warning</p>
<p>Message:  Invalid argument supplied for foreach()</p>
<p>Filename: models/Course_Model.php</p>
<p>Line Number: 150</p>


	<p>Backtrace:</p>
	
		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\application\models\Course_Model.php<br />
			Line: 150<br />
			Function: _error_handler			</p>

		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\application\models\Course_Model.php<br />
			Line: 20<br />
			Function: enrollUserIntoCourse			</p>

		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\application\controllers\Course.php<br />
			Line: 34<br />
			Function: create			</p>

		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\index.php<br />
			Line: 316<br />
			Function: require_once			</p>

		
	

</div>"5")
ERROR - 2020-05-05 03:52:00 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Course_Model.php 240
ERROR - 2020-05-05 03:53:31 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Course_Model.php 150
ERROR - 2020-05-05 03:53:31 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h' at line 5 - Invalid query: SELECT DISTINCT `T0`.`id` as `key`, `T0`.`name` as `label`
FROM `myuser` `T0`
WHERE T0.id not in (SELECT myuser_id FROM relationship WHERE mycourse_id = 
6
<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">

<h4>A PHP Error was encountered</h4>

<p>Severity: Warning</p>
<p>Message:  Invalid argument supplied for foreach()</p>
<p>Filename: models/Course_Model.php</p>
<p>Line Number: 150</p>


	<p>Backtrace:</p>
	
		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\application\models\Course_Model.php<br />
			Line: 150<br />
			Function: _error_handler			</p>

		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\application\models\Course_Model.php<br />
			Line: 20<br />
			Function: enrollUserIntoCourse			</p>

		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\application\controllers\Course.php<br />
			Line: 34<br />
			Function: create			</p>

		
	
		
	
		
			<p style="margin-left:10px">
			File: C:\xampp\htdocs\index.php<br />
			Line: 316<br />
			Function: require_once			</p>

		
	

</div>"6")
ERROR - 2020-05-05 03:53:31 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Course_Model.php 240
ERROR - 2020-05-05 03:57:07 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 03:57:07 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 03:57:23 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-05 03:57:32 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 03:57:32 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 03:58:48 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 03:58:48 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 03:58:56 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-05 03:59:04 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 03:59:04 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:02:30 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:02:30 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:02:40 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Program_Model.php 35
ERROR - 2020-05-05 04:02:40 --> Severity: error --> Exception: Too few arguments to function CI_DB_query_builder::join(), 1 passed in C:\xampp\htdocs\application\models\Program_Model.php on line 61 and at least 2 expected C:\xampp\htdocs\system\database\DB_query_builder.php 526
ERROR - 2020-05-05 04:06:59 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:06:59 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:07:08 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-05 04:07:23 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 20
ERROR - 2020-05-05 04:07:23 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-05 04:10:58 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:10:58 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:11:04 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-05 04:11:15 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:11:15 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:11:33 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:11:33 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:11:41 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-05 04:11:50 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:11:51 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:15:25 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:15:25 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:15:27 --> Severity: error --> Exception: Too few arguments to function CI_DB_query_builder::join(), 1 passed in C:\xampp\htdocs\application\models\Program_Model.php on line 61 and at least 2 expected C:\xampp\htdocs\system\database\DB_query_builder.php 526
ERROR - 2020-05-05 04:17:37 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-05 04:17:47 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:17:47 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:18:21 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:18:21 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:18:29 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-05 04:18:38 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:18:38 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:19:34 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:19:34 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:19:36 --> Severity: error --> Exception: Too few arguments to function CI_DB_query_builder::join(), 1 passed in C:\xampp\htdocs\application\models\Program_Model.php on line 61 and at least 2 expected C:\xampp\htdocs\system\database\DB_query_builder.php 526
ERROR - 2020-05-05 04:21:25 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:21:25 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:21:37 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-05 04:21:47 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:21:47 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:22:02 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:22:02 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:22:22 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:22:22 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:22:29 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-05 04:22:42 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:22:42 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:23:31 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:23:31 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:23:37 --> Severity: Notice --> Undefined property: PDO::$id C:\xampp\htdocs\application\models\Program_Model.php 66
ERROR - 2020-05-05 04:23:37 --> Query error: Column 'mycourse_id' cannot be null - Invalid query: INSERT INTO `relationship` (`myuser_id`, `mycourse_id`, `mymodule_id`, `mylesson_id`, `mygroup_id`, `question_id`, `answer_id`, `program_id`) VALUES (1, NULL, 1, 1, 1, 1, 1, 1)
ERROR - 2020-05-05 04:23:37 --> Severity: Notice --> Undefined property: PDOStatement::$id C:\xampp\htdocs\application\models\Program_Model.php 66
ERROR - 2020-05-05 04:23:37 --> Query error: Column 'mycourse_id' cannot be null - Invalid query: INSERT INTO `relationship` (`myuser_id`, `mycourse_id`, `mymodule_id`, `mylesson_id`, `mygroup_id`, `question_id`, `answer_id`, `program_id`) VALUES (1, NULL, 1, 1, 1, 1, 1, 1)
ERROR - 2020-05-05 04:23:37 --> Severity: Notice --> Trying to get property 'id' of non-object C:\xampp\htdocs\application\models\Program_Model.php 66
ERROR - 2020-05-05 04:23:37 --> Query error: Column 'mycourse_id' cannot be null - Invalid query: INSERT INTO `relationship` (`myuser_id`, `mycourse_id`, `mymodule_id`, `mylesson_id`, `mygroup_id`, `question_id`, `answer_id`, `program_id`) VALUES (1, NULL, 1, 1, 1, 1, 1, 1)
ERROR - 2020-05-05 04:23:37 --> Severity: Notice --> Trying to get property 'id' of non-object C:\xampp\htdocs\application\models\Program_Model.php 66
ERROR - 2020-05-05 04:23:37 --> Query error: Column 'mycourse_id' cannot be null - Invalid query: INSERT INTO `relationship` (`myuser_id`, `mycourse_id`, `mymodule_id`, `mylesson_id`, `mygroup_id`, `question_id`, `answer_id`, `program_id`) VALUES (1, NULL, 1, 1, 1, 1, 1, 1)
ERROR - 2020-05-05 04:23:37 --> Severity: Notice --> Trying to get property 'id' of non-object C:\xampp\htdocs\application\models\Program_Model.php 66
ERROR - 2020-05-05 04:23:37 --> Query error: Column 'mycourse_id' cannot be null - Invalid query: INSERT INTO `relationship` (`myuser_id`, `mycourse_id`, `mymodule_id`, `mylesson_id`, `mygroup_id`, `question_id`, `answer_id`, `program_id`) VALUES (1, NULL, 1, 1, 1, 1, 1, 1)
ERROR - 2020-05-05 04:23:37 --> Severity: Notice --> Trying to get property 'id' of non-object C:\xampp\htdocs\application\models\Program_Model.php 66
ERROR - 2020-05-05 04:23:37 --> Query error: Column 'mycourse_id' cannot be null - Invalid query: INSERT INTO `relationship` (`myuser_id`, `mycourse_id`, `mymodule_id`, `mylesson_id`, `mygroup_id`, `question_id`, `answer_id`, `program_id`) VALUES (1, NULL, 1, 1, 1, 1, 1, 1)
ERROR - 2020-05-05 04:23:37 --> Severity: Notice --> Trying to get property 'id' of non-object C:\xampp\htdocs\application\models\Program_Model.php 66
ERROR - 2020-05-05 04:23:37 --> Query error: Column 'mycourse_id' cannot be null - Invalid query: INSERT INTO `relationship` (`myuser_id`, `mycourse_id`, `mymodule_id`, `mylesson_id`, `mygroup_id`, `question_id`, `answer_id`, `program_id`) VALUES (1, NULL, 1, 1, 1, 1, 1, 1)
ERROR - 2020-05-05 04:23:37 --> Severity: Notice --> Trying to get property 'id' of non-object C:\xampp\htdocs\application\models\Program_Model.php 66
ERROR - 2020-05-05 04:23:37 --> Query error: Column 'mycourse_id' cannot be null - Invalid query: INSERT INTO `relationship` (`myuser_id`, `mycourse_id`, `mymodule_id`, `mylesson_id`, `mygroup_id`, `question_id`, `answer_id`, `program_id`) VALUES (1, NULL, 1, 1, 1, 1, 1, 1)
ERROR - 2020-05-05 04:23:37 --> Severity: Notice --> Undefined property: PDO::$id C:\xampp\htdocs\application\models\Program_Model.php 66
ERROR - 2020-05-05 04:23:37 --> Query error: Column 'mycourse_id' cannot be null - Invalid query: INSERT INTO `relationship` (`myuser_id`, `mycourse_id`, `mymodule_id`, `mylesson_id`, `mygroup_id`, `question_id`, `answer_id`, `program_id`) VALUES (1, NULL, 1, 1, 1, 1, 1, 1)
ERROR - 2020-05-05 04:23:37 --> Severity: Notice --> Undefined property: PDOStatement::$id C:\xampp\htdocs\application\models\Program_Model.php 66
ERROR - 2020-05-05 04:23:37 --> Query error: Column 'mycourse_id' cannot be null - Invalid query: INSERT INTO `relationship` (`myuser_id`, `mycourse_id`, `mymodule_id`, `mylesson_id`, `mygroup_id`, `question_id`, `answer_id`, `program_id`) VALUES (1, NULL, 1, 1, 1, 1, 1, 1)
ERROR - 2020-05-05 04:23:37 --> Severity: Notice --> Trying to get property 'id' of non-object C:\xampp\htdocs\application\models\Program_Model.php 66
ERROR - 2020-05-05 04:23:37 --> Query error: Column 'mycourse_id' cannot be null - Invalid query: INSERT INTO `relationship` (`myuser_id`, `mycourse_id`, `mymodule_id`, `mylesson_id`, `mygroup_id`, `question_id`, `answer_id`, `program_id`) VALUES (1, NULL, 1, 1, 1, 1, 1, 1)
ERROR - 2020-05-05 04:23:37 --> Severity: Notice --> Trying to get property 'id' of non-object C:\xampp\htdocs\application\models\Program_Model.php 66
ERROR - 2020-05-05 04:23:37 --> Query error: Column 'mycourse_id' cannot be null - Invalid query: INSERT INTO `relationship` (`myuser_id`, `mycourse_id`, `mymodule_id`, `mylesson_id`, `mygroup_id`, `question_id`, `answer_id`, `program_id`) VALUES (1, NULL, 1, 1, 1, 1, 1, 1)
ERROR - 2020-05-05 04:23:37 --> Severity: Notice --> Trying to get property 'id' of non-object C:\xampp\htdocs\application\models\Program_Model.php 66
ERROR - 2020-05-05 04:23:37 --> Query error: Column 'mycourse_id' cannot be null - Invalid query: INSERT INTO `relationship` (`myuser_id`, `mycourse_id`, `mymodule_id`, `mylesson_id`, `mygroup_id`, `question_id`, `answer_id`, `program_id`) VALUES (1, NULL, 1, 1, 1, 1, 1, 1)
ERROR - 2020-05-05 04:23:38 --> Severity: Notice --> Trying to get property 'id' of non-object C:\xampp\htdocs\application\models\Program_Model.php 66
ERROR - 2020-05-05 04:23:38 --> Query error: Column 'mycourse_id' cannot be null - Invalid query: INSERT INTO `relationship` (`myuser_id`, `mycourse_id`, `mymodule_id`, `mylesson_id`, `mygroup_id`, `question_id`, `answer_id`, `program_id`) VALUES (1, NULL, 1, 1, 1, 1, 1, 1)
ERROR - 2020-05-05 04:23:38 --> Severity: Notice --> Trying to get property 'id' of non-object C:\xampp\htdocs\application\models\Program_Model.php 66
ERROR - 2020-05-05 04:23:38 --> Query error: Column 'mycourse_id' cannot be null - Invalid query: INSERT INTO `relationship` (`myuser_id`, `mycourse_id`, `mymodule_id`, `mylesson_id`, `mygroup_id`, `question_id`, `answer_id`, `program_id`) VALUES (1, NULL, 1, 1, 1, 1, 1, 1)
ERROR - 2020-05-05 04:23:38 --> Severity: Notice --> Trying to get property 'id' of non-object C:\xampp\htdocs\application\models\Program_Model.php 66
ERROR - 2020-05-05 04:23:38 --> Query error: Column 'mycourse_id' cannot be null - Invalid query: INSERT INTO `relationship` (`myuser_id`, `mycourse_id`, `mymodule_id`, `mylesson_id`, `mygroup_id`, `question_id`, `answer_id`, `program_id`) VALUES (1, NULL, 1, 1, 1, 1, 1, 1)
ERROR - 2020-05-05 04:27:36 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:27:36 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:30:01 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:30:01 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:30:10 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-05 04:30:17 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:30:17 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:30:36 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:30:36 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:31:03 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:31:03 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:31:10 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-05 04:31:19 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:31:19 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:32:14 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 04:32:14 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 06:51:14 --> Severity: 4096 --> Object of class CI_DB_pdo_mysql_driver could not be converted to string C:\xampp\htdocs\application\models\Program_Model.php 84
ERROR - 2020-05-05 06:51:14 --> Severity: 4096 --> Object of class CI_DB_pdo_mysql_driver could not be converted to string C:\xampp\htdocs\application\models\Program_Model.php 84
ERROR - 2020-05-05 06:51:14 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, ' at line 1 - Invalid query: SELECT `DISTINCT` `T1`.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id ) as lessons, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id AND T3.status = 'finished' ) as finishedLessons
FROM `relationship` `T0`
JOIN `program` `T1` ON `T0`.`program_id` = `T1`.`id`
WHERE `T0`.`myuser_id` = 1
AND `T1`.`id` != 1
ORDER BY `T1`.`id` DESC
ERROR - 2020-05-05 06:51:14 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Program_Model.php 89
ERROR - 2020-05-05 06:51:14 --> Severity: 4096 --> Object of class CI_DB_pdo_mysql_driver could not be converted to string C:\xampp\htdocs\application\models\Program_Model.php 84
ERROR - 2020-05-05 06:51:15 --> Severity: 4096 --> Object of class CI_DB_pdo_mysql_driver could not be converted to string C:\xampp\htdocs\application\models\Program_Model.php 84
ERROR - 2020-05-05 06:51:15 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, ' at line 1 - Invalid query: SELECT `DISTINCT` `T1`.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id ) as lessons, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id AND T3.status = 'finished' ) as finishedLessons
FROM `relationship` `T0`
JOIN `program` `T1` ON `T0`.`program_id` = `T1`.`id`
WHERE `T0`.`myuser_id` = 1
AND `T1`.`id` != 1
ORDER BY `T1`.`id` DESC
ERROR - 2020-05-05 06:51:15 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Program_Model.php 89
ERROR - 2020-05-05 06:51:15 --> Severity: 4096 --> Object of class CI_DB_pdo_mysql_driver could not be converted to string C:\xampp\htdocs\application\models\Program_Model.php 84
ERROR - 2020-05-05 06:51:15 --> Severity: 4096 --> Object of class CI_DB_pdo_mysql_driver could not be converted to string C:\xampp\htdocs\application\models\Program_Model.php 84
ERROR - 2020-05-05 06:51:15 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, ' at line 1 - Invalid query: SELECT `DISTINCT` `T1`.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id ) as lessons, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id AND T3.status = 'finished' ) as finishedLessons
FROM `relationship` `T0`
JOIN `program` `T1` ON `T0`.`program_id` = `T1`.`id`
WHERE `T0`.`myuser_id` = 1
AND `T1`.`id` != 1
ORDER BY `T1`.`id` DESC
ERROR - 2020-05-05 06:51:15 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Program_Model.php 89
ERROR - 2020-05-05 06:51:50 --> Severity: 4096 --> Object of class CI_DB_pdo_mysql_driver could not be converted to string C:\xampp\htdocs\application\models\Program_Model.php 84
ERROR - 2020-05-05 06:51:50 --> Severity: 4096 --> Object of class CI_DB_pdo_mysql_driver could not be converted to string C:\xampp\htdocs\application\models\Program_Model.php 84
ERROR - 2020-05-05 06:51:50 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, ' at line 1 - Invalid query: SELECT `DISTINCT` `T1`.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id ) as lessons, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id AND T3.status = 'finished' ) as finishedLessons
FROM `relationship` `T0`
JOIN `program` `T1` ON `T0`.`program_id` = `T1`.`id`
WHERE `T0`.`myuser_id` = 1
AND `T1`.`id` != 1
ORDER BY `T1`.`id` DESC
ERROR - 2020-05-05 06:51:50 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Program_Model.php 89
ERROR - 2020-05-05 06:51:50 --> Severity: 4096 --> Object of class CI_DB_pdo_mysql_driver could not be converted to string C:\xampp\htdocs\application\models\Program_Model.php 84
ERROR - 2020-05-05 06:51:50 --> Severity: 4096 --> Object of class CI_DB_pdo_mysql_driver could not be converted to string C:\xampp\htdocs\application\models\Program_Model.php 84
ERROR - 2020-05-05 06:51:50 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, ' at line 1 - Invalid query: SELECT `DISTINCT` `T1`.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id ) as lessons, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id AND T3.status = 'finished' ) as finishedLessons
FROM `relationship` `T0`
JOIN `program` `T1` ON `T0`.`program_id` = `T1`.`id`
WHERE `T0`.`myuser_id` = 1
AND `T1`.`id` != 1
ORDER BY `T1`.`id` DESC
ERROR - 2020-05-05 06:51:50 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Program_Model.php 89
ERROR - 2020-05-05 06:51:50 --> Severity: 4096 --> Object of class CI_DB_pdo_mysql_driver could not be converted to string C:\xampp\htdocs\application\models\Program_Model.php 84
ERROR - 2020-05-05 06:51:50 --> Severity: 4096 --> Object of class CI_DB_pdo_mysql_driver could not be converted to string C:\xampp\htdocs\application\models\Program_Model.php 84
ERROR - 2020-05-05 06:51:50 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, ' at line 1 - Invalid query: SELECT `DISTINCT` `T1`.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id ) as lessons, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id AND T3.status = 'finished' ) as finishedLessons
FROM `relationship` `T0`
JOIN `program` `T1` ON `T0`.`program_id` = `T1`.`id`
WHERE `T0`.`myuser_id` = 1
AND `T1`.`id` != 1
ORDER BY `T1`.`id` DESC
ERROR - 2020-05-05 06:51:50 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Program_Model.php 89
ERROR - 2020-05-05 06:52:18 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, ' at line 1 - Invalid query: SELECT `DISTINCT` `T1`.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id ) as lessons, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id AND T3.status = 'finished' ) as finishedLessons
FROM `relationship` `T0`
JOIN `program` `T1` ON `T0`.`program_id` = `T1`.`id`
WHERE `T0`.`myuser_id` = 1
AND `T1`.`id` != 1
ORDER BY `T1`.`id` DESC
ERROR - 2020-05-05 06:52:18 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Program_Model.php 89
ERROR - 2020-05-05 06:52:18 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, ' at line 1 - Invalid query: SELECT `DISTINCT` `T1`.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id ) as lessons, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id AND T3.status = 'finished' ) as finishedLessons
FROM `relationship` `T0`
JOIN `program` `T1` ON `T0`.`program_id` = `T1`.`id`
WHERE `T0`.`myuser_id` = 1
AND `T1`.`id` != 1
ORDER BY `T1`.`id` DESC
ERROR - 2020-05-05 06:52:18 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Program_Model.php 89
ERROR - 2020-05-05 06:52:18 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, ' at line 1 - Invalid query: SELECT `DISTINCT` `T1`.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id ) as lessons, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id AND T3.status = 'finished' ) as finishedLessons
FROM `relationship` `T0`
JOIN `program` `T1` ON `T0`.`program_id` = `T1`.`id`
WHERE `T0`.`myuser_id` = 1
AND `T1`.`id` != 1
ORDER BY `T1`.`id` DESC
ERROR - 2020-05-05 06:52:18 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Program_Model.php 89
ERROR - 2020-05-05 06:54:25 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, ' at line 1 - Invalid query: SELECT `DISTINCT` `T1`.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id ) as lessons, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id AND T3.status = 'finished' ) as finishedLessons
FROM `relationship` `T0`
JOIN `program` `T1` ON `T0`.`program_id` = `T1`.`id`
WHERE `T0`.`myuser_id` = 1
AND `T1`.`id` != 1
ERROR - 2020-05-05 06:54:25 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Program_Model.php 88
ERROR - 2020-05-05 06:54:25 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, ' at line 1 - Invalid query: SELECT `DISTINCT` `T1`.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id ) as lessons, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id AND T3.status = 'finished' ) as finishedLessons
FROM `relationship` `T0`
JOIN `program` `T1` ON `T0`.`program_id` = `T1`.`id`
WHERE `T0`.`myuser_id` = 1
AND `T1`.`id` != 1
ERROR - 2020-05-05 06:54:25 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Program_Model.php 88
ERROR - 2020-05-05 06:54:25 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, ' at line 1 - Invalid query: SELECT `DISTINCT` `T1`.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id ) as lessons, (SELECT count( DISTINCT T3.mylesson_id) FROM program_has_mycourse T2 INNER JOIN lesson_status T3 ON T2.mycourse_id = T3.mycourse_id WHERE T2.program_id = T1.id AND T3.status = 'finished' ) as finishedLessons
FROM `relationship` `T0`
JOIN `program` `T1` ON `T0`.`program_id` = `T1`.`id`
WHERE `T0`.`myuser_id` = 1
AND `T1`.`id` != 1
ERROR - 2020-05-05 06:54:25 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Program_Model.php 88
ERROR - 2020-05-05 06:54:49 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`
F' at line 1 - Invalid query: SELECT `DISTINCT` `T1`.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`
FROM `relationship` `T0`
JOIN `program` `T1` ON `T0`.`program_id` = `T1`.`id`
WHERE `T0`.`myuser_id` = 1
AND `T1`.`id` != 1
ORDER BY `T1`.`id` DESC
ERROR - 2020-05-05 06:54:49 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Program_Model.php 87
ERROR - 2020-05-05 06:54:50 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`
F' at line 1 - Invalid query: SELECT `DISTINCT` `T1`.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`
FROM `relationship` `T0`
JOIN `program` `T1` ON `T0`.`program_id` = `T1`.`id`
WHERE `T0`.`myuser_id` = 1
AND `T1`.`id` != 1
ORDER BY `T1`.`id` DESC
ERROR - 2020-05-05 06:54:50 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Program_Model.php 87
ERROR - 2020-05-05 06:54:50 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`
F' at line 1 - Invalid query: SELECT `DISTINCT` `T1`.`id`, `T1`.`title`, `T1`.`photo`, `T1`.`release_date`, `T1`.`expiration_date`
FROM `relationship` `T0`
JOIN `program` `T1` ON `T0`.`program_id` = `T1`.`id`
WHERE `T0`.`myuser_id` = 1
AND `T1`.`id` != 1
ORDER BY `T1`.`id` DESC
ERROR - 2020-05-05 06:54:50 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Program_Model.php 87
ERROR - 2020-05-05 07:05:42 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 07:05:42 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 07:05:50 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-05 07:05:57 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 07:05:58 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 07:07:34 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-05-05 07:07:34 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-05-05 07:07:34 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-05-05 07:07:52 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-05-05 07:07:52 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-05-05 07:07:52 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-05-05 07:11:18 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 07:11:18 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 07:11:26 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-05 07:11:36 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 07:11:36 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 07:12:12 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-05-05 07:12:12 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-05-05 07:12:14 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-05-05 07:13:25 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-05 07:54:29 --> 404 Page Not Found: Settings/get
ERROR - 2020-05-05 07:54:33 --> 404 Page Not Found: Settings/get
ERROR - 2020-05-05 07:58:54 --> 404 Page Not Found: Settings/get
ERROR - 2020-05-05 08:00:55 --> 404 Page Not Found: Settings/get
ERROR - 2020-05-05 08:01:14 --> Severity: Notice --> Undefined variable: data C:\xampp\htdocs\application\models\Calendar_Model.php 31
ERROR - 2020-05-05 08:01:20 --> 404 Page Not Found: Settings/get
ERROR - 2020-05-05 08:01:33 --> Severity: Notice --> Undefined variable: data C:\xampp\htdocs\application\models\Calendar_Model.php 31
ERROR - 2020-05-05 08:01:36 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-05 17:25:07 --> 404 Page Not Found: Settings/get
ERROR - 2020-05-05 17:31:56 --> 404 Page Not Found: Settings/get
ERROR - 2020-05-05 17:32:18 --> 404 Page Not Found: Settings/get
ERROR - 2020-05-05 17:38:12 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-05 17:38:26 --> Severity: Notice --> Undefined variable: data C:\xampp\htdocs\application\models\Calendar_Model.php 31
ERROR - 2020-05-05 17:39:51 --> 404 Page Not Found: Settings/get
ERROR - 2020-05-05 17:40:06 --> 404 Page Not Found: Settings/get
ERROR - 2020-05-05 17:40:27 --> 404 Page Not Found: Settings/get
ERROR - 2020-05-05 17:41:18 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-05 17:41:23 --> 404 Page Not Found: Settings/get
ERROR - 2020-05-05 17:50:44 --> 404 Page Not Found: Settings/get
ERROR - 2020-05-05 20:34:03 --> 404 Page Not Found: Settings/get
ERROR - 2020-05-05 20:38:19 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-05 20:38:49 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-05 20:39:08 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-05 20:40:15 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-05 20:42:08 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 20
ERROR - 2020-05-05 20:42:08 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-05 20:43:44 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 20:43:44 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 20:44:08 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-05 20:44:17 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 20:44:18 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 20:48:23 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 20:48:23 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 20:52:45 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 20:52:45 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 20:53:01 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-05 20:53:25 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 20:53:25 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 20:53:44 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 20:53:45 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 20:54:17 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 20:54:17 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 20:54:26 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-05-05 20:54:36 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 20:54:36 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 20:55:51 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 20:55:51 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-05-05 22:26:26 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-05-05 22:26:26 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-05-05 22:26:26 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-05-05 22:39:08 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 20
ERROR - 2020-05-05 22:39:08 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-05 22:39:15 --> 404 Page Not Found: Settings/get
ERROR - 2020-05-05 22:39:35 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 20
ERROR - 2020-05-05 22:39:35 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-05 23:02:50 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-05-05 23:02:50 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 20
