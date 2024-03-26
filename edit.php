<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "myshop";

// create connection
$connection = new mysqli($servername, $username, $password, $database);

$id = '';
$name = "";
$email = "";
$phone = "";
$address = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // show data of client
    if (!isset ($_GET['id'])) {
        header('location: ./index.php');
        exit;
    }

    $id = $_GET['id'];

    // read data selected client from data table
    $sql = "SELECT * FROM clients WHERE id=$id";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header('location: ./index.php');
        exit;
    }

    // store data to data base
    $name = $row["name"];
    $email = $row["email"];
    $phone = $row["phone"];
    $address = $row["address"];

} else {
    // update data of the client
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    do {

        if (empty ($id) || empty ($name) || empty ($email) || empty ($phone) || empty ($address)) {
            $errorMessage = "All fields required";
            break;
        }

        $sql = "UPDATE clients " .
            "SET name = '$name', email = '$email', phone = '$phone', address = '$address' " .
            "WHERE id = $id";

            $result = $connection->query($sql);

            if(!$result){
                $errorMessage = "Invalid query: " . $connection->$error;
                break;
            }

            $successMessage = "Client updated correctly";

            // return home
            header('location: ./index.php');
            exit;

    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Update Client</title>
</head>

<body>
    <div class="container my-5">
        <h2 class="mb-5">Update Clients</h2>
        <!-- alert message -->
        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button class='btn-close' type='button' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
            ";
        }
        ?>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="row mb-3">
                <label for="name" class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" id="name">
                </div>
            </div>

            <div class="row mb-3">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $email; ?>" id="email">
                </div>
            </div>

            <div class="row mb-3">
                <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>" id="phone">
                </div>
            </div>

            <div class="row mb-3">
                <label for="address" class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo $address; ?>" id="address">
                </div>
            </div>


            <!-- succes message -->
            <?php
            if (!empty ($successMessage)) {
                echo "
                <div class='row mb-3'>
                <div class='offset-sm-3 col-sm-6'>
                    <div class='alert alert-succes alert-dismissible fade show' role='alert'>
                    <strong>$successMessage</strong>
                    <button class='btn-close' data-bs-dissmiss='alert' aria-label='Close'></button>
                </div>
                </div>
            </div>
                ";
            }
            ?>


            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a href="" class="btn btn-outline-danger" href='./index.php' role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>