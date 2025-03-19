<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
<div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-lg">
    <form action="./server.php" method="POST" class="space-y-4">
        <div>
            <label for="fname" class="block text-gray-700 font-semibold">First Name</label>
            <input id="fname" name="fname" type="text" required class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label for="lname" class="block text-gray-700 font-semibold">Last Name</label>
            <input id="lname" name="lname" type="text" required class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label for="address" class="block text-gray-700 font-semibold">Address</label>
            <textarea id="address" name="address" required class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400"></textarea>
        </div>

        <div>
            <label for="country" class="block text-gray-700 font-semibold">Country</label>
            <select id="country" name="country" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
                <option value="Germany">Germany</option>
                <option value="Egypt">Egypt</option>
                <option value="USA">USA</option>
            </select>
        </div>

        <div>
            <span class="block text-gray-700 font-semibold">Gender</span>
            <div class="flex gap-4">
                <label class="inline-flex items-center">
                    <input type="radio" id="male" name="gender" value="Male" required class="text-blue-500">
                    <span class="ml-2">Male</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" id="female" name="gender" value="Female" required class="text-blue-500">
                    <span class="ml-2">Female</span>
                </label>
            </div>
        </div>

        <div>
            <span class="block text-gray-700 font-semibold">Skills</span>
            <div class="grid grid-cols-2 gap-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" id="php" name="skills[]" value="PHP" class="text-blue-500" required>
                    <span class="ml-2">PHP</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" id="j2se" name="skills[]" value="J2SE" class="text-blue-500">
                    <span class="ml-2">J2SE</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" id="mysql" name="skills[]" value="MySQL" class="text-blue-500">
                    <span class="ml-2">MySQL</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" id="postgreesql" name="skills[]" value="PostgreeSQL" class="text-blue-500">
                    <span class="ml-2">PostgreeSQL</span>
                </label>
            </div>
        </div>

        <div>
            <label for="uname" class="block text-gray-700 font-semibold">Username</label>
            <input id="uname" name="uname" type="text" required class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label for="password" class="block text-gray-700 font-semibold">Password</label>
            <input id="password" name="password" type="password" required class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label for="department" class="block text-gray-700 font-semibold">Department</label>
            <input id="department" name="department" type="text" value="Open Source" disabled class="w-full p-2 bg-gray-200 border border-gray-300 rounded-lg">
        </div>

        <div>
            <p class="bg-gray-300 text-center p-2 rounded text-lg font-bold">Sh68So</p>
            <label for="code"></label><input id="code" name="code" type="text" placeholder="Enter the code" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
            <p class="text-gray-500 text-sm">Please insert the code above</p>
        </div>

        <div class="flex gap-4 justify-center">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Submit</button>
            <button type="reset" class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">Reset</button>
        </div>
    </form>
</div>
</body>
</html>