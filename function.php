<?php

session_start();

require_once 'config.php';
$conn = OpenCon();

//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);

function pr($data) {
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

//die;
if (!empty($_GET['adminssion_no'])) {

    updateStudent($conn, $_POST);
}

function countTotal($conn) {
    $count_query = "SELECT count(*) as total from student_info where check_updated='1'";
    $count_result = mysqli_query($conn, $count_query);
    $count = mysqli_fetch_assoc($count_result);
    return $count;
}

function getStudent($conn, $a_no, $date_of_birth) {
    $myDateTime = DateTime::createFromFormat('Y-m-d', $date_of_birth);
    $newDateString = $myDateTime->format('d-M-Y');
    $sql = "SELECT * from student_info where Admission_No='" . $a_no . "' AND Date_of_Birth='" . $newDateString . "' ";
    $result = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($result);
    $count_query = "SELECT count(*) as total from student_info where check_updated='01'";
    $count_result = mysqli_query($conn, $count_query);
    $count = mysqli_fetch_assoc($count_result);
    if ($result['check_updated'] == 1) {
        $_SESSION["error"][] = 'You have updated this form';
    }
    $sql2 = "SELECT * from bus_routes ";
    $result2 = $conn->query($sql2);
    
    if ($result2->num_rows > 0) {
        while ($row = $result2->fetch_assoc()) {
            $row_data[] = $row;
        }
    }
//    return $result;
    return array('student_info' => $result, 'bus_route' => $row_data);
}

function updateStudent($conn, $data) {

    foreach ($_FILES as $key => $img) {
        if (empty($img['name'])) {
            continue;
        }

        $file_size = $img['size'];
        $file_ext = strtolower(end(explode('.', $img['name'])));
        $file_type = $img['type'];

        $expensions = array("jpeg", "jpg", "png");

        if ($file_size > 5000152) {
            $_SESSION["error"][] = 'File size must be less than 5 MB';
            continue;
        }

        if (in_array($file_ext, $expensions) === FALSE) {
            $_SESSION["error"][] = "Invalid image extension, please try a JPEG or PNG file.";
            continue;
        }
        $uploaddir = 'assets/img/';
        $uploadfile = $uploaddir . basename($img['name']);

        $newfilename = trim($data['Admission_No'] . $key . "." . $file_ext);

        if (move_uploaded_file($img['tmp_name'], $uploaddir . $newfilename)) {

            $sql = "UPDATE student_info SET " . $key . " ='" . $newfilename . "' WHERE Admission_No='" . trim($data['Admission_No']) . "'";

            if (!mysqli_query($conn, $sql) === TRUE) {
                $_SESSION["error"][] = "Record update failed";
            }
        } else {
            $_SESSION["error"][] = "Image upload failed";
        }
    }

    $sql = "UPDATE student_info SET Admission_No='" . trim($data['Admission_No']) . "',Student_Name='" . trim($data['Student_Name']) . "',Class_Sec='" . trim($data['Class_Sec']) . "',E_Mail='" . trim($data['E_Mail']) . "',Address='" . trim($data['Address']) . "',City='" . trim($data['City']) . "',State='" . trim($data['State']) . "',Pin_code='" . trim($data['Pin_code']) . "',Phone='" . trim($data['Phone']) . "',Emergency_No='" . trim($data['Emergency_No']) . "',Date_of_Birth='" . trim($data['Date_of_Birth']) . "',Gender='" . trim($data['Gender']) . "',Bus_Stop='" . trim($data['Bus_Stop']) . "',Blood_Group	='" . trim($data['Blood_Group']) . "',Father_Name	='" . trim($data['Father_Name']) . "',Father_Mobile='" . trim($data['Father_Mobile']) . "',Father_Email='" . trim($data['Father_Email']) . "',Mother_Name	='" . trim($data['Mother_Name']) . "',Mother_Mobile='" . trim($data['Mother_Mobile']) . "',Mother_Email='" . trim($data['Mother_Email']) . "', private_escort='" . trim($data['private_escort']) . "',route_no='" . trim($data['root_no']) . "',check_updated='" . trim($data['check_updated']) . "' WHERE Admission_No='" . trim($data['Admission_No']) . "'";

    if (!mysqli_query($conn, $sql) === TRUE) {
        $_SESSION["error"][] = "Record update failed.";
    } else {
        $_SESSION["success"] = "Record updated successfully.";
    }
    $a_no = trim($_GET['adminssion_no']);
    $m_no = trim($_GET['mobile_no']);
    header("Location:index.php?adminssion_no=$a_no&mobile_no=$m_no");
    exit();
}
