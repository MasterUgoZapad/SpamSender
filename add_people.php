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
    <script src="scripts/validation/jquery.validate.js"></script>
    <script src="scripts/add_people.js"></script>
    <script src="scripts/validation/add_people.js"></script>
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
        <h2 align="center">Edit user information</h2>
        <form id="formHuman" name="formHuman">
            <div style="display: flex; flex-direction: column;">
                <label for="name">Name :</label>
                <input style="width:95%;" type="text" name="name" id="name"/>
                <label for="sname">Surname :</label>
                <input style="width:95%;" type="text" name="sname" id="sname"/>
                <label>Fathers name :</label>
                <input style="width:95%;" type="text" name="fname" id="fname"/>
                <label>Birth date :</label>
                <input type="date" style="width:95%;" name="age" id="age"/>
                <label>Area :</label>
                <input style="width:95%;" type="text" name="area" id="area" list="defined_area"/>
                <label>Town :</label>
                <input style="width:95%;" type="text" name="town" id="town" list="defined_town"/>
                <label>Role :</label>
                <input style="width:95%;" type="text" name="role" id="role" list="defined_roles"/>
                <label>Origin :</label>
                <input style="width:95%;" type="text" name="origin" id="origin" list="defined_origin"/>
                <button type="submit" style="margin:auto; display: block; width: 40%">
                    Submit
                </button>

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