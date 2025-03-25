<?php
require_once '../models/User.php';
require_once '../utils/HelperTrait.php';
require_once '../utils/ValidationTrait.php';

class EditUser {
	use HelperTrait, ValidationTrait;

	public function __construct() {
		$formDataIssues = $this->validateEditData($_POST);
		$formErrors = $formDataIssues["errors"];
		$oldData = $formDataIssues["valid_data"];

		if (!empty($formErrors)) {
			$errors = json_encode($formErrors);
			$queryString = "errors={$errors}";
			$old_data = json_encode($oldData);
			if ($old_data) $queryString .= "&old={$old_data}";
			header("location:editForm.php?{$queryString}");
			exit;
		} else {
			$id = $this->filtersRequest("id");
			$name = $this->filtersRequest("name");
			$email = $this->filtersRequest("email");
			$room_no = $this->filtersRequest("room_no");
			$ext = $this->filtersRequest("ext");

			$emailExists = User::where('email', '=', $email)->where('id', '!=', $id)->first();
			if ($emailExists) {
				$errors = json_encode(["email" => "Email already exists"]);
				$queryString = "errors={$errors}";
				$old_data = json_encode($oldData);
				if ($old_data) $queryString .= "&old={$old_data}";
				header("location:editForm.php?{$queryString}");
				exit;
			}

			User::update($id, ["name" => $name, "email" => $email, "room_no" => $room_no, "ext" => $ext]);
			header("location:display.php");
			exit;
		}
	}
}

new EditUser();
