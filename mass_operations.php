<?php
session_start();

if (!isset($_SESSION['login']) || empty($_SESSION['login']) || !isset($_SESSION['level']) || empty($_SESSION['level']) || $_SESSION['level'] < 1) {
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Spam sender</title>
    <link rel="stylesheet" type="text/css" href="styles/main.css">
    <script src="scripts/mass_operations.js"></script>
    <script src="scripts/common.js"></script>
    <script src="scripts/validation/jquery.js"></script>
    <script src="scripts/jquery.csv.js"></script>
    <script src="elements/EN-errorstrings.js"></script>
    <script src="elements/EN-strings.js"></script>
    <script>
        $(function () {
            $("#navbar").load("elements/navbar.html");
        });
        $(function () {
            $("#errorwrap").load("elements/errorwrap.html");
        });
        $(function () {
            $("#submitwrap").load("elements/submitwrap.html");
        });
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
<div id="Main" class="main">
    <div class="firstColoumn" style="width: inherit">
        <h2 align="center">Import people data</h2>
        <form id="formImport" name="formImport">
            <div style="display: flex; flex-direction: column;">
                <label for="name">Default name :</label>
                <input style="width: 98%" type="text" name="name" id="name"/>
                <label for="sname">Default surname :</label>
                <input style="width: 98%"type="text" name="sname" id="sname"/>
                <label>Default fathers name :</label>
                <input style="width: 98%" type="text" name="fname" id="fname"/>
                <label>Default birth date :</label>
                <input type="date" style="width: 98%" name="birthdate" id="birthdate"/>
                <label>Default area :</label>
                <input style="width: 98%" type="text" id="area" name="area" list="defined_area"/>
                <label>Default town :</label>
                <input style="width: 98%" type="text" id="town" name="town" list="defined_town"/>
                <label>Default role :</label>
                <input style="width: 98%" type="text" id="role" name="role" list="defined_roles"/>
                <label>Default origin :</label>
                <input style="width: 98%" type="text" id="origin" name="origin" list="defined_origin"/>
                <label>Import file :</label>
                <div>
                    <input style="width: 98%" type="file" id="file" name="file"/>
                    <label>Encoding :</label>
                    <select id="encoding">
                        <option value="UTF8">UTF8</option>
                        <option value="ANSI">ANSI</option>
                        <option value="CP1251">CP1251</option>
                        <option value="ISO-8859-5">ISO-8859-5</option>
                    </select>
                </div>
                <button type="button" style="margin:auto; display: block;" onclick="Import()">Import</button>


                <datalist id="defined_roles">
                </datalist>
                <datalist id="defined_origin">
                </datalist>
                <datalist id="defined_area">
                </datalist>
                <datalist id="defined_town">
                </datalist>
            </div>
        </form>
    </div>
</div>
</body>

</html>