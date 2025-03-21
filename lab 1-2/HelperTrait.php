<?php

trait HelperTrait
{
  function filtersRequest($requestName): string
  {
    if (is_array($_POST[$requestName])) return implode(', ', $_POST[$requestName]);
    return trim(htmlspecialchars(strip_tags($_POST[$requestName])));
  }

  public function checkFileExist($fileName): void
  {
    if (!file_exists($fileName)) {
      file_put_contents($fileName, "");
    }
  }

  public function readJsonFile($fileName): array
  {
    if (!file_exists($fileName)) {
      file_put_contents($fileName, json_encode([]));
    }
    return json_decode(file_get_contents($fileName), true);
  }

  public function readTxtFile($fileName): array
  {
    $this->checkFileExist($fileName);
    $users = [];
    $usersData = file($fileName);
    foreach ($usersData as $key => $value) {
      $userData = explode(":", $value);
      $user['id'] = $userData[0];
      $user['firstName'] = $userData[1];
      $user['lastName'] = $userData[2];
      $user['address'] = $userData[3];
      $user['country'] = $userData[4];
      $user['gender'] = $userData[5];
      $user['skills'] = $userData[6];
      $user['userName'] = $userData[7];
      $user['department'] = $userData[8];
      $users[] = $user;
    }
    return $users;
  }

  public function saveToFile($fileName, $data): void
  {
    $this->checkFileExist($fileName);
    $newID = 1;
    $file = fopen($fileName, "a");
    if (!empty($file)) {
      $usersData = file($fileName);
      $newID = (int)(explode(":", end($usersData))[0]) + 1;
    }
    fwrite($file, $newID . ":" . $data . "\n");
    fclose($file);
  }

  public function deleteFromFile($fileName, $id): void
  {
    $newData = [];
    $usersData = file($fileName);
    foreach ($usersData as $key => $value) {
      if (explode(':', $value)[0] != (int)$id) $newData[] = $value;
    }
    file_put_contents($fileName, $newData);
  }

  function validatePostData($postData): array
  {
    $errors = [];
    $valid_data = [];

    $fields = [
      'fname' => 'First name',
      'lname' => 'Last name',
      'address' => 'Address',
      'country' => 'Country',
      'gender' => 'Gender',
      'uname' => 'User Name',
      'password' => 'Password',
      'code' => 'Code'
    ];
    foreach ($fields as $field => $label) {
      if (empty(trim($postData[$field]))) {
        $errors[$field] = "$label is required";
      } else {
        $valid_data[$field] = trim($postData[$field]);
      }
    }

    if (empty($postData['skills']) || !is_array($postData['skills'])) {
      $errors['skills'] = "At least one skill is required";
    } else {
      $valid_data['skills'] = $postData['skills'];
    }
    return ["errors" => $errors, "valid_data" => $valid_data];
  }
}
