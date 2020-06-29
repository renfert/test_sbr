<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-06-17 00:51:19 --> Severity: Notice --> Undefined variable: ssh C:\xampp\htdocs\trial\application\models\Trial_Model.php 170
ERROR - 2020-06-17 00:51:19 --> Severity: error --> Exception: Call to a member function exec() on null C:\xampp\htdocs\trial\application\models\Trial_Model.php 170
ERROR - 2020-06-17 05:09:16 --> Severity: error --> Exception: SQLSTATE[3D000]: Invalid catalog name: 1046 No database selected C:\xampp\htdocs\trial\application\models\Trial_Model.php 1061
ERROR - 2020-06-17 05:58:43 --> Severity: Notice --> Undefined variable: serverName C:\xampp\htdocs\trial\application\models\Trial_Model.php 1008
ERROR - 2020-06-17 05:58:43 --> Severity: Notice --> Undefined variable: password C:\xampp\htdocs\trial\application\models\Trial_Model.php 1008
ERROR - 2020-06-17 05:58:43 --> Severity: Notice --> Undefined variable: conn C:\xampp\htdocs\trial\application\models\Trial_Model.php 1032
ERROR - 2020-06-17 05:58:43 --> Severity: error --> Exception: Call to a member function prepare() on null C:\xampp\htdocs\trial\application\models\Trial_Model.php 1330
ERROR - 2020-06-17 06:00:32 --> Severity: Compile Error --> Redefinition of parameter $userName C:\xampp\htdocs\trial\application\models\Trial_Model.php 1005
ERROR - 2020-06-17 06:02:54 --> Severity: error --> Exception: SQLSTATE[23000]: Integrity constraint violation: 1048 Column 'contact' cannot be null C:\xampp\htdocs\trial\application\models\Trial_Model.php 1338
ERROR - 2020-06-17 18:26:45 --> Severity: Notice --> Undefined variable: data C:\xampp\htdocs\trial\application\views\email\first_email.php 214
ERROR - 2020-06-17 18:26:45 --> Severity: Notice --> Undefined variable: data C:\xampp\htdocs\trial\application\views\email\first_email.php 321
ERROR - 2020-06-17 18:26:45 --> Severity: Notice --> Undefined variable: data C:\xampp\htdocs\trial\application\views\email\first_email.php 322
ERROR - 2020-06-17 18:26:45 --> Severity: Notice --> Undefined variable: data C:\xampp\htdocs\trial\application\views\email\first_email.php 350
ERROR - 2020-06-17 18:36:29 --> Severity: Notice --> Undefined variable: data C:\xampp\htdocs\trial\application\views\email\first_email.php 214
ERROR - 2020-06-17 18:36:29 --> Severity: Notice --> Undefined variable: data C:\xampp\htdocs\trial\application\views\email\first_email.php 321
ERROR - 2020-06-17 18:36:29 --> Severity: Notice --> Undefined variable: data C:\xampp\htdocs\trial\application\views\email\first_email.php 322
ERROR - 2020-06-17 18:36:29 --> Severity: Notice --> Undefined variable: data C:\xampp\htdocs\trial\application\views\email\first_email.php 350
ERROR - 2020-06-17 18:49:47 --> Severity: Notice --> Undefined variable: userPassword C:\xampp\htdocs\trial\application\models\Trial_Model.php 128
ERROR - 2020-06-17 18:49:47 --> Severity: Notice --> Undefined variable: stage C:\xampp\htdocs\trial\application\views\email\new_trial.php 132
ERROR - 2020-06-17 20:50:30 --> Severity: error --> Exception: Call to a member function putObject() on string C:\xampp\htdocs\trial\application\models\Trial_Model.php 117
ERROR - 2020-06-17 20:52:55 --> Severity: error --> Exception: Call to a member function putObject() on string C:\xampp\htdocs\trial\application\models\Trial_Model.php 117
ERROR - 2020-06-17 20:55:44 --> Severity: 4096 --> Object of class Aws\Route53\Route53Client could not be converted to string C:\xampp\htdocs\trial\application\models\Trial_Model.php 128
ERROR - 2020-06-17 20:55:48 --> Severity: error --> Exception: Error executing "PutObject" on "https://sabiorealm.s3.amazonaws.com//"; AWS HTTP error: Client error: `PUT https://sabiorealm.s3.amazonaws.com//` resulted in a `403 Forbidden` response:
<?xml version="1.0" encoding="UTF-8"?>
<Error><Code>AccessDenied</Code><Message>Access Denied</Message><RequestId>D691FB (truncated...)
 AccessDenied (client): Access Denied - <?xml version="1.0" encoding="UTF-8"?>
<Error><Code>AccessDenied</Code><Message>Access Denied</Message><RequestId>D691FBC0D072D3B3</RequestId><HostId>59s4kx+MVyLpvrmZgWGvj05f4dI4BdJJs3XOxEmcqTNpEpCYcsCx0Nby6/xTgqiwD97kFknqDx4=</HostId></Error> C:\xampp\htdocs\trial\application\trial_libraries\Aws\WrappedHttpHandler.php 195
ERROR - 2020-06-17 20:58:57 --> Severity: 4096 --> Object of class Aws\Route53\Route53Client could not be converted to string C:\xampp\htdocs\trial\application\models\Trial_Model.php 129
ERROR - 2020-06-17 20:58:58 --> Severity: error --> Exception: Error executing "PutObject" on "https://sabiorealm.s3.amazonaws.com//"; AWS HTTP error: Client error: `PUT https://sabiorealm.s3.amazonaws.com//` resulted in a `403 Forbidden` response:
<?xml version="1.0" encoding="UTF-8"?>
<Error><Code>AccessDenied</Code><Message>Access Denied</Message><RequestId>495E39 (truncated...)
 AccessDenied (client): Access Denied - <?xml version="1.0" encoding="UTF-8"?>
<Error><Code>AccessDenied</Code><Message>Access Denied</Message><RequestId>495E390F3A9EF79B</RequestId><HostId>StcEgA1ISHHkyQET5Z6qOE4JRrO5gPWzOxhJCYMsYIvlnLxP6LpSOD8e3mCvyjVBzuIoOqYLngM=</HostId></Error> C:\xampp\htdocs\trial\application\trial_libraries\Aws\WrappedHttpHandler.php 195
ERROR - 2020-06-17 21:00:48 --> Severity: error --> Exception: Error executing "PutObject" on "https://sabiorealm.s3.amazonaws.com/teste/"; AWS HTTP error: Client error: `PUT https://sabiorealm.s3.amazonaws.com/teste/` resulted in a `403 Forbidden` response:
<?xml version="1.0" encoding="UTF-8"?>
<Error><Code>AccessDenied</Code><Message>Access Denied</Message><RequestId>42A404 (truncated...)
 AccessDenied (client): Access Denied - <?xml version="1.0" encoding="UTF-8"?>
<Error><Code>AccessDenied</Code><Message>Access Denied</Message><RequestId>42A404017F32B002</RequestId><HostId>AI5l7sPzjnpib/EaMpjYdYbaFBKeVrIHJlmZ+Oh5uCjgmTDcjZR6L6MQWzs+7dJP4vficVinMk4=</HostId></Error> C:\xampp\htdocs\trial\application\trial_libraries\Aws\WrappedHttpHandler.php 195
