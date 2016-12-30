<?php
    session_start();
    include("pdo.php");
    
    $account = $_POST['account'];
    $pwd = $_POST['pwd'];
    
    if($account!=NULL && $pwd != NULL)
    {
       $conn = OpenConnection();
       $tsql = "SELECT * FROM manager_tbl WHERE account = '$account'";  
       $getProducts = sqlsrv_query($conn, $tsql);
       if ($getProducts == FALSE) 
          die(FormatErrors(sqlsrv_errors()));
       $row = sqlsrv_fetch_array($getProducts, SQLSRV_FETCH_ASSOC);
       if ($row['pwd'] == $pwd)
       {
          echo '<meta http-equiv="REFRESH" CONTENT="1;url=dashboard.php">';
          //echo '密碼正確';
          //將帳號寫入session，方便驗證使用者身份
          $_SESSION['user_name'] = $account;
       }
       else
       {
          $msg="帳號或密碼錯誤";
          echo '<meta http-equiv="REFRESH" CONTENT="1; url=managerlogin.php?msg=帳號密碼錯誤">';
          //echo '帳號或密碼錯誤'; 
       }
       sqlsrv_free_stmt($getProducts);  
       sqlsrv_close($conn); 
    }
    else
    {
        $msg="帳號或密碼不得為空";
        echo '<meta http-equiv="REFRESH" CONTENT="1; url=managerlogin.php?msg=帳號密碼不得為空">';
    }

?>