<?php
include('login.php');
/*
if (isset($_SESSION['user'])) {
    header("location: student.php");
}*/

?>

<html>
<head>
    <title>4800/4890 Application Login</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div>
        <h1>Log In Here</h1>
        <form action="" method="post">
            <table>
                <tr>
                    <td><label>Weber Email: </label></td>
                    <td><input name="email" type="text"></td>
                </tr>
                <tr>
                    <td><label>Password: </label></td>
                    <td><input name="password" type="password"></td>
                </tr>
                <tr>
                    <td><input name="submit" type="submit" value="Login"></td>
                </tr>
                <tr>
                    <td><span><?php echo $error; ?></span></td>
                </tr>
            </table>
        </form>
        <a href="signup.php">No student account? Sign up here!</a>
    </div>
</body>
</html>