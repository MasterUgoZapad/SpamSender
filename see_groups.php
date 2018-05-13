<!DOCTYPE html>
<html>

	<head>
		<title>Spam sender</title>
		<link rel="stylesheet" type="text/css" href="styles/main.css"/>
		<script src="scripts/validation/jquery.js"></script>
		<script src="scripts/validation/jquery.validate.js"></script>
		<script src="scripts/see_groups.js"></script>
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
				<h2 align="center">Group list</h2>
				<form style="width:auto">
					<button type="button" onclick="RefreshGroups()">Refresh</button>
					<button type="button" onclick="location.href = 'add_groups.php'">New</button>
					<button type="button" onclick="DeleteGroup()">Delete</button>
					<button type="button" onclick="SendToGroup()">Send letter to group</button>
				</form>
				<select onchange="OnGroupSelect()" id="GroupListSelect" size="50" class="select_widelist" onFocus="window.scrollTo(0, 0);">
				</select>
			</div>
			<div class="secondColoumn">
				<h2 align="center">Group members</h2>
				<textarea class="wide_area" id="groupExplanationText" name="text" rows="2" readonly>

				</textarea>
			</div>
		</div>
	</body>

</html>