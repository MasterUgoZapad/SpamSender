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
<div id="navbar"></div>
<div id="errorwrap"></div>
<div id="Main" class="main">
    <div class="firstColoumn" style="width: inherit">
        <h2 align="center">Email list</h2>
        <label id="ManDecription"></label>
        <form style="width:auto" name="mailForm">
            <div style="display: flex; flex-direction: column;">
                <label for="mail">New e-mail:</label>
                <input style="width:95%;"type="text" id="mail" name="mail"/>
                <button style="width: max-content;" type="submit">Add new</button>
            </div>
        </form>
        <form style="width:auto">
            <button type="button" onclick="RefreshHumanEmails(current_man_index)">Refresh</button>
            <button type="button" onclick="DeleteEmail()">Delete</button>
            <button type="button" onclick="location.href = 'see_people.php'">Back</button>
        </form>
        <select id="EmailListSelect" size="10"
                style="width:95%; margin:5px 5px 5px 5px; padding:4px 4px 4px 4px; overflow:hidden; font: 12pt consolas;">
        </select>
    </div>
</div>
</body>

</html>