<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$route['default_controller'] = 'pages';
$route['translate_uri_dashes'] = FALSE;
$route['product/(:any)'] = 'pages/index';
$route[':any'] = 'pages/index';

