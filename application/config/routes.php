<?php
defined('BASEPATH') or exit('No direct script access allowed');


$route['default_controller'] = 'pages';
$route['translate_uri_dashes'] = FALSE;
$route['(:any)'] = 'pages/index';
$route['viewcourse/(:num)'] = 'pages/index';
$route['editcourse/(:num)'] = 'pages/index';
$route['product/(:any)'] = 'pages/index';
$route['user/(:num)'] = 'pages/index';
$route['auth/(:any)'] = 'pages/index';
$route['purchase/(:any)/(:any)'] = 'pages/index';
$route['viewprogram/(:num)'] = 'pages/index';
$route['editprogram/(:num)'] = 'pages/index';
$route['group/(:num)'] = 'pages/index';
