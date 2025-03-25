<?php
require_once '../models/User.php';
require_once '../utils/HelperTrait.php';
require_once '../utils/ValidationTrait.php';

class ChangePassword {
	use HelperTrait, ValidationTrait;

	public function __construct() {
		$formDataIssues = $this->validateChangePasswordData($_POST);
		$formErrors = $formDataIssues["errors"];
		$oldData = $formDataIssues["valid_data"];

		if (!empty($formErrors)) {
			$errors = json_encode($formErrors);
			$queryString = "errors={$errors}";
			$old_data = json_encode($oldData);
			if ($old_data) $queryString .= "&old={$old_data}";
			header("location:changePasswordForm.php?{$queryString}");
			exit;
		} else {
			$id = $this->filtersRequest("id");
			$current_password = $this->filtersRequest("current_password");
			$new_password = $this->filtersRequest("new_password");
			$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

			$user = User::find($id);
			if (!password_verify($current_password, $user['password'])) {
				$errors = json_encode(["current_password" => "CurrentPassword is not correct"]);
				$queryString = "errors={$errors}";
				$old_data = json_encode($oldData);
				if ($old_data) $queryString .= "&old={$old_data}";
				header("location:changePasswordForm.php?{$queryString}");
				exit;
			}

			User::update($id, ["password" => $hashed_password]);
			header("location:display.php");
			exit;
		}
	}
}

new ChangePassword();
