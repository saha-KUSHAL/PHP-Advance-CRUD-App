<?php
    session_start();
    ob_start();
    require_once __DIR__ . "/../dbConnect.php";
?>
<!doctype html>
<html lang="en">

<head>
    <title>Register for CRUD</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
        <link rel="stylesheet" href="style.css">
</head>

<body>

    <main>
        <section class="d-flex align-items-center justify-content-center mt-auto vh-100">
            <div class="container col-lg-4 border rounded">
                <form action="" method="post">

                    <h1 class="text-center my-3">Register</h1>
                    <?php
                        if (isset($_SESSION["alert"]) && isset($_SESSION["alert_type"])) {
                        ?>
                        <div class="alert alert-<?php echo $_SESSION["alert_type"]; ?> alert-dismissible fade show"
                            role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <?php echo nl2br($_SESSION["alert"]); ?>
                        </div>

                        <?php
                            session_unset();
                            }
                        ?>
                    <div class="mb-3"><label for="first_name" class="form-label">First Name</label>
                        <input type="text" id="first_name" class="form-control" name="first_name"
                            placeholder="Your First name here">
                    </div>

                    <div class="mb-3"><label for="last_name" class="form-label">Last Name</label>
                        <input type="text" id="last_name" class="form-control" name="last_name"
                            placeholder="Your Last name here">
                    </div>

                    <div class="mb-3"><label for="email" class="form-label">Email</label>
                        <input type="email" id="email" class="form-control" name="email" placeholder="Your Email here">
                    </div>

                    <div class="mb-3"><label for="password" class="form-label">Password</label>
                        <input type="password" id="password" class="form-control" name="password"
                            placeholder="Your Password here">
                    </div>

                    <div class="mb-3"><label for="cpassword" class="form-label">Confirm Password</label>
                        <input type="password" id="cpassword" class="form-control" name="cpassword"
                            placeholder="Password again">
                    </div>

                    <button class="btn btn-primary w-100 mb-3">
                        Register
                    </button>
                </form>
            </div>
        </section>
    </main>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>

<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $first_name = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['first_name']), ENT_QUOTES, "UTF-8");
        $last_name  = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['last_name']), ENT_QUOTES, "UTF-8");
        $email      = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email']), ENT_QUOTES, "UTF-8");
        $password   = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['password']), ENT_QUOTES, "UTF-8");
        $cpassword  = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['cpassword']), ENT_QUOTES, "UTF-8");

        if (empty($first_name)) {
            $_SESSION["alert"] .= "Enter first name\n";
            $_SESSION["alert_type"] = "danger";
        }
        if (empty($last_name)) {
            $_SESSION["alert"] .= "Enter last name\n";
            $_SESSION["alert_type"] = "danger";
        }
        if (empty($email)) {
            $_SESSION["alert"] .= "Enter email\n";
            $_SESSION["alert_type"] = "danger";
        }

        if (empty($password)) {
            $_SESSION["alert"] .= "Enter password\n";
            $_SESSION["alert_type"] = "danger";
        }

        if (! ($password === $cpassword)) {
            $_SESSION["alert"] .= "Password is not matched\n";
            $_SESSION["alert_type"] = "danger";
        }

        if (! empty($_SESSION["alert"])) {
            header("Refresh:0");
            exit;
        } else {

            $check_email_exist = mysqli_query($conn, "SELECT `email` FROM `auth_cred` WHERE email = '$email'");

            if (mysqli_num_rows($check_email_exist) > 0) {
                $_SESSION["alert"]      = "Email already exist, Kindly &nbsp <button class='btn btn-warning'><a href='login.php' >Login Now</a></button>";
                $_SESSION["alert_type"] = "warning";
                header("Refresh:0");
                exit;
            }
            $hpassword = password_hash($password, PASSWORD_DEFAULT);

            $insert_into_db = "INSERT INTO `auth_cred`(`first_name`, `last_name`, `email`, `password`) VALUES ('$first_name','$last_name','$email','$hpassword')";

            $result = mysqli_query($conn, $insert_into_db);

            if (! $result) {
                echo "Error in insert query " . mysqli_error($conn);
            } else {
                $_SESSION["alert"]      = "Account Created ! &nbsp <button class='btn btn-sucess'><a href='login.php' >Login</a></button>";
                $_SESSION["alert_type"] = "success";
                header("Refresh:0");
                exit;

            }
        }
}
?>