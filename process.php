<?php
function store_data($conn, $name, $gender, $lang, $state, $email, $contact)
{
    $langs = implode(",", $lang);
//    echo $langs;
    $sql = "INSERT INTO `advance_crud`(`name`, `gender`, `lang`, `state`, `email`, `contact`) VALUES ('$name','$gender','$langs','$state','$email','$contact')";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error in insert query -> " . mysqli_error($conn);
    }
    header("location:index.php");
}

function delete_data($conn, $id)
{
    $sql = "DELETE FROM `advance_crud` WHERE id=$id";
    mysqli_query($conn, $sql);
    header("location:index.php");
}

function update_data($conn, $name, $gender, $lang, $state, $email, $contact, $id)
{
    $langs = implode(",", $lang);
//    echo $langs;
    $sql = "UPDATE `advance_crud` SET `name`='$name',`gender`='$gender',`lang`='$langs',`state`='$state',`email`='$email',`contact`='$contact' WHERE id=$id";

//    echo $sql;
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error in insert query -> " . mysqli_error($conn);
    }
    header("location:index.php");
}