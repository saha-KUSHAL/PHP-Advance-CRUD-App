<?php
session_start();
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
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container text-center bg-dark text-light rounded col-lg-4 col-sm-12">
        <h1>Update Details</h1>
    </div>
    <div class="container rounded border mb-3 mt-3 col-lg-4 col-sm-12">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" value="<?php echo $row['id'] ?>" name="id">

            <img src="<?php echo $row['image'] ?>" width="150px" height="150px" class="rounded d-block mt-3">
            <label for="contact" class="form-label">Upload photo</label>
            <input type="file" class="form-control" name="pic">

            <label for="name" class="form-label mt-3">Name</label>
            <input type="text" class="form-control mb-2" name="name" id="name" value="<?php echo $row['name'] ?>">

            <label for="gender" class="form-label me-3">Gender</label>
            <input class="form-check-input" type="radio" name="gender" value="male" <?php if ($row['gender'] == "male") {
                echo "checked";
            } ?>>
            <label class="form-check-label">
                Male
            </label>
            <input class="form-check-input" type="radio" name="gender" value="female" <?php if ($row['gender'] == "female") {
                echo "checked";
            } ?>>
            <label class="form-check-label">
                Female
            </label>
            <br>

            <label for="gender" class="form-label me-3">Languages</label>
            <input class="form-check-input" type="checkbox" name="lang[]" value="c++" <?php if (strpos($row['lang'], "c++") !== false) {
                echo "checked";
            } ?>>
            <label class="form-check-label">
                C++
            </label>

            <input class="form-check-input" type="checkbox" name="lang[]" value="py" <?php if (strpos($row['lang'], "py") !== false) {
                echo "checked";
            } ?>>
            <label class="form-check-label">
                Python
            </label>
            <input class="form-check-input" type="checkbox" name="lang[]" value="java" <?php if (strpos($row['lang'], "java") !== false) {
                echo "checked";
            } ?>>
            <label class="form-check-label">
                Java
            </label>
            <input class="form-check-input" type="checkbox" name="lang[]" value="rust" <?php if (strpos($row['lang'], "rust") !== false) {
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
    // echo "<pre>";
    // print_r($_POST);

    /**
     * $errors collects all validation errors, so that we can output the errors which are happened.
     * trim() method is used to cut any unwanted whitespace or unprintable characters.
     * null coalescing operator '??' is used to set empty string if the key is not set.
     */

    $errors = [];
    $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
    $name = trim(htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') ?? '');
    $gender = htmlspecialchars($_POST['gender'], ENT_QUOTES, 'UTF-8') ?? '';

    $lang = [];
    if (isset($_POST['lang']) && is_array($_POST['lang'])) {
        foreach ($_POST['lang'] as $langs)
            $lang[] = htmlspecialchars($langs, ENT_QUOTES, 'UTF-8') ?? '';
    }

    $state = htmlspecialchars($_POST['state'], ENT_QUOTES, 'UTF-8') ?? '';
    $email = trim(htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') ?? '');
    $contact = trim(htmlspecialchars($_POST['contact'], ENT_QUOTES, 'UTF-8') ?? '');
    $image = [];
    $image_path = '';
    // Validations
    if (empty($name))
        $errors[] = "Name is required";
    if (!in_array($gender, ['male', 'female']))
        $errors[] = "Invalid gender selected";
    if (empty($lang))
        $errors[] = "Select at least one language";
    if (empty($state) || $state == "Select state")
        $errors[] = "Select at least one state";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email";
    }
    if (!preg_match('/^[0-9]{10}$/', $contact)) {
        $errors[] = "Invalid phone number. Must be numeric and 10 digits";
    }

    // File validation
    // check if pic is uploaded and no error is there
    if (isset($_FILES['pic']) && $_FILES['pic']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['pic'];

        // Size must be under 1mb
        if ($image['size'] > 1048576) {
            $errors[] = "Image size must be under 1 mb";
        }
        // Check for image type
        if (!in_array($image['type'], ['image/jpeg', 'image/png'])) {
            $errors[] = "Image type must be jpg, jpeg or png";
        }
    } else if (isset($row['image'])) {
        $image_path = $row['image'];
    } else {
        $errors[] = "Upload a picture or Error in upload";
    }

    // Proceed insertion if only there is no error
    if (empty($errors)) {
        // If Image update is not performed
        if (empty($image_path))
            $image_path = store_image($image);

        update_data($conn, $name, $gender, $lang, $state, $email, $contact, $id, $image_path);
        $_SESSION['success'][] = "Data Updated Successfully";
    } else {
        // Prints the error messages
        foreach ($errors as $error)
            echo "<p style='color:red;'>$error</p>";
    }
}
?>