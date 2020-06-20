<?php
include_once '..\dbconfig.php';


$data = json_decode(file_get_contents('php://input'), true);

//print_r($data);
//$area = $data["area"];
$json = array();
if (isset($data["user"]) && $data["user"] == 'test1234') {


    $sql = "select  [id]
      ,[username]
      ,[password]
      ,[full_name]
      ,[designation]
      ,[dist_id] from users where enabled = 1 and username not like '%@%' ";


    if (isset($data["dist_id"])) {

        $dist_id = $data["dist_id"];

        $sql .= " and (dist_id is null or dist_id = " . $dist_id . ")";
    }

    $result = sqlsrv_query($con, $sql);

    if ($result === false) {
        echo "Error in query preparation/execution.\n";
        die(print_r(sqlsrv_errors(), true));
    }


    while ($r = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $json[] = $r;
    }
}
header('Content-Type: application/json');
echo json_encode($json);
die();
?>