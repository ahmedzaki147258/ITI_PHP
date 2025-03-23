<?php
require_once "./connect.php";
require_once "./HelperTrait.php";

class LoginUser {
	use HelperTrait;

	public function loginUser(){

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
			global $con;
			$email = $this->filtersRequest("email");
			$password = $this->filtersRequest("password");

			$stmt = $con->prepare("SELECT * FROM `users2` WHERE `email` = ?");
			$stmt->execute(array($email));
			$count = $stmt->rowCount();
			if ($count > 0) {
				$user = $stmt->fetch(PDO::FETCH_ASSOC);
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
}

$user = new LoginUser();
$user->loginUser();
