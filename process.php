<?php
session_start();
function store_data($conn, $name, $gender, $lang, $state, $email, $contact, $image)
{
    $image_path = store_image($image);
    if ($image_path !== false) {
        $langs = implode(",", $lang);
        //    echo $langs;
        $sql = "INSERT INTO `advance_crud`(`name`, `gender`, `lang`, `state`, `email`, `contact`, `image`) VALUES ('$name','$gender','$langs','$state','$email','$contact', '$path')";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            $_SESSION['error']= "Error in insert query -> " . mysqli_error($conn);
            return false;
        }
        return true;
    } else {
        $_SESSION['error']= "Image path cannot be generated | ".$image_path;
        return false;
    }
}

function delete_data($conn, $id)
{
    $sql = "DELETE FROM `advance_crud` WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    if(!$result){
        $_SESSION['error']= "Error while deleting record | ".mysqli_errno($conn);
        return false;
    }
    return true;
}

function update_data($conn, $name, $gender, $lang, $state, $email, $contact, $id, $image_path)
{
    $langs = implode(",", $lang);
    //    echo $langs;
    $sql = "UPDATE `advance_crud` SET `name`='$name',`gender`='$gender',`lang`='$langs',`state`='$state',`email`='$email',`contact`='$contact',`image`='$image_path' WHERE id=$id";

    //    echo $sql;
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $_SESSION['error'] = "Error in update query -> " . mysqli_error($conn);
        return false;
    }
    return true;
}

function store_image(array $image): mixed
{
    $dir = __DIR__ . "/images/";

    if (!is_dir($dir)) {
        if (mkdir($dir, 0755, true)) {
            echo "Created directory $dir\n";
        } else {
            $_SESSION['error'] = "Directory $dir cannot be created\n";
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