
 <?php
    session_start();
    header("Content-Type:text/html; charset=utf-8");
    include("pdo.php");
    function ReadTableData()
    {  
        try  
        {  
            $conn = OpenConnection();  
            $tsql = "SELECT * FROM asset_tbl";  
            $getProducts = sqlsrv_query($conn, $tsql);  
            if ($getProducts == FALSE)  
                die(print_r( sqlsrv_errors(), true));  
            $productCount = 0;  
            while($row = sqlsrv_fetch_array($getProducts, SQLSRV_FETCH_ASSOC))  
            {       
                 echo("<tr>");
                 //echo("<td>".$row['aId']."</td>"); 
                 echo("<td>".$row['aName']."</td>");  
                 echo("<td>".$row['totalNum']."</td>");  
                 echo("<td>".$row['availNum']."</td>");  
                 echo("<tr/>");  
                 $productCount++;  
            }  
            sqlsrv_free_stmt($getProducts);  
            sqlsrv_close($conn);  
        }  
        catch(Exception $e)  
        {  
            echo("Error!");  
        }  
    }  
    function ReadSelectedData()  
    {  
        try  
        {  
            $conn = OpenConnection();  
            $tsql = "SELECT aName,aId FROM asset_tbl";  
            $getProducts = sqlsrv_query($conn, $tsql);  
            if ($getProducts == FALSE)  
                die(print_r( sqlsrv_errors(), true));  
            $productCount = 0;  
            while($row = sqlsrv_fetch_array($getProducts, SQLSRV_FETCH_ASSOC))  
            {       
                echo ("<option value='".$row['aId']."'>".$row['aName']."</option>");
                
            }  
            sqlsrv_free_stmt($getProducts); 
            sqlsrv_close($conn);  
        }  
        catch(Exception $e)  
        {  
            echo("Error!");  
        }  
    }  
?>


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
        <h1>微軟大學資工系器材租借網 <a  style="float:right;" href="managerlogin.php"><span  style="font-size:large;" class="glyphicon glyphicon-user">Admin</span></a></h1> 
        <div class="panel panel-success">
        <!-- Default panel contents -->
        <div class="panel-heading">使用者介面</div>
            <div class="panel-body">
                <p>使用說明: 以下列出為系上所含器材數量，若要借用請選取數量並點選[送出申請]，器材長將會審核您的申請單並email通知~請大家愛護器材</p>
            </div>
        </div>
        <!-- Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>器材名稱</th>
                    <th>資產總數量</th>
                    <th>可出借數量</th>
                </tr>
            </thead>
            <tbody>
                <?php ReadTableData(); ?>
            </tbody>
        </table>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-10">
                    <form class="form-horizontal" role="form" method="post" action="save.php">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">姓名</label>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control" placeholder="your name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">系級</label>
                            <div class="col-sm-8">
                                  <select type="checkbox" name="grade" class="form-control" > 
                                      <option selected>系級</option>
                                      <option value='1'>大一</option>
                                      <option value='2'>大二</option>
                                      <option value='3'>大三</option>
                                      <option value='4'>大四</option>
                                  </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">email</label>
                            <div class="col-sm-8">
                                <input type="text" name = "email" class="form-control" placeholder="example@microsoft.com">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">欲借器材</label>
                            <div class="col-sm-8">
                                  <select type="checkbox" name = "bAsset" class="form-control" > 
                                  <option selected>請選擇欲借器材</option>
                                        <?php ReadSelectedData(); ?>
                                  </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">數量</label>
                            <div class="col-sm-8">
                                <input name = "number" class="form-control" type="number" value="0" id="example-number-input">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">借用開始日</label>
                            <div class="col-sm-8">
                                <input class="form-control" name ="borrowerDate" type="date" value="2016-12-10" id="example-date-input">
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-sm-4 control-label">預計歸還日</label>
                            <div class="col-sm-8">
                               <input class="form-control" name = "returnDate" type="date" value="2016-12-10" id="example-date-input">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-8 col-sm-offset-4">
                                <label>
                                    <button type="submit" class="btn btn-primary">送出申請</button>
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