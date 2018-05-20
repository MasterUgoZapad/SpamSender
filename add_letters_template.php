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
    <script src="scripts/add_letters_template.js"></script>
    <script src="scripts/validation/add_letters_template.js"></script>
    <script src="scripts/common.js"></script>
    <script src="elements/EN-errorstrings.js"></script>
    <script src="elements/EN-strings.js"></script>
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
<div id="Main" class="main">
    <div class="firstColoumn">
        <h2 align="center">Template constructor</h2>
        <form id="formTemplate" name="formTemplate">
            <div style="display: block">
                <label style="display: block">
                    <span style="display: inline-block; width: 130px">Template name :</span>
                    <input style="width: 95%" type="text" id="name" name="name"/>
                </label>
                <label style="display: block">
                    <span style="display: inline-block; width: 130px">Subject:</span>
                    <input style="width: 95%" type="text" id="theme" name="theme"/>
                </label>
                <label style="display: block">
                    <span style="display: inline-block; width: 130px">Text :</span>
                    <textarea style="width:95%" id="text" name="text" rows="20"></textarea>
                </label>
            </div>
            <button type="submit">Save template</button>
        </form>
    </div>
    <div class="secondColoumn">
        <h2 align="center">Available aliases</h2>
        <form style="width:auto">
            <textarea class="wide_area" id="aliasesText" name="text"
                      rows="2" readonly></textarea>
        </form>
    </div>
</div>
</body>

</html>