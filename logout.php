<?php
/**
 * Created by PhpStorm.
 * User: mlivi
 * Date: 11/25/2015
 * Time: 5:04 PM
 */
session_start();
if(session_destroy()) // Destroying All Sessions
{
    header("Location: index.php"); // Redirecting To Home Page
}