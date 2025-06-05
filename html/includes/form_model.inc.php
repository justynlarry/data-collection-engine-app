<?php

declare(strict_types=1);  //Set to true, allows type declarations

function create_user(
    object $pdo, 
    string $fname, 
    string $lname,     
    string $email,
    string $cc_email,
    string $cell_phone,
    string $work_phone,
    string $home_phone,
    string $fax,
    string $company_name,
    string $company_addr1,
    string $company_addr2,
    string $company_city,
    string $company_state,
    string $company_zip

    ) {


$query = "INSERT INTO RBi_Realtors.rbi_realtors (
    fname,
    lname,
    email,
    cc_email,
    cell_phone,
    work_phone,
    home_phone,
    fax,
    company_name,
    company_addr1,
    company_addr2,
    company_city,
    company_state,
    company_zip
    )
    VALUES (
    :fname,
    :lname,
    :email,
    :cc_email,
    :cell_phone,
    :work_phone,
    :home_phone,
    :fax,
    :company_name,
    :company_addr1,
    :company_addr2,
    :company_city,
    :company_state,
    :company_zip  
    );";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":fname", $fname);
    $stmt->bindParam(":lname", $lname);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":cc_email", $cc_email);
    $stmt->bindParam(":cell_phone", $cell_phone);
    $stmt->bindParam(":work_phone", $work_phone);
    $stmt->bindParam(":home_phone", $home_phone);
    $stmt->bindParam(":fax", $fax);
    $stmt->bindParam(":company_name", $company_name);
    $stmt->bindParam(":company_addr1", $company_addr1);
    $stmt->bindParam(":company_addr2", $company_addr2);
    $stmt->bindParam(":company_city", $company_city);
    $stmt->bindParam(":company_state", $company_state);
    $stmt->bindParam(":company_zip", $company_zip);

    $stmt->execute();
}