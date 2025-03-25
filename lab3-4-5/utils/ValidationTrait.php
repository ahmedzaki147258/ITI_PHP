<?php
const MB = 1048576;
const pattern = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";

trait ValidationTrait {
	private function validateRequiredFields(array $postData, array $fields): array {
		$errors = [];
		$valid_data = [];

		foreach ($fields as $field => $label) {
			if (empty(trim($postData[$field]))) {
				$errors[$field] = "$label is required";
			} else {
				$valid_data[$field] = trim($postData[$field]);
			}
		}

		return ['errors' => $errors, 'valid_data' => $valid_data];
	}

	private function validateEmail(string $email): array {
		$errors = [];
		$valid_data = [];

		if (empty(trim($email))) {
			$errors['email'] = "Email is required";
		} else if (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = "Email is invalid";
			$valid_data['email'] = trim($email);
		} else if (!preg_match(pattern, trim($email))) {
			$errors['email'] = "Email is invalid";
			$valid_data['email'] = trim($email);
		} else {
			$valid_data['email'] = trim($email);
		}

		return ['errors' => $errors, 'valid_data' => $valid_data];
	}

	private function validatePassword(string $password, string $fieldName = 'password'): array {
		$errors = [];
		$valid_data = [];

		if (empty(trim($password))) {
			$errors[$fieldName] = ucfirst($fieldName) . " is required";
		} elseif (strlen(trim($password)) < 8) {
			$errors[$fieldName] = ucfirst($fieldName) . " must be at least 8 characters";
			$valid_data[$fieldName] = trim($password);
		} elseif (!preg_match('/^[a-z0-9_]+$/', trim($password))) {
			$errors[$fieldName] = ucfirst($fieldName) . " must contain only lowercase letters, numbers, and underscores";
			$valid_data[$fieldName] = trim($password);
		} else {
			$valid_data[$fieldName] = trim($password);
		}

		return ['errors' => $errors, 'valid_data' => $valid_data];
	}

	private function validateImage(array $file): array {
		$errors = [];
		$valid_data = [];

		$file_name = $file['name'];
		$file_size = $file['size'];
		$ext = pathinfo($file_name, PATHINFO_EXTENSION);
		$file_ext = strtolower($ext);
		$extensions = ["jpeg", "jpg", "png"];

		if (!$file_name) {
			$errors['image'] = "Profile picture is required";
		} else if (!in_array($file_ext, $extensions)) {
			$errors['image'] = "Extension not allowed, please choose a JPEG or PNG file.";
			$valid_data['image'] = $file_name;
		} else if ($file_size > 2*MB) {
			$errors['image'] = 'File size must be less than 2 MB';
			$valid_data['image'] = $file_name;
		}

		return ['errors' => $errors, 'valid_data' => $valid_data];
	}

	private function validatePasswordConfirmation(string $password, string $confirmPassword, string $fieldName = 'confirm_password'): array {
		$errors = [];
		$valid_data = [];

		if (trim($password) != trim($confirmPassword)) {
			$errors[$fieldName] = "Confirm password does not match";
		}
		$valid_data[$fieldName] = trim($confirmPassword);

		return ['errors' => $errors, 'valid_data' => $valid_data];
	}

	/*************************************************** Main methods ***************************************************/
	public function validateAddData($postData): array {
		$requiredFields = [
			'name' => 'Name',
			'room_no' => 'Room number',
			'ext' => 'Ext',
		];

		$result = $this->validateRequiredFields($postData, $requiredFields);
		$errors = $result['errors'];
		$valid_data = $result['valid_data'];

		// Validate image
		$imageResult = $this->validateImage($_FILES['image']);
		$errors = array_merge($errors, $imageResult['errors']);
		$valid_data = array_merge($valid_data, $imageResult['valid_data']);

		// Validate email
		$emailResult = $this->validateEmail($postData['email']);
		$errors = array_merge($errors, $emailResult['errors']);
		$valid_data = array_merge($valid_data, $emailResult['valid_data']);

		// Validate password
		$passwordResult = $this->validatePassword($postData['password']);
		$errors = array_merge($errors, $passwordResult['errors']);
		$valid_data = array_merge($valid_data, $passwordResult['valid_data']);

		// Validate password confirmation
		$confirmResult = $this->validatePasswordConfirmation(
			$postData['password'],
			$postData['confirm_password']
		);
		$errors = array_merge($errors, $confirmResult['errors']);
		$valid_data = array_merge($valid_data, $confirmResult['valid_data']);

		return ["errors" => $errors, "valid_data" => $valid_data];
	}

	public function validateEditData($postData): array {
		$requiredFields = [
			'id' => 'ID',
			'name' => 'Name',
			'room_no' => 'Room number',
			'ext' => 'Ext',
		];

		$result = $this->validateRequiredFields($postData, $requiredFields);
		$errors = $result['errors'];
		$valid_data = $result['valid_data'];

		// Validate email
		$emailResult = $this->validateEmail($postData['email']);
		$errors = array_merge($errors, $emailResult['errors']);
		$valid_data = array_merge($valid_data, $emailResult['valid_data']);

		return ["errors" => $errors, "valid_data" => $valid_data];
	}

	public function validateChangePasswordData($postData): array {
		$requiredFields = [
			'id' => 'ID',
			'current_password' => 'CurrentPassword',
		];

		$result = $this->validateRequiredFields($postData, $requiredFields);
		$errors = $result['errors'];
		$valid_data = $result['valid_data'];

		// Validate new password
		$passwordResult = $this->validatePassword($postData['new_password'], 'new_password');
		$errors = array_merge($errors, $passwordResult['errors']);
		$valid_data = array_merge($valid_data, $passwordResult['valid_data']);

		// Validate password confirmation
		$confirmResult = $this->validatePasswordConfirmation(
			$postData['new_password'],
			$postData['confirm_password']
		);
		$errors = array_merge($errors, $confirmResult['errors']);
		$valid_data = array_merge($valid_data, $confirmResult['valid_data']);

		return ["errors" => $errors, "valid_data" => $valid_data];
	}

	public function validateChangeImage($postData): array {
		$requiredFields = [
			'id' => 'ID',
		];

		$result = $this->validateRequiredFields($postData, $requiredFields);
		$errors = $result['errors'];
		$valid_data = $result['valid_data'];

		// Validate image
		$imageResult = $this->validateImage($_FILES['image']);
		$errors = array_merge($errors, $imageResult['errors']);
		$valid_data = array_merge($valid_data, $imageResult['valid_data']);

		return ["errors" => $errors, "valid_data" => $valid_data];
	}

	public function validateLoginData($loginData): array {
		// Validate email
		$emailResult = $this->validateEmail($loginData['email']);
		$errors = $emailResult['errors'];
		$valid_data = $emailResult['valid_data'];

		// Validate password
		if (empty(trim($loginData['password']))) {
			$errors['password'] = "Password is required";
		} else {
			$valid_data['password'] = trim($loginData['password']);
		}

		return ["errors" => $errors, "valid_data" => $valid_data];
	}
}
