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
    <script src="scripts/add_email.js"></script>
    <script src="scripts/validation/add_email.js"></script>
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
    <div class="firstColoumn" style="width: inherit">
        <h2 align="center">Email list</h2>
        <label id="ManDecription"></label>
        <fieldset>
            <legend>New E-mail</legend>
            <form style="width:auto" name="mailForm">
                <div style="display: flex; flex-direction: column;">
                    <label for="mail">E-mail address:</label>
                    <input style="width:95%;" type="text" id="mail" name="mail"/>
                    <button style="width: max-content;" type="submit">Add</button>
                </div>
            </form>
        </fieldset>
        <form style="width:auto">
            <button type="button" onclick="RefreshHumanEmails(current_man_index)">Refresh</button>
            <button type="button" onclick="DeleteEmail()">Delete</button>
            <button type="button" onclick="location.href = 'see_people.php'">Back</button>
        </form>
        <select id="EmailListSelect" size="10" class="select_widelist" onFocus="window.scrollTo(0, 0);">
        </select>
    </div>
</div>
</body>

</html>