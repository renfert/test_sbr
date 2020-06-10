<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'pages';
$route['404_override'] = 'pages/notfound';
$route['translate_uri_dashes'] = FALSE;

$route['pages/product/process'] = 'payment/process';



$route['dashboard'] = 'pages/dashboard';
$route['categories'] = 'pages/categories';
$route['certificates'] = 'pages/certificates';
$route['corrections'] = 'pages/corrections';
$route['courses'] = 'pages/courses';
$route['groups'] = 'pages/groups';
$route['helpcenter'] = 'pages/helpcenter';
$route['index'] = 'pages/index';
$route['integrations'] = 'pages/integrations';
$route['leads'] = 'pages/leads';
$route['newcourse'] = 'pages/newcourse';
$route['newprogram'] = 'pages/newprogram';
$route['plans'] = 'pages/plans';
$route['products'] = 'pages/products';
$route['profile'] = 'pages/profile';
$route['programs'] = 'pages/programs';
$route['viewprogram'] = 'pages/viewprogram';
$route['records'] = 'pages/records';
$route['settings'] = 'pages/settings';
$route['site'] = 'pages/site';
$route['users'] = 'pages/users';
$route['calendar'] = 'pages/calendar';
$route['leads'] = 'pages/leads';

