<?php
/**
 * This script handles registration and payment
 *
 * PHP version 7.2
 *
 * @category Lawyer_Processor
 * @package  Lawyer_Processor
 * @author   Benson Imoh,ST <benson@stbensonimoh.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://stbensonimoh.com
 */
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

//Require Classes
require '../config.php';
require './DB.php';
require './Notify.php';
require './Newsletter.php';

// Capture Post Data that is coming from the form
$_POST = json_decode(file_get_contents('php://input'), true);

$firstName = $_POST['firstName'];
$middleName = $_POST['middleName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$location = $_POST['location'];
$service = $_POST['service'];
$handledCases = $_POST['handledCases'];
$probonoCases = $_POST['probonoCases'];
$available = $_POST['available'];
$familiarCases = $_POST['familiarCases'];
$requireMentor = $_POST['requireMentor'];
$mentorNeededFor = $_POST['mentorNeededFor'];
$agree = $_POST['agree'];

$name = $firstName . " " . $lastName;

require './emails.php';

$details = array(
    "firstName" => $_POST['firstName'],
    "middleName" => $_POST['middleName'],
    "lastName" => $_POST['lastName'],
    "email" => $_POST['email'],
    "phone" => $_POST['phone'],
    "location" => $_POST['location'],
    "service" => $_POST['service'],
    "handledCases" => $_POST['handledCases'],
    "probonoCases" => $_POST['probonoCases'],
    "available" => $_POST['available'],
    "familiarCases" => $_POST['familiarCases'],
    "requireMentor" => $_POST['requireMentor'],
    "mentorNeededFor" => $_POST['mentorNeededFor'],
    "agree" => $_POST['agree']
);

$emails = array(
    array(
            "email"         =>  $email,
            "variables"     =>  array(
            "phone"         =>  $phone,
            "name"          =>  $firstName,
            "middleName"    =>  $middleName,
            "lastName"      =>  $lastName
            )
    )
);

$db = new DB($host, $db, $username, $password);
$notify = new Notify($smstoken, $emailHost, $emailUsername, $emailPassword, $SMTPDebug, $SMTPAuth, $SMTPSecure, $Port);
$newsletter = new Newsletter($apiUserId, $apiSecret);

// Check to see if userexists

if ($db->userExists($email, "lawyer")) {
    echo json_encode("user_exists");
} elseif ($db->insertUser("lawyer", $details)) {
    // Put the User into the Database
    $notify->viaEmail("letstalk@hopebehindbarsafrica.org", "Hope Behind Bars Africa", $email, $name, $emailBodyLawyer, "We're excited to have you join us!");
    $notify->viaEmail("letstalk@hopebehindbarsafrica.org", "Hope Behind Bars Africa", "letstalk@hopebehindbarsafrica.org", "Admin", $emailBodyLawyerOrganisation, "A Lawyer has signed up on the ConnectLawyer App.");
    $notify->viaSMS("HBBAfrica", "Dear {$firstName} {$lastName}, tthank you for bringing hope by choosing to contribute your quota towards providing access to justice for indigents. We're excited to have you join us. Our representative will speak with you shortly. Cheers!", $phone);
    $notify->viaSMS("HBBAfrica", "A Lawyer has signed up on the ConnectLawyer App. Kindly check your email for the details.", "08073600790");
    $notify->viaSMS("HBBAfrica", "A Lawyer has signed up on the ConnectLawyer App. Kindly check your email for the details. Kindly check your email for the details.", "07033633243");
    $newsletter->insertIntoList("2278825", $emails);
    echo json_encode("success");

}
