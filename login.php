<?php
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

$error='';
if (isset($_POST['submit'])) {
    if (empty($_POST['email']) || empty($_POST['password'])) {
        $error = "Email or Password is invalid";
    }
    else
    {
// Define $username and $password
        $email = $_POST['email'];
        $email = strip_tags($email);
        $password = $_POST['password'];
        $password = strip_tags($password);
        $hash = password_hash($password, PASSWORD_BCRYPT);

// Selecting Database

        $studentSql = $dbh->prepare("SELECT password FROM Student WHERE email=:email");
        $studentData = array("email" => $email);
        $studentSql->execute($studentData);
        $studentSql->setFetchMode(PDO::FETCH_ASSOC);
        $hashedPassword = '';
        while ($row = $studentSql->fetch()) {
            $hashedPassword = $row['password'];
        }
        $numStudentRows = $studentSql->rowCount();

        $facultySql = $dbh->prepare("SELECT password FROM Faculty WHERE email=:email");
        $facultyData = array("email" => $email);
        $facultySql->execute($facultyData);
        $facultySql->setFetchMode(PDO::FETCH_ASSOC);
        if ($numStudentRows == 0) {
            while ($row = $facultySql->fetch()) {
                $hashedPassword = $row['password'];
            }
        }
        $numFacultyRows = $facultySql->rowCount();

// SQL query to fetch information of registerd users and finds user match.
        if ($numFacultyRows == 1 && $numStudentRows == 1) {
            die("you exist in both tables");
        }
        if ($numFacultyRows == 1 || $numStudentRows == 1) {
            $_SESSION['user']=$email; // Initializing Session
            if ($numFacultyRows == 1 && $numStudentRows == 0) {
                //send to faculty page
                if (password_verify($password, $hashedPassword)) {
                    echo "true";
                } else {
                    die("you shall not pass faculty person!");
                }
                header("location: faculty.php");
            } else if ($numStudentRows == 1 && $numFacultyRows == 0) {
                //send to student page
                if (password_verify($password, $hashedPassword)) {
                    echo "true";
                } else {
                    die("you shall not pass student person!");
                }
                header("location: student.php");
            } else {
                die('it died...with lots of fire');
            }
        } else {
            $error = "Username or Password is invalid";
        }
    }
}