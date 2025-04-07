<?php
function store_data($conn, $name, $gender, $lang, $state, $email, $contact, $image)
{
    $path = store_image($image);
    if ($path !== false) {
        $langs = implode(",", $lang);
        //    echo $langs;
        $sql = "INSERT INTO `advance_crud`(`name`, `gender`, `lang`, `state`, `email`, `contact`, `image`) VALUES ('$name','$gender','$langs','$state','$email','$contact', '$path')";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "Error in insert query -> " . mysqli_error($conn);
        }
        header("location:index.php");
        exit;
    } else {
        echo "Image path cannot be generated";
        echo $path;
    }
    header("location:index.php");
    exit;
}

function delete_data($conn, $id)
{
    $sql = "DELETE FROM `advance_crud` WHERE id=$id";
    mysqli_query($conn, $sql);
    header("location:index.php");
    exit;
}

function update_data($conn, $name, $gender, $lang, $state, $email, $contact, $id, $image)
{
    $path = store_image($image);
    $langs = implode(",", $lang);
    //    echo $langs;
    $sql = "UPDATE `advance_crud` SET `name`='$name',`gender`='$gender',`lang`='$langs',`state`='$state',`email`='$email',`contact`='$contact',`image`='$path' WHERE id=$id";

    //    echo $sql;
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error in insert query -> " . mysqli_error($conn);
    }
    header("location:index.php");
    exit;
}

function store_image(array $image): mixed
{
    $dir = __DIR__ . "/images/";

    if (!is_dir($dir)) {
        if (mkdir($dir, 0755, true)) {
            echo "Created directory $dir\n";
        } else {
            echo "Directory $dir cannot be created\n";
            return false;
        }
    }
    $img_name = $image['name'];
    $path = "images/" . $img_name;
    if (move_uploaded_file($image['tmp_name'], $path)) {
        return $path;
    }
    return false;
}