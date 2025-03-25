<?php
require_once '../models/User.php';
require_once '../utils/HelperTrait.php';
require_once '../utils/ValidationTrait.php';

class AddUser {
  use HelperTrait, ValidationTrait;

  public function __construct() {
    $formDataIssues = $this->validateAddData($_POST);
    $formErrors = $formDataIssues["errors"];
    $oldData = $formDataIssues["valid_data"];

    if (!empty($formErrors)) {
      $errors = json_encode($formErrors);
      $queryString = "errors={$errors}";
      $old_data = json_encode($oldData);
      if ($old_data) $queryString .= "&old={$old_data}";
      header("location:addForm.php?{$queryString}");
      exit;
    } else {
      $file_name = $_FILES['image']['name'];
      $file_tmp = $_FILES['image']['tmp_name'];
			$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
			$new_file_name = md5($this->generateRandomString(10) . "_" . time() . "_" . $file_name) . "." . $file_ext;
			move_uploaded_file($file_tmp, "../images/" . $new_file_name);

      $name = $this->filtersRequest("name");
      $email = $this->filtersRequest("email");
      $password = $this->filtersRequest("password");
      $room_no = $this->filtersRequest("room_no");
      $ext = $this->filtersRequest("ext");
      $image = "http://localhost/iti-php/lab3-4-5/images/" . $new_file_name;
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

	    try {
		    User::create([
			    "name" => $name,
			    "email" => $email,
			    "password" => $hashed_password,
			    "room_no" => $room_no,
			    "ext" => $ext,
			    "image" => $image
		    ]);
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
                      <h2 class='text-2xl font-bold text-gray-700'>Thanks $name</h2>
                      <h3 class='text-lg text-gray-500 mb-4'>Please Review Your Information</h3>
                      <p class='text-gray-700'><strong>E-mail:</strong> $email</p>
                      <p class='text-gray-700'><strong>Room Number:</strong> $room_no</p>
                      <p class='text-gray-700'><strong>Ext:</strong> $ext</p>
                  </div>
              </body>
              </html>";
	    } catch (Exception $e) {
		    $errors = json_encode(["email" => "Email already exists"]);
		    $queryString = "errors={$errors}";
		    $old_data = json_encode($oldData);
		    if ($old_data) $queryString .= "&old={$old_data}";
		    header("location:addForm.php?{$queryString}");
		    exit;
	    }
    }
  }
}

new AddUser();
