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
  <title>Registration Form</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex justify-center items-center min-h-screen">
  <div class="bg-white shadow-md rounded-lg p-6 w-full max-w-md">
    <h2 class="text-xl font-semibold text-gray-700 text-center mb-4">Registration Form</h2>
    <form action="./server.php" method="POST" class="space-y-3">
      <div class="grid grid-cols-2 gap-3">
        <input id="fname" name="fname" type="text" placeholder="First Name"
          value='<?php echo $old_data["fname"] ?? "" ?>'
          class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">

        <?php if (!empty($errors["fname"])): ?>
          <div class="text-red-500">
            <?php echo $errors["fname"]; ?>
          </div>
        <?php endif; ?>


        <input id="lname" name="lname" type="text" placeholder="Last Name"
          value='<?php echo $old_data["lname"] ?? "" ?>'
          class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">

        <?php if (!empty($errors["lname"])): ?>
          <div class="text-red-500">
            <?php echo $errors["lname"]; ?>
          </div>
        <?php endif; ?>
      </div>

      <textarea id="address" name="address" placeholder="Address"
        class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400"><?php echo $old_data["address"] ?? ""; ?></textarea>

      <?php if (!empty($errors["address"])): ?>
        <div class="text-red-500">
          <?php echo $errors["address"]; ?>
        </div>
      <?php endif; ?>

      <div class="grid grid-cols-[20%_78%] gap-2">
        <label class="text-gray-700 font-semibold">Country</label>
        <select id="country" name="country"
          class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
          <option value="Germany" <?php echo (isset($old_data["country"]) && $old_data["country"] === "Germany") ? "selected" : ""; ?>>Germany</option>
          <option value="Egypt" <?php echo (isset($old_data["country"]) && $old_data["country"] === "Egypt") ? "selected" : ""; ?>>Egypt</option>
          <option value="USA" <?php echo (isset($old_data["country"]) && $old_data["country"] === "USA") ? "selected" : ""; ?>>USA</option>
        </select>
      </div>
      <?php if (!empty($errors["country"])): ?>
        <div class="text-red-500">
          <?php echo $errors["country"]; ?>
        </div>
      <?php endif; ?>

      <div class="grid grid-cols-3 gap-2">
        <label class="text-gray-700 font-semibold">Gender</label>

        <label class="inline-flex items-center">
          <input type="radio" name="gender" value="Male" class="text-blue-500"
            <?php echo (isset($old_data["gender"]) && $old_data["gender"] === "Male") ? "checked" : ""; ?>>
          <span class="ml-2">Male</span>
        </label>

        <label class="inline-flex items-center">
          <input type="radio" name="gender" value="Female" class="text-blue-500"
            <?php echo (isset($old_data["gender"]) && $old_data["gender"] === "Female") ? "checked" : ""; ?>>
          <span class="ml-2">Female</span>
        </label>
      </div>
      <?php if (!empty($errors["gender"])): ?>
        <div class="text-red-500">
          <?php echo $errors["gender"]; ?>
        </div>
      <?php endif; ?>

      <div class="grid grid-cols-3 gap-2">
        <label class="text-gray-700 font-semibold">Skills</label>
        <label class="inline-flex items-center">
          <input type="checkbox" name="skills[]" value="PHP" class="text-blue-500"
            <?= (!empty($old_data['skills']) && in_array("PHP", $old_data['skills'])) ? 'checked' : '' ?>>
          <span class="ml-2">PHP</span>
        </label>

        <label class="inline-flex items-center">
          <input type="checkbox" name="skills[]" value="J2SE" class="text-blue-500"
            <?= (!empty($old_data['skills']) && in_array("J2SE", $old_data['skills'])) ? 'checked' : '' ?>>
          <span class="ml-2">J2SE</span>
        </label>

        <label></label>
        <label class="inline-flex items-center">
          <input type="checkbox" name="skills[]" value="MySQL" class="text-blue-500"
            <?= (!empty($old_data['skills']) && in_array("MySQL", $old_data['skills'])) ? 'checked' : '' ?>>
          <span class="ml-2">MySQL</span>
        </label>

        <label class="inline-flex items-center">
          <input type="checkbox" name="skills[]" value="PostgreeSQL" class="text-blue-500"
            <?= (!empty($old_data['skills']) && in_array("PostgreeSQL", $old_data['skills'])) ? 'checked' : '' ?>>
          <span class="ml-2">PostgreeSQL</span>
        </label>
      </div>

      <?php if (!empty($errors["skills"])): ?>
        <div class="text-red-500">
          <?php echo $errors["skills"]; ?>
        </div>
      <?php endif; ?>

      <input id="uname" name="uname" type="text" placeholder="Username"
        value='<?php echo $old_data["uname"] ?? "" ?>'
        class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
      <?php if (!empty($errors["uname"])): ?>
        <div class="text-red-500">
          <?php echo $errors["uname"]; ?>
        </div>
      <?php endif; ?>

      <input id="password" name="password" type="password" placeholder="Password"
        value='<?php echo $old_data["password"] ?? "" ?>'
        class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
      <?php if (!empty($errors["password"])): ?>
        <div class="text-red-500">
          <?php echo $errors["password"]; ?>
        </div>
      <?php endif; ?>

      <input type="text" value="Open Source" disabled
        class="w-full p-2 bg-gray-200 border border-gray-300 rounded-md">
      <div class="text-center">
        <p class="bg-gray-300 p-2 rounded font-bold">Sh68So</p>
        <input id="code" name="code" type="text" placeholder="Enter the code"
          value='<?php echo $old_data["code"] ?? "" ?>'
          class="w-full p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
      </div>
      <?php if (!empty($errors["code"])): ?>
        <div class="text-red-500">
          <?php echo $errors["code"]; ?>
        </div>
      <?php endif; ?>

      <div class="flex justify-between">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Submit</button>
        <button type="reset" class="bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-500">Reset</button>
      </div>
    </form>
  </div>
</body>
</html>
