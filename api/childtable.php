<?php
include_once '../dbconfig.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

//$mcrypt = new MCrypt();

/* Encrypt */
//$encrypted = $mcrypt->encrypt("Text to encrypt");

/* Decrypt */


$_id = "_id";
$deviceid = "deviceid";
$formdate = "formdate";

// To GET
// ***
//
// $sql="SELECT * FROM $table";
// $result=mysqli_query($con,$sql);


$data = file_get_contents("php://input");
//$data = $mcrypt->decrypt($data);
$data = preg_replace('/[\x00-\x1F\x7F]/', '', $data);

//$value = stripslashes($value);
$data = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($data));
$data = str_replace("\0", "", $data);
$data = str_replace("'", " ", $data);
$value = json_decode($data, true);
$table = $value[0];
$value = $value[1];

$table = $table['table'];

$today = date("Y-m-d H:i:s");

$file_dt = date("Y-m-d");

$file = "json/" . $table . '-' . $file_dt . '.json';

file_put_contents($file, $today . " - " . $data . "\r\n", FILE_APPEND | LOCK_EX);
//$value = json_decode($value,true);
//echo $value;


$json = array();

if ($value === null && json_last_error() !== JSON_ERROR_NONE) {

    switch (json_last_error()) {
        case JSON_ERROR_NONE:

            break;
        case JSON_ERROR_DEPTH:
            echo ' - Maximum stack depth exceeded';
            $json[] = array('status' => ' - Maximum stack depth exceeded');
            break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Underflow or the modes mismatch';
            $json[] = array('status' => ' - Underflow or the modes mismatch');
            break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Unexpected control character found';
            $json[] = array('status' => ' - Unexpected control character found');
            break;
        case JSON_ERROR_SYNTAX:
            echo ' - Syntax error, malformed JSON';
            $json[] = array('status' => ' - Syntax error, malformed JSON');

            break;
        case JSON_ERROR_UTF8:
            echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
            $json[] = array('status' => ' - Malformed UTF-8 characters, possibly incorrectly encoded');
            break;
        default:
            echo ' - Unknown error';
            $json[] = array('status' => ' - Unknown error');

            break;
    }
} else {


    $row_1 = $value[0];
    $row_1 = flatten($row_1);

    $fld_count = 0;

    $array_keys_1 = array_keys($row_1);

    sort($array_keys_1);

    //$create_sql = "CREATE TABLE IF NOT EXISTS $table ( col_id int(11) NOT NULL AUTO_INCREMENT, col_dt datetime DEFAULT CURRENT_TIMESTAMP, ";


    $create_sql = "SET ANSI_NULLS ON SET QUOTED_IDENTIFIER ON if not exists (select * from sysobjects where name='$table' and xtype='U') ";
    $create_sql .= " CREATE TABLE $table ( [col_id] [int] IDENTITY(1,1) NOT NULL, [col_dt] [datetime] NULL, ";


    foreach ($array_keys_1 as $field) {

        if ($fld_count >= count($array_keys_1)) {
            $create_sql .= "[" . $field . "] varchar(max) ";
        } else {
            $create_sql .= "[" . $field . "] varchar(max), ";
        }

    }


    $create_sql .= " CONSTRAINT [PK_$table] PRIMARY KEY CLUSTERED  (  [col_id] ASC )WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]  ) ON [PRIMARY] ";

    $create_sql .= " IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_form_col_dt]') AND type = 'D')  ";
    $create_sql .= " ALTER TABLE [$table] ADD  CONSTRAINT [DF_" . $table . "_col_dt]  DEFAULT (getdate()) FOR [col_dt] ";


    $params_sel = $array_keys_1;


    sqlsrv_query($con, $create_sql, $array_keys_1);


    //echo $create_sql;

    //die();


    $jCount = count($value);
    $rCount = 0;
    //$string = file_get_contents("app/linelisting/output.json");
    //$json_a = json_decode($string, true);


    //print_r($json_a[0]["apkInfo"]["versionCode"]);

    //var_dump($value[$jCount-1]);
    /*
    $app_ver = explode(".",$value[$jCount-1]['appver']);
    //echo $app_ver[2];die();
    $cluster = $value[$jCount-1]['hh02']." | ";
    $devicetag = $value[$jCount-1]['tagId']." | ";
    $appversion = $value[$jCount-1]['appver']." | ";
    $region = $value[$jCount-1]['enumstr']." | ";



    if($app_ver[2] < $json_a[0]["apkInfo"]["versionCode"] ){
                $errfile = "errors/".$table . '-' . $file_dt . '.json';
                file_put_contents($errfile, $table." ".$today." [".$cluster.$region.$devicetag.$appversion."] \r\n", FILE_APPEND | LOCK_EX);
                    $json[] = array("error" => 1, "message" => "* * * UPDATE NOTICE * * * \r\n Update your app to 'Upload Data'", "status" => 0, "id" => 0);

    } else {
     */

    foreach ($value as $row) {


        $row = flatten($row);
        $array_keys = array_keys($row);
        $array_values = array_values($row);

        $params_ins = $array_values;


        $sql = "INSERT INTO " . $table . "(" . implode(",", array_map('trim', $array_keys)) . ") SELECT '" . implode("','", $array_values) . "'";
        $sql .= " WHERE NOT EXISTS ( SELECT $deviceid, $_id, $formdate FROM " . $table . " WHERE $_id = '" . $row[$_id] . "' and $deviceid = '" . $row[$deviceid] . "' and $formdate = '" . $row[$formdate] . "');";

        //$stmt = sqlsrv_query($con, $sql, $params_ins);

        //echo $sql;

        //die();


        if ($stmt = sqlsrv_query($con, $sql, $params_ins)) {
            if (sqlsrv_rows_affected($stmt) == 1) {


                $json[] = array("error" => 0, "message" => "Successfully Saved!", "status" => 1, "id" => $row[$_id]);
            } else {

                $json[] = array("error" => 0, "message" => "Duplicate Sample ID", "status" => 2, "id" => $row[$_id]);

            }
        } else {
            $json[] = array("error" => 1, "message" => sqlsrv_errors(), "status" => 0, "id" => $row[$_id]);
        }
        $rCount = $rCount + 1;
    }
//	}
}

sqlsrv_close($con);

header('Content-Type: application/json');
echo json_encode($json);

function flatten($array)
{
    $result = array();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $result = $result + flatten($value);
        } else {
            $result[$key] = $value;
        }
    }
    return $result;
}


?>