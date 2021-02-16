<?php

// Define class namespace
namespace UosApplication;

// Include database class.
require_once(dirname(__FILE__) . "/../../core/AppDatabase.php");



/**
 * Summer School data capture form.
 * 
 * 
 * @author Paul Cranner
 * @copyright 2020 University of Sunderland
 * @license Proprietary
 * @version 1.1.0
 */
class SummerSchool {

    /**
     * The hostname of the database server.
     * 
     * @var string
     */
    private $databaseServerHost = "walts-mysql-01.sunderland.ac.uk";
    
    /**
     * The port of the database server.
     * 
     * @var integer
     */
    private $databaseServerPort = 3306;
    
    /**
     * The database account username (read/write access).
     * 
     * @var string
     */
    private $databaseAccountUserRW = "web_summrscl_rw";
    
    /**
     * The database account password (read/write access).
     * 
     * @var string
     */
    private $databaseAccountPasswordRW = "wtz9DhUOvWDgpz";
    
    /**
     * The database account username (read only access).
     * 
     * @var string
     */
    private $databaseAccountUser = "web_summrscl_ro";
    
    /**
     * The database account password (read only access).
     * 
     * @var string
     */
    private $databaseAccountPassword = "16Rj0FTGiITamu";    
    
    /**
     * The name of the database schema.
     *
     * @var string
     */
    private $databaseSchema = "web_summrscl";
    
    
    /**
     * List of fields in responses table.
     *
     * @var string
     */
    private $fieldList = "response_id, firstname, lastname, dob, mobile, address1, address2, address3, city, postcode, email, currentschoolorcollege, hoodiesize, subject1, course1, subject2, course2, accomm, additional_support, disabilityYes, dietary_req, next_of_kin, next_of_kin_relationship, next_of_kin_phone, emailopt, phoneopt, textopt, postopt, date_created";
    
    
    /**
     * Constructor.
     * 
     * @since 1.0.0
     */
    function __construct() {
        
    }

    
    public function getResponses() {
        /**
         * Returns all responses from the database
         */
        
        try {
            $appDatabase = new \UosCore\AppDatabase($this->databaseAccountUser, $this->databaseAccountPassword, $this->databaseSchema, $this->databaseServerHost, $this->databaseServerPort);

            $sqlStatement = "SELECT {$this->fieldList} FROM responses ORDER BY date_created DESC;";
            
            if ($sqlResult = $appDatabase->queryDatabase($sqlStatement)) return $sqlResult;
        
        } catch (\Exception $ex) {
            throw new \Exception("Unable to retrieve responses. <!--{$ex->getMessage()}--><!--{$sqlStatement}-->");
        }
    }
    
    
    public function getResponsebyID($responseID) {
        /**
         * Returns specified response from database
         */
        
        try {
            $appDatabase = new \UosCore\AppDatabase($this->databaseAccountUser, $this->databaseAccountPassword, $this->databaseSchema, $this->databaseServerHost, $this->databaseServerPort);
            
            $sqlStatement = "SELECT {$this->fieldList} FROM responses WHERE response_id = {$responseID};";
            
            if ($sqlResult = $appDatabase->queryDatabase($sqlStatement)) return $sqlResult[0];
        
        } catch (\Exception $ex) {
            throw new \Exception("Unable to retrieve response. <!--{$ex->getMessage()}-->");
        }
    }
    
    
    public function addResponse($response) {
        /**
         * Inserts a new response into the database
         */
        
        try {
            $appDatabase = new \UosCore\AppDatabase($this->databaseAccountUserRW, $this->databaseAccountPasswordRW, $this->databaseSchema, $this->databaseServerHost, $this->databaseServerPort);

            $prefix = $fieldList = $valueList = "";

            // Convert field list into an array so we can Loop over it
            $fieldArray = explode(', ', $this->fieldList);
            
            // Loop over all fields
            foreach($fieldArray as $field) {
                
                // Ignore date_created and response_id as these have default values in the database
                if ($field != "date_created" & $field != "response_id") {
                    
                    if (array_key_exists($field, $response)) {
                        // A value for this field has been passed in $response so let's use it
                        $valueList .= "{$prefix}'" . $appDatabase->escapeString($response[$field]) . "'";
                    } else {
                        // This field hasn't been passed in $response so set a blank value
                        $valueList .= "{$prefix}''";
                    }
                    // Append the current field to the field list
                    $fieldList .= "{$prefix}`{$field}`";
                    $prefix = ", ";
                }
            }
            
            $sqlStatement = "INSERT INTO responses ({$fieldList}) VALUES ({$valueList});";
            $recordID = $appDatabase->queryDatabase($sqlStatement);
            return $recordID;
        
        } catch (\Exception $ex) {
            throw new \Exception("Unable to save response. Please try again. <!--{$ex->getMessage()}-->");
        }
    }
   
    public function deleteResponse($responseID) {
        /**
         * Deletes specified response from database
         */
        
        try {
            $appDatabase = new \UosCore\AppDatabase($this->databaseAccountUserRW, $this->databaseAccountPasswordRW, $this->databaseSchema, $this->databaseServerHost, $this->databaseServerPort);
            
            $sqlStatement = "DELETE FROM responses WHERE response_id = {$responseID};";
            
            if ($sqlResult = $appDatabase->queryDatabase($sqlStatement)) return $sqlResult;
        
        } catch (\Exception $ex) {
            throw new \Exception("Unable to delete response. <!--{$ex->getMessage()}-->");
        }
    }
    
    public function generateCsvExport() {
        /**
         * Generates CSV file containing all records
         */
        
        try {
            $appDatabase = new \UosCore\AppDatabase($this->databaseAccountUser, $this->databaseAccountPassword, $this->databaseSchema, $this->databaseServerHost, $this->databaseServerPort);
        
            $sqlStatement = "SELECT {$this->fieldList} FROM responses ORDER BY date_created DESC;";
            
            if ($sqlResult = $appDatabase->queryDatabase($sqlStatement)) {
                // Results were returned
                
                // Output headers so that the file is downloaded rather than displayed
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename=data.csv');
                
                // Create a file pointer connected to the output stream
                $output = fopen('php://output', 'w');

                // Output the column headings
                fputcsv($output, explode(", ", $this->fieldList));
                
                // Fetch the data
                $sqlResult = $appDatabase->queryDatabase($sqlStatement);
                
                // Output each row
                foreach ($sqlResult as $row) fputcsv($output, $row);
            }
        } catch (\Exception $ex) {
            throw new \Exception("Unable to generate CSV file. <!--{$ex->getMessage()}-->");
        }
    }

}
?>