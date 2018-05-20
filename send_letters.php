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
    <link rel="stylesheet" type="text/css" href="styles/main.css"/>
    <script src="scripts/validation/jquery.js"></script>
    <script src="scripts/validation/jquery.validate.js"></script>
    <script src="scripts/send_letters.js"></script>
    <script src="scripts/common.js"></script>
    <script src="elements/EN-errorstrings.js"></script>
    <script src="elements/EN-strings.js"></script>
    <script>
        $(function () {$("#navbar").load("elements/navbar.html");});
        $(function () {$("#errorwrap").load("elements/errorwrap.html");});
        $(function () {$("#submitwrap").load("elements/submitwrap.html");});
        $(function () {
            $("#progresswrap").load("elements/progress.html");
        });
    </script>
</head>

<body>
<div id="navbar"></div>
<div id="errorwrap"></div>
<div id="submitwrap"></div>
<div id="progresswrap"></div>
<div id="Main" class="main" style="width:100%">
    <div class="firstColoumn" style="width:100%">
        <div style="display: flex; flex-direction: column;">
            <label id="labelTo"></label>
                <label style="display: inline-block;">Email :</label>
                <input style="width: 95%" type="text" id="to" name="to" onchange="OnChangeEmail()"/>
                <label style="display: inline-block;">Subject:</label>
                <input style="width: 95%" type="text" id="theme" name="theme"/>
                <label style="display: inline-block;">Text :</label>
                <textarea style="width:95%" id="text" name="text" rows="20"></textarea>
        </div>
        <button align="right" type="button" onclick="SendLetters()">Send</button>
        <select onchange="OnTemplateSelect()" id="templateSelect">
        </select>
        <select onchange="OnGroupSelect()" id="groupSelect">
        </select>
    </div>
</div>
</body>

</html>