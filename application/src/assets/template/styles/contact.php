<?php
// Define que o arquivo terá a codificação de saída no formato CSS
header("Content-type: text/css");

$color = $_GET['color']; 

?>

@charset "utf-8";
/* CSS Document */

/******************************

[Table of Contents]

1. Fonts
2. Body and some general stuff
3. Header
	3.1 Top Bar
	3.2 Header Content
	3.3 Logo
	3.4 Main Nav
	3.5 Hamburger
4. Menu
5. Section
6. Home
7. Contact
8. Newsletter
9. Footer



******************************/

/***********
1. Fonts
***********/

@import url(https://fonts.googleapis.com/css?family=Nunito|Nunito+Sans|Poppins&display=swap);
@import url('https://fonts.googleapis.com/css?family=Roboto+Slab:400,700|Roboto:300,400,500,700,900');

/*********************************
2. Body and some general stuff
*********************************/

*
{
	margin: 0;
	padding: 0;
	-webkit-font-smoothing: antialiased;
	-webkit-text-shadow: rgba(0,0,0,.01) 0 0 1px;
	text-shadow: rgba(0,0,0,.01) 0 0 1px;
}
body
{
	font-family: 'Poppins', sans-serif;
	font-size: 14px;
	font-weight: 400;
	background: #FFFFFF;
	color: #a5a5a5;
}
div
{
	display: block;
	position: relative;
	-webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
ul
{
	list-style: none;
	margin-bottom: 0px;
}
p
{
	font-family: 'Roboto', sans-serif;
	font-size: 14px;
	line-height: 1.85;
	font-weight: 400;
	color: #76777a;
	-webkit-font-smoothing: antialiased;
	-webkit-text-shadow: rgba(0,0,0,.01) 0 0 1px;
	text-shadow: rgba(0,0,0,.01) 0 0 1px;
}
p a
{
	display: inline;
	position: relative;
	color: inherit;
	border-bottom: solid 1px #ffa07f;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
p:last-of-type
{
	margin-bottom: 0;
}
a, a:hover, a:visited, a:active, a:link
{
	text-decoration: none;
	-webkit-font-smoothing: antialiased;
	-webkit-text-shadow: rgba(0,0,0,.01) 0 0 1px;
	text-shadow: rgba(0,0,0,.01) 0 0 1px;
}
p a:active
{
	position: relative;
	color: #FF6347;
}
p a:hover
{
	color: #FFFFFF;
	background: #ffa07f;
}
p a:hover::after
{
	opacity: 0.2;
}
::selection
{
	
}
p::selection
{
	
}
h1{font-size: 48px;}
h2{font-size: 36px;}
h3{font-size: 24px;}
h4{font-size: 18px;}
h5{font-size: 14px;}
h1, h2, h3, h4, h5, h6
{
	font-family: 'Roboto Slab', serif;
	font-weight: 700;
	-webkit-font-smoothing: antialiased;
	-webkit-text-shadow: rgba(0,0,0,.01) 0 0 1px;
	text-shadow: rgba(0,0,0,.01) 0 0 1px;
	color: #384158;
	margin-bottom: 0;
}
h1::selection, 
h2::selection, 
h3::selection, 
h4::selection, 
h5::selection, 
h6::selection
{
	
}
.form-control
{
	color: #db5246;
}
section
{
	display: block;
	position: relative;
	box-sizing: border-box;
}
.clear
{
	clear: both;
}
.clearfix::before, .clearfix::after
{
	content: "";
	display: table;
}
.clearfix::after
{
	clear: both;
}
.clearfix
{
	zoom: 1;
}
.float_left
{
	float: left;
}
.float_right
{
	float: right;
}
.trans_200
{
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.trans_300
{
	-webkit-transition: all 300ms ease;
	-moz-transition: all 300ms ease;
	-ms-transition: all 300ms ease;
	-o-transition: all 300ms ease;
	transition: all 300ms ease;
}
.trans_400
{
	-webkit-transition: all 400ms ease;
	-moz-transition: all 400ms ease;
	-ms-transition: all 400ms ease;
	-o-transition: all 400ms ease;
	transition: all 400ms ease;
}
.trans_500
{
	-webkit-transition: all 500ms ease;
	-moz-transition: all 500ms ease;
	-ms-transition: all 500ms ease;
	-o-transition: all 500ms ease;
	transition: all 500ms ease;
}
.fill_height
{
	height: 100%;
}
.super_container
{
	width: 100%;
	overflow: hidden;
}
.prlx_parent
{
	overflow: hidden;
}
.prlx
{
	height: 130% !important;
}
.parallax-window
{
    min-height: 400px;
    background: transparent;
}
.nopadding
{
	padding: 0px !important;
}

/*********************************
3. Header
*********************************/

.header
{
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	z-index: 100;
	box-shadow: 0px 5px 20px rgba(0,0,0,0.05);
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.header.scrolled
{
	top: -40px;
}

/*********************************
3.1 Top Bar
*********************************/

.top_bar
{
	width: 100%;
	background: #<?php echo $color; ?>;
}
.header.scrolled .top_bar
{

}
.top_bar_container
{
	width: 100%;
	height: 100%;
}
.top_bar_content
{
	width: 100%;
	height: 40px;
}
.top_bar_contact_list li
{
	display: inline-block;
}
.question
{
	font-family: 'Roboto Slab', serif;
	font-size: 14px;
	color: #FFFFFF;
	margin-left: 0px;
}
.top_bar_contact_list li i,
.top_bar_contact_list li > div
{
	display: inline-block;
	font-size: 14px;
	color: #FFFFFF;
}
.top_bar_contact_list li > div
{
	margin-left: 1px;
}
.top_bar_contact_list li:not(:last-child)
{
	margin-right: 21px;
}
.top_bar_login
{
	height: 100%;
}
.login_button
{
	width: 160px;
	height: 100%;
	background: #f3f3f3;
	text-align: center;
}
.login_button a
{
	display: block;
	font-size: 14px;
	font-weight: 500;
	line-height: 40px;
	color: #384158;
}

/*********************************
3.2 Header Content
*********************************/

.header_container
{
	width: 100%;
	background: #FFFFFF;
}
.header_content
{
	height: 90px;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.header.scrolled .header_content
{
	height: 80px;
}

/*********************************
3.3 Logo
*********************************/

.logo,
.logo_text
{
	display: inline-block;
}
.logo
{
	width: 60px;
	height: 60px;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.logo img
{
	max-width: 100%;
}
.logo_text
{
	font-family: 'Roboto Slab', serif;
	font-size: 36px;
	font-weight: 700;
	line-height: 0.75;
	color: #384158;
	vertical-align: middle;
	margin-left: 4px;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.logo_text span
{
	color: #<?php echo $color; ?>;
}
.header.scrolled .logo
{
	width: 40px;
	height: 40px;
}
.header.scrolled .logo_text
{
	font-size: 24px;
}

/*********************************
3.4 Main Nav
*********************************/

.main_nav_contaner
{

}
.main_nav,
.search_button,
.shopping_cart
{
	display: inline-block;
}
.main_nav li
{
	display: inline-block;
	position: relative;
}
.main_nav li:not(:last-child)
{
	margin-right: 44px;
}
.main_nav li a
{
	font-size: 18px;
	font-weight: 500;
	color: #384158;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.main_nav li a:hover,
.main_nav li.active a
{
	color: #<?php echo $color; ?>;
}
.main_nav li.active::after
{
	display: block;
	position: absolute;
	bottom: -2px;
	left: 0;
	width: 100%;
	height: 2px;
	background: #<?php echo $color; ?>;
	content: '';
}
.search_button
{
	margin-left: 46px;
	cursor: pointer;
}
.shopping_cart
{
	margin-left: 23px;
	cursor: pointer;
}
.search_button i,
.shopping_cart i
{
	font-size: 18px;
	color: #181818;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.search_button:hover i,
.shopping_cart:hover i
{
	color: #<?php echo $color; ?>;
}
.header_search_form
{
	display: block;
	position: relative;
	width: 40%;
}
.header_search_container
{
	position: absolute;
	bottom: 0px;
	left: 0px;
	width: 100%;
	background: #<?php echo $color; ?>;
	z-index: -1;
	opacity: 0;
	-webkit-transition: all 400ms ease;
	-moz-transition: all 400ms ease;
	-ms-transition: all 400ms ease;
	-o-transition: all 400ms ease;
	transition: all 400ms ease;
}
.header_search_container.active
{
	bottom: -73px;
	opacity: 1;
}
.header_search_content
{
	width: 100%;
	height: 73px;
}
.search_input
{
	width: 100%;
	height: 40px;
	border: none;
	outline: none;
	padding-left: 20px;
}
.header_search_button
{
	position: absolute;
	top: 0;
	right: 0;
	width: 40px;
	height: 100%;
	border: none;
	outline: none;
	cursor: pointer;
}

/*********************************
3.5 Hamburger
*********************************/

.hamburger_container
{

}
.hamburger
{
	display: none;
	cursor: pointer;
}
.hamburger i
{
	font-size: 20px;
	color: #353535;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.hamburger:hover i
{
	color: #<?php echo $color; ?>;
}

/*********************************
4. Menu
*********************************/

.menu
{
	position: fixed;
	top: 0;
	right: -400px;
	width: 400px;
	height: 100vh;
	background: #FFFFFF;
	z-index: 101;
	padding-right: 60px;
	padding-top: 87px;
	padding-left: 50px;
}
.menu .logo a
{
	color: #000000;
}
.menu.active
{
	right: 0;
}
.menu_close_container
{
	position: absolute;
	top: 30px;
	right: 60px;
	width: 18px;
	height: 18px;
	transform-origin: center center;
	-webkit-transform: rotate(45deg);
	-moz-transform: rotate(45deg);
	-ms-transform: rotate(45deg);
	-o-transform: rotate(45deg);
	transform: rotate(45deg);
	cursor: pointer;
}
.menu_close
{
	width: 100%;
	height: 100%;
	transform-style: preserve-3D;
}
.menu_close div
{
	width: 100%;
	height: 2px;
	background: #232323;
	top: 8px;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.menu_close div:last-of-type
{
	-webkit-transform: rotate(90deg) translateX(-2px);
	-moz-transform: rotate(90deg) translateX(-2px);
	-ms-transform: rotate(90deg) translateX(-2px);
	-o-transform: rotate(90deg) translateX(-2px);
	transform: rotate(90deg) translateX(-2px);
	transform-origin: center;
}
.menu_close:hover div
{
	background: #937c6f;
}
.menu .logo
{
	margin-bottom: 60px;
}
.menu_nav ul li
{
	margin-bottom: 9px;
}
.menu_nav ul li a
{
	font-family: 'Roboto', sans-serif;
	font-size: 14px;
	text-transform: uppercase;
	color: rgba(0,0,0,1);
	font-weight: 700;
	letter-spacing: 0.1em;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.menu_nav ul li a:hover
{
	color: #<?php echo $color; ?>;
}
.menu .search
{
	width: 100%;
	margin-bottom: 67px;
}
.search
{
	display: inline-block;
	width: 400px;
	-webkit-transform: translateY(2px);
	-moz-transform: translateY(2px);
	-ms-transform: translateY(2px);
	-o-transform: translateY(2px);
	transform: translateY(2px);
}
.menu .header_search_form
{
	width: 100%;
}
.search form
{
	position: relative;
}
.menu .search_input
{
	width: 100%;
	height: 40px;
	background: rgba(0,0,0,0.1);
	border-radius: 3px;
	border: none;
	outline: none;
	padding-left: 15px;
	color: rgba(0,0,0,0.5);
}
.menu .search_input::-webkit-input-placeholder
{
	font-family: 'Roboto', sans-serif;
	font-size: 14px !important;
	font-weight: 400 !important;
	color: rgba(0,0,0,0.4) !important;
}
.menu .search_input:-moz-placeholder
{
	font-family: 'Roboto', sans-serif;
	font-size: 14px !important;
	font-weight: 400 !important;
	color: rgba(0,0,0,0.4) !important;
}
.menu .search_input::-moz-placeholder
{
	font-family: 'Roboto', sans-serif;
	font-size: 14px !important;
	font-weight: 400 !important;
	color: rgba(0,0,0,0.4) !important;
} 
.menu .search_input:-ms-input-placeholder
{ 
	font-family: 'Roboto', sans-serif;
	font-size: 14px !important;
	font-weight: 400 !important;
	color: rgba(0,0,0,0.4) !important;
}
.menu .search_input::input-placeholder
{
	font-family: 'Roboto', sans-serif;
	font-size: 14px !important;
	font-weight: 400 !important;
	color: rgba(0,0,0,0.4) !important;
}

/*********************************
5. Section
*********************************/

.section_title_container
{
	max-width: 600px;
	margin: 0 auto;
}
.section_title
{
	line-height: 1.2;
}
.section_subtitle
{
	line-height: 1.85;
	margin-top: 14px;
}
.section_background
{
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
}

/*********************************
6. Home
*********************************/

.home
{
	width: 100%;
	height: 182px;
	background: #f2f4f5;
	border-bottom: solid 1px #edeff0;
}
.breadcrumbs_container
{
	position: absolute;
	left: 0;
	bottom: 0;
	width: 100%;
	padding-bottom: 13px;
	padding-left: 3px;
}
.breadcrumbs ul li
{
	display: inline-block;
	position: relative;
}
.breadcrumbs ul li:not(:last-child)::after
{
	display: inline-block;
	font-family: 'FontAwesome';
	content: '\f105';
	margin-left: 7px;
	margin-right: 4px;
	color: #384158;
}
.breadcrumbs ul li a
{
	font-size: 14px;
	font-weight: 400;
	color: #384158;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.breadcrumbs ul li a:hover
{
	color: #<?php echo $color; ?>;
}

/*********************************
7. Contact
*********************************/

.contact
{
	width: 100%;
	padding-bottom: 100px;
}
.contact_map
{
	width: 100%;
}
.map
{
	width: 100%;
}
.google_map
{
	width: 100%;
	height: 500px;
}
.map_container
{
	width: 100%;
	height: 100%;
	overflow: hidden;
}
#map
{
	width: 100%;
	height: calc(100% + 30px);
}
#content
{
	width: 180px;
	padding-left: 20px;
	padding-top: 20px;
	padding-bottom: 20px;
	font-family: 'Roboto', sans-serif;
	font-size: 14px;
	color: #76777a;
	line-height: 1.71;
}
.contact_info_container
{
	margin-top: 100px;
}
.contact_info_title
{
	font-family: 'Roboto Slab', serif;
	font-size: 36px;
	font-weight: 700;
	color: #384158;
}
.contact_form
{
	padding-right: 10px;
}
.comment_form
{
	margin-top: 35px;
}
.comment_input
{
	width: 100%;
	height: 46px;
	border: solid 1px #d9d9d9;
	border-radius: 3px;
	padding-left: 19px;
	font-size: 16px;
	font-weight: 400;
	color: #2c3145;
}
.comment_form > div:not(:last-child)
{
	margin-bottom: 25px;
}
.comment_input:focus
{
	border: solid 1px #<?php echo $color; ?>;
	outline: none;
}
.comment_textarea
{
	width: 100%;
	height: 150px;
	padding-top: 15px;
}
.form_title
{
	font-size: 16px;
	font-weight: 400;
	color: #384158;
	margin-bottom: 12px;
}
.comment_button
{
	width: 150px;
	height: 46px;
	background: #<?php echo $color; ?>;
	text-transform: uppercase;
	font-size: 14px;
	font-weight: 500;
	color: #FFFFFF;
	cursor: pointer;
	border: none;
	outline: none;
	border-radius: 3px;
	margin-top: 15px;
}
.comment_button:hover
{
	box-shadow: 0px 5px 40px rgba(0,0,0,0.25);
}
.contact_info
{
	padding-left: 45px;
}
.contact_info_text
{
	margin-top: 27px;
}
.contact_info_location
{
	margin-top: 28px;
}
.contact_info_location_title
{
	font-family: 'Roboto Slab', serif;
	font-size: 18px;
	font-weight: 700;
	color: #384158;
}
.location_list
{
	margin-top: 14px;
}
.location_list li
{
	font-size: 14px;
	color: #5e6271;
}
.location_list li:not(:last-child)
{
	margin-bottom: 9px;
}

/*********************************
8. Newsletter
*********************************/

.newsletter
{
	width: 100%;
}
.newsletter_background
{
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background-repeat: no-repeat;
	background-size: cover;
	background-position: center center;
}
.newsletter_container
{
	width: 100%;
	height: 120px;
}
.newsletter_title
{
	font-family: 'Roboto Slab', serif;
	font-size: 20px;
	font-weight: 700;
	text-transform: uppercase;
	color: #FFFFFF;
}
.newsletter_subtitle
{
	font-size: 14px;
	font-weight: 400;
	color: #FFFFFF;
	margin-top: 6px;
}
.newsletter_form_container
{
	width: 450px;
	padding-left: 20px;
}
.newsletter_form
{
	display: block;
	position: relative;
	width: 100%;
}
.newsletter_input
{
	width: calc(100% - 136px);
	height: 40px;
	background: rgba(255,255,255,0.4);
	border: none;
	outline: none;
	padding-left: 20px;
	color: #FFFFFF;
	border-top-left-radius: 3px;
	border-bottom-left-radius: 3px;
}
.newsletter_input::-webkit-input-placeholder
{
	font-size: 14px !important;
	font-weight: 400 !important;
	color: #FFFFFF !important;
}
.newsletter_input:-moz-placeholder
{
	font-size: 14px !important;
	font-weight: 400 !important;
	color: #FFFFFF !important;
}
.newsletter_input::-moz-placeholder
{
	font-size: 14px !important;
	font-weight: 400 !important;
	color: #FFFFFF !important;
} 
.newsletter_input:-ms-input-placeholder
{ 
	font-size: 14px !important;
	font-weight: 400 !important;
	color: #FFFFFF !important;
}
.newsletter_input::input-placeholder
{
	font-size: 14px !important;
	font-weight: 400 !important;
	color: #FFFFFF !important;
}
.newsletter_button
{
	width: 136px;
	height: 40px;
	background: #FFFFFF;
	border-radius: 3px;
	border: none;
	outline: none;
	cursor: pointer;
	font-size: 14px;
	text-transform: uppercase;
	color: #<?php echo $color; ?>;
	font-weight: 500;
	letter-spacing: 0.1em;
}

/*********************************
9. Footer
*********************************/

.footer
{
	display: block;
	position: relative;
	width: 100%;
	background: #1e2434;
	padding-top: 94px;
}
.footer_background
{
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background-repeat: no-repeat;
	background-size: cover;
	background-position: center center;
}
.footer_content
{
	padding-bottom: 53px;
}
.footer_logo_text
{
	font-family: 'Roboto Slab', serif;
	font-size: 36px;
	font-weight: 700;
	line-height: 0.75;
	color: #FFFFFF;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.footer_logo_text span
{
	color: #<?php echo $color; ?>;
}
.footer_title
{
	font-family: 'Roboto Slab', serif;
	font-size: 18px;
	font-weight: 700;
	color: #FFFFFF;
	line-height: 0.75;
}
.footer_logo_container
{
	margin-top: -14px;
}
.footer_about_text
{
	margin-top: 31px;
}
.footer_about_text p
{
	color: #FFFFFF;
}
.footer_social
{
	margin-top: 23px;
}
.footer_social ul li
{
	display: inline-block;
	width: 45px;
	height: 45px;
	background: #4b505d;
	border-radius: 50%;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.footer_social ul li:not(:last-child)
{
	margin-right: 6px;
}
.footer_social ul li a
{
	display: block;
	position: relative;
	text-align: center;
}
.footer_social ul li a i
{
	color: #FFFFFF;
	line-height: 45px;
}
.footer_social ul li:hover
{
	background: #<?php echo $color; ?>;
}
.footer_contact
{
	padding-left: 36px;
}
.footer_contact_info
{
	margin-top: 33px;
}
.footer_contact_info ul li
{
	font-size: 14px;
	font-weight: 400;
	color: #b5b8be;
}
.footer_contact_info ul li:not(:last-child)
{
	margin-bottom: 15px;
}
.footer_links
{
	padding-left: 80px;
}
.footer_links_container ul
{
	columns: 2;
	-webkit-columns: 2;
	-moz-columns: 2;
}
.footer_links_container
{
	margin-top: 33px;
}
.footer_links_container ul li a
{
	font-size: 14px;
	color: #b5b8be;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.footer_links_container ul li:not(:last-child)
{
	margin-bottom: 15px;
}
.footer_links_container ul li a:hover
{
	color: #<?php echo $color; ?>;
}
.footer_mobile
{
	display: inline-block;
	float: right;
}
.footer_mobile_content
{
	padding-top: 35px;
}
.footer_image:not(:last-child)
{
	margin-bottom: 10px;
}
.copyright
{
	height: 54px;
	border-top: solid 1px #353a49;
}
.cr_list li
{
	display: inline-block;
}
.copyright div
{
	font-size: 14px;
	color: #b5b8be;
}
.cr_text a
{
	color: #FFFFFF;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.cr_text a:hover
{
	color: #<?php echo $color; ?>;
}
.cr_list li:not(:last-child)
{
	margin-right: 50px;
}
.cr_list li a
{
	font-size: 14px;
	color: #b5b8be;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.cr_list li a:hover
{
	color: #<?php echo $color; ?>;
}