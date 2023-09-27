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
            $customerId = $path[3];

            // echo "get user id----".$customerId; die;

            $getCutomerRow = mysqli_query($db_conn, "SELECT * FROM customers WHERE customerId ='$customerId'");
            while ($customerRow = mysqli_fetch_array($getCutomerRow)) {
                $json_array['rowCustomerData'] = array('customerId' => $customerRow['customerId'], 'customerName' => $customerRow['customerName'], 'customerEmail' => $customerRow['customerEmail'], 'customerPassword' => $customerRow['customerPassword']);
            }
            echo json_encode($json_array['rowCustomerData']);
            return;
        }

        $allCustomer = mysqli_query($db_conn, "SELECT * FROM customers");
        if (mysqli_num_rows($allCustomer) > 0) {
            while ($row = mysqli_fetch_array($allCustomer)) {
                $json_array["customerData"][] = array("id" => $row["customerId"], "customerName" => $row["customerName"], "customerEmail"=> $row["customerEmail"], "customerPassword" => $row["customerPassword"]);
            }
            echo json_encode($json_array["customerData"]);
            return;
        } else {
            echo json_encode(["result" => "Please check the data"]);
        }
        break;

    case "POST":

        $customerPostData = json_decode(file_get_contents("php://input"));
        $customerName = $customerPostData->customerName;
        $customerEmail = $customerPostData->customerEmail;
        $customerPassword = $customerPostData->customerPassword;

        $result = mysqli_query($db_conn, "INSERT INTO customers (customerName,customerEmail,customerPassword) VALUES('$customerName','$customerEmail','$customerPassword')");

        if ($result) {
            echo json_encode(["success" => "Customer added successfully"]);
        } else {
            echo json_encode(["success" => "Please check the Customer data"]);
            return;
        }

        break;

    case "DELETE":

        $path = explode('/', $_SERVER["REQUEST_URI"]);

        // echo "message customerId-------".$path[4]; die;

        $result = mysqli_query($db_conn, "DELETE FROM customers WHERE customerId = '$path[3]' ");
        if ($result) {
            echo json_encode(["success" => "customer record Deleted successfully"]);
            return;
        } else {
            echo json_encode(["success" => "Please check the customer data"]);
            return;
        }

        break;

    case "PUT":

        $customerUpdate = json_decode(file_get_contents("php://input"));

        $customerId = $customerUpdate->id;
        $customerName = $customerUpdate->customerName;
        $customerEmail = $customerUpdate->customerEmail;
        $customerPassword = $customerUpdate->customerPassword;
     

        $updateCustomer = mysqli_query($db_conn, "UPDATE customers SET customerName='$customerName', customerEmail='$customerEmail',customerPassword='$customerPassword' WHERE customerId ='$customerId' ");


        if ($updateCustomer) {
            echo json_encode(["success" => "Customer record Updated successfully"]);
            return;
        } else {
            echo json_encode(["success" => "Please check the Customer data"]);
            return;
        }



        break;
}





?>