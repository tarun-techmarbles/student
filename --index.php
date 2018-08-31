<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
require_once 'function.php';
require_once 'config.php';

$conn = OpenCon();
if (isset($_GET["adminssion_no"])) {
    $a_no = trim($_GET['adminssion_no']);
    $m_no = trim($_GET['mobile_no']);
} else {
    header("Location:login.php");
    exit;
}
$result = getStudent($conn, $a_no, $m_no);

if (empty($result['student_info'])) {
    header("Location:login.php");
    exit;
}
$bus_route_id = '';

if (!empty($result['student_info']['route_no'])) {
    $bus_route_id = $result['student_info']['route_no'];
}
foreach ($result['bus_route'] as $key => $bus_info) {

    $jsondata[] = json_encode($bus_info);
    $bus_route[$key]['id'] = $bus_info['s_no'];
    if (!empty($bus_info['route_number_2'])) {
        $bus_route[$key]['name'] = $bus_info['route_number_1'] . " / " . $bus_info['route_number_2'];
    } else {
        $bus_route[$key]['name'] = $bus_info['route_number_1'];
    }
}
$busroute = array("bus_route" => $bus_route, "jsondata" => $jsondata);


$stud_src = (!empty($result['student_info']['student_img'])) ? "assets/img/" . $result['student_info']['student_img'] : '//ssl.gstatic.com/accounts/ui/avatar_2x.png';
$father_src = (!empty($result['student_info']['Father_img'])) ? "assets/img/" . $result['student_info']['Father_img'] : '//ssl.gstatic.com/accounts/ui/avatar_2x.png';
$mother_src = (!empty($result['student_info']['Mother_img'])) ? "assets/img/" . $result['student_info']['Mother_img'] : '//ssl.gstatic.com/accounts/ui/avatar_2x.png';
$gurardian_1_img = (!empty($result['student_info']['gurardian_1_img'])) ? "assets/img/" . $result['student_info']['gurardian_1_img'] : '//ssl.gstatic.com/accounts/ui/avatar_2x.png';
$gurardian_2_img = (!empty($result['student_info']['gurardian_2_img'])) ? "assets/img/" . $result['student_info']['gurardian_2_img'] : '//ssl.gstatic.com/accounts/ui/avatar_2x.png';
?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<!------ Include the above in your HEAD tag ---------->
<div class="container">
    <div class="card card-container">

        <div>
            <div style="text-align: center;" id="form_container">
                <img src='assets/img/logo.png'></img>  
                <h1 align="center">DELHI PUBLIC SCHOOL,GBN</h1>
                <h2 align="center"> Under the aegis of The Delhi Public School Society, New Delhi 
                    B-1, Sector-132, Expressway, Noida-201301</h2>
                <h3 align="center"  >ESCORT CARD</h3>
            </div>
            <?php
            if (!empty($_SESSION['error'])) {
                $errors = ($_SESSION['error']);
                foreach ($errors as $error) {
                    ?>
                    <div class="alert alert-danger">
                        <?php
                        echo $error;
                        ?>
                    </div>
                    <?php
                }
                unset($_SESSION["error"]);
            }
            ?>
            <?php if (!empty($_SESSION['success'])) { ?>
                <div class = "alert alert-success">
                    <?php
                    echo $_SESSION['success'];
                    ?>
                </div>

                <?php
                unset($_SESSION["success"]);
            }
            ?>

            <form class="form-signin"  action="function.php?adminssion_no=<?php echo $a_no; ?>&mobile_no=<?php echo $m_no; ?>" id="formentry"  method="POST"  enctype="multipart/form-data" >
                <div class="img_uplaod"> 
                    <div class="img_div"> <img id="profile-img" class="profile-img-card" src='<?php echo $stud_src; ?>'/> <div class="img-title"><p>Student image</p></div>
                        <div class="hover-text">Add Students image in school summer uniform.</div>
                    </div>
                    <input type="file" name="student_img" />
                    <p id="profile-name" class="profile-name-card"></p> </div>
                 <!--<img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" />--> 
                <div class="img_uplaod">
                    <div class="img_div"> <img id="profile-img" class="profile-img-card" src='<?php echo $father_src; ?>' /> <div class="img-title"><p>Father image</p></div>
                    </div><input type="file" name="Father_img" />
                    <p id="profile-name" class="profile-name-card"></p> </div>

                <div class="img_uplaod">
                    <div class="img_div"> <img id="profile-img" class="profile-img-card" src='<?php echo $mother_src; ?>' /> <div class="img-title"><p>Mother image</p></div>
                    </div><input type="file" name="Mother_img"/>
                    <p id="profile-name" class="profile-name-card"></p> </div>
                <div class="img_uplaod">
                    <div class="img_div"> <img id="profile-img" class="profile-img-card" src='<?php echo $gurardian_1_img; ?>' /> <div class="img-title"><p>Gurardian-1 image</p></div>
                    </div> <input type="file" name="gurardian_1_img"/>
                    <p id="profile-name" class="profile-name-card"></p> </div>
                <div class="img_uplaod">
                    <div class="img_div"> <img id="profile-img" class="profile-img-card" src='<?php echo $gurardian_2_img; ?>' /> <div class="img-title"><p>Gurardian-2 image</p></div>
                    </div> <input type="file" name="gurardian_2_img"/>
                    <p id="profile-name" class="profile-name-card"></p> </div>
        </div>
        <h4>Student Details</h4>
        <div class="row">
            <div class="col-sm-5">

                <div class="panel panel-default">
                    <div class="panel-body form-horizontal payment-form">
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Admission No</label>
                            <div class="col-sm-9">
                                <input type="text" readonly=readonly value="<?php echo $result['student_info']['Admission_No'] ?>" class="form-control" id="concept" name="Admission_No">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">Student Name</label>
                            <div class="col-sm-9">
                                <input type="text" readonly=readonly class="form-control" id="description" value="<?php echo $result['student_info']['Student_Name'] ?>" name="Student_Name">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="date" class="col-sm-3 control-label">Date of Birth</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?php echo $result['student_info']['Date_of_Birth'] ?>" id="date" name="Date_of_Birth">
                            </div>
                        </div> 

                        <div class="form-group">
                            <label for="status" class="col-sm-3 control-label">Gender</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="status" value=""  name="Gender">
                                    <option <?php if ($result['student_info']['Gender'] == "Male") echo 'selected'; ?> >Male</option>
                                    <option <?php if ($result['student_info']['Gender'] == "Female") echo 'selected'; ?>>Female</option>

                                </select>
                            </div>
                        </div> 

                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">Adhar No</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" name="description">
                            </div>
                        </div> 

                    </div>
                </div>            
            </div> <!-- / panel preview -->
            <div class="col-sm-5">

                <div class="panel panel-default">
                    <div class="panel-body form-horizontal payment-form">
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Blood Group</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="concept" value="<?php echo $result['student_info']['Blood_Group'] ?>" name="Blood_Group">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">E-mail</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" value="<?php echo $result['student_info']['E_Mail'] ?>" name="E_Mail">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">Class & Sec</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" value="<?php echo $result['student_info']['Class_Sec'] ?>" name="Class_Sec">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">Phone</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="<?php echo $result['student_info']['Phone'] ?>" id="description" name="Phone">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">Emergency No</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" value="<?php echo $result['student_info']['Emergency_No'] ?>" name="Emergency_No">
                            </div>
                        </div>   
                    </div>
                </div>            
            </div> 
        </div>
        <h4>Address</h4>
        <div class="row">
            <!-- / panel preview -->
            <div class="col-sm-5">

                <div class="panel panel-default">
                    <div class="panel-body form-horizontal payment-form">
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Address</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="concept" value="<?php echo $result['student_info']['Address'] ?>" name="Address">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">City</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" value="<?php echo $result['student_info']['City'] ?>" name="City">
                            </div>
                        </div> 



                    </div>
                </div>            
            </div> <!-- / panel preview -->
            <div class="col-sm-5">

                <div class="panel panel-default">
                    <div class="panel-body form-horizontal payment-form">
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">Pincode</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" value="<?php echo $result['student_info']['Pin_code'] ?>" name="Pin_code">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">State</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" value="<?php echo $result['student_info']['State'] ?>" name="State">
                            </div>
                        </div>   
                    </div>
                </div>            
            </div>
        </div><!-- / panel preview -->
        <h4>Parents details</h4>
        <div class="row">
            <div class="col-sm-5">

                <div class="panel panel-default">
                    <div class="panel-body form-horizontal payment-form">
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Father Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="concept" value="<?php echo $result['student_info']['Father_Name'] ?>" name="Father_Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">Father Mobile</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" value="<?php echo $result['student_info']['Father_Mobile'] ?>" name="Father_Mobile">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">Father Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description"  value="<?php echo $result['student_info']['Father_Email'] ?>" name="Father_Email">
                            </div>
                        </div> 



                    </div>
                </div>            
            </div> <!-- / panel preview -->
            <div class="col-sm-5">

                <div class="panel panel-default">
                    <div class="panel-body form-horizontal payment-form">
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Mother Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="concept" value="<?php echo $result['student_info']['Mother_Name'] ?>" name="Mother_Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">Mother Mobile</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" value="<?php echo $result['student_info']['Mother_Mobile'] ?>" name="Mother_Mobile">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">Mother Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" value="<?php echo $result['student_info']['Mother_Email'] ?>" name="Mother_Email">
                            </div>
                        </div> 
                    </div>
                </div>            
            </div> 
        </div>
        <h4>Travel Details</h4>
        <div class="row">
            <div class="col-sm-5">

                <div class="panel panel-default">
                    <div class="panel-body form-horizontal payment-form">
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Bus Stop</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="concept" value="<?php echo $result['student_info']['Bus_Stop'] ?>" name="Bus_Stop">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-sm-3 control-label">Bus root no</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="root_no"  name="root_no">
                                    <option value="0">Select a bus route</option>
                                    <?php foreach ($busroute['bus_route'] as $key => $route) { ?>
                                        <option value="<?php echo $route['id']; ?>" <?php if ($route['id'] == $bus_route_id) echo 'selected'; ?> data-info='<?php echo $busroute['jsondata'][$key] ?>'><?php echo $route['name'] ?> </option> 
                                    <?php }
                                    ?>
                                </select>
                            </div>
                        </div> 
                    </div>
                </div>            
            </div> <!-- / panel preview -->
            <div class="col-sm-5">
                <div class="panel panel-default">
                    <div class="panel-body form-horizontal payment-form">
                        <div class="form-group">
                            <label for="status" class="col-sm-3 control-label">Private Escort</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="status" name="private_escort">
                                    <option value="0">Select Private Escort</option>
                                    <option <?php if ($result['student_info']['private_escort'] == "Yes") echo 'selected'; ?>>Yes</option>
                                    <option <?php if ($result['student_info']['private_escort'] == "No") echo 'selected'; ?>>No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
        <h4>Bus route Details</h4>
        <div class="row">
            <div class="col-sm-5">

                <div class="panel panel-default">
                    <div class="panel-body form-horizontal payment-form">
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Vehicle No</label>
                            <div class="col-sm-9">
                                <input type="text" readonly="readonly" class="form-control route_details" id="vehicle_no" value="" name="vehicle_no">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Seats</label>
                            <div class="col-sm-9">
                                <input type="text" readonly="readonly" class="form-control route_details" id="seats" value="" name="Seats">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Route Number 1</label>
                            <div class="col-sm-9">
                                <input type="text" readonly="readonly" class="form-control route_details" id="route_no1" value="" name="route_no1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Route Number 2</label>
                            <div class="col-sm-9">
                                <input type="text" readonly="readonly" class="form-control route_details" id="route_no2" value="" name="route_no2">
                            </div>
                        </div>
                    </div>
                </div>            
            </div> <!-- / panel preview -->
            <div class="col-sm-5">
                <div class="panel panel-default">
                    <div class="panel-body form-horizontal payment-form">
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Driver Name</label>
                            <div class="col-sm-9">
                                <input type="text" readonly="readonly" class="form-control route_details" id="driver_name" value="" name="driver_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Helper Name</label>
                            <div class="col-sm-9">
                                <input type="text" readonly="readonly" class="form-control route_details" id="helper_name" value="" name="helper_name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label">Area</label>
                            <div class="col-sm-9">
                                <input type="text" readonly="readonly" class="form-control route_details" id="area" value="" name="area">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="concept" class="col-sm-3 control-label ">Remarks</label>
                            <div class="col-sm-9">
                                <input type="text" readonly="readonly" class="form-control route_details" id="remark" value="" name="remark">
                                <input type="hidden"  class="form-control route_details" id="check_updated" value="1" name="check_updated">
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <button id="button24" name="submit"<?php if ($result['student_info']['check_updated'] == "1") echo 'disabled'; ?> type="submit" class="btn btn-primary btn-default">Update</button></div>

        </div>
    </div>            
</div>  
</form>

</div><!-- /container -->
<style> .img_uplaod {
        width: 18%;
        float: left;
        margin: 0 1.1% 0 0;
        text-align: center;}
    .img_div {
        height: 150px;
        overflow: hidden;
        margin: 0 0 20px;
        border: 1px solid #ccc;
        background: #F4F4F4;
        position:relative;
    }
    .img_div img {
        width: 100%;
    }
    #button24{
        margin-bottom: 29px;
    }
    div#form_container h2, div#form_container h3 {
        font-size: 16px;
        margin: 0 0 5px;
    }
    div#form_container h1 {
        font-size: 18px;
        font-weight: 700;
        color: #222;
    }
    div#form_container img {
        width: 59px;
    }
    .img-title {
        position: absolute;
        bottom: 0px;
        left: 0;
        right: 0;
        width: 100%;
        background: rgba(0,0,0,0.5);
        color: #fff;
        padding: 2px;
        /* transform: translateY(-50%); */
    }
    .img-title p {
        margin: 0;
    }
    .hover-text {
    /* display: none; */
    position: absolute;
    top: 0;
    /* bottom: 0; */
    /* height: 100%; */
    left: 0;
    right: 0;
    width: 100%;
    background: rgba(0,0,0,0.5);
    color: #fff;
    font-size: 12px;
    line-height: 1;
    padding: 4px;
}
</style>
<script>

    $(document).ready(function () {
        if ($('select#root_no').find(':selected').val() != 0) {
            var data = $('select#root_no').find(':selected').data('info');
            document.getElementById("vehicle_no").value = data.vehicle_no;
            document.getElementById("seats").value = data.seats;
            document.getElementById("route_no1").value = data.route_number_1;
            document.getElementById("route_no2").value = data.route_number_2;
            document.getElementById("driver_name").value = data.driver_name;
            document.getElementById("helper_name").value = data.helper_name;
            document.getElementById("area").value = data.area;
            document.getElementById("remark").value = data.Remarks;

        }

        $('select#root_no').change(function () {
            //            console.log($(this).find(':selected').data('info'));

            var data = $('select#root_no').find(':selected').data('info');
            document.getElementById("vehicle_no").value = data.vehicle_no;
            document.getElementById("seats").value = data.seats;
            document.getElementById("route_no1").value = data.route_number_1;
            document.getElementById("route_no2").value = data.route_number_2;
            document.getElementById("driver_name").value = data.driver_name;
            document.getElementById("helper_name").value = data.helper_name;
            document.getElementById("area").value = data.area;
            document.getElementById("remark").value = data.Remarks;
        });
    });
</script>