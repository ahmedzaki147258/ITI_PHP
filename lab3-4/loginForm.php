<?php
    session_start();
    if (isset($_SESSION['name'])) {
        header("Location:preview.php");
        exit;
    }

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
    <title>Login Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex justify-center items-center min-h-screen">
<div class="bg-white shadow-md rounded-lg p-6 w-full max-w-md">
    <h2 class="text-xl font-semibold text-gray-700 text-center mb-4">Login Form</h2>
    <form action="./loginServer.php" method="POST" class="space-y-3">

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
            <label class="text-gray-700 font-semibold" for="password">Password</label>
            <input id="password" name="password" type="password"
                   value='<?php echo $old_data["password"] ?? "" ?>'
                   class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
        </div>
			<?php if (!empty($errors["password"])): ?>
          <div class="text-red-500">
						<?php echo $errors["password"]; ?>
          </div>
			<?php endif; ?>

        <div class="flex justify-between">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Login</button>
            <button type="reset" class="bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-500">Reset</button>
        </div>
    </form>
</div>
</body>
</html>
