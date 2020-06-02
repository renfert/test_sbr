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
7. Features
8. Courses
9. Counter
10. Events
11. Team
12. News
13. Newsletter
14. Footer



******************************/

/***********
1. Fonts
***********/

@import url('https://fonts.googleapis.com/css?family=Roboto+Slab:400,700|Roboto:300,400,500,700,900');
@import url(https://fonts.googleapis.com/css?family=Nunito|Nunito+Sans|Poppins&display=swap);

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
	font-size: 16px;
  	font-weight: 600;
  	font-family: 'Poppins', sans-serif;
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
	font-family: 'Poppins', sans-serif;
	font-size: 15px;
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

}
h1{font-size: 48px;}
h2{font-size: 36px;}
h3{font-size: 24px;}
h4{font-size: 18px;}
h5{font-size: 14px;}
h1, h2, h3, h4, h5, h6
{
 	font-family: 'Poppins', sans-serif;
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
	background: #<?php echo $color; ?>
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
	margin-left: 7px;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.logo_text span
{
	color:#<?php echo $color; ?>;
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
	color:#<?php echo $color; ?>;
}
.main_nav li.active::after
{
	display: block;
	position: absolute;
	bottom: -2px;
	left: 0;
	width: 100%;
	height: 2px;
	background:#<?php echo $color; ?>;
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
	color:#<?php echo $color; ?>;
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
	background: #<?php echo $color; ?>
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
	color:#<?php echo $color; ?>
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
	color: #<?php echo $color; ?>
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



/*********************************
5. Section
*********************************/

.section_title_container
{
	max-width: 600px;
	margin: 0 auto;
	margin-bottom:5%;
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
	height: 850px;
}
.home_slider_container
{
	width: 100%;
	height: 80%;
}
.home_slider
{
	width: 100%;
	height: 100%;
}
.home_slider_background
{
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	max-height: 100%;
	max-width: 100%;
	background-repeat: no-repeat;
	background-size: cover;
	background-position: center center;
}

@media (max-width:960px){
	.home_slider_background
{
	position: absolute;
	top: 20%;
	left: 0;
	width: 100%;
	height: 100%;
	max-height: 100%;
	max-width: 100%;
	background-repeat: no-repeat;
	background-size: contain;
	background-position: center top;
}

.home
{
	width: 100%;
	height: 450px;
}

.home_slider_title
{
	font-family: 'Roboto Slab', serif;
	font-size: 5px;
	font-weight: 300;
	color: white;
}


}

.home_slider_content
{
	position: absolute;
	top: 41%;
	left: 0;
	width: 100%;
	height: auto;
}
.home_slider_title
{
	font-family: 'Roboto Slab', serif;
	font-size: 60px;
	font-weight: 700;
	line-height: 1.2;
	color: white;
}
.home_slider_subtitle
{
	font-size: 24px;
	color: #96CDCD;
	margin-top: 9px;
}
.home_slider_form_container
{
	width: 832px;
	margin: 0 auto;
	margin-top: 35px;
}
.home_search_form div
{
	width: calc(100% - 140px);
	height: 46px;
	background: #FFFFFF;
	border-radius: 3px;
}

.dropdown_item_select
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
	padding-right: 20px;
	padding-left: 20px;
}
.home_search_button
{
	width: 120px;
	height: 46px;
	background: #<?php echo $color; ?>
	border: none;
	outline: none;
	border-radius: 3px;
	font-size: 14px;
	font-weight: 500;
	color: #FFFFFF;
	text-transform: uppercase;
	letter-spacing: 0.1em;
	cursor: pointer;
}
.home_slider_nav
{
	position: absolute;
	top: 45.8%;
	width: 30px;
	background: #b6b7bd;
	border-radius: 50%;
	text-align: center;
	z-index: 10;
	cursor: pointer;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.home_slider_prev
{
	left: 75px;

}
.home_slider_next
{
	right: 75px;
}
.home_slider_nav i
{
	line-height: 30px;
	color: #FFFFFF;
	font-size: 20px;
}
.home_slider_nav:hover
{
	background: #<?php echo $color; ?>
}

/*********************************
7. Features
*********************************/

.features
{
	width: 100%;
	background: #FFFFFF;
	padding-bottom: 103px;
}
.features_row
{
	margin-top: 55px;
}
.feature
{
	width: 100%;
	padding-top: 0px;
	padding-bottom: 28px;
	padding-left: 15px;
	padding-right: 15px;
	background: #FFFFFF;
}
.feature:hover
{
	box-shadow: 0px 5px 40px rgba(29,34,47,0.15);
}
.feature_icon
{
	height: 55px;
}
.feature_icon img
{
	max-width: 100%;
}
.feature_title
{
	position: relative;
	font-size: 20px;
	margin-top: 23px;
}

/*********************************
8. Courses
*********************************/

.courses
{
	width: 100%;
	padding-top: 93px;
	padding-bottom: 100px;
}
.courses_row
{
	margin-top: 45px;
}
.course
{
	width: 100%;
	border-radius: 6px;
	background: #FFFFFF;
	box-shadow: 0px 1px 10px rgba(29,34,47,0.1);
}
.course_image
{
	width: 100%;
	height: 29%;
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
	color: #<?php echo $color; ?>
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
	color: #<?php echo $color; ?>
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
	background:#<?php echo $color; ?>;
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

.courses_button a:hover
{
	color: #FFFFFF;
}

/*********************************
9. Counter
*********************************/

.counter
{
	width: 100%;
	background: #FFFFFF;
	z-index: 2;
}
.counter_background
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
.counter_content
{
	padding-top: 119px;
	padding-bottom: 125px;
}
.counter_title
{
	font-family: 'Roboto Slab', serif;
	color: #FFFFFF;
	font-weight: 700;
}
.counter_text
{
	margin-top: 19px;
}
.counter_text p
{
	color: #FFFFFF;
}
.milestones
{
	margin-top: 39px;
}
.milestone
{
	text-align: center;
}
.milestone:not(:last-child)::after
{
	display: block;
	position: absolute;
	top: 0;
	right: -45px;
	width: 1px;
	height: 70px;
	background: rgba(255,255,255,0.2);
	content: '';
	-webkit-transform: rotate(30deg);
	-moz-transform: rotate(30deg);
	-ms-transform: rotate(30deg);
	-o-transform: rotate(30deg);
	transform: rotate(30deg);

}
.milestone_counter
{
	font-size: 42px;
	font-weight: 700;
	line-height: 0.75;
	color: #<?php echo $color; ?>
}
.milestone_text
{
	font-size: 16px;
	font-weight: 400;
	color: #FFFFFF;
	text-transform: uppercase;
	margin-top: 14px;
}
.counter_form
{
	position: absolute;
	top: 0;
	right: 30px;
	width: 380px;
	height: 100%;
	background: #FFFFFF;
	padding-left: 40px;
	padding-right: 40px;
	box-shadow: 0px 5px 40px rgba(29,34,47,0.15);
}
.counter_form_content
{
	display: block;
	position: relative;
	padding:10%;
	width: 100%;
	height: 100%;
}
.counter_form_title
{
	font-family: 'Roboto Slab', serif;
	font-size: 24px;
	font-weight: 700;
	color: #384158;
	text-transform: uppercase;
	line-height: 0.75;
	margin-bottom: 41px;
}

.counter_form_button
{
	width: 100%;
	height: 46px;
	color: #FFFFFF;
	font-size: 14px;
	font-weight: 500;
	text-transform: uppercase;
	border: none;
	outline: none;
	background: #<?php echo $color; ?>
	cursor: pointer;
	margin-top: 30px;
	box-shadow: 0px 5px 40px rgba(29,34,47,0.15);
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.counter_form_button:hover
{
	box-shadow: 0px 5px 40px rgba(29,34,47,0.45);
}

/*********************************
10. Events
*********************************/

.events
{
	width: 100%;
	padding-top: 93px;
	padding-bottom: 70px;
	background: #FFFFFF;
}
.events_row
{
	margin-top: 47px;
}
.event_left
{
	padding-right: 20px;
}
.event_mid
{
	padding-left: 10px;
	padding-right: 10px;
}
.event_right
{
	padding-left: 20px;
}
.event_image
{
	width: 100%;
	border-radius: 5px;
	overflow: hidden;
}
.event_image img
{
	max-width: 100%;
}
.event_body
{
	padding-top: 30px;
	padding-bottom: 30px;
}
.event_date
{
	box-shadow: 0px 1px 10px rgba(29, 34, 47, 0.1);
}
.event_date > div
{
	width: 60px;
	height: 60px;
}
.event_day
{
	font-family: 'Roboto Slab', serif;
	font-size: 24px;
	color: #<?php echo $color; ?>;
	font-weight: 700;
	line-height: 0.75;
}
.event_month
{
	font-family: 'Roboto Slab', serif;
	font-size: 14px;
	color: #<?php echo $color; ?>;
	font-weight: 400;
	line-height: 0.75;
	margin-top: 9px;
}
.event:hover .event_date > div
{
	background: #<?php echo $color; ?>;
}
.event:hover .event_day,
.event:hover .event_month
{
	color: #FFFFFF;
}
.event_content
{
	padding-left: 20px;
}
.event_title a
{
	font-family: 'Roboto Slab', serif;
	font-size: 20px;
	font-weight: 700;
	line-height: 1.4;
	color: #384158;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.event_title a:hover
{
	color: #14bdee;
}
.event_info_container
{
	margin-top: 11px;
}
.event_info
{
	display: inline-block;
	color: #b5b8be;
	font-size: 14px;
}
.event_info:not(:last-child)
{
	margin-right: 17px;
}
.event_info span
{
	margin-left: 4px;
}
.event_text
{
	margin-top: 12px;
}

/*********************************
11. Team
*********************************/

.team
{
	width: 100%;
	padding-top: 93px;
	padding-bottom: 60px;
}
.team_background
{
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
}
.team_row
{
	margin-top: 43px;
}
.team_col
{
	margin-bottom: 40px;
}
.team_item
{
	width: 100%;
}
.team_image
{
	width: 180px;
	height: 160px;
	border-radius: 6px;
	overflow: hidden;
	margin-left: auto;
	margin-right: auto;
	margin-bottom: -86px;
	z-index: 5;
}
.team_image img
{
	max-width: 100%;
}
.team_body
{
	width: 100%;
	padding-top: 108px;
	padding-bottom: 24px;
	background: #FFFFFF;
	border-radius: 6px;
	box-shadow: 0px 1px 10px rgba(29,34,47,0.1);
	text-align: center;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.team_item:hover .team_body
{
	box-shadow: 0px 5px 40px rgba(29,34,47,0.15);
}
.team_title a
{
	font-family: 'Roboto Slab', serif;
	font-size: 20px;
	font-weight: 700;
	color: #384158;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.team_title a:hover
{
	color: #14bdee;
}
.team_subtitle
{
	font-size: 14px;
	font-weight: 400;
	color: #76777a;
	margin-top: 6px;
}
.social_list
{
	margin-top: 16px;
}
.social_list ul li
{
	display: inline-block;
}
.social_list ul li:not(:last-child)
{
	margin-right: 10px;
}
.social_list ul li a i
{
	font-size: 18px;
	color: #76777a;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.social_list ul li:hover a i
{
	color: #<?php echo $color; ?>
}
.team_col .team_item
{
	padding-left: 6px;
	padding-right: 6px;
}
.team_col:first-child .team_item
{
	padding-left: 0;
	padding-right: 6px;
}
.team_col:nth-child(4n) .team_item
{
	padding-left: 6px;
	padding-right: 0;
}

/*********************************
12. News
*********************************/

.news
{
	width: 100%;
	padding-top: 93px;
	padding-bottom: 100px;
	background: #FFFFFF;
}
.news_row
{
	margin-top: 55px;
}
.news_post_large_container
{
	padding-right: 30px;
}
.news_post_large
{
	width: 100%;
}
.news_post_image
{
	width: 100%;
	border-radius: 6px;
	overflow: hidden;
}
.news_post_image img
{
	max-width: 100%;
}
.news_post_large_title
{
	margin-top: 23px;
}
.news_post_large_title a
{
	font-family: 'Roboto Slab', serif;
	font-size: 20px;
	font-weight: 700;
	color: #384158;
	line-height: 1.4;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.news_post_large_title a:hover
{
	color: #<?php echo $color; ?>
}
.news_post_meta
{
	margin-top: 11px;
}
.news_post_meta ul li
{
	display: inline-block;
	position: relative;
}
.news_post_meta ul li:not(:last-of-type)::after
{
	display: inline-block;
	position: relative;
	content: '|';
	margin-left: 14px;
	margin-right: 11px;
}
.news_post_meta ul li a
{
	font-size: 14px;
	font-weight: 400;
	color: #b5b8be;
	text-transform: uppercase;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.news_post_meta ul li a:hover
{
	color: #<?php echo $color; ?>
}
.news_post_text
{
	margin-top: 13px;
}
.news_post_link
{
	margin-top: 19px;
}
.news_post_link a
{
	font-size: 14px;
	font-weight: 400;
	text-transform: uppercase;
	color: #384158;
	text-decoration: underline;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.news_post_link a:hover
{
	color: #<?php echo $color; ?>
}
.news_posts_small
{
	margin-top: -6px;
}
.news_post_small:not(:last-child)
{
	padding-bottom: 31px;
	border-bottom: solid 1px #e5e5e5;
}
.news_post_small:not(:first-child)
{
	padding-top: 29px;
}
.news_post_small_title a
{
	font-family: 'Roboto Slab', serif;
	font-size: 18px;
	font-weight: 700;
	line-height: 1.55;
	color: #384158;
	-webkit-transition: all 200ms ease;
	-moz-transition: all 200ms ease;
	-ms-transition: all 200ms ease;
	-o-transition: all 200ms ease;
	transition: all 200ms ease;
}
.news_post_small_title a:hover
{
	color: #<?php echo $color; ?>
}

/*********************************
13. Newsletter
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
	color: #<?php echo $color; ?>
	font-weight: 500;
	letter-spacing: 0.1em;
}

/*********************************
14. Footer
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
	color:#<?php echo $color; ?>
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

a{
    color:#<?php echo $color; ?>
}

a:hover{
    color:#<?php echo $color; ?>
}

*, *:before, *:after {
  box-sizing: boder-box;
  -o-box-sizing: border-box;
  -ms-box-sizing: border-box;
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
}


@media (min-width: 768px) {
  .container {
    width: 768px;
  }
}
@media (min-width: 992px) {
  .container {
    width: 992px;
  }
}
@media (min-width: 1200px) {
  .container {
    width: 1200px;
  }
}

h1 {
  display: block;
  clear: both;
  width: 96%;
  margin: 25px auto;
  font-family: "Pacifico", cursive;
  font-size: 64px;
  font-weight: bold;
  text-align: center;
  background: -webkit-linear-gradient(#5bc0de, #428bca);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

pre {
  width: 52.555%;
  margin: 15px auto;
  padding: 10px;
  font-family: Consolas, Menlo, Courier, monsopace;
  font-size: 13px;
  line-height: 1.5;
  border: 1px solid #ddd;
  background-color: #f4f4f4;
  border-radius: 4px;
  box-shadow: 0 0 5px rgba(51, 51, 51, 0.1) inset;
}

ul.thumbnails {
  margin-left: -15px;
  margin-right: -15px;
  margin: 0;
  padding: 0;
  list-style: none;
}
ul.thumbnails:before, ul.thumbnails:after {
  display: table;
  content: " ";
}
ul.thumbnails:after {
  clear: both;
}
ul.thumbnails:before, ul.thumbnails:after {
  display: table;
  content: " ";
}
ul.thumbnails:after {
  clear: both;
}
@media (min-width: 768px) {
  ul.thumbnails {
    margin-left: -15px;
    margin-right: -15px;
  }
}

ul.thumbnails > li {
  position: relative;
  padding-left: 15px;
  padding-right: 15px;
  position: relative;
  padding-left: 15px;
  padding-right: 15px;
  position: relative;
  padding-left: 15px;
  padding-right: 15px;
  position: relative;
  padding-left: 15px;
  padding-right: 15px;
  text-align: center;
  border-left: 1px solid #fff;
  cursor: pointer;
}
@media (min-width: 480px) {
  ul.thumbnails > li {
    float: left;
    width: 50%;
  }
}
@media (min-width: 768px) {
  ul.thumbnails > li {
    float: left;
    width: 33.33333%;
  }
}
@media (min-width: 992px) {
  ul.thumbnails > li {
    float: left;
    width: 33.33333%;
  }
}
@media (min-width: 1200px) {
  ul.thumbnails > li {
    float: left;
    width: 16.66667%;
  }
}
ul.thumbnails > li:nth-of-type(1) {
  color: #000;
}
ul.thumbnails > li:nth-of-type(2) {
  color: #428bca;
}
ul.thumbnails > li:nth-of-type(3) {
  color: #5cb85c;
}
ul.thumbnails > li:nth-of-type(4) {
  color: #5bc0de;
}
ul.thumbnails > li:nth-of-type(5) {
  color: #f0ad4e;
}
ul.thumbnails > li:nth-of-type(6) {
  color: #d9534f;
}

.content {
  -moz-transition: all 0.2s ease-in;
  -o-transition: all 0.2s ease-in;
  -webkit-transition: all 0.2s ease-in;
  transition: all 0.2s ease-in;
  position: relative;
  margin: 15px 0;
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 3px;
  width:300px;
}

@media (min-width: 1200px) {
  .content {
    min-height: 260px;
  }
}

@media (max-width: 300px) {
  .content {
	width:100%;
  }
}

.content .icon {
  display: table;
  width: 100%;
  height: 270px;
  text-align: center;
}

.content .icon > .fa {
  display: table-cell;
  height: 100%;
  vertical-align: middle;
}

.text-field {
  display: block;
  width: 100%;
  padding: .375rem .75rem;
  font-size: 1rem;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #ced4da;
  border-radius: .25rem;
  transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
  font-family: 'Poppins', sans-serif;
}

.text-field:focus {
  border: 1px solid <?php echo $color; ?>;
}

.form-row {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
  margin-right: -15px;
  margin-left: -15px;
}

label{
	font-size: 16px;
  	font-weight: 400;
  	font-family: 'Poppins', sans-serif;
	color: #363636;
}

/* Card Box */
.card-box {
  padding: 20px;
  -webkit-box-shadow: 0 0px 8px 0 rgba(0, 0, 0, 0.06), 0 1px 0px 0 rgba(0, 0, 0, 0.02);
  box-shadow: 0 0px 10px 0 rgba(0, 0, 0, 0.06), 0 5px 0px 0 rgba(0, 0, 0, 0.02);
  border-radius: 5px;
  margin-bottom: 20px;
  background-color: #FFF;  
  box-shadow: 0px 0px 5px 0px #aca9a9;
}

.checkmark__circle {
  stroke-dasharray: 166;
  stroke-dashoffset: 166;
  stroke-width: 2;
  stroke-miterlimit: 10;
  stroke: #3BB6B6;
  fill: none;
  animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

.checkmark {
  width: 56px;
  height: 56px;
  border-radius: 50%;
  display: block;
  stroke-width: 2;
  stroke: #fff;
  stroke-miterlimit: 10;
  margin: 10% auto;
  box-shadow: inset 0px 0px 0px #3BB6B6;
  animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
}

.checkmark__check {
  transform-origin: 50% 50%;
  stroke-dasharray: 48;
  stroke-dashoffset: 48;
  animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
}

@keyframes stroke {
  100% {
    stroke-dashoffset: 0;
  }
}
@keyframes scale {
  0%, 100% {
    transform: none;
  }
  50% {
    transform: scale3d(1.1, 1.1, 1);
  }
}
@keyframes fill {
  100% {
    box-shadow: inset 0px 0px 0px 30px #3BB6B6;
  }
}

.card-box .card-drop {
  color: #98a6ad;
  font-size: 20px;
  height: 20px;
  line-height: 1px;
  display: inline-block;
}

.ead {
    box-shadow: 0 2px 5px 0 rgba(0,0,0,.16), 0 2px 10px 0 rgba(0,0,0,.12);
    padding: .84rem 2.14rem;
    font-size: .81rem;
    -webkit-transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
    -o-transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
    margin: .375rem;
    border: 0;
    -webkit-border-radius: .125rem;
    border-radius: .125rem;
    cursor: pointer;
    text-transform: uppercase;
    white-space: normal;
    word-wrap: break-word;
    color: inherit;
}

.ead-primary {
    background-color: #<?php echo $color; ?>!important;
    color: #fff;
}

.ead-block{
  width:100%;margin:0;text-align:center;
}


.full-wdth{
  width: 100%;
}
.form-column, .full-wdth {
  position: relative;
  min-height: 1px;
  padding-right: 15px;
  padding-left: 15px;
  margin-bottom: 10px;
}

.text-field:focus {
  border: 1px solid purple;
}

.ribbon {
  position: absolute;
  top: -3px;
  right: -6px;
  z-index: 1;
  width: 120px;
  height: 120px;
  overflow: hidden;
}
.ribbon.ribbon-default > small {
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
  transform: rotate(45deg);
  *zoom: 1;
  filter: progid:DXImageTransform.Microsoft.gradient(gradientType=0, startColorstr='#FFF4F4F4', endColorstr='#FFDDDDDD');
  background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4gPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJncmFkIiBncmFkaWVudFVuaXRzPSJvYmplY3RCb3VuZGluZ0JveCIgeDE9IjAuNSIgeTE9IjAuMCIgeDI9IjAuNSIgeTI9IjEuMCI+PHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2Y0ZjRmNCIvPjxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iI2RkZGRkZCIvPjwvbGluZWFyR3JhZGllbnQ+PC9kZWZzPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
  background-size: 100%;
  background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #f4f4f4), color-stop(100%, #dddddd));
  background-image: -moz-linear-gradient(top, #f4f4f4 0%, #dddddd 100%);
  background-image: -webkit-linear-gradient(top, #f4f4f4 0%, #dddddd 100%);
  background-image: linear-gradient(to bottom, #f4f4f4 0%, #dddddd 100%);
  -moz-box-shadow: 0 3px 6px -3px rgba(0, 0, 0, 0.5);
  -webkit-box-shadow: 0 3px 6px -3px rgba(0, 0, 0, 0.5);
  box-shadow: 0 3px 6px -3px rgba(0, 0, 0, 0.5);
  position: absolute;
  top: 16px;
  left: 27px;
  display: block;
  width: 100%;
  padding: 8px 16px;
  text-align: center;
  text-transform: uppercase;
  text-shadow: 0 2px 0 #cecece;
  font-weight: bold;
  font-size: 75%;
  color: #000;
  background-color: #f4f4f4;
}
.ribbon.ribbon-default > small:before,
.ribbon.ribbon-default > small:after {
  position: absolute;
  bottom: -3px;
  content: " ";
  border-top: 3px solid #8e8e8e;
  border-left: 3px solid transparent;
  border-right: 3px solid transparent;
}
.ribbon.ribbon-default > small:before {
  left: 0;
}
.ribbon.ribbon-default > small:after {
  right: 0;
}
.ribbon.ribbon-primary > small {
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
  transform: rotate(45deg);
  *zoom: 1;
  filter: progid:DXImageTransform.Microsoft.gradient(gradientType=0, startColorstr='#FF428BCA', endColorstr='#FF2A6496');
  background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4gPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJncmFkIiBncmFkaWVudFVuaXRzPSJvYmplY3RCb3VuZGluZ0JveCIgeDE9IjAuNSIgeTE9IjAuMCIgeDI9IjAuNSIgeTI9IjEuMCI+PHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzQyOGJjYSIvPjxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iIzJhNjQ5NiIvPjwvbGluZWFyR3JhZGllbnQ+PC9kZWZzPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
  background-size: 100%;
  background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #428bca), color-stop(100%, #2a6496));
  background-image: -moz-linear-gradient(top, #428bca 0%, #2a6496 100%);
  background-image: -webkit-linear-gradient(top, #428bca 0%, #2a6496 100%);
  background-image: linear-gradient(to bottom, #428bca 0%, #2a6496 100%);
  -moz-box-shadow: 0 3px 6px -3px rgba(0, 0, 0, 0.5);
  -webkit-box-shadow: 0 3px 6px -3px rgba(0, 0, 0, 0.5);
  box-shadow: 0 3px 6px -3px rgba(0, 0, 0, 0.5);
  position: absolute;
  top: 16px;
  left: 27px;
  display: block;
  width: 100%;
  padding: 8px 16px;
  text-align: center;
  text-transform: uppercase;
  text-shadow: 0 2px 0 #2a6496;
  font-weight: bold;
  font-size: 75%;
  color: #fff;
  background-color: #428bca;
}
.ribbon.ribbon-primary > small:before,
.ribbon.ribbon-primary > small:after {
  position: absolute;
  bottom: -3px;
  content: " ";
  border-top: 3px solid #0e2132;
  border-left: 3px solid transparent;
  border-right: 3px solid transparent;
}
.ribbon.ribbon-primary > small:before {
  left: 0;
}
.ribbon.ribbon-primary > small:after {
  right: 0;
}
.ribbon.ribbon-success > small {
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
  transform: rotate(45deg);
  *zoom: 1;
  filter: progid:DXImageTransform.Microsoft.gradient(gradientType=0, startColorstr='#FF5CB85C', endColorstr='#FF3D8B3D');
  background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4gPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJncmFkIiBncmFkaWVudFVuaXRzPSJvYmplY3RCb3VuZGluZ0JveCIgeDE9IjAuNSIgeTE9IjAuMCIgeDI9IjAuNSIgeTI9IjEuMCI+PHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzVjYjg1YyIvPjxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iIzNkOGIzZCIvPjwvbGluZWFyR3JhZGllbnQ+PC9kZWZzPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
  background-size: 100%;
  background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #5cb85c), color-stop(100%, #3d8b3d));
  background-image: -moz-linear-gradient(top, #5cb85c 0%, #3d8b3d 100%);
  background-image: -webkit-linear-gradient(top, #5cb85c 0%, #3d8b3d 100%);
  background-image: linear-gradient(to bottom, #5cb85c 0%, #3d8b3d 100%);
  -moz-box-shadow: 0 3px 6px -3px rgba(0, 0, 0, 0.5);
  -webkit-box-shadow: 0 3px 6px -3px rgba(0, 0, 0, 0.5);
  box-shadow: 0 3px 6px -3px rgba(0, 0, 0, 0.5);
  position: absolute;
  top: 16px;
  left: 27px;
  display: block;
  width: 100%;
  padding: 8px 16px;
  text-align: center;
  text-transform: uppercase;
  text-shadow: 0 2px 0 #3d8b3d;
  font-weight: bold;
  font-size: 75%;
  color: #fff;
  background-color: #5cb85c;
}
.ribbon.ribbon-success > small:before,
.ribbon.ribbon-success > small:after {
  position: absolute;
  bottom: -3px;
  content: " ";
  border-top: 3px solid #163216;
  border-left: 3px solid transparent;
  border-right: 3px solid transparent;
}
.ribbon.ribbon-success > small:before {
  left: 0;
}
.ribbon.ribbon-success > small:after {
  right: 0;
}
.ribbon.ribbon-info > small {
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
  transform: rotate(45deg);
  *zoom: 1;
  filter: progid:DXImageTransform.Microsoft.gradient(gradientType=0, startColorstr='#FF5BC0DE', endColorstr='#FF28A1C5');
  background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4gPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJncmFkIiBncmFkaWVudFVuaXRzPSJvYmplY3RCb3VuZGluZ0JveCIgeDE9IjAuNSIgeTE9IjAuMCIgeDI9IjAuNSIgeTI9IjEuMCI+PHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iIzViYzBkZSIvPjxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iIzI4YTFjNSIvPjwvbGluZWFyR3JhZGllbnQ+PC9kZWZzPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
  background-size: 100%;
  background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #5bc0de), color-stop(100%, #28a1c5));
  background-image: -moz-linear-gradient(top, #5bc0de 0%, #28a1c5 100%);
  background-image: -webkit-linear-gradient(top, #5bc0de 0%, #28a1c5 100%);
  background-image: linear-gradient(to bottom, #5bc0de 0%, #28a1c5 100%);
  -moz-box-shadow: 0 3px 6px -3px rgba(0, 0, 0, 0.5);
  -webkit-box-shadow: 0 3px 6px -3px rgba(0, 0, 0, 0.5);
  box-shadow: 0 3px 6px -3px rgba(0, 0, 0, 0.5);
  position: absolute;
  top: 16px;
  left: 27px;
  display: block;
  width: 100%;
  padding: 8px 16px;
  text-align: center;
  text-transform: uppercase;
  text-shadow: 0 2px 0 #28a1c5;
  font-weight: bold;
  font-size: 75%;
  color: #fff;
  background-color: #5bc0de;
}
.ribbon.ribbon-info > small:before,
.ribbon.ribbon-info > small:after {
  position: absolute;
  bottom: -3px;
  content: " ";
  border-top: 3px solid #124a5b;
  border-left: 3px solid transparent;
  border-right: 3px solid transparent;
}
.ribbon.ribbon-info > small:before {
  left: 0;
}
.ribbon.ribbon-info > small:after {
  right: 0;
}
.ribbon.ribbon-warning > small {
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
  transform: rotate(45deg);
  *zoom: 1;
  filter: progid:DXImageTransform.Microsoft.gradient(gradientType=0, startColorstr='#FFF0AD4E', endColorstr='#FFDF8A13');
  background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4gPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJncmFkIiBncmFkaWVudFVuaXRzPSJvYmplY3RCb3VuZGluZ0JveCIgeDE9IjAuNSIgeTE9IjAuMCIgeDI9IjAuNSIgeTI9IjEuMCI+PHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2YwYWQ0ZSIvPjxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iI2RmOGExMyIvPjwvbGluZWFyR3JhZGllbnQ+PC9kZWZzPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
  background-size: 100%;
  background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #f0ad4e), color-stop(100%, #df8a13));
  background-image: -moz-linear-gradient(top, #f0ad4e 0%, #df8a13 100%);
  background-image: -webkit-linear-gradient(top, #f0ad4e 0%, #df8a13 100%);
  background-image: linear-gradient(to bottom, #f0ad4e 0%, #df8a13 100%);
  -moz-box-shadow: 0 3px 6px -3px rgba(0, 0, 0, 0.5);
  -webkit-box-shadow: 0 3px 6px -3px rgba(0, 0, 0, 0.5);
  box-shadow: 0 3px 6px -3px rgba(0, 0, 0, 0.5);
  position: absolute;
  top: 16px;
  left: 27px;
  display: block;
  width: 100%;
  padding: 8px 16px;
  text-align: center;
  text-transform: uppercase;
  text-shadow: 0 2px 0 #df8a13;
  font-weight: bold;
  font-size: 75%;
  color: #fff;
  background-color: #f0ad4e;
}
.ribbon.ribbon-warning > small:before,
.ribbon.ribbon-warning > small:after {
  position: absolute;
  bottom: -3px;
  content: " ";
  border-top: 3px solid #694109;
  border-left: 3px solid transparent;
  border-right: 3px solid transparent;
}
.ribbon.ribbon-warning > small:before {
  left: 0;
}
.ribbon.ribbon-warning > small:after {
  right: 0;
}
.ribbon.ribbon-danger > small {
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
  transform: rotate(45deg);
  *zoom: 1;
  filter: progid:DXImageTransform.Microsoft.gradient(gradientType=0, startColorstr='#FFD9534F', endColorstr='#FFB52B27');
  background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4gPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PGxpbmVhckdyYWRpZW50IGlkPSJncmFkIiBncmFkaWVudFVuaXRzPSJvYmplY3RCb3VuZGluZ0JveCIgeDE9IjAuNSIgeTE9IjAuMCIgeDI9IjAuNSIgeTI9IjEuMCI+PHN0b3Agb2Zmc2V0PSIwJSIgc3RvcC1jb2xvcj0iI2Q5NTM0ZiIvPjxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iI2I1MmIyNyIvPjwvbGluZWFyR3JhZGllbnQ+PC9kZWZzPjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JhZCkiIC8+PC9zdmc+IA==');
  background-size: 100%;
  background-image: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #d9534f), color-stop(100%, #b52b27));
  background-image: -moz-linear-gradient(top, #d9534f 0%, #b52b27 100%);
  background-image: -webkit-linear-gradient(top, #d9534f 0%, #b52b27 100%);
  background-image: linear-gradient(to bottom, #d9534f 0%, #b52b27 100%);
  -moz-box-shadow: 0 3px 6px -3px rgba(0, 0, 0, 0.5);
  -webkit-box-shadow: 0 3px 6px -3px rgba(0, 0, 0, 0.5);
  box-shadow: 0 3px 6px -3px rgba(0, 0, 0, 0.5);
  position: absolute;
  top: 16px;
  left: 27px;
  display: block;
  width: 100%;
  padding: 8px 16px;
  text-align: center;
  text-transform: uppercase;
  text-shadow: 0 2px 0 #b52b27;
  font-weight: bold;
  font-size: 75%;
  color: #fff;
  background-color: #d9534f;
}
.ribbon.ribbon-danger > small:before,
.ribbon.ribbon-danger > small:after {
  position: absolute;
  bottom: -3px;
  content: " ";
  border-top: 3px solid #4c1210;
  border-left: 3px solid transparent;
  border-right: 3px solid transparent;
}
.ribbon.ribbon-danger > small:before {
  left: 0;
}
.ribbon.ribbon-danger > small:after {
  right: 0;
}

.validate.valid{
	color: #3c763d !important; 
}

.str,
.atv {
  color: #D14;
}

.pun,
.opn,
.clo {
  color: #93a1a1;
}

.kwd,
.prettyprint
.tag {
  color: #1e347b;
}

.typ,
.atn,
.dec,
.var {
  color: teal;
}

.lit {
  color: #195f91;
}

.fun {
  color: #dc322f;
}

.pln {
  color: #48484c;
}

.com {
  font-style: italic;
  color: #93a1a1;
}

.prettyprint.linenums {
  -moz-box-shadow: inset 45px 0 0 #fafafa;
  -webkit-box-shadow: inset 45px 0 0 #fafafa;
  box-shadow: inset 45px 0 0 #fafafa;
}

.prettyprint ol.linenums {
  margin: 0;
  margin-left: -5px;
}

.prettyprint ol.linenums > li {
  padding-left: 12px;
  color: #bebec5;
  line-height: 1.6;
}

.lt-ie9 .prettyprint ol.linenums {
  margin: 0;
  margin-left: 33px;
}

.course_col{
	padding-bottom:10%;
}

