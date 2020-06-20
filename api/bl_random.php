<?php
include_once '..\dbconfig.php';
$data = json_decode(file_get_contents('php://input'), true);
//print_r($data);
$json = array();
if (isset($data["dist_id"])) {
    $dist_id = $data["dist_id"];
    $sql = "SELECT _id, CONVERT(VARCHAR(10), randDT, 105) randDT, UID, sno, hh02, hh03,hh05, hh07, left(hh08,12) hh08, hh09, null as hhss, tabNo FROM bl_randomised where dist_id = '$dist_id' order by hh02 ;";
//$sql="SELECT * FROM district where dss_id_hh like '$area%' and member_type != 'h'";
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