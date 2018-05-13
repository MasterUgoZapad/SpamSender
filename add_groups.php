<!DOCTYPE html>
<html>

<head>
    <title>Spam sender</title>
    <link rel="stylesheet" type="text/css" href="styles/main.css">
    <script src="scripts/validation/jquery.js"></script>
    <script src="scripts/validation/jquery.validate.js"></script>
    <script src="scripts/add_groups.js"></script>
    <script src="scripts/validation/add_groups.js"></script>
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
        <h2 align="center">Select filters</h2>
        <form id="formGroup" name="formGroup">
            <div style="display: flex; flex-direction: column;">
                <label>Group name :</label>
                <input style="width: 98%" type="text" id="group_name" name="group_name"/>
                <label>Name :</label>
                <input style="width: 98%" type="text" id="name" name="name"/>
                <label>Surname :</label>
                <input style="width: 98%" type="text" id="sname" name="sname"/>
                <label>Fathers name :</label>
                <input style="width: 98%" type="text" id="fname" name="fname"/>
                <label>Registration year :</label>
                <div style="display: flex; flex-direction: row;">
                    <label>From :</label>
                    <input type="date" id="regYearFrom" name="regYearFrom"/>
                    <label>To :</label>
                    <input type="date" id="regYearTo" name="regYearTo"/>
                </div>
                <label>Birthdate :</label>
                <div style="display: flex; flex-direction: row;">
                    <label>From :</label>
                    <input type="date" id="ageFrom" name="ageFrom"/>
                    <label>To :</label>
                    <input type="date" id="ageTo" name="ageTo"/>
                </div>
                <label>Area :</label>
                <input style="width: 98%" type="text" id="area" name="area" list="defined_area"/>
                <label>Town :</label>
                <input style="width: 98%" type="text" id="town" name="town" list="defined_town"/>
                <label>Role :</label>
                <input style="width: 98%" type="text" id="role" name="role" list="defined_roles"/>
                <label>Origin :</label>
                <input style="width: 98%" type="text" id="origin" name="origin" list="defined_origin"/>
                <button type="submit" style="margin:auto; display: block; width: 80%">Submit</button>
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
    <div class="secondColoumn">
        <h2 align="center">Selection preview</h2>
        <div align="left">
        <button align="right" style="margin:auto; display: block;" type="button" onclick="GetGroupBySelection()">
            Refresh
        </button>
        </div>
        <textarea class="wide_area" id="groupExplanationText" name="text"
                  rows="2" readonly></textarea>
    </div>
</div>
</body>

</html>