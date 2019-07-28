<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
//header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
include "db.php";
$result = [];

if (isset($_GET['id'])) {
    $sql = "delete from employee where id=".$_GET['id'];
    if ($conn->query($sql) === TRUE) {
        $result = [ "success" => "success" ];
    } else {
       $result = [ "failed" => $conn->error ];
    }
}
echo json_encode($result);
?>
