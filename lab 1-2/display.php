<?php
require_once './HelperTrait.php';

class Display {
  use HelperTrait;

  public function display(): void {
    $users = $this->readTxtFile('users.txt');
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
                              #ID
                          </th>
                          <th scope='col' class='px-6 py-3'>
                              Full Name
                          </th>
                          <th scope='col' class='px-6 py-3'>
                              User Name
                          </th>
                          
                          <th scope='col' class='px-6 py-3'>
                              Address
                          </th>
                          <th scope='col' class='px-6 py-3'>
                              Country
                          </th>
                          <th scope='col' class='px-6 py-3'>
                              Gender
                          </th>
                          <th scope='col' class='px-6 py-3'>
                              Skills
                          </th>
                          <th scope='col' class='px-6 py-3'>
                              Department
                          </th>
                          
                          <th scope='col' class='px-6 py-3 text-red-600'>
                              Delete
                          </th>
                      </tr>
                  </thead>
                  <tbody>";
    foreach ($users as $user) {
      echo "<tr class='bg-white border-b border-gray-300'>
            <th class='px-6 py-4'>$user[id]</th>
            <td class='px-6 py-4'>$user[firstName] $user[lastName]</td>
            <td class='px-6 py-4'>$user[userName]</td>
            <td class='px-6 py-4'>$user[address]</td>
            <td class='px-6 py-4'>$user[country]</td>
            <td class='px-6 py-4'>$user[gender]</td>
            <td class='px-6 py-4'>$user[skills]</td>
            <td class='px-6 py-4'>$user[department]</td>
            <td class='px-6 py-4'>
            <form action='./delete.php' method='POST'>
                <input type='hidden' name='id' value='$user[id]'>
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

$display = new Display();
$display->display();
