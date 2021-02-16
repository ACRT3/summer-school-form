<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en" >
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>UoS website admin - Summer School 2020</title>
    <link rel="icon" type="image/ico" href="/images/favicon.ico"/>
    <link rel="stylesheet" href="/css/css2/foundation.css">
    <link href="/css/css2/foundation-icons.css" rel="stylesheet" type="text/css">
    <script src="/js/js2/vendor/custom.modernizr.js"></script>
    <!--[if lt IE 9]>
      <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
      <script src="//s3.amazonaws.com/nwapi/nwmatcher/nwmatcher-1.2.5-min.js"></script>
      <script src="//html5base.googlecode.com/svn-history/r38/trunk/js/selectivizr-1.0.3b.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
    <![endif]-->
    
    <script type="text/javascript" src="/js/dynatable/vendor/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/js/dynatable/jquery.dynatable.js"></script>

    <style>
        #adminIcon {margin-top:-5px;}
        .homeLogo {width:215px; height:100px; float:left;}
        .homeTitle {float:right; margin-top:39px;}
        .homeSubTitle {float:left; width:100%;}

        @media only screen and (max-width: 500px) {
            .homeLogo {width:100%; height:auto;}
            .homeTitle {float:left !important; margin-top:39px;}
        }
    </style>
</head>
<body>
<div class="row">
    <div class="large-12 columns">
        <img src="/images/uni-logo.png" class="homeLogo"><img src="/images/wwwadmin-logo.png" class="wwwadminlogo" style="float:right; height:100px; "><!-- <h2 class="homeTitle">UoS website admin</h2> -->
        <h3 class="homeSubTitle">Summer School 2020</h3>
        <hr />
    </div>
</div>
<div class="row">
    <div class="large-12 columns">
        <ul class="breadcrumbs">
            <li><a href="/index.php">Home</a></li>
            <li><a href="../../">Form Data</a></li>
            <li><a href="../">Summer School 2020</a></li>
            <li class="current">View Response</li>
        </ul>
 
        <hr />
        
        <!-- START: Page content -->
        <div class="row">
            <div class="large-12 columns">
                <h3>View Response</h3>
<?php
// Grab the response ID 
$responseID = ((isset($_POST['id'])) ? filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT) : filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT));
              
// Include class file
require_once(dirname(__FILE__) . "../../../../../../shared_library/classes/applications/Summer_School/SummerSchool.php");                        

try {
    // Initialise the class
    $summer = new \UoSApplication\SummerSchool();
    
    // Retreive all responses
    $response = $summer->getResponsebyID($responseID);
    
    if (count($response) > 0 ) { ?>
                <h4>Step 1: Your Details</h4>
                <table id="step1" width="100%">
                    <tr>
                        <th>First Name:</th><td><?php print($response['firstname']); ?></td>
                        <th>Address 1:</th><td><?php print($response['address1']); ?></td>
                    </tr>
                    <tr>
                        <th>Last Name:</th><td><?php print($response['lastname']); ?></td>
                        <th>Address 2:</th><td><?php print($response['address2']); ?></td>
                    </tr>
                    <tr>
                        <th>Date of Birth:</th><td><?php print($response['dob']); ?></td>
                        <th>Address 3:</th><td><?php print($response['address3']); ?></td>
                    </tr>
                    <tr>
                        <th>Mobile:</th><td><?php print($response['mobile']); ?></td>
                        <th>City:</th><td><?php print($response['city']); ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th><td><?php print($response['email']); ?></td>
                        <th>Post Code:</th><td><?php print($response['postcode']); ?></td>
                    </tr>
                    <tr>
                        <th>Current School or College:</th><td><?php print($response['currentschoolorcollege']); ?></td>
                        <th>Hoodie Size:</th><td><?php print($response['hoodiesize']); ?></td>
                    </tr>
                    
                </table>
                    
                <h4>Step 2: Course</h4>
                <table id="step2" width="100%">
                    <tr><th colspan="2">Subject Area 1:</th></tr>
                    <tr><td colspan="2"><?php print($response['subject1']); ?></td></tr>
                    <tr><th colspan="2">Course 1:</th></tr>
                    <tr><td colspan="2"><?php print($response['course1']); ?></td></tr>
                    <tr><th colspan="2">Subject Area 2:</th></tr>
                    <tr><td colspan="2"><?php print($response['subject2']); ?></td></tr>
                    <tr><th width="50%">Course 2:</th></tr>
                    <tr><td width="50%"><?php print($response['course2']); ?></td></tr>
                </table>
        
                <h4>Step 3: Accommodation</h4>
                <table id="step3" width="100%">
                    <tr><th colspan="2">Stay at Panns Bank or Travel to campus:</th></tr>
                    <tr><td colspan="2"><?php print($response['accomm']); ?></td></tr>
                </table>
        
                <h4>Step 4: Support</h4>
                <table id="step4" width="100%">
                    <tr><th colspan="2">Do you require any additional Support:</th></tr>
                    <tr><td colspan="2"><?php print($response['additional_support']); ?></td></tr>
                    <tr><th colspan="2">If yes, please provide details:</th></tr>
                    <tr><td colspan="2"><?php print($response['disabilityYes']); ?></td></tr>
                    <tr><th colspan="2">Please let us know if you have any dietary requirements:</th></tr>
                    <tr><td colspan="2"><?php print($response['dietary_req']); ?></td></tr>
                </table>
        
                <h4>Step 5: Emergency Contact</h4>
                <table id="step5a" width="100%">
                    <tr><th colspan="2">Who is your next of kin:</th></tr>
                    <tr><td colspan="2"><?php print($response['next_of_kin']); ?></td></tr>
                    <tr><th colspan="2">What is their relation to you:</th></tr>
                    <tr><td colspan="2"><?php print($response['next_of_kin_relationship']); ?></td></tr>
                    <tr><th colspan="2">Next of kin contact details:</th></tr>
                    <tr><td colspan="2"><?php print($response['next_of_kin_phone']); ?></td></tr>
                </table>
                
                <table id="step5b" width="100%">
                    <tr><th colspan="4">Keep me up to date relating to my interest in the University of Sunderland via:</th></tr>
                    <tr>
                        <th width="25%">E-mail</th>
                        <th width="25%">Phone</th>
                        <th width="25%">SMS</th>
                        <th width="25%">Post</th>
                    </tr>
                    <tr>
                        <td><?php print($response['emailopt']); ?></td>
                        <td><?php print($response['phoneopt']); ?></td>
                        <td><?php print($response['textopt']); ?></td>
                        <td><?php print($response['postopt']); ?></td>    
                    </tr>
                </table>
        
    <?php } else {
        // No records have been returned
        print("<div class=\"alert-box alert\"><p>No record found for the specified ID.</p></div>\n");
    }
    
} catch (\Exception $ex) {
    print("<div class=\"alert-box alert\"><p>{$ex->getMessage()}</p></div>\n");
}
?>                
            </div>
        </div>
        <!-- END: Page content -->
        
        <hr />

        <dl class="sub-nav">
            <dt>The Web Team</dt>
            <dd class="active"><a href="/help/index.html">Need help?</a></dd>
            <dd><a href="/version.html">version 1.0</a></dd>
        </dl>
    </div>
</div>

</body>
</html>