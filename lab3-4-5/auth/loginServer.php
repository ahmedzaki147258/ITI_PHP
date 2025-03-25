<?php
require_once '../models/User.php';
require_once '../utils/HelperTrait.php';
require_once '../utils/ValidationTrait.php';

class LoginUser {
	use HelperTrait;
	use ValidationTrait;

	public function __construct(){
		$formDataIssues = $this->validateLoginData($_POST);
		$formErrors = $formDataIssues["errors"];
		$oldData = $formDataIssues["valid_data"];

		if (!empty($formErrors)) {
			$errors = json_encode($formErrors);
			$queryString = "errors={$errors}";
			$old_data = json_encode($oldData);
			if ($old_data) $queryString .= "&old={$old_data}";
			header("location:loginForm.php?{$queryString}");
			exit;
		} else {
			$email = $this->filtersRequest("email");
			$password = $this->filtersRequest("password");

			$user = User::where('email', '=', $email)->first();
			if (password_verify($password, $user['password'])) {
				session_start();
				$_SESSION['name'] = $user['name'];
				$_SESSION['email'] = $user['email'];
				$_SESSION['room_no'] = $user['room_no'];
				$_SESSION['ext'] = $user['ext'];
				$_SESSION['image'] = $user['image'];
				header("location:preview.php");
				exit;
			} else {
				$errors = json_encode(["password" => "Invalid e-mail or password"]);
				$queryString = "errors={$errors}";
				$old_data = json_encode($oldData);
				if ($old_data) $queryString .= "&old={$old_data}";
				header("location:loginForm.php?{$queryString}");
				exit;
			}
		}
	}
}

new LoginUser();
