<?php
require_once '../models/User.php';
require_once '../utils/HelperTrait.php';
require_once '../utils/ValidationTrait.php';

class ChangeImage {
	use HelperTrait, ValidationTrait;

	public function __construct() {
		$formDataIssues = $this->validateChangeImage($_POST);
		$formErrors = $formDataIssues["errors"];
		$oldData = $formDataIssues["valid_data"];

		if (!empty($formErrors)) {
			$errors = json_encode($formErrors);
			$queryString = "errors={$errors}";
			$old_data = json_encode($oldData);
			if ($old_data) $queryString .= "&old={$old_data}";
			header("location:display.php?{$queryString}");
			exit;
		} else {
			$id = $this->filtersRequest("id");
			$curr_image = $this->filtersRequest("curr_image");
			$file_name = $_FILES['image']['name'];
			$file_tmp = $_FILES['image']['tmp_name'];
			$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
			$new_file_name = md5($this->generateRandomString(10) . "_" . time() . "_" . $file_name) . "." . $file_ext;
			move_uploaded_file($file_tmp, "../images/" . $new_file_name);
			$image = "http://localhost/iti-php/lab3-4-5/images/" . $new_file_name;

			User::update($id, ["image" => $image]);
			$this->deleteImageFromServer($curr_image);
			header("location:display.php");
			exit;
		}
	}
}

new ChangeImage();
