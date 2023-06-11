<?php

function deleteRecord($id) {
    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "phonebook";

    $connect = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
    }

    // Prepare and execute the delete statement
    $stmt = $connect->prepare("DELETE FROM contact WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Close the statement and the database connection
    $stmt->close();
    $connect->close();
}

if(isset($_POST["submit"])) {
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    $connect = new mysqli("localhost", "root", "", "phonebook");

    if ($connect->connect_error) {
        die("Connection Failed!" . $connect->connect_error);
    }

    $insert_data = "INSERT INTO contact (fname, lname, contact, email) VALUES ('$fname', '$lname', '$contact', '$email')";

    if ($connect->query($insert_data) === TRUE) {
        echo "<script>
        message('New contact successfully added.');
        </script>";
        echo "<script> 
        window.location.replace('contact.php');
        </script>";
    } else {
        echo "Contact Unsaved" . $insert_data . $connect->error;
    }

    $connect->close();
}

// Example usage of deleteRecord function
if(isset($_GET["id"])) {
    $recordId = $_GET["id"];
    deleteRecord($recordId);
}
?>

