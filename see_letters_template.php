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
    <script src="scripts/see_letters_template.js"></script>
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
        <h2 align="center">Available templates</h2>
        <form align="left" style="width:auto">
            <button align="right" type="button" onclick="ApplyTemplate()">Aplly to letter</button>
            <button align="right" type="button" onclick="location.href = 'add_letters_template.php'">Add</button>
            <button align="right" type="button" onclick="DeleteTemplate()">Delete</button>
            <button align="right" type="button" onclick="EditTemplate()">Edit</button>
        </form>
        <form align="left" style="width:auto">
        </form>
        <select onchange="OnTemplateSelect()" id="TemplateListSelect" size="50" class="select_widelist" onFocus="window.scrollTo(0, 0);">
        </select>

    </div>
    <div class="secondColoumn">
        <h2 align="center">Template preview</h2>
        <div style="display: block">
            <label style="display: block">
                <span style="display: inline-block; width: 130px">Template name :</span>
                <input style="background-color: #dddddd; width: 95%" type="text" id="name" name="name" readonly/>
            </label>
            <label style="display: block">
                <span style="display: inline-block; width: 130px">Subject:</span>
                <input style="background-color: #dddddd; width: 95%" type="text" id="theme" name="theme" readonly/>
            </label>
            <label style="display: block">
                <span style="display: inline-block; width: 130px">Text :</span>
                <textarea class="wide_area" id="text" name="text" rows="20" readonly>
                </textarea>
            </label>
        </div>
    </div>
</div>
</html>