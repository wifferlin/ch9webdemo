<?php
    header("Content-Type:text/html; charset=utf-8");
    session_start();
	if($_SESSION['user_name']!=NULL)
	{
         include("pdo.php");
         function ReadATableData()
         {  
            try  
            {  
                $conn = OpenConnection();  
                $tsql = "SELECT * FROM asset_tbl";  
                $getProducts = sqlsrv_query($conn, $tsql);  
                if ($getProducts == FALSE)  
                    die(print_r( sqlsrv_errors(), true));   
                while($row = sqlsrv_fetch_array($getProducts, SQLSRV_FETCH_ASSOC))  
                {       
                     echo("<tr>");
                     //echo("<td>".$row['aId']."</td>"); 
                     echo("<td>".$row['aName']."</td>");  
                     echo("<td>".$row['totalNum']."</td>");  
                     echo("<td>".$row['availNum']."</td>");  
                     echo("<tr/>");  
                }  
                sqlsrv_free_stmt($getProducts);  
                sqlsrv_close($conn);  
            }  
            catch(Exception $e)  
            {  
                echo("Error!");  
            }  
        }  
        function ReadBTableData()
        {  
            try  
            {  
                $conn = OpenConnection();
                //比對 NULL 欄位時使用 "欄位名稱 is NULL" 寫法  
                $tsql = "SELECT * FROM borrower_tbl WHERE status is NULL ";  
                $getProducts = sqlsrv_query($conn, $tsql);  
                if ($getProducts == FALSE)  
                    die(print_r( sqlsrv_errors(), true));  
                while($row = sqlsrv_fetch_array($getProducts, SQLSRV_FETCH_ASSOC))  
                {       
                    echo "<tr><td>$row[bName]</td>";
            		echo "<td>$row[bDlevel]</td>";
            		echo "<td>$row[bAsset]</td>";
            		echo "<td>$row[bNum]</td>";
            		echo "<td>$row[borrowDate]</td>";
            		echo "<td>$row[returnDate]</td>";
            		echo "<td><span><a href='modify.php?judgeObject=$row[bId]&judge=1&Asset=$row[bAsset]&Num=$row[bNum]' class='glyphicon glyphicon-ok'></a></span></td>";
            		echo "<td><span><a href='modify.php?judgeObject=$row[bId]&judge=0' class='glyphicon glyphicon-remove'></a></span></td>";
            		echo "<td><span><a href='mailto:$row[email]' class='glyphicon glyphicon-envelope'></a></span></td></tr>";  
                }  
                sqlsrv_free_stmt($getProducts);  
                sqlsrv_close($conn);  
            }  
            catch(Exception $e)  
            {  
                echo("Error!");  
            }  
        }
        function ReadCTableData()
        {  
            try  
            {  
                $conn = OpenConnection();  
                $tsql = "SELECT * FROM borrower_tbl WHERE status = '1'";  
                $getProducts = sqlsrv_query($conn, $tsql);  
                if ($getProducts == FALSE)  
                    die(print_r( sqlsrv_errors(), true));    
                while($row = sqlsrv_fetch_array($getProducts, SQLSRV_FETCH_ASSOC))  
                {       
                    echo "<tr><td>$row[bName]</td>";
        			echo "<td>$row[bDlevel]</td>";
        			echo "<td>$row[bAsset]</td>";
        			echo "<td>$row[bNum]</td>";
        			echo "<td>$row[borrowDate]</td>";
        			echo "<td>$row[returnDate]</td>";
        			echo "<td><span><a href='modify.php?judgeObject=$row[bId]&judge=2&Asset=$row[bAsset]&Num=$row[bNum]' class='glyphicon glyphicon-saved'></a></span></td>";
        			echo "<td><span><a href='mailto:$row[email]' class='glyphicon glyphicon-envelope'></a></span></td></tr>";  
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
                    echo ("<option value='".$row['aName']."'>".$row['aName']."</option>");
                    
                }  
                sqlsrv_free_stmt($getProducts); 
                sqlsrv_close($conn);  
            }  
            catch(Exception $e)  
            {  
                echo("Error!");  
            }  
        } 
    }
    else
    {
        echo '<meta http-equiv="REFRESH" CONTENT="1; url=managerlogin.php">';
        echo '您無權觀看此頁面';
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
        <h1>微軟大學資工系器材租借網</h1>
        <div class="panel panel-success">
            <!-- Default panel contents -->
            <div class="panel-heading">管理者介面</div>
            <div class="panel-body">
                <p>使用說明:  用以管理器材 </p>
            </div>
        </div>
        <!-- TableA -->
        <div class="panel panel-info">
	  	    <div class="panel-heading">
	           <span style="font-weight:bold;">系上物品清單</span>
		    </div>
	    </div>
        <table class="table table-striped">
            <thead>
                 <tr>
                    <th>器材名稱</th>
                    <th>資產總數量</th>
                    <th>可出借數量</th>
                  </tr>
            </thead>
            <tbody>
              <?php ReadATableData(); ?>
           </tbody>
        </table>
	    <!-- TableB -->
        <div class="panel panel-info">
        <div class="panel-heading">
        	<span style="font-weight:bold;">外借申請審核</span>
        </div>
        </div>
        <table class="table table-striped">
            <thead>
                 <tr>
                    <th>申請借用人</th>
                    <th>系級</th>
                    <th>器材</th>
                    <th>數量</th>
                    <th>開始</th>
                    <th>結束</th>
                    <th>批准</th>
                    <th>拒絕</th>
                    <th>連絡他</th>
                  </tr>
            </thead>
            <tbody>
                <?php ReadBTableData(); ?>
            </tbody>
        </table>
        <!-- TableC -->
        <div class="panel panel-info">
            <div class="panel-heading">
            	<span style="font-weight:bold;">目前外借器材</span>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                 <tr>
                    <th>申請借用人</th>
                    <th>系級</th>
                    <th>已借出器材</th>
                    <th>數量</th>
                    <th>開始</th>
                    <th>結束</th>
                    <th>歸還</th>
                    <th>連絡他</th>
                  </tr>
            </thead>
            <tbody>
                <?php ReadCTableData(); ?>
            </tbody>
        </table><br>
        <!-- 新增刪除器材 -->
        <div class="container">
            <div class="row">
                <div class="col-sm-10">  
                    <!-- 刪除器材 -->
                    <form class="form-inline" role="form" method="post" action="modify.php">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">刪除器材</label>
                            <div class="col-sm-5">
                                  <select type="checkbox" name = "deleteObject" class="form-control" > 
                                    <option selected>請選擇欲刪除的系上器材</option>
                                    <?php ReadSelectedData(); ?>
                                  </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">數量</label>
                            <div class="col-sm-5">
                                <input name = "deleteNum" class="form-control" type="number" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 col-sm-offset-4">
                                <label>
                                    <button type="submit" class="btn btn-primary">刪除器材</button>
                                </label>
                            </div>
                        </div>
                    </form> 
                    <!-- 新增器材 -->
                    <form class="form-inline" role="form" method="post" action="modify.php">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">新增器材</label>
                            <div class="col-sm-3">
                                  <input type="textarea" name="insertObject" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">數量</label>
                            <div class="col-sm-5">
                                 <input name = "insertNum" class="form-control" type="number" value="0" id="example-number-input">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5 col-sm-offset-4">
                                <label>
                                    <button type="submit" class="btn btn-primary">新增器材</button>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-6"><br><br></div>
            </div>
        </div>
                  
    <!-- jQuery (Bootstrap 所有外掛均需要使用) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- 最新編譯和最佳化的 JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    </body>
</html>