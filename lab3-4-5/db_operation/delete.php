<?php
require_once '../models/User.php';
require_once '../utils/HelperTrait.php';
class DeleteUser {
	use HelperTrait;

	public function __construct() {
		$id = $this->filtersRequest("id");
		$imageName = $this->filtersRequest("imageName");
		User::delete($id);
		$this->deleteImageFromServer($imageName);
		header("location:display.php");
		exit;
	}
}

new DeleteUser();
