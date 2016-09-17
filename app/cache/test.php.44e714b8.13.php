<?php 
/** Fenom template '/admin/test.php' compiled at 2016-09-17 14:36:46 */
return new Fenom\Render($fenom, function ($var, $tpl) {
?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php
/* admin/main.php:5: {$title} */
 echo $var["title"]; ?></title>
	<!-- Bootstrap -->
	<link href="/public/css/admin/bootstrap.min.css" rel="stylesheet">
	<link href="" rel="stylesheet">
		
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src=""></script>
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
</head>
<body>
   <nav role="navigation" class="navbar navbar-static-top navbar-inverse">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="#" class="navbar-brand">RM_SHOP</a>
        </div>
        <!-- Collection of nav links and other content for toggling -->
        <div id="navbarCollapse" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Товары</a></li>
            <li><a href="#">Блог</a></li>
            <li><a href="#">Новости</a></li>
            <li><a href="#">Страницы</a></li>
            <li><a href="#">Пользователи</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Выход</a></li>
          </ul>
        </div>
      </div>
    </nav>

	<div class="container">
		<div class="row">
            <!-- Main column -->
			<div class="col-md-12">
                
	<?php
/* /admin/test.php:4: {$content} */
 echo $var["content"]; ?>

			</div>
		</div>
	</div>
</body>
</html><?php
}, array(
	'options' => 384,
	'provider' => false,
	'name' => '/admin/test.php',
	'base_name' => '/admin/test.php',
	'time' => 1474111363,
	'depends' => array (
  0 => 
  array (
    'admin/main.php' => 1474111270,
    '/admin/test.php' => 1474111363,
  ),
),
	'macros' => array(),

        ));
