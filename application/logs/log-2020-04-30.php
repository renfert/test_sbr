<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-04-30 00:37:11 --> Severity: Notice --> Undefined variable: result C:\xampp\htdocs\application\models\Chart_Model.php 31
ERROR - 2020-04-30 00:42:14 --> 404 Page Not Found: Settings/get
ERROR - 2020-04-30 00:46:14 --> 404 Page Not Found: Settings/get
ERROR - 2020-04-30 05:37:03 --> Unable to connect to the database
ERROR - 2020-04-30 05:37:03 --> Unable to connect to the database
ERROR - 2020-04-30 05:37:03 --> Unable to connect to the database
ERROR - 2020-04-30 05:37:03 --> Unable to connect to the database
ERROR - 2020-04-30 05:37:04 --> Unable to connect to the database
ERROR - 2020-04-30 05:37:04 --> Unable to connect to the database
ERROR - 2020-04-30 05:37:04 --> Severity: error --> Exception: Call to a member function errorInfo() on boolean C:\xampp\htdocs\system\database\drivers\pdo\pdo_driver.php 295
ERROR - 2020-04-30 05:37:04 --> Severity: error --> Exception: Call to a member function errorInfo() on boolean C:\xampp\htdocs\system\database\drivers\pdo\pdo_driver.php 295
ERROR - 2020-04-30 05:37:04 --> Severity: error --> Exception: Call to a member function errorInfo() on boolean C:\xampp\htdocs\system\database\drivers\pdo\pdo_driver.php 295
ERROR - 2020-04-30 05:37:04 --> Unable to connect to the database
ERROR - 2020-04-30 05:37:04 --> Unable to connect to the database
ERROR - 2020-04-30 05:37:04 --> Unable to connect to the database
ERROR - 2020-04-30 05:37:04 --> Unable to connect to the database
ERROR - 2020-04-30 05:37:04 --> Severity: error --> Exception: Call to a member function errorInfo() on boolean C:\xampp\htdocs\system\database\drivers\pdo\pdo_driver.php 295
ERROR - 2020-04-30 05:37:04 --> Severity: error --> Exception: Call to a member function errorInfo() on boolean C:\xampp\htdocs\system\database\drivers\pdo\pdo_driver.php 295
ERROR - 2020-04-30 05:37:04 --> Unable to connect to the database
ERROR - 2020-04-30 05:37:04 --> Unable to connect to the database
ERROR - 2020-04-30 05:37:04 --> Severity: error --> Exception: Call to a member function errorInfo() on boolean C:\xampp\htdocs\system\database\drivers\pdo\pdo_driver.php 295
ERROR - 2020-04-30 05:37:07 --> Unable to connect to the database
ERROR - 2020-04-30 05:37:07 --> Unable to connect to the database
ERROR - 2020-04-30 05:37:07 --> Severity: error --> Exception: Call to a member function errorInfo() on boolean C:\xampp\htdocs\system\database\drivers\pdo\pdo_driver.php 295
ERROR - 2020-04-30 05:41:06 --> 404 Page Not Found: Assets/uploads
ERROR - 2020-04-30 05:41:09 --> 404 Page Not Found: Assets/uploads
ERROR - 2020-04-30 05:43:28 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-04-30 05:43:28 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-04-30 05:43:28 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-04-30 05:43:41 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-04-30 05:43:41 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-04-30 05:43:41 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-04-30 05:48:27 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-30 05:48:27 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-30 05:48:36 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-04-30 05:48:46 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-30 05:48:46 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-30 05:49:12 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-04-30 05:49:12 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-04-30 05:49:14 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-04-30 05:49:42 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-30 05:49:42 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-30 05:57:00 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ') as totalCorrectQuestions,

            (SELECT COUNT(DISTINCT T1.id)  FROM r' at line 5 - Invalid query: 
            SELECT(SELECT COUNT(DISTINCT T1.id) from relationship T0 
            INNER JOIN question T1 ON T0.question_id = T1.id 
            WHERE T0.mylesson_id = 3 AND  T1.id !=1) AS totalQuestions,
            
            (SELECT COUNT(DISTINCT T1.id) FROM relationship T0 INNER JOIN question T1 on T0.question_id = T1.id INNER JOIN users_answers T2 ON T1.id = T2.question_id WHERE T0.mylesson_id = 3 AND T1.id != 1 AND T2.score = 100 AND T2.myuser_id =   ) as totalCorrectQuestions,

            (SELECT COUNT(DISTINCT T1.id)  FROM relationship T0 
            INNER JOIN question T1 ON T0.question_id = T1.id
            INNER JOIN users_answers T2 ON T1.id = T2.question_id
            WHERE T0.mylesson_id = 3 AND T1.id != 1 AND T2.score = 0 AND T2.myuser_id =   ) as totalWrongQuestions,
            
            (SELECT COUNT(DISTINCT T1.id)  FROM relationship T0 
            INNER JOIN question T1 ON T0.question_id = T1.id
            INNER JOIN users_answers T2 ON T1.id = T2.question_id
            WHERE T0.mylesson_id = 3 AND T1.id != 1 AND T2.score > 50 AND T2.myuser_id =   ) as totalAboveAverageQuestions,
            
            (SELECT COUNT(DISTINCT T1.id)  FROM relationship T0 
            INNER JOIN question T1 ON T0.question_id = T1.id
            INNER JOIN users_answers T2 ON T1.id = T2.question_id
            WHERE T0.mylesson_id = 3 AND T1.id != 1 AND T2.score < 50 AND T2.score IS NOT NULL AND T2.myuser_id =   ) as totalBelowAverageQuestions,
            
            (SELECT COUNT(DISTINCT T1.id)  FROM relationship T0 
            INNER JOIN question T1 ON T0.question_id = T1.id
            INNER JOIN users_answers T2 ON T1.id = T2.question_id
            WHERE T0.mylesson_id = 3 AND T1.id != 1 AND T2.score IS NULL AND T2.myuser_id =   ) as waitingEvaluationQuestions,

            (SELECT DISTINCT score FROM lesson_status WHERE myuser_id =  AND mylesson_id = 3) as yourScore
        
ERROR - 2020-04-30 05:57:00 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Exam_Model.php 42
ERROR - 2020-04-30 05:58:06 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near ') as totalCorrectQuestions,

            (SELECT COUNT(DISTINCT T1.id)  FROM r' at line 5 - Invalid query: 
            SELECT(SELECT COUNT(DISTINCT T1.id) from relationship T0 
            INNER JOIN question T1 ON T0.question_id = T1.id 
            WHERE T0.mylesson_id = 3 AND  T1.id !=1) AS totalQuestions,
            
            (SELECT COUNT(DISTINCT T1.id) FROM relationship T0 INNER JOIN question T1 on T0.question_id = T1.id INNER JOIN users_answers T2 ON T1.id = T2.question_id WHERE T0.mylesson_id = 3 AND T1.id != 1 AND T2.score = 100 AND T2.myuser_id =   ) as totalCorrectQuestions,

            (SELECT COUNT(DISTINCT T1.id)  FROM relationship T0 
            INNER JOIN question T1 ON T0.question_id = T1.id
            INNER JOIN users_answers T2 ON T1.id = T2.question_id
            WHERE T0.mylesson_id = 3 AND T1.id != 1 AND T2.score = 0 AND T2.myuser_id =   ) as totalWrongQuestions,
            
            (SELECT COUNT(DISTINCT T1.id)  FROM relationship T0 
            INNER JOIN question T1 ON T0.question_id = T1.id
            INNER JOIN users_answers T2 ON T1.id = T2.question_id
            WHERE T0.mylesson_id = 3 AND T1.id != 1 AND T2.score > 50 AND T2.myuser_id =   ) as totalAboveAverageQuestions,
            
            (SELECT COUNT(DISTINCT T1.id)  FROM relationship T0 
            INNER JOIN question T1 ON T0.question_id = T1.id
            INNER JOIN users_answers T2 ON T1.id = T2.question_id
            WHERE T0.mylesson_id = 3 AND T1.id != 1 AND T2.score < 50 AND T2.score IS NOT NULL AND T2.myuser_id =   ) as totalBelowAverageQuestions,
            
            (SELECT COUNT(DISTINCT T1.id)  FROM relationship T0 
            INNER JOIN question T1 ON T0.question_id = T1.id
            INNER JOIN users_answers T2 ON T1.id = T2.question_id
            WHERE T0.mylesson_id = 3 AND T1.id != 1 AND T2.score IS NULL AND T2.myuser_id =   ) as waitingEvaluationQuestions,

            (SELECT DISTINCT score FROM lesson_status WHERE myuser_id =  AND mylesson_id = 3) as yourScore
        
ERROR - 2020-04-30 05:58:06 --> Severity: error --> Exception: Call to a member function num_rows() on boolean C:\xampp\htdocs\application\models\Exam_Model.php 42
ERROR - 2020-04-30 16:37:35 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-04-30 16:37:35 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-04-30 16:37:35 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-04-30 16:37:53 --> Severity: Notice --> Undefined variable: userName C:\xampp\htdocs\application\views\email\register.php 105
ERROR - 2020-04-30 16:37:53 --> Severity: Notice --> Undefined variable: userEmail C:\xampp\htdocs\application\views\email\register.php 127
ERROR - 2020-04-30 16:37:53 --> Severity: Notice --> Undefined variable: pass C:\xampp\htdocs\application\views\email\register.php 128
ERROR - 2020-04-30 17:24:19 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-30 17:24:19 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-30 17:24:30 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Module_Model.php 58
ERROR - 2020-04-30 17:24:41 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-30 17:24:41 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-30 17:25:11 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-04-30 17:25:11 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-04-30 17:25:13 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\application\models\Answer_Model.php 69
ERROR - 2020-04-30 17:25:43 --> Severity: Notice --> Undefined variable: file C:\xampp\htdocs\application\controllers\Upload.php 24
ERROR - 2020-04-30 17:25:43 --> Severity: Notice --> Undefined index:  C:\xampp\htdocs\application\controllers\Upload.php 24
