<?php
include_once '..\dbconfig.php';


$data = json_decode(file_get_contents('php://input'), true);

//print_r($data);

$json = array();
//if( isset( $data["dist_id"])){

// $dist_id = $data["dist_id"];

$sql = "SELECT [geoarea]
      ,[cluster_no]
      ,[dist_id]
      ,[ebcode]
  FROM [clusters] order by cluster_no ;";
//$sql="SELECT * FROM district where dss_id_hh like '$area%' and member_type != 'h'";
//echo $sql; die();

$result = sqlsrv_query($con, $sql) or die('A error occured: ' . sqlsrv_errors());
//var_dump($result);die();
if ($result === false) {
    echo "Error in query preparation/execution.\n";
    die(print_r(sqlsrv_errors(), true));
}

while ($r = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
//echo implode("\t", array_values($r)) . "\r\n";
    $json[] = $r;
}
//}
header('Content-Type: application/json');
echo json_encode($json);
/* switch (json_last_error()) {
        case JSON_ERROR_NONE:
            echo ' - No errors';
        break;
        case JSON_ERROR_DEPTH:
            echo ' - Maximum stack depth exceeded';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Underflow or the modes mismatch';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Unexpected control character found';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Syntax error, malformed JSON';
        break;
        case JSON_ERROR_UTF8:
            echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
        break;
        default:
            echo ' - Unknown error';
        break;
    }
	
	die(); */
?>