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
function HtmlHeader($pageName) {

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
?>