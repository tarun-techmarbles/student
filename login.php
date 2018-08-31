<?php
require_once 'config.php';
require_once 'function.php';
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
$conn = OpenCon();
$count = countTotal($conn);
$total = $count['total'];
if (!empty($_SESSION["invalid"])) {
    echo "<script type='text/javascript'>alert('Invalid Adminssion No And Date of Birth.');</script>";
    unset($_SESSION["invalid"]);
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Untitled Form</title>
        <link rel="stylesheet" type="text/css" href="custom.css" media="all">
        <script type="text/javascript" src="view.js"></script>

    </head>
    <body id="main_body" >

        <div id="form_container">

            <form id="form_741" class="appnitro"  method="get" action="index.php">
                <div class="form_description">

                    <h2 align="center"> <img src='assets/img/logo.png' alt="" style="max-height:100px" /> DELHI PUBLIC SCHOOL,GBN</h2>
                    <h3 align="center"> Under the aegis of The Delhi Public School Society, New Delhi<br>

                        B-1, Sector-132, Expressway, Noida-201301 </h3>
                    <p></p>
                </div>	
                <div align="center">					
                    <ul>
                        <li id="li_1" >
                            <label class="description" for="element_1">Admission No </label>
                            <div>
                                <input id="element_1" name="adminssion_no" class="element text medium" type="text" maxlength="255" placeholder="yyyyDPSExxxxx" value=""/> </br><span style="font-size:11px; color:#00F; text-align:center">
                                    Admission Number format: 4 digit of Admission year then DPSE followed by 5 digit Admission number </br>yearDPSExxxxx eg 2014DPSE02358</span>
                            </div> 
                        </li>		<li id="li_2" >
                            <label class="description" for="element_2">Date Of Birth </label>
                            <div>
                                <input id="element_2" value="<?php echo date('dd-M-Y'); ?>" name="mobile_no" class="element text medium" type="date" maxlength="255" max="<?php echo date("Y-m-d");?>" min="1985-03-19"/> 
                            </div> 
                        </li>

                        <li class="buttons">
                            <input id="saveForm" class="button_text" type="submit" value="Login" />
                        </li>
                        <li> <p><strong>PLEASE NOTE: </strong> 1) This form will be updated only ones, and after that no data change is allowed.<br>
                                2) Update Class-Sec as per <strong>session 2018-19</strong>.</p></li>
                        <li style="text-align: right;"><h6>Total form updated : <?php echo $total ?> </h6></li> 
                    </ul>
                </div>
            </form>	



            <div id="footer">

            </div>
        </div>
        <img id="bottom" src="bottom.png" alt="">
    </body>
</html>
