<!DOCTYPE html>
<html>

<head>
    <title>Spam sender</title>
    <link rel="stylesheet" type="text/css" href="styles/main.css"/>
    <script src="scripts/validation/jquery.js"></script>
    <script src="scripts/validation/jquery.validate.js"></script>
    <script src="scripts/add_letters_template.js"></script>
    <script src="scripts/validation/add_letters_template.js"></script>
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
    <div class="firstColoumn">
        <h2 align="center">Template constructor</h2>
        <form id="formTemplate" name="formTemplate">
            <div style="display: block">
                <label style="display: block">
                    <span style="display: inline-block; width: 130px">Template name :</span>
                    <input style="width: 95%" type="text" id="name" name="name"/>
                </label>
                <label style="display: block">
                    <span style="display: inline-block; width: 130px">Subject:</span>
                    <input style="width: 95%" type="text" id="theme" name="theme"/>
                </label>
                <label style="display: block">
                    <span style="display: inline-block; width: 130px">Text :</span>
                    <textarea style="width:95%" id="text" name="text" rows="20"></textarea>
                </label>
            </div>
            <button type="submit">Save template</button>
        </form>
    </div>
    <div class="secondColoumn">
        <h2 align="center">Available aliases</h2>
        <form style="width:auto">
            <textarea style="background-color: #dddddd; width:96%; margin:1% 1% 1% 1%; padding:1% 1% 1% 1%; overflow-y: auto" id="aliasesText" name="text"
                      rows="2" readonly></textarea>
        </form>
    </div>
</div>
</body>

</html>