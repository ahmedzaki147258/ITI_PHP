<?php
require_once "./connect.php";
require_once "./HelperTrait.php";

class Register {
  use HelperTrait;

  public function register() {
    $formDataIssues = $this->validatePostData($_POST);
    $formErrors = $formDataIssues["errors"];
    $oldData = $formDataIssues["valid_data"];

    if (!empty($formErrors)) {
      $errors = json_encode($formErrors);
      $queryString = "errors={$errors}";
      $old_data = json_encode($oldData);
      if ($old_data) $queryString .= "&old={$old_data}";
      header("location:registration.php?{$queryString}");
      exit;
    } else {
      global $con;
      $fname = $this->filtersRequest("fname");
      $lname = $this->filtersRequest("lname");
      $address = $this->filtersRequest("address");
      $country = $this->filtersRequest("country");
      $gender = $this->filtersRequest("gender");
      $skills = $this->filtersRequest("skills");
      $username = $this->filtersRequest("uname");
      $password = $this->filtersRequest("password");
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      $this->saveToFile("users.txt", "$fname:$lname:$address:$country:$gender:$skills:$username:Open Source");
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
    }
  }
}

$register = new Register();
$register->register();
