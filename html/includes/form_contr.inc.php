<?php

//  Control File, takes care of input from the user

declare(strict_types=1);

function is_input_empty(string $fname, string $lname, string $email, string $cell_phone) {
    if (empty($fname) || empty($lname) || empty ($email) || empty($cell_phone)) {
        return true;
    }
    else {
        return false;
    }
}

function is_email_invalid(string $email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    else {
        return false;
    }
}