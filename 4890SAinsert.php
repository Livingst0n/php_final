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
$saCourse = "";
$semesterCompleted = "";
$courseInstructor = "";
$courseGrade = "";
$courseStrength = "";
$courseWeaknesses = "";
$courseBeneficial = "";
$goodCandidate = "";
$ok = true;
if (isset($_POST['submit'])) {
    if (!isset($_POST['saCourse']) || $_POST['saCourse'] === '') {
        $ok = false;
    } else {
        $saCourse = $_POST["saCourse"];
        $saCourse = strip_tags($saCourse);
    }
    if (!isset($_POST['semesterCompleted']) || $_POST['semesterCompleted'] === '') {
        $ok = false;
    } else {
        $semesterCompleted = $_POST["semesterCompleted"];
        $semesterCompleted = strip_tags($semesterCompleted);
    }
    if (!isset($_POST['courseGrade']) || $_POST['courseGrade'] === '') {
        $ok = false;
    } else {
        $courseGrade = $_POST["courseGrade"];
        $courseGrade = strip_tags($courseGrade);
    }
    if (!isset($_POST['courseInstructor']) || $_POST['courseInstructor'] === '') {
        $ok = false;
    } else {
        $courseInstructor = $_POST["courseInstructor"];
        $courseInstructor = strip_tags($courseInstructor);
    }
    if (!isset($_POST['courseStrength']) || $_POST['courseStrength'] === '') {
        $ok = false;
    } else {
        $courseStrength = $_POST["courseStrength"];
        $courseStrength = strip_tags($courseStrength);
    }
    if (!isset($_POST['courseWeaknesses']) || $_POST['courseWeaknesses'] === '') {
        $ok = false;
    } else {
        $courseWeaknesses = $_POST["courseWeaknesses"];
        $courseWeaknesses = strip_tags($courseWeaknesses);
    }
    if (!isset($_POST['courseBeneficial']) || $_POST['courseBeneficial'] === '') {
        $ok = false;
    } else {
        $courseBeneficial = $_POST["courseBeneficial"];
        $courseBeneficial = strip_tags($courseBeneficial);
    }
    if (!isset($_POST['goodCandidate']) || $_POST['goodCandidate'] === '') {
        $ok = false;
    } else {
        $goodCandidate = $_POST["goodCandidate"];
        $goodCandidate = strip_tags($goodCandidate);
    }
}

if ($ok) {
//--SEND EMAIL-------------------------------
    $msg = $email . " has applied for CS4890 - Student Assistant. Please check the application system to approve/deny.\n" .
        "Click this link to go to the application system: icarus.cs.weber.edu/~ml92387/final";
    mail($tempFacultyEmail, '4890 Student Assistant Application', $msg);
//END --SEND EMAIL----------------------------
}

if (!$ok) {
    die("It died...with fire. But...also...Please make sure all fields are filled.");
}

$studentSql = $dbh->prepare("SELECT * FROM Student WHERE email=:email");
$studentData = array("email" => $email);
$studentSql->execute($studentData);
$studentSql->setFetchMode(PDO::FETCH_ASSOC);
$student_id ="";
while ($row = $studentSql->fetch()) {
    $student_id = $row['student_id'];
    $wNumber = $row['wNumber'];
    $newFirstName = $row['firstName'];
    $newLastName = $row['lastName'];
}

$explanationSql = $dbh->prepare("INSERT INTO Explanation (courseStrength, courseWeaknesses, courseBeneficial, goodCandidate, student_id)" .
                            " VALUES (:courseStrength, :courseWeaknesses, :courseBeneficial, :goodCandidate, :student_id)");
$explanationData = array("courseStrength" => $courseStrength, "courseWeaknesses" => $courseWeaknesses, "courseBeneficial" => $courseBeneficial, "goodCandidate" => $goodCandidate, "student_id" => $student_id);
$explanationSql->execute($explanationData);

$explanationIdSql = $dbh->prepare("SELECT * FROM Explanation WHERE student_id=:student_id");
$explanationIdData = array("student_id" => $student_id);
$explanationIdSql->execute($explanationIdData);
$explanationIdSql->setFetchMode(PDO::FETCH_ASSOC);
$explanation_id = "";
while ($row = $explanationIdSql->fetch()) {
    $explanation_id = $row['explanation_id'];
}

$sql = $dbh->prepare("INSERT INTO Application (saCourse, semesterCompleted, courseGrade, courseInstructor, student_id, explanation_id, isApproved)" .
    " VALUES (:saCourse, :semesterCompleted, :courseGrade, :courseInstructor, :student_id, :explanation_id, :isApproved)");

$data = array("saCourse" => $saCourse, "semesterCompleted" => $semesterCompleted, "courseGrade" => $courseGrade, "courseInstructor" => $courseInstructor, "student_id" => $student_id, "explanation_id" => $explanation_id, "isApproved" => "new");
$sql->execute($data);

header('location: student.php');