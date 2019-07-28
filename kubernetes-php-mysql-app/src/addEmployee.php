<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
//header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
//header('Access-Control-Allow-Methods: GET, POST, PUT');
include "db.php";
$result = [];
$request_body = file_get_contents('php://input');

if ($request_body) {
    $data = json_decode($request_body);

    if($data->id){
	$sql = "update employee SET name='".$data->name."', role='".$data->role."' WHERE id=".$data->id;
    }else{
	$sql = "insert into employee(name,role) values('".$data->name."','".$data->role."')";
    }
    
    if ($conn->query($sql) === TRUE) {
        $result = [ "success" => "success" ];
    } else {
       $result = [ "failed" => $conn->error ];
    }
}

echo json_encode($result);
/*
  $sql = "SELECT * FROM employee";
  $result = $conn->query($sql);
  $return_arr = array();
  $row_arr = array();


  if ($result->num_rows > 0) {

  while($row = $result->fetch_assoc()) {
  $row_arr['id'] = $row["id"];
  $row_arr['name'] = $row["name"];
  $row_arr['role'] = $row["role"];
  array_push($return_arr,$row_arr);
  }
  }
  echo json_encode($return_arr,JSON_PRETTY_PRINT);
 */
?>


