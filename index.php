<?php
include("dbConnect.php");
include("process.php")
?>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PHP Advance CRUD Application</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
              crossorigin="anonymous">
    </head>
    <body>
    <div class="container text-center bg-dark text-light rounded col-lg-12 col-sm-12"><h1>Advance CRUD Application</h1>
    </div>
    <div class="container rounded border mb-3 mt-3 col-lg-4 col-sm-12">
        <form action="" method="post">
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
            <button class="btn btn-success mt-3" type="submit">Save</button>
        </form>
    </div>
    <div class="container rounded border pt-3">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
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
//    echo "<pre>";
//    print_r($_POST);
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $lang = $_POST['lang'];
    $state = $_POST['state'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    if (!empty($name) && !empty($email) && !empty($contact)) {
        store_data($conn, $name, $gender, $lang, $state, $email, $contact);
    } else
        echo "Field values cannot be empty";
}
//Handel the delete operation
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {
//    print_r($_GET);
    delete_data($conn, $_GET['id']);
}
?>