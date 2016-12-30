<?php
	include("pdo.php");
    $conn = OpenConnection();

	//read aName from aId
	$sql = "SELECT * FROM asset_tbl WHERE aId = N'$_POST[bAsset]'";  
    $getProducts = sqlsrv_query($conn, $sql);
            if ($getProducts == FALSE)  
                die(print_r( sqlsrv_errors(), true));  
            $row = sqlsrv_fetch_array($getProducts, SQLSRV_FETCH_ASSOC);
    //save form to database
    $tsql= "INSERT INTO borrower_tbl(aId,bName,bDlevel,bAsset,bNum,email,borrowDate,returnDate,status) VALUES (?,?,?,?,?,?,?,?,?);";
	$params = array($row['aId'],$_POST['name'],$_POST['grade'],$row['aName'],$_POST['number'],$_POST['email'],$_POST['borrowerDate'],$_POST['returnDate'],NULL);
	$getResults= sqlsrv_query($conn, $tsql,$params);
	
	$rowsAffected = sqlsrv_rows_affected($getResults);
	if ($getResults == FALSE or $rowsAffected == FALSE)
	    die(print_r(sqlsrv_errors(),true));
	sqlsrv_free_stmt($getResults);
	echo '<meta http-equiv="REFRESH" CONTENT="1; url=index.php">'
?>