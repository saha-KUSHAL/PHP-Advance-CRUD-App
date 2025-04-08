<?php
session_start();
ob_start();
include("dbConnect.php");
include("process.php");
// header("Cache-Control: no-cache, no-store, must-revalidate");
// header("Pragma: no-cache");
// header("Expires: 0");
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP Advance CRUD Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container text-center bg-dark text-light rounded col-lg-12 col-sm-12">
        <h1>Advance CRUD Application</h1>
    </div>

    <!-- Alert for any activity -->
    <?php
    if (!empty($_SESSION)) {
        // Handel errors
        if (isset($_SESSION['error'])) {
            echo '<div class="container alert alert-danger" role="alert">';
            $errors = $_SESSION['error'];
            foreach ($errors as $error) {
                echo $error;
                echo "<hr>";
            }
            echo '</div>';
        }
        // Handel success messages
        if (isset($_SESSION['success'])) {
            echo '<div class="container alert alert-success" role="alert">';
            $successes = $_SESSION['success'];
            foreach ($successes as $success) {
                echo $success;
                echo "<hr>";
            }
            echo '</div>';
        }
        session_destroy();
    }
    ?>
    <div class="container rounded border mb-3 mt-3">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col">
                    <label for="name" class="form-label mt-3">Name</label>
                    <input type="text" class="form-control mb-2" name="name" id="name">

                    <label for="gender" class="form-label me-3">Gender</label>
                    <input class="form-check-input" type="radio" name="gender" value="male">
                    <label class="form-check-label">
                        Male
                    </label>
                    <input class="form-check-input" type="radio" name="gender" value="female">
                    <label class="form-check-label">
                        Female
                    </label>
                    <br>

                    <label for="gender" class="form-label me-3">Languages</label>
                    <input class="form-check-input" type="checkbox" name="lang[]" value="c++">
                    <label class="form-check-label">
                        C++
                    </label>

                    <input class="form-check-input" type="checkbox" name="lang[]" value="py">
                    <label class="form-check-label">
                        Python
                    </label>
                    <input class="form-check-input" type="checkbox" name="lang[]" value="java">
                    <label class="form-check-label">
                        Java
                    </label>
                    <input class="form-check-input" type="checkbox" name="lang[]" value="rust">
                    <label class="form-check-label">
                        Rust
                    </label>
                    <br>
                    <label for="state" class="form-label me-3">State</label>
                    <select class="form-select mb-2 " name="state">
                        <option selected>Select state</option>
                        <option value="West Bengal">West Bengal</option>
                        <option value="Delhi">Delhi</option>
                        <option value="Bangalore">Bengalore</option>
                        <option value="Bihar">Bihar</option>
                        <option value="Odisa">Odisa</option>
                        <option value="Assam">Assam</option>
                        <option value="J&K">J&K</option>
                    </select>

                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="email" name="email">

                    <label for="contact" class="form-label">Contact</label>
                    <input type="text" class="form-control" id="contact" name="contact">

                    <label for="contact" class="form-label">Upload photo</label>
                    <input type="file" class="form-control" name="pic">
                    <button class="btn btn-success mt-3" type="submit">Save</button>
                </div>
                <!-- <div class="col">
                    <img src="user.png" alt="Your photo displayed here" height="200" class="rounded mx-auto d-block mt-3">
                    <div class="input-group mt-3">
                        <input type="file" class="form-control" name="pic">
                    </div>
                </div> -->
            </div>

        </form>
    </div>
    <div class="container rounded border pt-3">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Picture</th>
                    <th scope="col">Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">State</th>
                    <th scope="col">Languages</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                <?php
                $query = "SELECT * FROM `advance_crud` WHERE 1";
                $data = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($data)) {
                    ?>
                    <tr>
                        <th scope="row"><?php echo $row['id'] ?></th>
                        <td><img src="<?php echo $row['image'] ?>" alt="Image of person" width="100px" height="100px"></td>
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['gender'] ?></td>
                        <td><?php echo $row['state'] ?></td>
                        <td><?php echo $row['lang'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td><?php echo $row['contact'] ?></td>
                        <td><a href="update.php?id=<?php echo $row['id'] ?>" class="btn btn-sm btn-warning">Update</a>
                            <a href="index.php?id=<?php echo $row['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>

<?php
//Handel the insert operation
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // echo "<pre>";
    // print_r($_POST);

    /**
     * $errors collects all validation errors, so that we can output the errors which are happened.
     * trim() method is used to cut any unwanted whitespace or unprintable characters.
     * null coalescing operator '??' is used to set empty string if the key is not set.
     */

    $errors = [];
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
            $errors = "Image type must be jpg, jpeg or png";
        }
    } else {
        $errors[] = "Upload a picture or Error in upload";
    }

    // Proceed insertion if only there is no error
    if (empty($errors)) {
        if(store_data($conn, $name, $gender, $lang, $state, $email, $contact, $image))
            $_SESSION['success'][] = "Data Stored Successfully";
        header("location:index.php");
    } else {
        // Prints the error messages
        $_SESSION['error'] = $errors;
        header("location:index.php");
    }
}
//Handel the delete operation
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {
    //    print_r($_GET);
    if(delete_data($conn, $_GET['id'])){
        $_SESSION['success'][] = "Data deleted successfully";
    }
    header("location:index.php");
}
?>