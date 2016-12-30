<?php
    header("Content-Type:text/html; charset=utf-8");    
    function OpenConnection()  
    {  
        try  
        {  
            $serverName = "你的SQL Server 名稱";  
            $connectionOptions = array("Database"=>"你的資料庫名稱",  
                "CharacterSet" => "UTF-8" ,
                "Uid"=>"你的帳號", "PWD"=>"你的密碼","ReturnDatesAsStrings"=>true);  
            $conn = sqlsrv_connect($serverName, $connectionOptions);  
            if($conn == false)  
                die(print_r( sqlsrv_errors(), true));
        }  
        catch(Exception $e)  
        {  
            echo("Error!");  
        }  
        return $conn;
    }
?>