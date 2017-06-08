<?php
/**
 * Created by PhpStorm.
 * User: mlivi
 * Date: 12/12/2015
 * Time: 5:23 PM
 */
?>

<html>
<head>
    <title>Sign up</title>
</head>
<body>
<div>
    <h1>Sign Up Here</h1>
    <form action="facultysignupinsert.php" method="post">
        <table>
            <tr>
                <td><label>First Name: </label></td>
                <td><input name="first_name" type="text"></td>
            </tr>
            <tr>
                <td><label>Last Name: </label></td>
                <td><input name="last_name" type="text"></td>
            </tr>
            <tr>
                <td><label>Email: </label></td>
                <td><input name="email" type="text"></td>
            </tr>
            <tr>
                <td><label>Password: </label></td>
                <td><input name="password" type="password"></td>
            </tr>
            <tr>
                <td><input name="submit" type="submit" value="Sign up"></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>