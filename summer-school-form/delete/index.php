<?php


// Input parameter sanitisation.
$responseID = ((isset($_POST['id'])) ? filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT) : filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT));

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    // Get the form data and sanitise it
    $responseID = ((isset($_POST['id'])) ? filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT) : NULL);
    $canDelete = ((isset($_POST['canDelete'])) ? 'y' : 'n');
    
    // Check that the required fields have been completed
    $formErrorMsgs = array();
    if ($canDelete != 'y') { $formErrorMsgs[] = "Please confirm that the response can be deleted"; }
    
    // Check if there are any errors with the form
    if (count($formErrorMsgs) == 0) {
        try {
            // Include class files
            require_once(dirname(__FILE__) . "../../../../../../shared_library/classes/applications/Summer_School/SummerSchool.php");
            $summer = new \UoSApplication\SummerSchool();
            
            // Delete the data from the database
            $summer->deleteResponse($responseID);
            
            // Display confirmation message
            header("Location: ../index.php");
        
        } catch (Exception $ex) {
            // Display an error messge
            $formErrorMsgs[] = "{$ex->getMessage()}";
        }
    }
    
    // There has been an error so display the form with a list of errors.

} else {
    // The form has not been submitted
    // Nothing to do here!  :-)
}

// Display the form
?>
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
            <li><a href="../">Summer School 202</a></li>
            <li class="current">Delete Response</li>
        </ul>
            
        <hr />
            
        <div class="row">
            <div class="large-12 columns">

                <!-- START: Introduction -->
                <div class="row">
                    <div class="large-12 columns">
                        <h3>Delete Response</h3>
                        <div class="alert-box warning radius">
                            <p><strong>Important notice:</strong> By agreeing to delete the response it will be permanently removed from the database and the process is irreversible.</p>
                        </div>
                    </div>
                </div>
                <!-- END: Introduction -->

<?php
    // Check if there are any error messages to display
    if (isset($formErrorMsgs) && count($formErrorMsgs) > 0) {
        print("                    <div class=\"alert-box alert radius\">\n");
        foreach ($formErrorMsgs as $formErrorMsg)
            print("                        <p>{$formErrorMsg}</p>\n");
        print("                    </div>\n");
    }
?>

                <!-- START: Form -->
                <form name="recordDelete" action="index.php" method="post" enctype="multipart/form-data" data-abide>

                    <!-- START: Delete control -->
                    <fieldset>
                        <legend>Delete Record</legend>
                        <div class="row">
                            <div class="large-12 columns">
                                <label for="canDelete">Are you sure that you wish to delete the response?</label>
                                <input name="canDelete" id="canDelete" type="checkbox" value="y" required <?php ((isset($canDelete) && $canDelete == 'y') ? print("checked") : print("")); ?> /> Yes
                                <small class="error">Please confirm that you wish to delete the response</small>
                            </div>
                        </div>
                    </fieldset>
                    <!-- END: Delete control -->
                        
                    <!-- START: Form controls -->
                    <div class="row">
                        <div class="large-12 columns">
                            <button name="submit" type="submit" value="" placeholder="" class="small button radius alert"><i class="fi-trash"></i> Delete Record</button>
                            <input name="id" type="hidden" value="<?php print($responseID); ?>" />
                        </div>
                    </div>
                    <!-- END: Form controls -->
                </form>
                <!-- END: Form -->
                
            </div>
        </div>

        <hr />

        <dl class="sub-nav">
            <dt>The Web Team</dt>
            <dd class="active"><a href="/help/index.html">Need help?</a></dd>
            <dd><a href="/version.html">version 1.0</a></dd>
        </dl>
    </div>
</div>

<script src="/js/js2/vendor/jquery.js" type="text/javascript"></script>
<script src="/js/foundation.min.js" type="text/javascript"></script>
<script src="/js/foundation/foundation.equalizer.js" type="text/javascript"></script>
<script src="/js/foundation/foundation.reveal.js" type="text/javascript"></script>
<script src="/js/foundation/foundation.abide.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).foundation();
</script>
<script src="/js/rem.js" type="text/javascript"></script>
    
</body>
</html>
