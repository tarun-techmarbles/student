<?php
require_once 'function.php';
require_once 'config.php';
$conn = OpenCon();
if (isset($_GET["adminssion_no"])) {
    $a_no = $_GET['adminssion_no'];
    $m_no = $_GET['mobile_no'];
} else {
    $a_no = '2013DPSE00829';
    $m_no = '2147483647';
}
$result = getStudent($conn, $a_no, $m_no);
$bus_route_id = '';
if (!empty($result['student_info']['route_no'])) {
    $bus_route_id = checkRoute($result);

}

foreach ($result['bus_route'] as $bus_info) {

    $jsondata[] = json_encode($bus_info);
    if (!empty($bus_info['route_number_2'])) {
        $bus_route[] = $bus_info['route_number_1'] . " / " . $bus_info['route_number_2'];
    } else {
        $bus_route[] = $bus_info['route_number_1'];
    }
}
$busroute = array("bus_route" => $bus_route, "jsondata" => $jsondata);

function checkRoute($bus_info) {
    $route_id = $bus_info['student_info']['route_no'];
     
    foreach ($bus_info['bus_route'] as $route) {
        if ($route_id == $route['s_no']) {
         
            if (!empty($route['route_number_2'])) {
                $bus_route = $route['route_number_1'] . " / " . $route['route_number_2'];
            } else {
                $bus_route = $route['route_number_1'];
            }
            return $bus_route;
        }
    }
}

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
            <h3>Escort Card</h3>
            <form class="form-signin"  action="function.php?adminssion_no=<?php echo $_GET['adminssion_no'];?>&mobile_no=<?php echo $_GET['mobile_no'];?>" id="formentry"  method="POST"  enctype="multipart/form-data" >
                <div class="img_uplaod">
                    <div class="img_div"> <img id="profile-img" class="profile-img-card" src='<?php echo $stud_src; ?>'/>
                    </div>
                    <input type="file" name="student_img" />
                    <p id="profile-name" class="profile-name-card"></p> </div>
                 <!--<img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" />--> 
                <div class="img_uplaod">
                    <div class="img_div"> <img id="profile-img" class="profile-img-card" src='<?php echo $father_src; ?>' />
                    </div><input type="file" name="Father_img" />
                    <p id="profile-name" class="profile-name-card"></p> </div>

                <div class="img_uplaod">
                    <div class="img_div"> <img id="profile-img" class="profile-img-card" src='<?php echo $mother_src; ?>' />
                    </div><input type="file" name="Mother_img"/>
                    <p id="profile-name" class="profile-name-card"></p> </div>
                <div class="img_uplaod">
                    <div class="img_div"> <img id="profile-img" class="profile-img-card" src='<?php echo $gurardian_1_img; ?>' />
                    </div> <input type="file" name="gurardian_1_img"/>
                    <p id="profile-name" class="profile-name-card"></p> </div>
                <div class="img_uplaod">
                    <div class="img_div"> <img id="profile-img" class="profile-img-card" src='<?php echo $gurardian_2_img; ?>' />
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
                                <input type="text" value=" <?php echo $result['student_info']['Admission_No'] ?>" class="form-control" id="concept" name="Admission_No">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">Student Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" value=" <?php echo $result['student_info']['Student_Name'] ?>" name="Student_Name">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="date" class="col-sm-3 control-label">Date of Birth</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" value=" <?php echo $result['student_info']['Date_of_Birth'] ?>" id="date" name="Date_of_Birth">
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
                                <input type="text" class="form-control" id="concept" <?php echo $result['student_info']['Blood_Group'] ?>" name="Blood_Group">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">E-mail</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" value=" <?php echo $result['student_info']['E_Mail'] ?>" name="E_Mail">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">Class & Sec</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" value=" <?php echo $result['student_info']['Class_Sec'] ?>" name="Class_Sec">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">Phone</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value=" <?php echo $result['student_info']['Phone'] ?>" id="description" name="Phone">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">Emergency No</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" value=" <?php echo $result['student_info']['Emergency_No'] ?>" name="Emergency_No">
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
                                <input type="text" class="form-control" id="concept" value=" <?php echo $result['student_info']['Address'] ?>" name="Address">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">City</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" value=" <?php echo $result['student_info']['City'] ?>" name="City">
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
                                <input type="text" class="form-control" id="description" value=" <?php echo $result['student_info']['Pin_code'] ?>" name="Pin_code">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">State</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" value=" <?php echo $result['student_info']['State'] ?>" name="State">
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
                                <input type="text" class="form-control" id="concept" value=" <?php echo $result['student_info']['Father_Name'] ?>" name="Father_Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">Father Mobile</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" value=" <?php echo $result['student_info']['Father_Mobile'] ?>" name="Father_Mobile">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">Father Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description"  value=" <?php echo $result['student_info']['Father_Email'] ?>" name="Father_Email">
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
                                <input type="text" class="form-control" id="concept" value=" <?php echo $result['student_info']['Mother_Name'] ?>" name="Mother_Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">Mother Mobile</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" value=" <?php echo $result['student_info']['Mother_Mobile'] ?>" name="Mother_Mobile">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="description" class="col-sm-3 control-label">Mother Email</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="description" value=" <?php echo $result['student_info']['Mother_Email'] ?>" name="Mother_Email">
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
                                <input type="text" class="form-control" id="concept" value=" <?php echo $result['student_info']['Bus_Stop'] ?>" name="Bus_Stop">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-sm-3 control-label">Bus root no</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="root_no"  name="root_no">
                                    <?php foreach ($busroute['bus_route'] as $key => $route) { ?>
                                        <option <?php if ($route == $bus_route_id) echo 'selected'; ?> data-info='<?php echo $busroute['jsondata'][$key] ?>'><?php echo $route ?> </option> 
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
                                <input type="hidden"  class="form-control route_details" id="id" value="" name="s_no">
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <button id="button24" name="submit" type="submit" class="btn btn-primary btn-default">Update</button></div>
        </div>
    </div>            
</div>  
</form>

</div><!-- /container -->


<style>
    .img_uplaod {
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
    }
    .img_div img {
        width: 100%;
    }
</style>

<script>

    $(document).ready(function () {
        var data = $('select#root_no').find(':selected').data('info');
        document.getElementById("vehicle_no").value = data.vehicle_no;
        document.getElementById("seats").value = data.seats;
        document.getElementById("route_no1").value = data.route_number_1;
        document.getElementById("route_no2").value = data.route_number_2;
        document.getElementById("driver_name").value = data.driver_name;
        document.getElementById("helper_name").value = data.helper_name;
        document.getElementById("area").value = data.area;
        document.getElementById("remark").value = data.Remarks;
        document.getElementById("id").value = data.s_no;
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
            document.getElementById("id").value = data.s_no;
        });
    });
</script>