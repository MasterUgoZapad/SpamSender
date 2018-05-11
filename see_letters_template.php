<!DOCTYPE html>
<html>

<head>
    <title>Spam sender</title>
    <link rel="stylesheet" type="text/css" href="styles/main.css"/>
    <script src="scripts/validation/jquery.js"></script>
    <script src="scripts/validation/jquery.validate.js"></script>
    <script src="scripts/see_letters_template.js"></script>
    <script src="scripts/common.js"></script>
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
<div id="Main" class="main">
    <div class="firstColoumn">
        <h2 align="center">Available templates</h2>
        <form align="left" style="width:auto">
            <button align="right" type="button" onclick="ApplyTemplate()">Aplly to letter</button>
            <button align="right" type="button" onclick="location.href = 'add_letters_template.php'">Add</button>
            <button align="right" type="button" onclick="DeleteTemplate()">Delete</button>
            <button align="right" type="button" onclick="EditTemplate()">Edit</button>
        </form>
        <form align="left" style="width:auto">
        </form>
        <select onchange="OnTemplateSelect()" id="TemplateListSelect" size="50"
                style="width:98%; margin:1% 1% 1% 1%; padding:1% 1% 1% 1%; overflow:hidden; font: 12pt consolas;">
        </select>

    </div>
    <div class="secondColoumn">
        <h2 align="center">Template preview</h2>
        <div style="display: block">
            <label style="display: block">
                <span style="display: inline-block; width: 130px">Template name :</span>
                <input style="background-color: #dddddd; width: 95%" type="text" id="name" name="name" readonly/>
            </label>
            <label style="display: block">
                <span style="display: inline-block; width: 130px">Subject:</span>
                <input style="background-color: #dddddd; width: 95%" type="text" id="theme" name="theme" readonly/>
            </label>
            <label style="display: block">
                <span style="display: inline-block; width: 130px">Text :</span>
                <textarea style="background-color: #dddddd; width:95%" id="text" name="text" rows="20" readonly>
                </textarea>
            </label>
        </div>
    </div>
</div>
</html>