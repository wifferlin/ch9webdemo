<?php   $msg = $_GET['msg'];  ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>微軟大學資工系器材租借網</title>
        <!-- Bootstrap -->
        <!-- 最新編譯和最佳化的 CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        
        <!-- 選擇性佈景主題 -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
    </head>
    <body>
        <h1>微軟大學資工系管理員入口</h1>
        <div class="panel panel-success">
            <!-- Default panel contents -->
            <div class="panel-heading">管理入口</div>
            <div class="panel-body">
                <p>使用說明: 登入您的管理員帳號密碼 </p>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-10">
                    <form class="form-horizontal" role="form" method="post" action="login.php">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">帳號</label>
                            <div class="col-sm-8">
                                <input type="text" name="account" class="form-control" placeholder="your account">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">密碼</label>
                            <div class="col-sm-8">
                                <input type="password" name="pwd" class="form-control" placeholder="your password">                          
                                <?php echo '<br>'.$msg; ?>                           
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-4">
                                <label>
                                    <button type="submit" class="btn btn-primary">登入</button>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-6"></div>
            </div>
        </div>
                  
    <!-- jQuery (Bootstrap 所有外掛均需要使用) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- 最新編譯和最佳化的 JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    </body>
</html>