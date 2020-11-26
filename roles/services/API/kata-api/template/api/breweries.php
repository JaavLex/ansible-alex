<?php
	// Connect to database
	require_once './db/database.php';
	$request_method = $_SERVER["REQUEST_METHOD"];

	function getBreweries()
	{
		
		$query = "SELECT * FROM breweries LIMIT 50";
		$response = array();
		$stmt = EDatabase::prepare($query);
		$stmt->execute(array(':id' => $id));
		$response = $stmt->fetchAll(PDO::FETCH_ASSOC);
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
	
	function getBrewerie($id=0)
	{
		$query = "SELECT * FROM breweries";
		if($id > 0)
		{
			$query .= " WHERE id=:id LIMIT 1";
		}
		$response = array();
		$stmt = EDatabase::prepare($query);
		$stmt->execute(array(':id' => $id));
		$response = $stmt->fetchAll(PDO::FETCH_BOTH);
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
    }
    
    switch($request_method)
	{
		
		case 'GET':
			// Retrive Beer
			if(!empty($_GET["id"]))
			{
				$id=intval($_GET["id"]);
				getBrewerie($id);
			}
			else
			{
				getBreweries();
			}
            break;
            
        default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;

	}
?>