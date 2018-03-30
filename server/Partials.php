<?php
/*****************************************
** File:    Partials.cpp
** Project: CSCE 315 Project 1
** Date:    03/30/2018
**
**   This file contains the partial templates that are used by
** multible different files. Purpose is to consolidate repeated
** code into one place.
**
**
***********************************************/

//-------------------------------------------------------
// Name: HtmlHeader
// PreCondition:  Called in the <head> of a page
// PostCondition: Prints template for linking JS, CSS, and
//                meta data about a general page
//---------------------------------------------------------
function HtmlHeader($pageName)
{
    // Dynamical set page title
    $pageTitle = 'CSCE 315 Project 1';
    if (!is_null($pageName)) {
        $pageTitle = $pageTitle.'|'.$pageName;
    }
    
    print <<< HTML
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{$pageTitle}</title>

        <!-- Bootstrap CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <!-- Project CSS -->
        <link rel="stylesheet" type="text/css" href="./main.css">

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

        <!-- Bootstrap JS -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <!-- Google Charts -->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <!-- Moment JS -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>

        <!-- Project JS -->
        <script type="text/javascript" src="./js/charts.js"></script>
HTML;
}

//-------------------------------------------------------
// Name: HtmlNavbar
// PostCondition: Prints template for site navbar
//---------------------------------------------------------
function HtmlNavbar($activePage)
{
    $tableActive = '';
    $chartsActive = '';
    $adminActive = '';

    // Determine which page should have the active CSS given the param
    switch ($activePage) {
        case 'table':
            $tableActive = 'active';
            break;
        case 'charts':
            $chartsActive = 'active';
            break;
        case 'admin':
            $adminActive = 'active';
            break;
        default:
            break;
    }
    print <<< HTML
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">315 Project 1</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item {$tableActive}">
                    <a class="nav-link" href="index.php">Table</a>
                </li>
                <li class="nav-item dropdown  {$chartsActive}">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Charts
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="MonthChart.php">Month</a>
                        <a class="dropdown-item" href="WeekChart.php">Week</a>
                        <a class="dropdown-item" href="DayChart.php">Day</a>
                        <a class="dropdown-item" href="HourChart.php">Hour</a>
                    </div>
                </li>
                <li class="nav-item  {$adminActive}">
                    <a class="nav-link" href="Admin.php">Admin</a>
                </li>
            </ul>
        </div>
    </nav>
HTML;
}

//-------------------------------------------------------
// Name: AnalysisTable
// PostCondition: Prints template table for analysis
//---------------------------------------------------------
function AnalysisTable($counts) {
    print <<< HTML
        <h3>Entering</h3>

        <table class="table">
            <thead>
                <tr>
                    <th>Mean</th>
                    <th>Median</th>
                    <th>Mode</th>
                    <th>Max</th>
                    <th>Min</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$counts["averageIn"]}</td>
                    <td>-1</td>
                    <td>-1</td>
                    <td>{$counts["maxIn"]}</td>
                    <td>{$counts["minIn"]}</td>
                    <td>{$counts["totalIn"]}</td>
                </tr>
            </tbody>
        </table>

        <h3>Leaving</h3>

        <table class="table">
            <thead>
                <tr>
                    <th>Mean</th>
                    <th>Median</th>
                    <th>Mode</th>
                    <th>Max</th>
                    <th>Min</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$counts["averageOut"]}</td>
                    <td>-1</td>
                    <td>-1</td>
                    <td>{$counts["maxOut"]}</td>
                    <td>{$counts["minOut"]}</td>
                    <td>{$counts["totalOut"]}</td>
                </tr>
            </tbody>
        </table>
HTML;
}
?>