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
	<title>Edit User Form</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex justify-center items-center min-h-screen">
<div class="bg-white shadow-md rounded-lg p-6 w-full max-w-md">
	<h2 class="text-xl font-semibold text-gray-700 text-center mb-4">Edit New User</h2>
	<form action="./editServer.php" method="POST" class="space-y-3">

		<input type='hidden' name='id' value='<?php echo $old_data["id"] ?? "" ?>'>
		<div class="grid grid-cols-[18%_80%] gap-2">
			<label class="text-gray-700 font-semibold" for="name">Name</label>
			<input id="name" name="name" type="text"
			       value='<?php echo $old_data["name"] ?? "" ?>'
			       class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
		</div>
		<?php if (!empty($errors["name"])): ?>
			<div class="text-red-500">
				<?php echo $errors["name"]; ?>
			</div>
		<?php endif; ?>

		<div class="grid grid-cols-[18%_80%] gap-2">
			<label class="text-gray-700 font-semibold" for="email">E-mail</label>
			<input id="email" name="email" type="email"
			       value='<?php echo $old_data["email"] ?? "" ?>'
			       class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
		</div>
		<?php if (!empty($errors["email"])): ?>
			<div class="text-red-500">
				<?php echo $errors["email"]; ?>
			</div>
		<?php endif; ?>

		<div class="grid grid-cols-[18%_80%] gap-2">
			<label class="text-gray-700 font-semibold" for="room_no">Room No.</label>
			<select id="room_no" name="room_no"
			        class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
				<option value="Application1" <?php echo (isset($old_data["room_no"]) && $old_data["room_no"] === "Application1") ? "selected" : ""; ?>>
					Application1
				</option>
				<option value="Application2" <?php echo (isset($old_data["room_no"]) && $old_data["room_no"] === "Application2") ? "selected" : ""; ?>>
					Application2
				</option>
				<option value="Cloud" <?php echo (isset($old_data["room_no"]) && $old_data["room_no"] === "Cloud") ? "selected" : ""; ?>>
					Cloud
				</option>
			</select>
		</div>
		<?php if (!empty($errors["room_no"])): ?>
			<div class="text-red-500">
				<?php echo $errors["room_no"]; ?>
			</div>
		<?php endif; ?>

		<div class="grid grid-cols-[18%_80%] gap-2">
			<label class="text-gray-700 font-semibold" for="ext">Ext</label>
			<input id="ext" name="ext" type="date"
			       value='<?php echo $old_data["ext"] ?? "" ?>'
			       class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
		</div>
		<?php if (!empty($errors["ext"])): ?>
			<div class="text-red-500">
				<?php echo $errors["ext"]; ?>
			</div>
		<?php endif; ?>

		<div class="flex justify-between">
			<button type="reset" class="bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-500">Reset</button>
			<button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Edit</button>
		</div>
	</form>
</div>
</body>
</html>
