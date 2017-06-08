<?php
/**
 * Created by PhpStorm.
 * User: mlivi
 * Date: 12/1/2015
 * Time: 8:14 AM
 */

if (!isset($_SESSION)) {
    session_start();
}
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

/* CHANGE THIS EMAIL ---> */$tempFacultyEmail = 'mikelivingston04@gmail.com'; // <<------- CHANGE THIS EMAIL TO YOURS AS A PROFESSOR

$email = $_SESSION['user'];
$jobDescription = "";
$jobHours = "";
$boss = "";
$prior2420 = "";
$ok = true;
if (isset($_POST['submit'])) {
    if (!isset($_POST['jobDescription']) || $_POST['jobDescription'] === '') {
        $ok = false;
    } else {
        $jobDescription = $_POST["jobDescription"];
        $jobDescription = strip_tags($jobDescription);
    }
    if (!isset($_POST['jobHours']) || $_POST['jobHours'] === '') {
        $ok = false;
    } else {
        $jobHours = $_POST["jobHours"];
        $jobHours = strip_tags($jobHours);
    }
    if (!isset($_POST['prior2420']) || $_POST['prior2420'] === '') {
        $ok = false;
    } else {
        $prior2420 = $_POST["prior2420"];
        $prior2420 = strip_tags($prior2420);
    }
    if (!isset($_POST['boss']) || $_POST['boss'] === '') {
        $ok = false;
    } else {
        $boss = $_POST["boss"];
        $boss = strip_tags($boss);
    }
}

if ($ok) {
//--SEND EMAIL-------------------------------
    $msg = $email . " has applied for CS4890. Please check the application system to approve/deny.\n" .
         "Click this link to go to the application system: icarus.cs.weber.edu/~ml92387/final";
    mail($tempFacultyEmail, '4890 Application', $msg);
//END --SEND EMAIL----------------------------
}

if (!$ok) {
    die("It died...with fire. But...also...Please make sure all fields are filled.");
}

$studentSql = $dbh->prepare("SELECT * FROM Student WHERE email=:email");
$studentData = array("email" => $email);
$studentSql->execute($studentData);
$studentSql->setFetchMode(PDO::FETCH_ASSOC);
while ($row = $studentSql->fetch()) {
    $student_id = $row['student_id'];
    $wNumber = $row['wNumber'];
    $newFirstName = $row['firstName'];
    $newLastName = $row['lastName'];
}

$sql = $dbh->prepare("INSERT INTO Application (jobDescription, jobHours, prior2420, boss, student_id, isApproved)" .
    " VALUES (:jobDescription, :jobHours, :prior2420, :boss, :student_id, :isApproved)");
$data = array("jobDescription" => $jobDescription, "jobHours" => $jobHours, "prior2420" => $prior2420, "boss" => $boss,"student_id" => $student_id, "isApproved" => "new");
$sql->execute($data);

header('location: student.php');