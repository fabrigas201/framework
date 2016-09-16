<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $title; ?></title>
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
                <?php echo $content; ?>
			</div>
		</div>
	</div>
</body>
</html>