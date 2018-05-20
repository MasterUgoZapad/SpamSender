<?php
session_start();

if(!isset($_SESSION['login']) || empty($_SESSION['login']) || !isset($_SESSION['level']) || empty($_SESSION['level']) || $_SESSION['level']<1){
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE html>

<html>

<head>
    <title>Spam sender</title>
    <link rel="stylesheet" type="text/css" href="styles/main.css">
    <script src="scripts/validation/jquery.js"></script>
    <script src="elements/EN-errorstrings.js"></script>
    <script src="elements/EN-strings.js"></script>
    <script>
        $(function () {$("#navbar").load("elements/navbar.html");});
        $(function () {$("#errorwrap").load("elements/errorwrap.html");});
        $(function () {$("#submitwrap").load("elements/submitwrap.html");});
        $(function () {$("#instructions").load("elements/instructions.htm");});
    </script>
</head>

<body>
<div id="navbar"></div>
<div id="errorwrap"></div>
<div id="submitwrap"></div>
<div class="main">
    <div style="display: flex;" id="instructions"></div>
</div>

</body>
</html>