<?php
/**
 * Created by PhpStorm.
 * User: mlivi
 * Date: 11/19/2015
 * Time: 8:11 AM
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

$email = $_SESSION['user'];
$newFirstName = "";
$newLastName = "";
$wNumber = "";

$studentHeaderSql = $dbh->prepare("SELECT * FROM Student WHERE email=:email");
$studentHeaderData = array("email" => $email);
$studentHeaderSql->execute($studentHeaderData);
$studentHeaderSql->setFetchMode(PDO::FETCH_ASSOC);
while ($row = $studentHeaderSql->fetch()) {
    $student_id = $row['student_id'];
    $wNumber = $row['wNumber'];
    $newFirstName = $row['firstName'];
    $newLastName = $row['lastName'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome Student!</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div>
        <h2>Welcome <?php echo $newFirstName; ?>!</h2>
        <div id="email"><b>Email:</b> <?php echo $email; ?></div>
        <div id="w-number"><b>WNumber:</b> <?php echo $wNumber; ?></div>
        <div id="logout-link"><a href='logout.php'>Log Out</a></div><br>
    </div>
    <div class="classFormDiv">
        <label>Which class are you applying for?</label>
        <input type="radio" name="classes" value="4800" />CS4800
        <input type="radio" name="classes" value="4890" />CS4890
        <input type="radio" name="classes" value="4890-SA" />CS4890 SA
        <div style="display:none" class="classForm" id="4800">
            <form action="4800insert.php" method="post">
                <table>
                    <tr>
                        <td><label>Project Description: </label></td>
                        <td><textarea class="big-input" name="projectDescription"></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Project Justification: </label></td>
                        <td><textarea class="big-input" name="projectJustification"></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Project Method: </label></td>
                        <td><textarea class="big-input" name="projectMethod"></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Project Resources: </label></td>
                        <td><textarea class="big-input" name="projectResources"></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Number of Credits Needed: </label></td>
                        <td><select name="projectCreditsNeeded">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><input name="submit" type="submit" value="Submit"></td>
                    </tr>
                </table>
            </form>
        </div>
        <div style="display:none" class="classForm" id="4890">
            <form action="4890insert.php" method="post">
                <table>
                    <tr>
                        <td><label>Job Description: </label></td>
                        <td><textarea class="big-input" name="jobDescription"></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Hours per week at work: </label></td>
                        <td><select name="jobHours">
                                <option value="5">5 - 9</option>
                                <option value="10">10 - 14</option>
                                <option value="15">15 - 19</option>
                                <option value="20">20+</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Do you have your Boss's approval?: </label></td>
                        <td><select name="boss">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Have you taken CS2420?: </label></td>
                        <td><select name="prior2420">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><input name="submit" type="submit" value="Submit"></td>
                    </tr>
                </table>
            </form>
        </div>
        <div style="display:none" class="classForm" id="4890-SA">
            <form action="4890SAinsert.php" method="post">
                <table>
                    <tr>
                        <td><label>Interested Course: </label></td>
                        <td><input name="saCourse" type="text"></td>
                    </tr>
                    <tr>
                        <td><label>Semester course was completed: </label></td>
                        <td><input name="semesterCompleted" type="text"></td>
                    </tr>
                    <tr>
                        <td><label>Whom did you take that course from: </label></td>
                        <td><input name="courseInstructor" type="text"></td>
                    </tr>
                    <tr>
                        <td><label>Final grade in that course: </label></td>
                        <td><input name="courseGrade" type="text"></td>
                    </tr>
                    <tr>
                        <td><label>Your strengths in that course: </label></td>
                        <td><textarea class="big-input" name="courseStrength"></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Your weaknesses in that course: </label></td>
                        <td><textarea class="big-input" name="courseWeaknesses"></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Explain in 250 words or less why you're a good candidate for a SA for this course: </label></td>
                        <td><textarea class="big-input" name="goodCandidate"></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Explain in 250 words or less why this course would be beneficial to you: </label></td>
                        <td><textarea class="big-input" name="courseBeneficial"></textarea></td>
                    </tr>
                    <tr>
                        <td><input name="submit" type="submit" value="Submit"></td>
                    </tr>
                </table>
            </form>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                //jQuery('p.boo').text('changed');
                $('input[type=radio]').click(function(){
                    $('.classForm').hide();
                    $('#' + $(this).val()).show();
                    $('.big-input').css({"width":"400", "height":"100"});
                });
            });

        </script>
    </div>
</body>
</html>