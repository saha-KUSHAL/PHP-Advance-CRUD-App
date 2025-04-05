<?php
include("dbConnect.php");
include("process.php");
$id = $_GET['id'];
$query = "SELECT * FROM `advance_crud` WHERE id=$id";
$data = mysqli_query($conn, $query);
$row = [];
if (mysqli_num_rows($data) > 0)
    $row = mysqli_fetch_assoc($data);
else
    echo "No Data found !";
?>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Update Details</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
              crossorigin="anonymous">
    </head>
    <body>
    <div class="container text-center bg-dark text-light rounded col-lg-4 col-sm-12"><h1>Update Details</h1>
    </div>
    <div class="container rounded border mb-3 mt-3 col-lg-4 col-sm-12">
        <form action="" method="post">
            <input type="hidden" value="<?php echo $row['id'] ?>" name="id">
            <label for="name" class="form-label mt-3">Name</label>
            <input type="text" class="form-control mb-2" name="name" id="name" value="<?php echo $row['name'] ?>">

            <label for="gender" class="form-label me-3">Gender</label>
            <input class="form-check-input" type="radio" name="gender"
                   value="male" <?php if ($row['gender'] == "male") {
                echo "checked";
            } ?>>
            <label class="form-check-label">
                Male
            </label>
            <input class="form-check-input" type="radio" name="gender"
                   value="female"<?php if ($row['gender'] == "female") {
                echo "checked";
            } ?>>
            <label class="form-check-label">
                Female
            </label>
            <br>

            <label for="gender" class="form-label me-3">Languages</label>
            <input class="form-check-input" type="checkbox" name="lang[]"
                   value="c++" <?php if (strpos($row['lang'], "c++") !== false) {
                echo "checked";
            } ?>>
            <label class="form-check-label">
                C++
            </label>

            <input class="form-check-input" type="checkbox" name="lang[]"
                   value="py" <?php if (strpos($row['lang'], "py") !== false) {
                echo "checked";
            } ?>>
            <label class="form-check-label">
                Python
            </label>
            <input class="form-check-input" type="checkbox" name="lang[]"
                   value="java" <?php if (strpos($row['lang'], "java") !== false) {
                echo "checked";
            } ?>>
            <label class="form-check-label">
                Java
            </label>
            <input class="form-check-input" type="checkbox" name="lang[]"
                   value="rust" <?php if (strpos($row['lang'], "rust") !== false) {
                echo "checked";
            } ?>>
            <label class="form-check-label">
                Rust
            </label>
            <br>

            <label for="state" class="form-label me-3">State</label>
            <select class="form-select mb-2 " name="state">
                <option>Select state</option>
                <option value="West Bengal" <?php if ($row['state'] == "West Bengal") {
                    echo "selected";
                } ?>>West Bengal
                </option>
                <option value="Delhi" <?php if ($row['state'] == "Delhi") {
                    echo "selected";
                } ?>>Delhi
                </option>
                <option value="Bangalore" <?php if ($row['state'] == "Bangalore") {
                    echo "selected";
                } ?>>Bengalore
                </option>
                <option value="Bihar" <?php if ($row['state'] == "Bihar") {
                    echo "selected";
                } ?>>Bihar
                </option>
                <option value="Odisa" <?php if ($row['state'] == "Odisa") {
                    echo "selected";
                } ?>>Odisa
                </option>
                <option value="Assam" <?php if ($row['state'] == "Assam") {
                    echo "selected";
                } ?>>Assam
                </option>
                <option value="J&K" <?php if ($row['state'] == "J&K") {
                    echo "selected";
                } ?>>J&K
                </option>
            </select>

            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="<?php echo $row['email'] ?>">

            <label for="contact" class="form-label">Contact</label>
            <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $row['contact'] ?>">
            <button class="btn btn-success mt-3" type="submit">Update</button>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    </body>
    </html>

<?php
//Handel the update operation
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_GET['id'])) {
//    echo "<pre>";
//    print_r($_POST);
    $id = $_POST['id'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $lang = $_POST['lang'];
    $state = $_POST['state'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    if (!empty($name) && !empty($email) && !empty($contact)) {
        update_data($conn, $name, $gender, $lang, $state, $email, $contact, $id);
        ?>
        <script>
            window.location.href="http://localhost/jphp21/PHP-Advance-CRUD-App/index.php"
        </script>
        <?php
    } else
        echo "Field values cannot be empty";
}
//Handel the delete operation
//if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {
//    print_r($_GET);
//}
?>