<?php
session_start();
?>
<!DOCTYPE html>

<html>

<head>
    <title>Spam sender</title>
    <link rel="stylesheet" type="text/css" href="styles/main.css">
    <script src="scripts/validation/jquery.js"></script>
    <script>
        $(function () {$("#navbar").load("elements/navbar.html");});
        $(function () {$("#errorwrap").load("elements/errorwrap.html");});
        $(function () {$("#submitwrap").load("elements/submitwrap.html");});
    </script>
</head>

<body>
<div id="navbar"></div>
<div id="errorwrap"></div>
<div id="submitwrap"></div>
<div class="main">
    <h2>Welcome to Spam Sender</h2>
</div>

</body>
</html>