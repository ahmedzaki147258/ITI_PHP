<?php
session_start();
if (!isset($_SESSION['name'])) {
	header("location:loginForm.php");
	exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

<div class="max-w-xs w-full bg-white shadow-lg rounded-xl overflow-hidden transform transition-all hover:scale-105 hover:shadow-xl">
    <div class="flex justify-center">
        <img class="w-41 h-41 object-cover shadow-sm"
             src="<?php echo $_SESSION['image']; ?>"
             alt="Profile Picture">
    </div>

    <div class="text-center px-4 py-3">
        <h2 class="text-xl font-bold text-gray-800"><?php echo $_SESSION['name']; ?></h2>
        <p class="text-gray-600 text-sm mt-1"><?php echo $_SESSION['email']; ?></p>
    </div>

    <div class="px-4 py-3 bg-gray-50">
        <div class="grid grid-cols-2 gap-3 text-xs text-gray-700">
            <p class="font-semibold">Room No:</p>
            <p><?php echo $_SESSION['room_no']; ?></p>
            <p class="font-semibold">Ext:</p>
            <p><?php echo $_SESSION['ext']; ?></p>
        </div>
    </div>

    <div class="p-4 flex justify-center">
        <a href="./logout.php" class="px-4 py-1.5 bg-red-500 text-white rounded-md shadow-sm hover:bg-red-600 transition-colors duration-300 text-sm">
            Logout
        </a>
    </div>
</div>

</body>
</html>
