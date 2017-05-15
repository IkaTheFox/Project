<?php 
	function connect()
	{
		return new PDO('mysql:host=localhost:3306;dbname=myfirstdb',"root","root");
	}

	function validate_user($username, $password)
	{
		try{
			$sqlCommand = "SELECT * FROM customers WHERE NICK = '$username'";
			
			$db = connect();
			foreach ($db->query($sqlCommand) as $row)
			{
				if($row["Password"] == $password)
				{
					return true;
				}
			}
		}catch(PDOException $ex){
			print("Error authenticating: " . $ex);
		}

		return false;
	}

	function query_database($SQLCommand)
	{
		$db = connect();
		return $db->query($SQLCommand);
	}

	function insert_item($Name,$Type,$Power,$Description)
	{
		$Command = "INSERT INTO item VALUES('$Name','$Type','$Power','$Description')";
		execute_command($Command);
		return;
	}

	function retrieve_item($Name)
	{
		return query_database("SELECT * FROM item WHERE itemName = '$Name'");
	}
 ?>