<?php
require_once '../models/User.php';
require_once '../utils/HelperTrait.php';

class Display {
	use HelperTrait;

	public function __construct() {
		$errors = [];
		if (isset($_GET["errors"])) {
			$errors = $_GET["errors"];
			$errors = json_decode($errors, true);
		}
		if (!empty($errors["image"])) {
			echo '<div class="text-red-500">' . $errors["image"] . '</div>';
		}

		$users = User::all();
		echo "<!DOCTYPE html>
          <html lang='en'>
          <head>
              <meta charset='UTF-8'>
              <meta name='viewport' content='width=device-width, initial-scale=1.0'>
              <title>Users</title>
              <script src='https://cdn.tailwindcss.com'></script>
          </head>
          <body>
          
          <div class='relative overflow-x-auto shadow-md sm:rounded-lg'>
              <table class='w-full text-sm text-left rtl:text-right text-gray-700 bg-white border border-gray-300'>
                  <thead class='text-xs text-gray-800 uppercase bg-gray-100 border-b border-gray-300'>
                      <tr>
                          <th scope='col' class='px-6 py-3'>
                              Image
                          </th>
                          <th scope='col' class='px-6 py-3'>
                              Name
                          </th>
                          <th scope='col' class='px-6 py-3'>
                              E-mail
                          </th>
                          <th scope='col' class='px-6 py-3'>
                              Room No
                          </th>
                          <th scope='col' class='px-6 py-3'>
                              Ext
                          </th>
                          
                          <th scope='col' class='px-6 py-3 text-blue-600'>
                              Edit
                          </th>
                           <th scope='col' class='px-6 py-3 text-blue-600'>
                              Edit Password
                          </th>
                          <th scope='col' class='px-6 py-3 text-red-600'>
                              Delete
                          </th>
                      </tr>
                  </thead>
                  <tbody>";
		foreach ($users as $user) {
			$userData = User::find($user['id']);
			$filteredIDs = array_intersect_key($userData, array_flip(["id"]));
			$userIDs[$user['id']] = json_encode($filteredIDs);
			$filteredData = array_intersect_key($userData, array_flip(["id", "name", "email", "room_no", "ext"]));
			$oldData[$user['id']] = json_encode($filteredData);

			echo "<tr class='bg-white border-b border-gray-300'>  
           	<td class='px-6 py-4'>
              <form action='./changeImage.php?old={$userIDs[$user['id']]}' method='POST' enctype='multipart/form-data'>
                <input type='hidden' name='id' value='{$user['id']}'>
                <input type='hidden' name='curr_image' value='{$user['image']}'>
                <label for='image-{$user['id']}' style='cursor:pointer;'>
                  <img src='{$user['image']}' width='80' height='80' alt='Profile Image'>
                </label>
                <input id='image-{$user['id']}' type='file' name='image' style='display:none;' onchange='this.form.submit()'>
              </form>
            </td>
						
            <td class='px-6 py-4'>$user[name]</td>
            <td class='px-6 py-4'>$user[email]</td>
            <td class='px-6 py-4'>$user[room_no]</td>
            <td class='px-6 py-4'>$user[ext]</td>

						<td class='px-6 py-4'>
	            <form action='./editForm.php?old={$oldData[$user['id']]}' method='POST'>
               	<button type='submit' class='text-blue-600'>
			            <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' viewBox='0 0 20 20' fill='currentColor'>
	                	<path d='M17.414 2.586a2 2 0 0 0-2.828 0l-10 10a2 2 0 0 0-.586 1.414V17a1 1 0 0 0 1 1h3.586a2 2 0 0 0 1.414-.586l10-10a2 2 0 0 0 0-2.828l-2-2zM15 4.414L16.586 6 14 8.586 12.414 7 15 4.414zM6 14v2h2l7.586-7.586-2-2L6 14z'/>
			            </svg>
				        </button>
	            </form>
            </td>
            
            <td class='px-6 py-4'>
	            <form action='./changePasswordForm.php?old={$userIDs[$user['id']]}' method='POST'>
                <button type='submit' class='text-blue-600'>
			            <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' viewBox='0 0 20 20' fill='currentColor'>
		                <path fill-rule='evenodd' d='M5 8V6a5 5 0 0 1 10 0v2h1a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2h1zm2-2v2h6V6a3 3 0 1 0-6 0zm-1 6a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-3z' clip-rule='evenodd'/>
			            </svg>
				        </button>
	            </form>
            </td>
            
            <td class='px-6 py-4'>
	            <form action='./delete.php' method='POST'>
                <input type='hidden' name='id' value='$user[id]'>
                <input type='hidden' name='imageName' value='$user[image]'>
                <button type='submit' class='text-red-600'>
                  <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' viewBox='0 0 20 20' fill='currentColor'>
                    <path fill-rule='evenodd' d='M6 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v1h3a1 1 0 1 1 0 2h-1v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6H2a1 1 0 1 1 0-2h3V3zm2 2v10h1V5H8zm3 0v10h1V5h-1z' clip-rule='evenodd'/>
                  </svg>
                </button>
	            </form>
            </td>
        </tr>";
		}
		echo "</tbody>
        </table>
      </div>
      </body>
    </html>";
	}
}

new Display();
