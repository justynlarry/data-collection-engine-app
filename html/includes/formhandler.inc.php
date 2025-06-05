<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//  Signup Form:  


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $cc_email = $_POST["cc_email"];
    $cell_phone = $_POST["cell_phone"];
    $work_phone = $_POST["work_phone"];
    $home_phone = $_POST["home_phone"];
    $fax = $_POST["fax"];
    $company_name = $_POST["company_name"];
    $company_addr1 = $_POST["company_addr1"];
    $company_addr2 = $_POST["company_addr2"];
    $company_city = $_POST["company_city"];
    if (empty($company_state)) {
        $errors["state_missing"] = "Please select a state.";
    }
    
    $company_state = $_POST["company_state"];
    $company_zip = $_POST["company_zip"] ?? "";
    try {
        require_once "dbh.inc.php";
        require_once "form_model.inc.php";
        require_once "form_contr.inc.php";


    //  ERROR HANDLERS - Make sure user inputs name, phone, email    
    $errors = [];
    
    if (is_input_empty($fname, $lname, $email, $cell_phone)) {
        $errors["empty_input"] = "Please fill in all required fields.";
    }

    if (is_email_invalid($email)) {
        $errors["invalid_email"] = "Invalid e-mail, please enter a valid email address.";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p class='error'>{$error}</p>";
        }
        exit; // Prevent further execution.
    }


        create_user(
            $pdo, 
            $fname, 
            $lname,     
            $email,
            $cc_email,
            $cell_phone,
            $work_phone,
            $home_phone,
            $fax,
            $company_name,
            $company_addr1,
            $company_addr2,
            $company_city,
            $company_state,
            $company_zip
        );


            header("Location: ../good_bye.php");

            $pdo = null;
            $stmt = null;


            die();

    } catch (PDOException $e) {
        die("Query failed:  " . $e->getMessage());
    }
    
    }
 else {
    header("Location: ../index.php");
}