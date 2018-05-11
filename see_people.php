<!DOCTYPE html>
<html>

<head>
    <title>Spam sender</title>
    <link rel="stylesheet" type="text/css" href="styles/main.css"/>
    <script src="scripts/validation/jquery.js"></script>
    <script src="scripts/validation/jquery.validate.js"></script>
    <script src="scripts/see_people.js"></script>
    <script src="scripts/common.js"></script>
    <script>
        //include navbar
        $(function () {
            $("#navbar").load("elements/navbar.html");
        });
    </script>
    <script>
        //include error wrap
        $(function () {
            $("#errorwrap").load("elements/errorwrap.html");
        });
    </script>
</head>

<body>
<div id="errorwrap"></div>
<div id="navbar"></div>
<div id="Main" class="main">

    <div class="firstColoumn">
        <h2 align="center">People list</h2>
        <form align="left" style="width:auto">
            <button align="right" type="button" onclick="RefreshPeople()">Refresh</button>
            <button align="right" type="button" onclick="location.href = 'add_people.php';">Add</button>
            <button align="right" type="button" onclick="DeletePeople()">Delete</button>
            <button align="right" type="button" onclick="EditPeople()">Edit information</button>
            <button align="right" type="button" onclick="ManageEmails()">Manage Emails</button>
            <button align="right" type="button" onclick="SendToPeople()">Send letter to</button>
        </form>
        <select onchange="OnManSelect()" id="PeopleListSelect" size="50"
                style="width:98%; margin:1% 1% 1% 1%; padding:1% 1% 1% 1%; overflow:hidden; font: 12pt consolas;">
        </select>
    </div>
    <div class="secondColoumn">
        <h2 align="center">More information</h2>
        <form align="left" style="width:auto">
            <div>
                <div style="display: block">
                    <label style="display: block">
                        <span style="display: inline-block; width: 130px">Name :</span>
                        <span id="name"></span>
                    </label>
                    <label style="display: block">
                        <span style="display: inline-block; width: 130px">Surname :</span>
                        <span id="sname"></span>
                    </label>
                    <label style="display: block">
                        <span style="display: inline-block; width: 130px">Fathers name :</span>
                        <span id="fname"></span>
                    </label>
                    <label style="display: block">
                        <span style="display: inline-block; width: 130px">Email :</span>
                        <span id="mail"></span>
                    </label>
                    <label style="display: block">
                        <span style="display: inline-block; width: 130px">Birthdate :</span>
                        <span id="age"></span>
                    </label>
                    <label style="display: block">
                        <span style="display: inline-block; width: 130px">Registration time :</span>
                        <span id="regYear"></span>
                    </label>
                    <label style="display: block">
                        <span style="display: inline-block; width: 130px">Area :</span>
                        <span id="area"></span>
                    </label>
                    <label style="display: block">
                        <span style="display: inline-block; width: 130px">Town :</span>
                        <span id="town"></span>
                    </label>
                    <label style="display: block">
                        <span style="display: inline-block; width: 130px">Role :</span>
                        <span id="role"></span>
                    </label>
                    <label style="display: block">
                        <span style="display: inline-block; width: 130px">Origin :</span>
                        <span id="origin"></span>
                    </label>
                </div>
            </div>
        </form>
    </div>
</div>
</body>

</html>