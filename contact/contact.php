<?php
require_once("connection.php");

// Delete record if the ID is provided in the URL
if (isset($_GET["id"])) {
    $recordId = $_GET["id"];
    $result = deleteRecord($recordId);
    if ($result) {
        echo "<script>alert('Record deleted successfully.');</script>";
    }
    echo "<script>window.location.href = 'Contact.php';</script>";
    exit();
}

// Function to delete a record by ID
function deleteRecord($id) {
    global $con;
    $query = "DELETE FROM contact WHERE id = $id";
    $result = mysqli_query($con, $query);
    return $result;
}

$query = "SELECT * FROM contact";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Phonebook</title>
    <link rel="stylesheet" href="css/contact.css">
</head>

<h1> <marquee behavior="alternate">CONTACT INFO</marquee></h1>

<body>

    <form method="POST" action="insert.php">
        <label for="firstname" id="fname">First Name:</label>
        <input type="text" name="firstname" placeholder="Enter your first name" required> 
        <label for="lastname" id="lname">Last Name:</label>
        <input type="text" name="lastname" placeholder="Enter your last name" required>
        <label for="contact" id="cont">Contact:</label>
        <input type="number" name="contact" placeholder="Enter your contact number" required>
        <label for="email" id="email">Email:</label>
        <input type="email" name="email" placeholder="Enter your email" required>&nbsp;
        <button type="submit" value="insert" name="submit">Submit</button>
         </form>


         <p>
         <button id="toggleDarkMode" class="toggle-button">Dark Mode</button>
</p>

<style>
body {
  background-color: #fff;
  color: #000;
}

body.dark-mode {
  background-color: #222;
  color: #fff;
}
h1 {
  font-family: Times New Roman, sans-serif;
  color: red;
}
body {
    color: blue;
  font-family: Times New Roman, sans-serif;
}

.toggle-button {
  cursor: pointer;
}

a {
  cursor: crosshair;
}
</style>


        <script>
  function confirmDelete(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: 'You are about to delete this record.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = 'Contact.php?id=' + id;
      }
    });
  }
</script>


    <body class="bg-dark">
        <div class="container">
            <div class="row">
                <div class="col m-auto">
                    <div class="card mt-5">
                        <table class="table table-bordered" id="Contact">
                            <tr>
                                <td> FIRST NAME </td>
                                <td> LAST NAME </td>
                                <td> CONTACT </td>
                                <td> EMAIL </td>
                                <td> ACTIONS </td>
                            </tr>

                            <?php 
                                while($row = mysqli_fetch_assoc($result))
                                {
                                    $id = $row["id"];
                                    $fname = $row["fname"];
                                    $lname = $row["lname"];
                                    $contact = $row["contact"];
                                    $email = $row["email"];
                            ?>
<tr>
  <td><?php echo $fname ?></td>
  <td><?php echo $lname ?></td>
  <td><?php echo $contact ?></td>
  <td><?php echo $email ?></td>
  <td>
    <form method="GET" action="Contact.php">
      <button type="button" name="id" value="<?php echo $id; ?>" onclick="confirmDelete(<?php echo $id; ?>)">Delete</button>
    </form>
  </td>
</tr>
     
                            <?php 
                                }  
                            ?>                                                                    
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script>
        const toggleButton = document.getElementById('toggleDarkMode');
        const body = document.body;

        toggleButton.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
        });
    </script>
</body>
</html>
