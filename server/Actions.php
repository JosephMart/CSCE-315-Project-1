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
// Name: Increment
// PreCondition: entering is either 'true' or 'false' or
//  empty
// PostCondition: Increment someone entering or leaving
//---------------------------------------------------------
function Increment($entering)
{
    global $COMMON;

    $sql = <<< SQL
    INSERT INTO `PeopleCounts` (`id`, `time`, `entering`) VALUES (NULL, CURRENT_TIMESTAMP, '{$entering}')
SQL;
    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
}

function ResetDb() {
    // Delete users
    $sql = "DELETE FROM `PeopleCounts`";
    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);

    // Reset AutoIncrement
    $alter = 'ALTER TABLE `PeopleCounts` AUTO_INCREMENT = 1';
    $rs = $COMMON->executeQuery($alter, $_SERVER["SCRIPT_NAME"]);
}


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
        SUM(goingIn) as totalIn, 
        AVG(goingIn) as averageIn, 
        MIN(goingIn) as minIn, 
        MAX(goingIn) as maxIn,
        SUM(goingOut) as totalOut, 
        AVG(goingOut) as averageOut, 
        MIN(goingOut) as minOut, 
        MAX(goingOut) as maxOut
    FROM ({$subQuery}) as sub;
SQL;
    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
    return $rs->fetchAll()[0];
}

//-------------------------------------------------------
// Name: GetHourData
// PostCondition: Return data and analysis on an hour basis
//---------------------------------------------------------
function GetHourData($date)
{
    global $COMMON;

    $sql = <<< SQL
            SELECT 
                COUNT(DISTINCT id) AS count, 
                SUM(
                    CASE WHEN entering = 'true' THEN 1 ELSE 0 END
                ) AS goingIn, 
                SUM(
                    CASE WHEN entering = 'false' THEN 1 ELSE 0 END
                ) AS goingOut, 
                DATE_FORMAT(time, '%Y-%m-%d %H:00') AS date
            FROM 
                PeopleCounts 
            WHERE DATE(time) = {$date}
            GROUP BY 
                date
SQL;

    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
    return array($rs->fetchAll(), AnalyzeQuery($sql));
}

//-------------------------------------------------------
// Name: GetDayData
// PostCondition: Return data and analysis on a day basis
//---------------------------------------------------------
function GetDayData($start, $end)
{
    global $COMMON;
    $whereStatement = '';

    if(isset($start) && isset($end)) {
        $whereStatement = <<< SQL
            WHERE time >= '{$start}' AND time <= '{$end}'
SQL;
    }

    $sql = <<< SQL
        SELECT
        COUNT(DISTINCT id) AS count,
        SUM(
            CASE WHEN entering = 'true'
                THEN 1
            ELSE 0 END
        )                  AS goingIn,
        SUM(
            CASE WHEN entering = 'false'
                THEN 1
            ELSE 0 END
        )                  AS goingOut,
        DATE_FORMAT(time, '%Y-%m-%d') AS date
    FROM `PeopleCounts`
    {$whereStatement}
    GROUP BY date
    ORDER BY date ASC
SQL;

    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
    return array($rs->fetchAll(), AnalyzeQuery($sql));
}

//-------------------------------------------------------
// Name: GetWeekData
// PostCondition: Return data and analysis on a week basis
//---------------------------------------------------------
function GetWeekData($start, $end)
{
    global $COMMON;
    $whereStatement = '';

    if(isset($start) && isset($end)) {
        $whereStatement = <<< SQL
            WHERE time >= '{$start}' AND time <= '{$end}'
SQL;
    }

    $sql = <<< SQL
        SELECT
        COUNT(DISTINCT id) AS count,
        SUM(
            CASE WHEN entering = 'true'
                THEN 1
            ELSE 0 END
        )                  AS goingIn,
        SUM(
            CASE WHEN entering = 'false'
                THEN 1
            ELSE 0 END
        )                  AS goingOut,
        DATE_FORMAT(time, '%Y-%U') AS date
    FROM `PeopleCounts`
    {$whereStatement}
    GROUP BY date
    ORDER BY date ASC
SQL;

    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
    return array($rs->fetchAll(), AnalyzeQuery($sql));
}

//-------------------------------------------------------
// Name: GetMonthData
// PostCondition: Return data and analysis on a month basis
//---------------------------------------------------------
function GetMonthData($start, $end)
{
    global $COMMON;
    $whereStatement = '';

    if(isset($start) && isset($end)) {
        $whereStatement = <<< SQL
            WHERE time >= '{$start}' AND time <= '{$end}'
SQL;
    }

    $sql = <<< SQL
        SELECT
        COUNT(DISTINCT id) AS count,
        SUM(
            CASE WHEN entering = 'true'
                THEN 1
            ELSE 0 END
        )                  AS goingIn,
        SUM(
            CASE WHEN entering = 'false'
                THEN 1
            ELSE 0 END
        )                  AS goingOut,
        DATE_FORMAT(time, '%Y-%m') AS date
    FROM `PeopleCounts`
    {$whereStatement}
    GROUP BY date
    ORDER BY date ASC
SQL;

    $rs = $COMMON->executeQuery($sql, $_SERVER["SCRIPT_NAME"]);
    return array($rs->fetchAll(), AnalyzeQuery($sql));
}

?>