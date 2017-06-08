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
$projectDescription = "";
$projectJustification = "";
$projectMethod = "";
$projectResources = "";
$projectCreditsNeeded = "";
$ok = true;
if (isset($_POST['submit'])) {
    if (!isset($_POST['projectDescription']) || $_POST['projectDescription'] === '') {
        $ok = false;
    } else {
        $projectDescription = $_POST["projectDescription"];
        $projectDescription = strip_tags($projectDescription);
    }
    if (!isset($_POST['projectJustification']) || $_POST['projectJustification'] === '') {
        $ok = false;
    } else {
        $projectJustification = $_POST["projectJustification"];
        $projectJustification = strip_tags($projectJustification);
    }
    if (!isset($_POST['projectMethod']) || $_POST['projectMethod'] === '') {
        $ok = false;
    } else {
        $projectMethod = $_POST["projectMethod"];
        $projectMethod = strip_tags($projectMethod);
    }
    if (!isset($_POST['projectResources']) || $_POST['projectResources'] === '') {
        $ok = false;
    } else {
        $projectResources = $_POST["projectResources"];
        $projectResources = strip_tags($projectResources);
    }
    if (!isset($_POST['projectCreditsNeeded']) || $_POST['projectCreditsNeeded'] === '') {
        $ok = false;
    } else {
        $projectCreditsNeeded = $_POST["projectCreditsNeeded"];
        $projectCreditsNeeded = strip_tags($projectCreditsNeeded);
    }
}

if ($ok) {
//--SEND EMAIL-------------------------------
    $msg = $email . " has applied for CS4800. Please check the application system to approve/deny.\n" .
        "Click this link to go to the application system: icarus.cs.weber.edu/~ml92387/final";
    mail($tempFacultyEmail, '4800 Application', $msg);
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

$explanationSql = $dbh->prepare("INSERT INTO Explanation (projectDescription, projectJustification, projectMethod, projectResources, student_id)" .
        " VALUES (:projectDescription, :projectJustification, :projectMethod, :projectResources, :student_id)");
$explanationData = array("projectDescription" => $projectDescription, "projectJustification" => $projectJustification, "projectMethod" => $projectMethod, "projectResources" => $projectResources, "student_id" => $student_id);
$explanationSql->execute($explanationData);

$explanationIdSql = $dbh->prepare("SELECT * FROM Explanation WHERE student_id=:student_id");
$explanationIdData = array("student_id" => $student_id);
$explanationIdSql->execute($explanationIdData);
$explanationIdSql->setFetchMode(PDO::FETCH_ASSOC);
$explanation_id = "";
while ($row = $explanationIdSql->fetch()) {
    $explanation_id = $row['explanation_id'];
}


$sql = $dbh->prepare("INSERT INTO Application (projectCreditsNeeded, student_id, explanation_id, isApproved)" .
    " VALUES (:projectCreditsNeeded, :student_id, :explanation_id, :isApproved)");
$data = array("projectCreditsNeeded" => $projectCreditsNeeded, "student_id" => $student_id, "explanation_id" => $explanation_id, "isApproved" => "new");
$sql->execute($data);


header('location: student.php');
