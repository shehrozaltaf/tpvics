<?php
include_once '..\dbconfig.php';


//this is our upload folder
$upload_path = 'uploads/';

//Getting the server ip
$server_ip = gethostbyname(gethostname());

//creating the upload url
$upload_url = 'http://' . $server_ip . '/tpvics/api/' . $upload_path;

//response array
$json = array();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //checking the required parameters from the request
    if (isset($_POST['tagname']) and isset($_FILES['image']['name'])) {
        //connecting to the database
        //$con = mysqli_connect(HOST,USER,PASS,DB) or die('Unable to Connect...');

        //getting name from the request
        $tagname = $_POST['tagname'];

        //getting file info from the request
        $fileinfo = pathinfo($_FILES['image']['name']);

        //getting the file extension
        $extension = $fileinfo['extension'];

        //file url to store in the database
        $file_url = $upload_url . getFileName($con) . '.' . $extension;

        //file path to upload in the server
        $file_path = $upload_path . getFileName($con) . '.' . $extension;

        //trying to save the file in the directory
        try {
            //saving the file
            move_uploaded_file($_FILES['image']['tmp_name'], $file_path);
            $sql = "INSERT INTO images (url, tagname) VALUES ('$file_url', '$tagname');";
            //echo $sql;
            //adding the path and name to database
            if ($stmt = sqlsrv_query($con, $sql)) {
                //echo $sql;

                //filling response array with values
                $json['status'] = "1";
                $json['error'] = "0";
                //$json['url'] = $file_url;
                $json['tagname'] = $tagname;
            } else {

                sqlsrv_errors();
            }
            //if some error occurred
        } catch (Exception $e) {
            $json['error'] = true;
            $json['message'] = $e->getMessage();
        }
        //displaying the response
        echo json_encode($json);

        //closing the connection
        //mysqli_close($con);
    } else {
        $json['error'] = true;
        $json['message'] = 'Please choose a file';
    }

    header('Content-Type: application/json');
    echo json_encode($json);
}
/*
    We are generating the file name
    so this method will return a file name for the image to be upload
*/
function getFileName($conn)
{
    //$con = mysqli_connect(HOST,USER,PASS,DB) or die('Unable to Connect...');
    $con = $conn;
    $sql = "SELECT max(col_id) as id FROM images";
    $result = sqlsrv_query($con, $sql) or die('A error occured: ' . sqlsrv_errors());

    //mysqli_close($con);
    if ($result['col_id'] == null)
        return 1;
    else
        return ++$result['col_id'];
}