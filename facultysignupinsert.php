<?php
/**
 * Created by PhpStorm.
 * User: mlivi
 * Date: 12/12/2015
 * Time: 5:24 PM
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
} catch (PDOException $e) {
    echo "Something has gone wrong: ".$e->getMessage();
    die();
}

$firstName = "";
$lastName = "";
$email = "";
$password = "";
$ok = true;
if (isset($_POST['submit'])) {
    if (!isset($_POST['first_name']) || $_POST['first_name'] === '') {
        $ok = false;
    } else {
        $firstName = $_POST["first_name"];
        $firstName = strip_tags($firstName);
    }
    if (!isset($_POST['last_name']) || $_POST['last_name'] === '') {
        $ok = false;
    } else {
        $lastName = $_POST["last_name"];
        $lastName = strip_tags($lastName);
    }
    if (!isset($_POST['email']) || $_POST['email'] === '') {
        $ok = false;
    } else {
        $email = $_POST["email"];
        $email = strip_tags($email);
    }
    if (!isset($_POST['password']) || $_POST['password'] === '') {
        $ok = false;
    } else {
        $password = $_POST["password"];
        $password = strip_tags($password);
        $password = password_hash($password, PASSWORD_BCRYPT);
    }
}

if (!$ok) {
    die("It died...with fire. But...also...Please make sure all fields are filled.");
}

$sql = $dbh->prepare("INSERT INTO Faculty (firstName, lastName, email, password)" .
    " VALUES (:firstName, :lastName, :email, :password)");
$data = array("firstName" => $firstName, "lastName" => $lastName, "email" => $email, "password" => $password);
$sql->execute($data);

header('location: index.php');