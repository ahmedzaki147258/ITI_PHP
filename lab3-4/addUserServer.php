<?php
require_once "./connect.php";
require_once "./HelperTrait.php";

class User {
  use HelperTrait;

  public function addUser() {
    $formDataIssues = $this->validatePostData($_POST);
    $formErrors = $formDataIssues["errors"];
    $oldData = $formDataIssues["valid_data"];

    if (!empty($formErrors)) {
      $errors = json_encode($formErrors);
      $queryString = "errors={$errors}";
      $old_data = json_encode($oldData);
      if ($old_data) $queryString .= "&old={$old_data}";
      header("location:addUserForm.php?{$queryString}");
      exit;
    } else {
      global $con;
      $file_name = $_FILES['image']['name'];
      $file_tmp = $_FILES['image']['tmp_name'];
			$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
			$new_file_name = md5($this->generateRandomString(10). "_" . time() . "_" . $file_name) . '.' . $file_ext;
			move_uploaded_file($file_tmp, "images/" . $new_file_name);

      $name = $this->filtersRequest("name");
      $email = $this->filtersRequest("email");
      $password = $this->filtersRequest("password");
      $room_no = $this->filtersRequest("room_no");
      $ext = $this->filtersRequest("ext");
      $image = "http://localhost/iti-php/lab3-4/images/" . $new_file_name;
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      $stmt = $con->prepare("INSERT INTO `users2`(`name`, `email`, `password`, `room_no`, `ext`, `image`) VALUES ( ? , ? , ? , ?, ? , ? )");
      $stmt->execute(array($name, $email, $hashed_password, $room_no, $ext, $image));
      $count = $stmt->rowCount();
      if ($count > 0) {
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
      } else {
	      $errors = json_encode(["email" => "Email already exists"]);
	      $queryString = "errors={$errors}";
	      $old_data = json_encode($oldData);
	      if ($old_data) $queryString .= "&old={$old_data}";
	      header("location:addUserForm.php?{$queryString}");
	      exit;
      }
    }
  }
}

$user = new User();
$user->addUser();
