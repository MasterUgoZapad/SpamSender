<!DOCTYPE html>

<html>

<head>
    <title>Spam sender</title>
    <link rel="stylesheet" type="text/css" href="styles/main.css">
    <script src="scripts/index.js"></script>
    <script src="scripts/common.js"></script>
    <script src="scripts/validation/jquery.js"></script>
    <script src="scripts/validation/jquery.validate.js"></script>
    <script src="scripts/validation/index.js"></script>
    <script src="elements/EN-errorstrings.js"></script>
    <script src="elements/EN-strings.js"></script>
    <script>
        $(function () {
            $("#errorwrap").load("elements/errorwrap.html");
        });
        $(function () {
            $("#submitwrap").load("elements/submitwrap.html");
        });
    </script>
</head>

<body>
<div id="errorwrap"></div>
<div id="submitwrap"></div>
<div id="Main" class="main" style="width:100%">
    <div class="firstColoumn" style="width:100%">
        <form style="width:auto" id="formLogin" name="formLogin">
            <div style="display: flex; flex-direction: column;">
                <label for="login" style="display: inline-block;">Login :</label>
                <input style="width: 95%" type="text" id="login" name="login"/>
                <label for="pass" style="display: inline-block;">Password :</label>
                <input style="width: 95%" type="password" id="pass" name="pass"/>
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>