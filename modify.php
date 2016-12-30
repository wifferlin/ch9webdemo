<?php
	include("pdo.php");
	$conn = OpenConnection();
	
	//接收新增器材POST值
	$insertObject = $_POST['insertObject'];
    $insertNum = $_POST['insertNum'];
	//接收刪除器材POST值
	$deleteObject = $_POST['deleteObject'];
	$deleteNum = $_POST['deleteNum'];
	//接收狀態修改GET值
	$judgeObject = $_GET['judgeObject'];
	$judge = $_GET['judge'];
	$Asset = $_GET['Asset'];
	$Num = $_GET['Num'];

//新增器材
	if($insertObject != NULL && $insertNum != NULL)
	{
		$sql = "SELECT * FROM asset_tbl WHERE aName = N'$insertObject' ";
		$getProducts = sqlsrv_query($conn, $sql);
		$row = sqlsrv_fetch_array($getProducts, SQLSRV_FETCH_ASSOC);
        if ($row == NULL )
		{
			$sqli = " INSERT INTO asset_tbl(aName,totalNum,availNum) VALUES (?,?,?)";
			$data = array($insertObject,$insertNum,$insertNum);
			$insertProducts = sqlsrv_query($conn , $sqli , $data);
		}	
		else
		{		
			$totalchangeNum = $row['totalNum'] + $insertNum;
			$availchangeNum = $row['availNum'] + $insertNum;
			//判斷中文字串需加上前綴詞 N
			$sqlup = "UPDATE  asset_tbl SET totalNum =$totalchangeNum ,availNum = $availchangeNum WHERE aName = N'$insertObject'";
			$updateProducts = sqlsrv_query($conn , $sqlup);
		}
	}
//刪除器材
	else if($deleteObject != NULL && $deleteNum != NULL)
	{
		//判斷中文字串需加上前綴詞 N
		$sql = "SELECT * FROM asset_tbl WHERE aName = N'$deleteObject' ";
		$getProducts = sqlsrv_query($conn, $sql);
		$row = sqlsrv_fetch_array($getProducts, SQLSRV_FETCH_ASSOC);
		if($row['totalNum'] >= $deleteNum)
		{
			$totalchangeNum =$row['totalNum']- $deleteNum;
			$availchangeNum = $row['availNum']- $deleteNum;
			if($totalchangeNum == 0)
			{
				$sqld="DELETE FROM asset_tbl WHERE aId =$row[aId]";
				$deleteProducts = sqlsrv_query($conn , $sqld);
			}
			else
			{
				//判斷中文字串需加上前綴詞 N
				$sqld = "UPDATE  asset_tbl SET totalNum =$totalchangeNum ,availNum = $availchangeNum WHERE aName = N'$deleteObject'";
				$deleteProducts = sqlsrv_query($conn , $sqld);
			}
			
		}
		else
		{
			echo "刪除數量錯誤";
		}	
	}
//接受、拒絕、歸還=>狀態修改
	else if($judgeObject!= NULL && $judge != NULL)
	{
		//接受申請
		if($judge == 1)
		{
			$sqlb = "SELECT * FROM asset_tbl WHERE aName = N'$Asset' ";
			$getProductsb = sqlsrv_query($conn, $sqlb);
			$rowb = sqlsrv_fetch_array($getProductsb, SQLSRV_FETCH_ASSOC);
			$changeavailNum = $rowb['availNum'] - $Num;
			$sqlc = "UPDATE  asset_tbl SET availNum = $changeavailNum WHERE aName = N'$Asset'";
			$changeProducts = sqlsrv_query($conn , $sqlc);		
		}
		//歸還器材
		if($judge == 2)
		{
			$sqlb = "SELECT * FROM asset_tbl WHERE aName = N'$Asset' ";
			$getProductsb = sqlsrv_query($conn, $sqlb);
			$rowb = sqlsrv_fetch_array($getProductsb, SQLSRV_FETCH_ASSOC);
			$changeavailNum = $rowb['availNum'] + $Num;
			$sqlc = "UPDATE  asset_tbl SET availNum = $changeavailNum WHERE aName = N'$Asset'";
			$changeProducts = sqlsrv_query($conn , $sqlc);
		}
		$sql = "SELECT * FROM borrower_tbl WHERE bId = N'$judgeObject' ";
		$getProducts = sqlsrv_query($conn, $sql);
		$row = sqlsrv_fetch_array($getProducts, SQLSRV_FETCH_ASSOC);
		$sqls = "UPDATE  borrower_tbl SET status = $judge WHERE bId = N'$judgeObject'";
		$judgeProducts = sqlsrv_query($conn , $sqls);	
	}
	//轉跳回管理者頁面
	echo '<meta http-equiv="REFRESH" CONTENT="1; url=dashboard.php">';
?>