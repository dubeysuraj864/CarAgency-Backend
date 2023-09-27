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
            $vehicleId = $path[3];

            // echo "get user id----".$vehicleId; die;

            $getVehicleRow = mysqli_query($db_conn, "SELECT * FROM cars WHERE vehicleId ='$vehicleId'");
            while ($vehicleRow = mysqli_fetch_array($getVehicleRow)) {
                $json_array['rowVehicleData'] = array('vehicleId' => $vehicleRow['vehicleId'], 'vehicleModel' => $vehicleRow['vehicleModel'], 'vehicleNumber' => $vehicleRow['vehicleNumber'], 'vehicleSeats' => $vehicleRow['vehicleSeats'], 'vehicleRent' => $vehicleRow['vehicleRent']);
            }
            echo json_encode($json_array['rowVehicleData']);
            return;
        }

        $allVehicle = mysqli_query($db_conn, "SELECT * FROM cars");
        if (mysqli_num_rows($allVehicle) > 0) {
            while ($row = mysqli_fetch_array($allVehicle)) {
                $json_array["vehicleData"][] = array("id" => $row["vehicleId"], "model" => $row["vehicleModel"], "number" => $row["vehicleNumber"], "seats" => $row["vehicleSeats"], "vehicleRent" => $row["vehicleRent"]);
            }
            echo json_encode($json_array["vehicleData"]);
            return;
        } else {
            echo json_encode(["result" => "Please check the data"]);
        }
        break;

    case "POST":

        $vehiclePostData = json_decode(file_get_contents("php://input"));
        // echo "success Data";
        // print_r($vehiclePostData);
        // $vehicleImage = $vehiclePostData->vehicleImage;
        $vehicleModel = $vehiclePostData->vehicleModel;
        $vehicleNumber = $vehiclePostData->vehicleNumber;
        $vehicleSeats = $vehiclePostData->vehicleSeats;
        $vehicleRent = $vehiclePostData->vehicleRent;

        $result = mysqli_query($db_conn, "INSERT INTO cars (vehicleModel,vehicleNumber,vehicleSeats,vehicleRent) VALUES('$vehicleModel','$vehicleNumber','$vehicleRent','$vehicleRent')");

        if ($result) {
            echo json_encode(["success" => "vehicle added successfully"]);
        } else {
            echo json_encode(["success" => "Please check the vehicle data"]);
            return;
        }

        break;

    case "DELETE":

        $path = explode('/', $_SERVER["REQUEST_URI"]);

        // echo "message vehicleId-------".$path[4]; die;

        $result = mysqli_query($db_conn, "DELETE FROM cars WHERE vehicleId = '$path[3]' ");
        if ($result) {
            echo json_encode(["success" => "vehicle record Deleted successfully"]);
            return;
        } else {
            echo json_encode(["success" => "Please check the vehicle data"]);
            return;
        }

        break;

    case "PUT":

        $vehicleUpdate = json_decode(file_get_contents("php://input"));

        $vehicleId = $vehicleUpdate->id;
        $vehicleModel = $vehicleUpdate->vehicleModel;
        $vehicleNumber = $vehicleUpdate->vehicleNumber;
        $vehicleSeats = $vehicleUpdate->vehicleSeats;
        $vehicleRent = $vehicleUpdate->vehicleRent;

        $updateVehicle = mysqli_query($db_conn, "UPDATE cars SET vehicleModel='$vehicleModel', vehicleNumber='$vehicleNumber',vehicleSeats='$vehicleSeats',vehicleRent='$vehicleRent' WHERE vehicleId ='$vehicleId' ");


        if ($updateVehicle) {
            echo json_encode(["success" => "vehicle record Updated successfully"]);
            return;
        } else {
            echo json_encode(["success" => "Please check the vehicle data"]);
            return;
        }



        break;
}





?>