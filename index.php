<?php
session_start();
?>
<!DOCTYPE html>

<html>

<head>
    <title>Spam sender</title>
    <link rel="stylesheet" type="text/css" href="styles/main.css">
    <script src="scripts/validation/jquery.js"></script>
    <script>
        //include navbar
        $(function(){
            $("#navbar").load("elements/navbar.html");
        });
    </script>
    <script>
        //include error wrap
        $(function(){
            $("#errorwrap").load("elements/errorwrap.html");
        });
    </script>
</head>

<body>
<div id="navbar"></div>
<div id="errorwrap"></div>
<div class="main">
    <h2>Welcome to Spam Sender</h2>
</div>

</body>
</html>