<?php
const MB = 1048576;
const pattern = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";

trait HelperTrait {
	public function filtersRequest($requestName): string {
    if (is_array($_POST[$requestName])) return implode(', ', $_POST[$requestName]);
    return trim(htmlspecialchars(strip_tags($_POST[$requestName])));
  }
	public function generateRandomString($length): string{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	public function validatePostData($postData): array {
    $errors = [];
    $valid_data = [];

    $fields = [
      'name' => 'Name',
      'room_no' => 'Room number',
      'ext' => 'Ext',
    ];
    foreach ($fields as $field => $label) {
      if (empty(trim($postData[$field]))) {
        $errors[$field] = "$label is required";
      } else {
        $valid_data[$field] = trim($postData[$field]);
      }
    }

    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $ext = explode('.', $file_name);
    $file_ext = strtolower(end($ext));
    $ext = pathinfo($file_name)["extension"];
    $extensions = array("jpeg", "jpg", "png");
    if (!$file_name) {
      $errors['image'] = "Profile picture is required";
    } else if (in_array($file_ext, $extensions) === false) {
      $errors['image'] = "extension not allowed, please choose a JPEG or PNG file.";
      $valid_data['image'] = $file_name;
    } else if ($file_size > 2*MB) {
      $errors['image'] = 'File size must be least than 2 MB';
      $valid_data['image'] = $file_name;
    }


    if (empty(trim($postData['email']))) {
      $errors['email'] = "Email is required";
    } else if (!filter_var(trim($postData['email']), FILTER_VALIDATE_EMAIL)){ // way1
      $errors['email'] = "Email is invalid";
      $valid_data['email'] = trim($postData['email']);
    } else if (!preg_match(pattern, trim($postData['email']))){ //way2
      $errors['email'] = "Email is invalid";
      $valid_data['email'] = trim($postData['email']);
    } else {
      $valid_data['email'] = trim($postData['email']);
    }

    if (empty(trim($postData['password']))) {
      $errors['password'] = "Password is required";
    } elseif (strlen(trim($postData['password'])) < 8) {
      $errors['password'] = "Password must be at least 8 characters";
      $valid_data['password'] = trim($postData['password']);
    } elseif (!preg_match('/^[a-z0-9_]+$/', trim($postData['password']))) {
      $errors['password'] = "Password must contain only lowercase letters, numbers, and underscores";
      $valid_data['password'] = trim($postData['password']);
    } else {
      $valid_data['password'] = trim($postData['password']);
    }

    if (trim($postData['password']) != trim($postData['confirm_password'])){
      $errors['confirm_password'] = "confirm password not matching";
    }
    $valid_data['confirm_password'] = trim($postData['confirm_password']);

    return ["errors" => $errors, "valid_data" => $valid_data];
  }
	public function validateLoginData($loginData): Array {
		$errors = [];
		$valid_data = [];

		if (empty(trim($loginData['email']))) {
			$errors['email'] = "Email is required";
		} else if (!filter_var(trim($loginData['email']), FILTER_VALIDATE_EMAIL)){ // way1
			$errors['email'] = "Email is invalid";
			$valid_data['email'] = trim($loginData['email']);
		} else if (!preg_match(pattern, trim($loginData['email']))){ //way2
			$errors['email'] = "Email is invalid";
			$valid_data['email'] = trim($loginData['email']);
		} else {
			$valid_data['email'] = trim($loginData['email']);
		}

		if (empty(trim($loginData['password']))) {
			$errors['password'] = "Password is required";
		} else {
			$valid_data['password'] = trim($loginData['password']);
		}

		return ["errors" => $errors, "valid_data" => $valid_data];
	}
}
