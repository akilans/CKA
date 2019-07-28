<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
include "db.php";
$return_arr = array();
$row_arr = array();

if (isset($_GET['id'])) {

	$sql = "SELECT * FROM employee where id=".$_GET['id'];
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {

	    while($row = $result->fetch_assoc()) {
	      $row_arr['id'] = $row["id"];
	      $row_arr['name'] = $row["name"];
	      $row_arr['role'] = $row["role"];
	      array_push($return_arr,$row_arr);
	    }
	}
        echo json_encode($return_arr,JSON_PRETTY_PRINT);


}else{
	$sql = "SELECT * FROM employee";
	$result = $conn->query($sql);
	


	if ($result->num_rows > 0) {

	    while($row = $result->fetch_assoc()) {
	      $row_arr['id'] = $row["id"];
	      $row_arr['name'] = $row["name"];
	      $row_arr['role'] = $row["role"];
	      array_push($return_arr,$row_arr);
	    }
	}
        echo json_encode($return_arr,JSON_PRETTY_PRINT);
}
?>
