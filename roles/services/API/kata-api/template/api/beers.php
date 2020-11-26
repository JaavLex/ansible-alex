<?php
	// Connect to database
	require_once './db/database.php';
	$request_method = $_SERVER["REQUEST_METHOD"];

	function getBeers()
	{
		
		$query = "SELECT * FROM beers LIMIT 50";
		$response = array();
		$stmt = EDatabase::prepare($query);
		$stmt->execute(array(':id' => $id));
		$response = $stmt->fetchAll(PDO::FETCH_ASSOC);
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
	
	function getBeer($id=0)
	{
		$query = "SELECT * FROM beers";
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

	function AddBeer()
	{
		$sql = "INSERT INTO beers (brewery_id, name, cat_id, style_id, abv, ibu, srm, upc, filepath, descript, add_user, last_mod) 
						   VALUES (:bre, :nam, :cat, :sty, :abv, :ibu, :srm, :upc, :fil, :des, :add, :las)";
		$sth = EDatabase::prepare($sql);
		try {
			$sth->bindParam(':bre', $_POST["brewery_id"], PDO::PARAM_INT);
			$sth->bindParam(':nam', $_POST["name"], PDO::PARAM_STR);
			$sth->bindParam(':cat', $_POST["cat_id"], PDO::PARAM_INT);
			$sth->bindParam(':sty', $_POST["style_id"], PDO::PARAM_INT);
			$sth->bindParam(':abv', $_POST["abv"]);
			$sth->bindParam(':ibu', $_POST["ibu"]);
			$sth->bindParam(':srm', $_POST["srm"]);
			$sth->bindParam(':upc', $_POST["upc"], PDO::PARAM_INT);
			$sth->bindParam(':fil', $_POST["filepath"], PDO::PARAM_STR);
			$sth->bindParam(':des', $_POST["descript"], PDO::PARAM_STR);
			$sth->bindParam(':add', $_POST["add_user"], PDO::PARAM_INT);
			$sth->bindParam(':las', date("Y-m-d H:i:s"));
			$sth->execute();

		} catch (PDOException $e) {
			echo 'Problème de lecture de la base de données: ' . $e->getMessage();
			EDatabase::rollBack();
			return false;
		}
		
/* 		header('Content-Type: application/json'); */
		echo json_encode($sth);
	}

	function deleteBeer($id)
	{
		$query = "DELETE FROM beers WHERE id=:id";
		$sth = EDatabase::prepare($query);
		try {
			$sth->bindParam(':id', $id, PDO::PARAM_INT);   
			$sth->execute();
		} catch (PDOException $e) {
			echo 'Problème de lecture de la base de données: ' . $e->getMessage();
			EDatabase::rollBack();
			return false;
		}

		header('Content-Type: application/json');
		echo json_encode($sth);
	}
	

	function updateBeer()
  	{
		// $_PUT = array(); //tableau qui va contenir les données reçues
		$tmp = (file_get_contents('php://input'));
		$_PUT = (json_decode($tmp, true));
		//construire la requête SQL
		$sql="UPDATE beers SET brewery_id=:bre, name=:nam, cat_id=:cat, style_id=:sty, abv=:abv, ibu=:ibu, srm=:srm, upc=:upc, filepath=:fil, descript=:des, add_user=:add, last_mod=:las WHERE id=:id";
		
		var_dump($_PUT["commentaire"]);
		var_dump($_PUT["postType"]);
		var_dump($_PUT["id"]);
		$sth = EDatabase::prepare($sql);
		try {
			$sth->bindParam(':id',  $_PUT["id"], PDO::PARAM_INT);
			$sth->bindParam(':bre', $_PUT["brewery_id"], PDO::PARAM_INT);
			$sth->bindParam(':nam', $_PUT["name"], PDO::PARAM_STR);
			$sth->bindParam(':cat', $_PUT["cat_id"], PDO::PARAM_INT);
			$sth->bindParam(':sty', $_PUT["style_id"], PDO::PARAM_INT);
			$sth->bindParam(':abv', $_PUT["abv"]);
			$sth->bindParam(':ibu', $_PUT["ibu"]);
			$sth->bindParam(':srm', $_PUT["srm"]);
			$sth->bindParam(':upc', $_PUT["upc"], PDO::PARAM_INT);
			$sth->bindParam(':fil', $_PUT["filepath"], PDO::PARAM_STR);
			$sth->bindParam(':des', $_PUT["descript"], PDO::PARAM_STR);
			$sth->bindParam(':add', $_PUT["add_user"], PDO::PARAM_INT);
			$sth->bindParam(':las', date("Y-m-d"));
			$sth->execute();
		} catch (PDOException $e) {
			echo 'Problème de lecture de la base de données: ' . $e->getMessage();
			EDatabase::rollBack();
			return false;
		}
		
		header('Content-Type: application/json');
		echo json_encode($sth);
	}

	switch($request_method)
	{
		
		case 'GET':
			// Retrive Beer
			if(!empty($_GET["id"]))
			{
				$id=intval($_GET["id"]);
				getBeer($id);
			}
			else
			{
				getBeers();
			}
			break;

		case 'POST':
			// Ajouter une bière
			AddBeer();
			break;

		case 'DELETE':
    		// Supprimer une bière
			$id = intval($_GET["id"]);
			deleteBeer($id);
			break;

		case 'PUT':
			// Modifier une bière
			updateBeer();
			break;

		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;

	}
?>