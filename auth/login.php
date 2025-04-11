<?php
    session_start();
    ob_start();
    require_once __DIR__ . "/../dbConnect.php";
?>
<!doctype html>
<html lang="en">

<head>
    <title>Login for CRUD</title>
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

                    <h1 class="text-center my-3">Login</h1>
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

                    <div class="mb-3"><label for="email" class="form-label">Email</label>
                        <input type="email" id="email" class="form-control" name="email" placeholder="Your Email here">
                    </div>

                    <div class="mb-3"><label for="password" class="form-label">Password</label>
                        <input type="password" id="password" class="form-control" name="password"
                            placeholder="Your Password here">
                    </div>

                    <button class="btn btn-success w-100 mb-3">
                        Login
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

        $email    = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email']), ENT_QUOTES, "UTF-8");
        $password = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['password']), ENT_QUOTES, "UTF-8");

        if (empty($email)) {
            $_SESSION["alert"] .= "Enter email\n";
            $_SESSION["alert_type"] = "danger";
        }

        if (empty($password)) {
            $_SESSION["alert"] .= "Enter password\n";
            $_SESSION["alert_type"] = "danger";
        }

        if (! empty($_SESSION["alert"])) {
            header("Refresh:0");
            exit;
        } else {

            $check_user_exist = mysqli_query($conn, "SELECT *  FROM `auth_cred` WHERE email = '$email'");
            if (! $check_user_exist) {
                echo "Error in insert query " . mysqli_error($conn);
                exit;
            }

            if (mysqli_num_rows($check_user_exist) == 0) {
                $_SESSION["alert"]      = "No User found, Kindly &nbsp <button class='btn btn-warning'><a href='register.php' >Register</a></button>";
                $_SESSION["alert_type"] = "warning";
                header("Refresh:0");
                exit;
            }
            $result            = mysqli_fetch_assoc($check_user_exist);
            $password_mathched = password_verify($password, $result['password']);

            if ($password_mathched) {

                $_SESSION["first_name"] = $result['first_name'];
                $_SESSION["last_name"]  = $result['last_name'];

                header("location:../index.php");
                exit;
            } else {
                $_SESSION["alert"]      = "Login Failed ! Password does not matched.";
                $_SESSION["alert_type"] = "danger";
                header("location:../index.php");
                exit;
            }
        }
    }
?>