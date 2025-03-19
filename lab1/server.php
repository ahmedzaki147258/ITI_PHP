<?php
  global $con;
  include "./connect.php";

  $fname = filtersRequest("fname");
  $lname = filtersRequest("lname");
  $address = filtersRequest("address");
  $country = filtersRequest("country");
  $gender = filtersRequest("gender");
  $skills = filtersRequest("skills");
  $username = filtersRequest("uname");
  $password = filtersRequest("password");
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  $stmt = $con->prepare("INSERT INTO `users`(`first_name`, `last_name`, `address`, `country`, `gender`, `skills`, `username`, `password`, `department`) VALUES ( ? , ? , ? , ?, ? , ? , ? , ? , ? )");
  $stmt->execute(array($fname, $lname, $address, $country, $gender, $skills, $username, $hashed_password, "Open Source"));
  $count = $stmt->rowCount();
  if ($count > 0) {
    $fullName = $fname . " " . $lname;
    $dear = ($gender == "Male") ? "Mr. " : "Miss. ";

    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Review</title>
        <script src='https://cdn.tailwindcss.com'></script>
    </head>
    <body class='flex items-center justify-center min-h-screen bg-gray-100'>
        <div class='bg-white p-8 rounded-lg shadow-lg max-w-md text-center'>
            <h2 class='text-2xl font-bold text-gray-700'>Thanks $dear$fullName</h2>
            <h3 class='text-lg text-gray-500 mb-4'>Please Review Your Information</h3>
            <p class='text-gray-700'><strong>Name:</strong> $fullName</p>
            <p class='text-gray-700'><strong>Address:</strong> $address</p>
            <p class='text-gray-700'><strong>Your Skills:</strong> $skills</p>
            <p class='text-gray-700'><strong>Department:</strong> Open Source</p>
        </div>
    </body>
    </html>";
  } else {
    echo json_encode(array("status" => "fail"));
  }
