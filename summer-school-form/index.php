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
        
        .dynatable-pagination-links span{
            /*display: none;*/
        }
        
        .dynatable-pagination-links{
            margin-left: 0px !important;
        }
        
        .dynatable-pagination-links li{
            /*float: left:;*/
            display: inline-block;
            padding: 10px;
            /*background-color: grey;*/
        }
        
        .dynatable-pagination-links li a{
            background-color: #008cba;
            /*border:1px solid #017094;*/
            padding: 10px;
            color: white;
            margin: -8px;
        }
        
        .dynatable-pagination-links li a:hover{
            color: #b8b8b8;
        }
        
        .dynatable-record-count{
            /*display: block;*/
            margin-left: 10px;
        }
        
        .dynatable-search{
            font-size: 15px;
            top: 6px;
            color: #008cba;
        }
        
        #dynatable-query-search-record-list{
            width: 50%;
            margin-top: 10px;
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
            <li><a href="../">Form Data</a></li>
            <li class="current">Summer School 2020</li>
        </ul>
 
        <hr />
        
        <!-- START: Page content -->
        <div class="row">
            <div class="large-12 columns">
                <h3>Responses</h3>
                <p><a href="download/index.php" class="small button radius primary" style="float: right;">Export Records</a></p>
                    
                <!-- START: Listing table -->
                <table id="record-list" role="grid">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Date Created</th>
                            <th>Postcode</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th data-dynatable-no-sort="true">View</th>
                            <th data-dynatable-no-sort="true">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
                        
// Include class file
require_once(dirname(__FILE__) . "../../../../../shared_library/classes/applications/Summer_School/SummerSchool.php");                        

try {
    // Initialise the class
    $summer = new \UoSApplication\SummerSchool();
    
    // Retreive all responses
    $responses = $summer->getResponses();
    
    if (count($responses) > 0 ) {
        // Loop over the responses 
        foreach ($responses as $response) {
            print("                        <tr>
                            <td>{$response['firstname']} {$response['lastname']}</td>
                            <td>{$response['date_created']}</td>
                            <td>{$response['postcode']}</td>
                            <td>{$response['mobile']}</td>
                            <td>{$response['email']}</td>
                            <td><a href=\"view/index.php?id={$response['response_id']}\" class=\"small button radius success\"><i class=\"fi-magnifying-glass\"></i></a></td>
                            <td><a href=\"delete/index.php?id={$response['response_id']}\" class=\"small button radius alert\"><i class=\"fi-trash\"></i></a></td>
                        </tr>\n");            
        }
        
    } else {
        // No records have been returned
        print("                        <tr>
                            <td colspan=\"7\">No responses currently exist</td>
                        </tr>\n");
    }
    
} catch (\Exception $ex) {
    $error = $ex->getMessage();
    var_dump($ex);
}
?>
                    </tbody>
                </table>
                <!-- END: Listing table -->
            </div>
        </div>
        <!-- END: Page content -->
        
        <?php if (isset($error)) print("<div class=\"alert-box alert\"><p>{$error}</p></div>\n"); ?>

        <hr />

        <dl class="sub-nav">
            <dt>The Web Team</dt>
            <dd class="active"><a href="/help/index.html">Need help?</a></dd>
            <dd><a href="/version.html">version 1.0</a></dd>
        </dl>
    </div>
</div>
    
<script type="text/javascript">
    $(document).ready(function() {
        $('#record-list').dynatable({
            features: {
                    paginate: true,         // Pagination ?
                    recordCount: true,      // Showing ... ?
                    sort: true,             // Sortable headings?
                    search: true,           // Search box?
                    perPageSelect: false,   // Records per page select list ?
                    pushState: false,       // Pagination in URL?
            },

            inputs: {
                    recordCountText: "Displaying ", // Text before record count; replaces "Showing ..."
            },

            dataset: {
                    perPageDefault: 10,
            },

            params: {
                    records: "responses", // Text after "Showing ..."; replaces "records"
            },
        });
    });
</script>

<script src="/js/rem.js" type="text/javascript"></script>

</body>
</html>
