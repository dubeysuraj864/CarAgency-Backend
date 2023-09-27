<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin:* ");
header("Access-Control-Allow-Headers: * ");
header("Access-Control-Allow-Methods: * ");

$db_conn = mysqli_connect("localhost", "root", "", "reactphp");
if ($db_conn === false) {
    die("ERROR: Could Not Connect" . mysqli_connect_error());
}
;

$method = $_SERVER['REQUEST_METHOD'];

// echo "test----".$method; die;

switch ($method) {
    case "GET":

        $path = explode('/', $_SERVER['REQUEST_URI']);

        if (isset($path[3]) && is_numeric($path[3])) {
            $json_array = array();
            $agencyId = $path[3];

            // echo "get user id----".$agencyId; die;

            $getAgencyRow = mysqli_query($db_conn, "SELECT * FROM agencies WHERE agencyId ='$agencyId'");
            while ($agencyRow = mysqli_fetch_array($getAgencyRow)) {
                $json_array['rowAgencyData'] = array('agencyId' => $agencyRow['agencyId'], 'agencyName' => $agencyRow['agencyName'], 'agencyEmail' => $agencyRow['agencyEmail'], 'agencyPassword' => $agencyRow['agencyPassword']);
            }
            echo json_encode($json_array['rowAgencyData']);
            return;
        }

        $allAgency = mysqli_query($db_conn, "SELECT * FROM agencies");
        if (mysqli_num_rows($allAgency) > 0) {
            while ($row = mysqli_fetch_array($allAgency)) {
                $json_array["agencyData"][] = array("id" => $row["agencyId"], "agencyName" => $row["agencyName"], "agencyEmail" => $row["agencyEmail"], "agencyPassword" => $row["agencyPassword"]);
            }
            echo json_encode($json_array["agencyData"]);
            return;
        } else {
            echo json_encode(["result" => "Please check the data"]);
        }
        break;

    case "POST":

        $agencyPostData = json_decode(file_get_contents("php://input"));
        // echo "success Data";
        // print_r($agencyPostData);
        // $customerImage = $agencyPostData->customerImage;
        $agencyName = $agencyPostData->agencyName;
        $agencyEmail = $agencyPostData->agencyEmail;
        $agencyPassword = $agencyPostData->agencyPassword;

        $result = mysqli_query($db_conn, "INSERT INTO agencies (agencyName,agencyEmail,agencyPassword) VALUES('$agencyName','$agencyEmail','$agencyPassword')");

        if ($result) {
            echo json_encode(["success" => "Agency user added successfully"]);
        } else {
            echo json_encode(["success" => "Please check the agency data"]);
            return;
        }

        break;

    case "DELETE":

        $path = explode('/', $_SERVER["REQUEST_URI"]);

        // echo "message agencyId-------".$path[4]; die;

        $result = mysqli_query($db_conn, "DELETE FROM agencies WHERE agencyId = '$path[3]' ");
        if ($result) {
            echo json_encode(["success" => "Agency record Deleted successfully"]);
            return;
        } else {
            echo json_encode(["success" => "Please check the Agency data"]);
            return;
        }

        break;

    case "PUT":

        $agencyUpdate = json_decode(file_get_contents("php://input"));

        $agencyId = $agencyUpdate->id;
        $agencyName = $agencyUpdate->agencyName;
        $agencyEmail = $agencyUpdate->agencyEmail;
        $agencyPassword = $agencyUpdate->agencyPassword;


        $updateCustomer = mysqli_query($db_conn, "UPDATE agencies SET agencyName='$agencyName', agencyEmail='$agencyEmail',agencyPassword='$agencyPassword' WHERE agencyId ='$agencyId' ");


        if ($updateCustomer) {
            echo json_encode(["success" => "Agency record Updated successfully"]);
            return;
        } else {
            echo json_encode(["success" => "Please check the Agency data"]);
            return;
        }



        break;
}





?>