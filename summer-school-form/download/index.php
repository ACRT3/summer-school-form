<?php try {
    require_once(dirname(__FILE__) . "../../../../../../shared_library/classes/applications/Summer_School/SummerSchool.php");
    $summer = new \UoSApplication\SummerSchool();
    $summer->generateCsvExport();
    
} catch(\Exception $ex){
    echo $ex->getMessage();
} ?>