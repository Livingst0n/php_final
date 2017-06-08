<?php
/**
 * Created by PhpStorm.
 * User: mlivi
 * Date: 12/10/2015
 * Time: 8:01 AM
 */

$host = "localhost";
$dbname = "application_4800_4890";
$user = "W01092387";
$pass = "Michaelcs!";

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    echo "Something has gone wrong: " . $e->getMessage();
    die();
}

$studentEmail = "";
$comments = "";
$msg = "";
$application_id = "";
$isApproved = "";

if (isset($_POST['4800approve'])) {
    $application_id = $_POST['application_id'];
    $studentEmail = $_POST['studentEmail'];
    $comments = $_POST['comments'];
    $isApproved = "approved";
    $msg = "Congratulations! Your CS4800 Application has been approved." . "\n" .
        "Comments from the professor: " . $comments;
    mail($studentEmail, '4800 Application', $msg);
} else if (isset($_POST['4800deny'])) {
    $application_id = $_POST['application_id'];
    $studentEmail = $_POST['studentEmail'];
    $comments = $_POST['comments'];
    $isApproved = "denied";
    $msg = "I'm sorry, your CS4800 Application has not been approved." . "\n" .
        "Comments from the professor: " . $comments;
    mail($studentEmail, '4800 Application', $msg);
} else if (isset($_POST['4890approve'])) {
    $application_id = $_POST['application_id'];
    $studentEmail = $_POST['studentEmail'];
    $comments = $_POST['comments'];
    $isApproved = "approved";
    $msg = "Congratulations! Your CS4890 Application has been approved." . "\n" .
        "Comments from the professor: " . $comments;
    mail($studentEmail, '4890 Application', $msg);
} else if (isset($_POST['4890deny'])) {
    $application_id = $_POST['application_id'];
    $studentEmail = $_POST['studentEmail'];
    $comments = $_POST['comments'];
    $isApproved = "denied";
    $msg = "I'm sorry, your CS4890 Application has not been approved." . "\n" .
        "Comments from the professor: " . $comments;
    mail($studentEmail, '4890 Application', $msg);
} else if (isset($_POST['4890saApprove'])) {
    $application_id = $_POST['application_id'];
    $studentEmail = $_POST['studentEmail'];
    $comments = $_POST['comments'];
    $isApproved = "approved";
    $msg = "Congratulations! Your CS4890 Student Assistant Application has been approved." . "\n" .
        "Comments from the professor: " . $comments;
    mail($studentEmail, '4890 Student Assistant Application', $msg);
} else if (isset($_POST['4890saDeny'])) {
    $application_id = $_POST['application_id'];
    $studentEmail = $_POST['studentEmail'];
    $comments = $_POST['comments'];
    $isApproved = "denied";
    $msg = "I'm sorry, your CS4890 Student Assistant Application has not been approved." . "\n" .
        "Comments from the professor: " . $comments;
    mail($studentEmail, '4890 Student Assistant Application', $msg);
} else {
    die("something broke");
}

$statement = $dbh->prepare("UPDATE Application SET isApproved=:isApproved WHERE application_id=:application_id");
$data = array("isApproved" => $isApproved, "application_id" => $application_id);
$statement->execute($data);

header('location: faculty.php');