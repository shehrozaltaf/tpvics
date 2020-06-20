<?php
include_once '../dbconfig.php';
$data = file_get_contents('php://input');
$today = date("Y-m-d H:i:s");
$file_dt = date("Y-m-d");
$file = 'json/devices-' . $file_dt . '.json';
file_put_contents($file, $today . " - " . $data . "\r\n", FILE_APPEND | LOCK_EX);
$data = json_decode($data, true);
$imei = $data["imei"];
$appversion = $data["appversion"];
$appname = $data["appname"];
$dist_id = $data["dist_id"];
$tblname = "devices";
file_put_contents($file, $today . " - " . $imei . " - " . $appversion . " - " . $dist_id . "\r\n", FILE_APPEND | LOCK_EX);
$json = array();
if ($imei != '') {
    $sql = "UPDATE " . $tblname . " set appversion = '" . $appversion . "', appname = '" . $appname . "', dist_id = '" . $dist_id . "', updt_date = GETDATE()  where imei like '%" . $imei . "%';";
    $param = array("appversion" => "appversion", "appname" => "appname", "imei" => "imei");
    if ($result = sqlsrv_query($con, $sql)) {
        $sql1 = "SELECT tag FROM " . $tblname . " where imei = '" . $imei . "';";
        $result = sqlsrv_query($con, $sql1);
        while ($r = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $json[] = $r;
        }
    } else {
        $json[] = array("error" => 1, "message" => "Device not found on server.", "status" => 0, "imei" => $imei);
    }
    $sql = "SELECT tag FROM " . $tblname . " where imei != '$imei';";
    $result = sqlsrv_query($con, $sql);
} else {
    $json[] = array("error" => 1, "message" => "imei error", "status" => 0, "imei" => $imei);

}
sqlsrv_close($con);
header('Content-Type: application/json');
echo json_encode($json);
die();
?>