<?php
/**
 * This script handles registration and payment
 *
 * PHP version 7.2
 *
 * @category Registration_And_Payment
 * @package  Registration_And_Payment
 * @author   Benson Imoh,ST <benson@stbensonimoh.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://stbensonimoh.com
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

//Require Classes
require '../config.php';
require './DB.php';
require './Notify.php';
require './Newsletter.php';

// Capture Post Data that is coming from the form

$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$phone = $_POST['phone'];

$details = array(
    "firstName" => $_POST['firstName'],
    "lastName" => $_POST['lastName'],
    "email" => $_POST['email'],
    "phone" => $_POST['phone']
);

$emails = array(
    array(
            "email"         =>  $email,
            "variables"     =>  array(
            "phone"         =>  $phone,
            "name"          =>  $firstName,
            "lastName"      =>  $lastName
            )
    )
);

$db = new DB($host, $db, $username, $password);
$notify = new Notify($smstoken, $emailHost, $emailUsername, $emailPassword, $SMTPDebug, $SMTPAuth, $SMTPSecure, $Port);
$newsletter = new Newsletter($apiUserId, $apiSecret);

// Check to see if userexists

// if ($db->userExists($email, "person")) {
//     echo "User Exists";
// } else {
//     echo "User doesn't exist!";
// }

// Put the User into the Database
// if ($db->insertUser("person", $details)) {
//     echo "User Inserted";
// } else {
//     echo "User not inserted";
// }

// // Send Notifications
// $notify->viaEmail("info@awlo.org", "African Women in Leadership Organisation", $email, $firstName, $emailBody, "This one Na Test");
// $notify->viaSMS("AWLO", "Hey there! I'm watching you.", $phone);
// $newsletter->insertIntoList("2272840", $emails);
