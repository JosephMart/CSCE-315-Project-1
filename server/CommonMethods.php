<?php
include_once('./Logger.php');

class Common
{
    var $conn;
    var $debug;
    var $logger;

    var $db="database.cse.tamu.edu";
    # USER SPECIFIC DATA
    var $dbname="XXXXXX";
    var $user="XXXXXX";
    var $pass="XXXXXX";

    function Common($debug)
    {
        $this->debug = $debug;
        $this->logger=new Logger();
        $rs = $this->connect($this->user); // db name really here
        return $rs;
    }

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */

    function connect($db)// connect to MySQL DB Server
    {
        try
        {
            $this->conn = new PDO('mysql:host='.$this->db.';dbname='.$this->dbname, $this->user, $this->pass);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% */

    function executeQuery($sql, $filename) // execute query
    {
        if($this->debug == true) { echo("$sql <br>\n"); }
        $this->logger->info($sql);
        
        $rs = $this->conn->query($sql) or die("Could not execute query '$sql' in $filename");
        return $rs;
    }
} // ends class, NEEDED!!
?>