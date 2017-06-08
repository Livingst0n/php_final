<?php
/**
 * Created by PhpStorm.
 * User: mlivi
 * Date: 11/24/2015
 * Time: 7:58 AM
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

echo "<link rel='stylesheet' type='text/css' href='styles.css'>";

$facultyEmail = $_SESSION['user'];
$facultyFirstName = "";

$newStudentId = "";
$studentFirstName = "";
$studentLastName = "";
$studentWNumber = "";
$studentEmail = "";

$application_id = "";
$explanation_id = "";

//4800
$projectDescription = "";
$projectJustification = "";
$projectMethod = "";
$projectResources = "";
$projectCreditsNeeded = "";

//4890
$jobDescription = "";
$jobHours = "";
$boss = "";
$prior2420 = "";

//4890SA
$saCourse = "";
$semesterCompleted = "";
$courseInstructor = "";
$courseGrade = "";
$courseStrength = "";
$courseWeaknesses = "";
$courseBeneficial = "";
$goodCandidate = "";

$facultyHeaderSql = $dbh->prepare("SELECT * FROM Faculty WHERE email=:email");
$facultyHeaderData = array("email" => $facultyEmail);
$facultyHeaderSql->execute($facultyHeaderData);
$facultyHeaderSql->setFetchMode(PDO::FETCH_ASSOC);
while ($row = $facultyHeaderSql->fetch()) {
    $facultyFirstName = $row['firstName'];
}
?>

<html>
    <body>
        <h2>Welcome <?php echo $facultyFirstName; ?>!</h2>
        <div><b>Email: </b> <?php echo $facultyEmail; ?></div>
        <div><a href="logout.php">Log Out</a></div>
        <div><a href="facultysignup.php">Click here to create new Faculty Account</a></div>
    </body>
</html>

<?php

$facultySql = $dbh->prepare("SELECT * FROM Application WHERE isApproved=:isApproved");
$facultyData = array("isApproved" => "new");
$facultySql->execute($facultyData);
$facultySql->setFetchMode(PDO::FETCH_ASSOC);
while ($row = $facultySql->fetch()) {
    $projectCreditsNeeded = $row['projectCreditsNeeded'];
    $boss = $row['boss'];
    $saCourse = $row['saCourse'];
    $application_id = $row['application_id'];

//Grab student's name and WNumber for the application
    $newStudentId = $row['student_id'];
    $studentInfoSql = $dbh->prepare("SELECT * FROM Student WHERE student_id=:student_id");
    $studentInfoData = array("student_id" => $newStudentId);
    $studentInfoSql->execute($studentInfoData);
    $studentInfoSql->setFetchMode(PDO::FETCH_ASSOC);
    while ($studentRow = $studentInfoSql->fetch()) {
        $studentFirstName = $studentRow['firstName'];
        $studentLastName = $studentRow['lastName'];
        $studentWNumber = $studentRow['wNumber'];
        $studentEmail = $studentRow['email'];
    }

//Depending on which fields are populated, display the corresponding application.
    if ($projectCreditsNeeded != null) { //4800
        $explanation_id = $row["explanation_id"];
        $explanation4800Sql = $dbh->prepare("SELECT * FROM Explanation WHERE explanation_id=:explanation_id");
        $explanation4800Data = array("explanation_id" => $explanation_id);
        $explanation4800Sql->execute($explanation4800Data);
        $explanation4800Sql->setFetchMode(PDO::FETCH_ASSOC);
        while ($newRow = $explanation4800Sql->fetch()) {
            $projectDescription = $newRow['projectDescription'];
            $projectJustification = $newRow['projectJustification'];
            $projectMethod = $newRow['projectMethod'];
            $projectResources = $newRow['projectResources'];
            echo
                "<div class='app-block'><h3>4800 Application</h3>" .
                "<form action='ApproveDeny.php' method='post'><table class='app-table'>
                    <input type='hidden' name='studentEmail' value='$studentEmail'>
                    <input type='hidden' name='application_id' value='$application_id'>
                    <tr>
                        <td><b>Name: </b></td>
                        <td>" . $studentFirstName . " " . $studentLastName . "</td>
                    </tr>
                    <tr>
                        <td><b>WNumber: </b></td>
                        <td>" . $studentWNumber . "</td>
                    </tr>
                    <tr>
                        <td><b>Description: </b></td>
                        <td>" . $projectDescription . "</td>
                    </tr>
                    <tr>
                        <td><b>Project Justification: </b></td>
                        <td>" . $projectJustification . "</td>
                    </tr>
                    <tr>
                        <td><b>Project Method: </b></td>
                        <td>" . $projectMethod . "</td>
                    </tr>
                    <tr>
                        <td><b>Project Resources: </b></td>
                        <td>" . $projectResources . "</td>
                    </tr>
                    <tr>
                        <td><b>Credits Needed from Project: </b></td>
                        <td>" . $projectCreditsNeeded . "</td>
                    </tr>
                    <tr>
                        <td><b>Comments: </b></b></td>
                        <td><textarea name='comments' cols='40' rows='5' style='resize: none;'></textarea></td>
                    </tr>
                </table>
                <input type='submit' name='4800approve' value='Approve'><input type='submit' name='4800deny' value='Deny'></form><br></div>";
        }
    } else if ($boss != null) { //4890
        $jobDescription = $row['jobDescription'];
        $jobHours = $row['jobHours'];
        $boss = $row['boss'];
        $prior2420 = $row['prior2420'];
        echo
            "<div class='app-block'><h3>4890 Application</h3>" .
            "<form action='ApproveDeny.php' method='post'><table class='app-table'>
                <input type='hidden' name='studentEmail' value='$studentEmail'>
                <input type='hidden' name='application_id' value='$application_id'>
                <tr>
                    <td><b>Name: </b></td>
                    <td>" . $studentFirstName . " " . $studentLastName . "</td>
                </tr>
                <tr>
                    <td><b>WNumber: </b></td>
                    <td>" . $studentWNumber . "</td>
                </tr>
                <tr>
                    <td><b>Job Description: </b></td>
                    <td>" . $jobDescription . "</td>
                </tr>
                <tr>
                    <td><b>Job Hours: </b></td>
                    <td>" . $jobHours . "</td>
                </tr>
                <tr>
                    <td><b>Boss Approval: </b></td>
                    <td>" . $boss . "</td>
                </tr>
                <tr>
                    <td><b>Prior CS2420: </b></td>
                    <td>" . $prior2420 . "</td>
                </tr>
                <tr>
                    <td><b>Comments: </b></b></td>
                    <td><textarea name='comments' cols='40' rows='5' style='resize: none;'></textarea></td>
                </tr>
            </table>
            <input type='submit' name='4890approve' value='Approve'><input type='submit' name='4890deny' value='Deny'></form><br></div>";
    } else if ($saCourse != null) { //4890SA
        $explanation_id = $row["explanation_id"];
        $explanation4890Sql = $dbh->prepare("SELECT * FROM Explanation WHERE explanation_id=:explanation_id");
        $explanation4890Data = array("explanation_id" => $explanation_id);
        $explanation4890Sql->execute($explanation4890Data);
        $explanation4890Sql->setFetchMode(PDO::FETCH_ASSOC);
        while ($newRow = $explanation4890Sql->fetch()) {
            $goodCandidate = $newRow['goodCandidate'];
            $courseBeneficial = $newRow['courseBeneficial'];
            $courseWeaknesses = $newRow['courseWeaknesses'];
            $courseStrength = $newRow['courseStrength'];
            echo
                "<div class='app-block'><h3>4890 Student Assistant Application</h3>" .
                "<form action='ApproveDeny.php' method='post'><table class='app-table'>
                    <input type='hidden' name='studentEmail' value='$studentEmail'>
                    <input type='hidden' name='application_id' value='$application_id'>
                    <tr>
                        <td><b>Name: </b></td>
                        <td>" . $studentFirstName . " " . $studentLastName . "</td>
                    </tr>
                    <tr>
                        <td><b>WNumber: </b></td>
                        <td>" . $studentWNumber . "</td>
                    </tr>
                    <tr>
                        <td><b>Good Candidate: </b></td>
                        <td>" . $goodCandidate . "</td>
                    </tr>
                    <tr>
                        <td><b>Course Beneficial: </b></td>
                        <td>" . $courseBeneficial . "</td>
                    </tr>
                    <tr>
                        <td><b>Course Weaknesses: </b></td>
                        <td>" . $courseWeaknesses . "</td>
                    </tr>
                    <tr>
                        <td><b>Course Strengths: </b></td>
                        <td>" . $courseStrength . "</td>
                    </tr>
                    <tr>
                        <td><b>Comments: </b></b></td>
                        <td><textarea name='comments' cols='40' rows='5' style='resize: none;'></textarea></td>
                    </tr>
                </table>
                <input type='submit' name='4890saApprove' value='Approve'><input type='submit' name='4890saDeny' value='Deny'></form><br></div>";
        }
    } else {
        die("something broke");
    }
}
