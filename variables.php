<?php
switch($_SERVER['SERVER_NAME']){
	
	case 'muthachan.org':
	case 'www.muthachan.org':
		$servername = "muthachanorg.ipagemysql.com";
		$username 	= "muthachanorg";
		$password 	= "Muthachan_123";
		$dbname 	= "muthachan_fund";
		break;
	
	case 'localhost':
		$servername = "localhost";
		$username 	= "root";
		$password 	= "";
		$dbname 	= "muthachan_fund";
		break;

	default:
		$servername = "localhost";
		$username 	= "root";
		$password 	= "";
		$dbname 	= "muthachan_fund";	
		break;
}
?>