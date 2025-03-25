<?php
require_once "../models/User.php";

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
	public function deleteImageFromServer($imageName): void {
		$imageName = "../images/" . basename($imageName);
		unlink($imageName);
	}
}
