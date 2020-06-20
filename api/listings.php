<?php
include_once '..\dbconfig.php';

$table = "listings";
$_id = "_id";
$deviceid = "deviceid";
$formdate = "hhdt";

// To GET
// ***
//
// $sql="SELECT * FROM $table";
// $result=mysqli_query($con,$sql);


$value = file_get_contents("php://input");
$value = preg_replace('/[\x00-\x1F\x7F]/', '', $value);

//$value = stripslashes($value);
$value = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($value));
$value = str_replace("\0", "", $value);
$value = str_replace("'", " ", $value);

$today = date("Y-m-d H:i:s");

$file_dt = date("Y-m-d");

$file = "json/" . $table . '-' . $file_dt . '.json';

file_put_contents($file, $today . " - " . $value . "\r\n", FILE_APPEND | LOCK_EX);
$value = json_decode($value, true);
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
    $create_sql .= " CREATE TABLE dbo.$table ( [col_id] [int] IDENTITY(1,1) NOT NULL, [col_dt] [datetime] NULL, ";


    foreach ($array_keys_1 as $field) {

        if ($fld_count >= count($array_keys_1)) {
            $create_sql .= "[" . $field . "] varchar(max) ";
        } else {
            $create_sql .= "[" . $field . "] varchar(max), ";
        }

    }


    $create_sql .= " CONSTRAINT [PK_" . $table . "_id_table] PRIMARY KEY CLUSTERED  (  [col_id] ASC )WITH (PAD_INDEX  = OFF, STATISTICS_NORECOMPUTE  = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS  = ON, ALLOW_PAGE_LOCKS  = ON) ON [PRIMARY]  ) ON [PRIMARY] ";

    $create_sql .= " IF NOT EXISTS (SELECT * FROM dbo.sysobjects WHERE id = OBJECT_ID(N'[DF_form_col_dt]') AND type = 'D')  ";
    $create_sql .= " ALTER TABLE [$table] ADD  CONSTRAINT [DF_form_col_dt]  DEFAULT (getdate()) FOR [col_dt] ";


    $params_sel = $array_keys_1;


    //sqlsrv_query($con, $create_sql,$array_keys_1) or die( print_r( sqlsrv_errors(), true));
    if ($stmt = sqlsrv_query($con, $create_sql, $array_keys_1)) {

        foreach ($value as $row) {


            $row = flatten($row);
            $array_keys = array_keys($row);
            $array_values = array_values($row);

            $params_ins = $array_values;


            $sql = "INSERT INTO " . $table . "([" . implode("],[", array_map('trim', $array_keys)) . "]) SELECT '" . implode("','", $array_values) . "'";
            $sql .= " WHERE NOT EXISTS ( SELECT $deviceid, $_id, $formdate FROM " . $table . " WHERE $_id = '" . $row[$_id] . "' and $deviceid = '" . $row[$deviceid] . "' and $formdate = '" . $row[$formdate] . "');";

            //$stmt = sqlsrv_query($con, $sql, $params_ins);


            if ($stmt = sqlsrv_query($con, $sql, $params_ins)) {
                if (sqlsrv_rows_affected($stmt) == 1) {
                    //echo $sql;

                    $json[] = array("error" => 0, "message" => "Successfully Saved!", "status" => 1, "id" => $row[$_id]);
                } else {

                    $json[] = array("error" => 0, "message" => "Duplicate Sample ID", "status" => 2, "id" => $row[$_id]);

                }
            } else {
                $err_message = '';
                if (($errors = sqlsrv_errors()) != null) {
                    foreach ($errors as $error) {
                        //echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
                        //echo "code: ".$error[ 'code']."<br />";
                        $err_message = $error['message'];
                    }
                }

                $json[] = array("error" => $error['code'], "message" => $err_message, "status" => $sql, "id" => $row[$_id]);
            }
        }
    } else {

        $err_message = '';
        if (($errors = sqlsrv_errors()) != null) {
            foreach ($errors as $error) {
                //echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
                //echo "code: ".$error[ 'code']."<br />";
                $err_message = $error['message'];
            }
        }

        $json[] = array("error" => $error['code'], "message" => $err_message, "status" => 0);
    }
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