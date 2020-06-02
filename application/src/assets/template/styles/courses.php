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
7. Courses
8. Sidebar
9. Newsletter
10. Footer



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
	color: #<?php echo $color; ?>;;
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
	font-family: 'Poppins', sans-serif;
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
	color: #<?php echo $color; ?>;;
}
.main_nav li.active::after
{
	display: block;
	position: absolute;
	bottom: -2px;
	left: 0;
	width: 100%;
	height: 2px;
	background: #<?php echo $color; ?>;;
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
	color: #<?php echo $color; ?>;;
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
	background: #<?php echo $color; ?>;;
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
	color: #<?php echo $color; ?>;;
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
	color: #<?php echo $color; ?>;;
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
	line-height: 0.75;
}
.section_subtitle
{
	line-height: 1.85;
	margin-top: 22px;
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
	color: #<?php echo $color; ?>;;
}

/*********************************
7. Courses
*********************************/

.courses
{
	width: 100%;
	padding-top: 100px;
	padding-bottom: 100px;
}
.courses_search_container
{
	padding-left: 20px;
	padding-right: 20px;
	background: #f2f4f5;
}
.courses_search_form
{
	width: 100%;
	height: 92px;
}
.courses_search_input
{
	width: 240px;
	height: 46px;
	border: solid 1px #d9d9d9;
	border-radius: 3px;
	background: #FFFFFF;
	padding-left: 20px;
}
.courses_search_input:focus
{
	outline: solid 1px #<?php echo $color; ?>;;
}
.courses_search_form > input
{
	margin-right: 19px;
}
.courses_search_select
{
	position: relative;
	-webkit-appearance: none;
    -moz-appearance: none;
    -ms-appearance: none;
    -o-appearance: none;
    appearance: none;
    -webkit-box-shadow: 0px 0px 0px rgba(0, 0, 0, 0);
	-webkit-user-select: none;
	background-image: url(../images/down.png);
	background-position: center right;
	background-repeat: no-repeat;
	cursor: pointer;
}
.courses_search_button
{
	width: 161px;
	height: 46px;
	background: #<?php echo $color; ?>;;
	color: #FFFFFF;
	font-size: 14px;
	font-weight: 500;
	text-transform: uppercase;
	border: none;
	outline: none;
	border-radius: 3px;
	cursor: pointer;
}
.courses_row
{
	margin-top: 25px;
}
.course_col
{
	margin-bottom: 51px;
}
.course
{
	width: 100%;
	border-radius: 6px;
	background: #FFFFFF;
	box-shadow: 0px 1px 10px rgba(29,34,47,0.1);
}
.course_col:nth-child(odd)
{
	padding-right: 30px;
}
.course_col:nth-child(even)
{
	padding-left: 30px;
}
.course_image
{
	width: 100%;
	border-top-left-radius: 6px;
	border-top-right-radius: 6px;
	overflow: hidden;
}
.course_image img
{
	max-width: 100%;
}
.course_body
{
	padding-top: 22px;
	padding-left: 30px;
	padding-right: 30px;
	padding-bottom: 23px;
}
.course_title
{

}
.course_title a
{
	font-family: 'Roboto Slab', serif;
	font-size: 20px;
	color: #384158;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.course_title a:hover
{
	color: #<?php echo $color; ?>;
}
.course_teacher
{
	font-size: 15px;
	font-weight: 400;
	color: #384158;
	margin-top: 6px;
}
.course_text
{
	margin-top: 13px;
}
.course_footer
{
	padding-left: 30px;
	padding-right: 30px;
}
.course_footer_content
{
	width: 100%;
	border-top: solid 1px #e5e5e5;
	padding-top: 9px;
	padding-bottom: 11px;
}
.course_info
{
	display: inline-block;
	font-size: 14px;
	font-weight: 400;
	color: #55555a;
}
.course_info:first-child
{
	margin-right: 18px;
}
.course_info i
{
	color: #ffc80a;
}
.course_price
{
	font-family: 'Roboto Slab', serif;
	font-size: 20px;
	font-weight: 700;
	color: #<?php echo $color; ?>;
}
.course_price span
{
	font-family: 'Roboto Slab', serif;
	font-size: 14px;
	font-weight: 400;
	text-decoration: line-through;
	color: #b5b8be;
	margin-right: 10px;
}
.courses_button
{
	width: 210px;
	height: 46px;
	border-radius: 3px;
	background: #<?php echo $color; ?>;
	text-align: center;
	margin: 0 auto;
	margin-top: 41px;
	box-shadow: 0px 5px 40px rgba(29,34,47,0.15);
}
.courses_button:hover
{
	box-shadow: 0px 5px 40px rgba(29,34,47,0.45);
}
.courses_button a
{
	display: block;
	font-size: 14px;
	font-weight: 500;
	text-transform: uppercase;
	line-height: 46px;
	color: #FFFFFF;
}
.pagination_row
{
	margin-top: 11px;
}
.pagination_container
{

}
.pagination_list li
{
	display: inline-block;
	width: 40px;
	height: 40px;
	background: #FFFFFF;
	border: solid 1px #ebebeb;
	text-align: center;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.pagination_list li:not(:last-child)
{
	margin-right: 5px;
}
.pagination_list li:hover,
.pagination_list li.active
{
	background: #<?php echo $color; ?>;
}
.pagination_list li a
{
	display: block;
	position: relative;
	font-size: 16px;
	font-weight: 400;
	color: #757686;
	line-height: 40px;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.pagination_list li:hover a,
.pagination_list li.active a
{
	color: #FFFFFF;
}
.courses_show_text
{
	display: inline-block;
}
.courses_show_content
{
	display: inline-block;
	width: 144px;
	border: solid 1px #ecedee;
}
.courses_show_content span
{
	line-height: 40px;
	padding-left: 20px;
	font-size: 16px;
	color: #384158;
}
.courses_show_text
{
	font-size: 16px;
	font-weight: 400;
	color: #384158;
	margin-right: 16px;
}
.courses_show_select
{
	position: relative;
	float: right;
	width: 50px;
	height: 40px;
	-webkit-appearance: none;
    -moz-appearance: none;
    -ms-appearance: none;
    -o-appearance: none;
    appearance: none;
    -webkit-box-shadow: 0px 0px 0px rgba(0, 0, 0, 0);
	-webkit-user-select: none;
	background-image: url(../images/down.png);
	background-position: center right;
	background-repeat: no-repeat;
	cursor: pointer;
	font-size: 16px;
	color: #384158;
	border: none;
	outline: none;
}
.courses_show_select option
{
	padding-left: 20px;
	text-align: right;
}

/*********************************
8. Sidebar
*********************************/

.sidebar
{
	width: 100%;
	padding-left: 40px;
}
.sidebar_section:not(:last-child)
{
	margin-bottom: 60px;
}
.sidebar_section_title
{
	font-family: 'Roboto Slab', serif;
	font-size: 24px;
	font-weight: 700;
	color: #384158;
	line-height: 0.75;
}
.sidebar_categories
{
	margin-top: 16px;
}
.sidebar_categories ul li
{
	position: relative;
	width: 100%;
	height: 51px;
}
.sidebar_categories ul li:not(:last-of-type)
{
	border-bottom: solid 1px #e5e5e5;
}
.sidebar_categories ul li a
{
	display: block;
	position: relative;
	font-size: 14px;
	color: #76777a;
	line-height: 51px;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.sidebar_categories ul li a::before
{
	display: inline-block;
	position: relative;
	font-family: 'FontAwesome';
	content: '\f101';
	margin-right: 4px;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.sidebar_categories ul li:hover a,
.sidebar_categories ul li:hover a::before
{
	color: #<?php echo $color; ?>;
}
.sidebar_latest
{
	margin-top: 31px;
}
.latest:not(:last-child)
{
	margin-bottom: 20px;
}
.latest_image div
{
	width: 90px;
	height: 74px;
	border-radius: 3px;
	overflow: hidden;
}
.latest_image div img
{
	max-width: 100%;
}
.latest_content
{
	padding-left: 21px;
	margin-top: -4px;
}
.latest_title a
{
	font-family: 'Roboto Slab', serif;
	font-size: 16px;
	font-weight: 700;
	color: #383749;
	line-height: 1.625;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.latest_title a:hover
{
	color: #<?php echo $color; ?>;
}
.latest_price
{
	font-family: 'Roboto Slab', serif;
	font-size: 14px;
	font-weight: 700;
	color: #<?php echo $color; ?>;
	line-height: 0.75;
	margin-top: 16px;
}
.sidebar_gallery
{
	margin-top: 34px;
}
.gallery_item
{
	position: relative;
	width: calc((100% - 36px) / 3);
	margin-bottom: 18px;
	cursor: pointer;
}
.gallery_item img
{
	width: 100%;
}
.gallery_item_overlay
{
	display: block;
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(20,189,238,0.7);
	opacity: 0;
	pointer-events: none;
	font-size: 33px;
	font-weight: 300;
	color: #FFFFFF;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.gallery_item:hover .gallery_item_overlay
{
	opacity: 1;
}
.colorbox
{
	outline: none;
}
.sidebar_tags
{
	margin-top: 40px;
}
.tags_list li
{
	display: inline-block;
	padding-left: 19px;
	padding-right: 18px;
	background: #f2f4f5;
	border-radius: 3px;
	margin-bottom: 10px;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.tags_list li:not(:last-child)
{
	margin-right: 5px;
}
.tags_list li:hover
{
	background: #<?php echo $color; ?>;
}
.tags_list li:hover a
{
	color: #FFFFFF;
}
.tags_list li a
{
	display: block;
	font-size: 12px;
	color: #76777a;
	text-transform: uppercase;
	line-height: 30px;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.sidebar_banner
{
	width: 100%;
	height: 213px;
}
.sidebar_banner_background
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
.sidebar_banner_overlay
{
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: #<?php echo $color; ?>;
	opacity: 0.7;
}
.banner_title
{
	font-family: 'Roboto Slab', serif;
	font-size: 20px;
	font-weight: 700;
	color: #FFFFFF;
	line-height: 0.75;
}
.banner_button
{
	width: 200px;
	height: 46px;
	background: #FFFFFF;
	border-radius: 3px;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.banner_button a
{
	display: block;
	color: #<?php echo $color; ?>;
	font-size: 14px;
	font-weight: 400;
	letter-spacing: 0.1em;
	margin-left: -0.1em;
	text-transform: uppercase;
	line-height: 46px;
	margin-top: 21px;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.banner_button:hover
{
	background: #<?php echo $color; ?>;
}
.banner_button:hover a
{
	color: #FFFFFF;
}

/*********************************
9. Newsletter
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
10. Footer
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

.validate.valid{
	color: #3c763d !important; 
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