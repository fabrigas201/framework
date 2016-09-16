<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title></title>
	<!-- Bootstrap -->
	<link href="/public/css/admin/bootstrap.min.css" rel="stylesheet">
	<link href="" rel="stylesheet">
		
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script src=""></script>
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
</head>
<body style="background: #555;">

  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title">Войти</h4>
      </div>
      <div class="modal-body">
            <form action="" method="POST" >
                <table class="table">
                    <tr>
                        <td>Email</td>
                        <td><input type="text" name="" class="form-control" placeholder="Email" /></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><input type="password" name="" class="form-control" placeholder="Password" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="" class="btn btn-primary" value="Войти" /></td>
                    </tr>
                </table>
            </form>
      </div>
      <div class="modal-footer">
        &copy; <?php echo date('Y'); ?> 
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->

</body>
</html>