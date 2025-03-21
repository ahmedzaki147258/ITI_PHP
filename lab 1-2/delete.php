<?php

require_once './HelperTrait.php';
class DeleteUser
{
  use HelperTrait;

  public function delete(): void
  {
    $id = $this->filtersRequest("id");
    $this->deleteFromFile('users.txt', $id);
    header("Location: display.php");
    exit;
  }
}

$delete = new DeleteUser();
$delete->delete();
