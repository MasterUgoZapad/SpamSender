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
    <link rel="stylesheet" type="text/css" href="styles/main.css"/>
    <script src="scripts/validation/jquery.js"></script>
    <script src="scripts/validation/jquery.validate.js"></script>
    <script src="scripts/see_users.js"></script>
    <script src="scripts/validation/see_users.js"></script>
    <script src="scripts/common.js"></script>
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
    </script>
</head>

<body>
<div id="navbar"></div>
<div id="errorwrap"></div>
<div id="submitwrap"></div>
<div id="Main" class="main">
    <div class="firstColoumn" style="width: inherit">
        <h2 align="center">Users list</h2>
        <fieldset>
            <legend>New user</legend>
            <form style="width:auto" name="userForm">
                <div style="display: flex; flex-direction: column;">
                    <div style="display: flex; flex-direction: column;">
                        <label for="login">Login :</label>
                        <input type="text" id="login" name="login"/>
                        <label for="pass">Password :</label>
                        <input type="password" id="pass" name="pass"/>
                        <label for="login">Previliges level :</label>
                        <select id="level" name="level">
                            <option value="1">User</option>
                            <option value="2">Admin</option>
                        </select>
                        <button style="width: max-content;" type="submit">Add new</button>
                    </div>

                </div>
            </form>
        </fieldset>
        <form style="width:auto">
            <button type="button" onclick="DeleteUsers()">Delete</button>
        </form>
        <select id="UsersListSelect" size="10" class="select_widelist" onFocus="window.scrollTo(0, 0);">
        </select>
    </div>
</div>
</body>

</html>