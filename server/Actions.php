<?php
/*****************************************
** File:    Actions.php
** Project: CSCE 315 Project 1
** Date:    03/30/2018
**
**   Common actions and queries for the app
**
**
***********************************************/

include_once('CommonMethods.php');

# Setup CommonMethods for query execution
$debug = false;
$COMMON = new Common($debug);

//-------------------------------------------------------
// Name: GetAllCounts
// PostCondition: Return count number of items array with
//   array having keys `entering` and `leaving
//---------------------------------------------------------
function GetAllCounts()
{
    global $COMMON;

    $sql = <<< SQL
    SELECT
        SUM(CASE WHEN entering = 'true' THEN 1 ELSE 0 END) AS entering,
        SUM(CASE WHEN entering = 'false' THEN 1 ELSE 0 END) AS leaving
    FROM `PeopleCounts`
SQL;
    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
    return $rs->fetchAll()[0];
}

//-------------------------------------------------------
// Name: AnalyzeQuery
// PostCondition: Return analysis data of provided query
//---------------------------------------------------------
function AnalyzeQuery($subQuery)
{
    global $COMMON;

    // Analysis queries
    $sql = <<< SQL
    SELECT 
        SUM(going_in) as totalIn, 
        AVG(going_in) as averageIn, 
        MIN(going_in) as minIn, 
        MAX(going_in) as maxIn,
        SUM(going_out) as totalOut, 
        AVG(going_out) as averageOut, 
        MIN(going_out) as minOut, 
        MAX(going_out) as maxOut
    FROM ({$subQuery}) as sub;
SQL;
    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
    return $rs->fetchAll()[0];
}

?>