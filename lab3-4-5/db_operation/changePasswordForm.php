<?php
$errors = [];
$old_data = [];
if (isset($_GET["errors"])) {
	$errors = $_GET["errors"];
	$errors = json_decode($errors, true);
}

if (isset($_GET["old"])) {
	$old_data = $_GET["old"];
	$old_data = json_decode($old_data, true);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Change Password Form</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex justify-center items-center min-h-screen">
<div class="bg-white shadow-md rounded-lg p-6 w-full max-w-md">
	<h2 class="text-xl font-semibold text-gray-700 text-center mb-4">Change Password</h2>
	<form action="./changePasswordServer.php" method="POST" class="space-y-3">

        <input type='hidden' name='id' value='<?php echo $old_data["id"] ?? "" ?>'>
		<div class="grid grid-cols-[18%_80%] gap-2">
			<label class="text-gray-700 font-semibold" for="current_password">Current Password</label>
			<input id="current_password" name="current_password" type="password"
			       value='<?php echo $old_data["current_password"] ?? "" ?>'
			       class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
		</div>
		<?php if (!empty($errors["current_password"])): ?>
			<div class="text-red-500">
				<?php echo $errors["current_password"]; ?>
			</div>
		<?php endif; ?>

		<div class="grid grid-cols-[18%_80%] gap-2">
			<label class="text-gray-700 font-semibold" for="new_password">New Password</label>
			<input id="new_password" name="new_password" type="password"
			       value='<?php echo $old_data["new_password"] ?? "" ?>'
			       class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
		</div>
		<?php if (!empty($errors["new_password"])): ?>
			<div class="text-red-500">
				<?php echo $errors["new_password"]; ?>
			</div>
		<?php endif; ?>

		<div class="grid grid-cols-[18%_80%] gap-2">
			<label class="text-gray-700 font-semibold" for="confirm_password">Confirm Password</label>
			<input id="confirm_password" name="confirm_password" type="password"
			       value='<?php echo $old_data["confirm_password"] ?? "" ?>'
			       class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
		</div>
		<?php if (!empty($errors["confirm_password"])): ?>
			<div class="text-red-500">
				<?php echo $errors["confirm_password"]; ?>
			</div>
		<?php endif; ?>

		<div class="flex justify-between">
			<button type="reset" class="bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-500">Reset</button>
			<button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Change Password</button>
		</div>
	</form>
</div>
</body>
</html>
