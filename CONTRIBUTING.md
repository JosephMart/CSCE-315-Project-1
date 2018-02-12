# CSCE 315 - General C++ Coding Standards (and PHP)

Every programming department has some set of standards or conventions that programmers are expected to follow. The purpose of these standards is make programs readable and maintainable. After all, you may be the programmer who maintains your own code more than six months after having written the original. While no two programming departments' standards/conventions may be the same, it is important that all members of the department follow the same standards. Neatness counts!!! The following standards are to be followed in CSCE 315.

DO NOT use tabs (unless your text editor changes tabs to 3 or 4 spaces). Tabs may be interpreted differently by different editors.

Use 3 or 4 spaces (not 2, 6 or 8) for each level of indentation. and be consistent. Too much indenting makes the code unreadable and hastens line wrapping.

Approximately every 5 lines of code need AT LEAST 1 comment.
Not every line of code needs a comment.
Constant declarations MUST have 1 comment.

## File Naming

For every project, a file containing only the main( ) function is required. This file should be named after the project and have a .cpp file extension. For example, the main( ) function for project 3 would be in a file named Proj3.cpp. 

Auxiliary files (e.g Proj3Aux.cpp) and/or header files (e.g. Proj3Aux.h) are permitted, but must be named appropriately

## Class Definition Standards

* All class names begin with uppercase. Multi-word class names follow the variable/function naming convention below.
* Only one private, protected and public section in a class definition. public comes first, followed by protected and then private.
* Every data member of a class must be private.
* You may use global symbolic constants (const), but not global variables.
* Class methods follow function naming conventions below.
* Class methods must have complete function header comments in the header file. Fewer comments are required in the .cpp file.
* Class methods must be const whenever possible.
* Except for explicit class input/output methods, class methods should not perform input or output.
* Class data members begin with m_ and follow the variable naming conventions below.

## Variable, Constant and Function Declarations

* Use meaningful descriptive variable names!! 
* For example, if your program needs a variable to represent the radius of a circle, call it 'radius', NOT 'r' and NOT 'rad'.
* Begin variable names with lowercase letters
* The use of single letter variables is forbidden, except as simple 'for' loop indices, temporary pointer variables and in special cases such as x- and y-coordinates.
* The use of obvious, common, meaningful abbreviations is permitted. For example, 'number' can be abbreviated as 'num' as in 'numStudents' or as 'nr' in 'nrStudents'.
* If commented, variables must be declared one per line. Comments should appear on the same line without wrapping (use two lines if necessary).
* Do not use global variables
* Separate "words" within variable names with mixed upper and lowercase. (e.g. grandTotal)
* Begin function names with uppercase letters.
* Use active function names, generally beginning with a verb and including a noun -- GetName( ).
* Function prototypes must include parameter names as well as types.
* Default values for parameters must be specified in the prototype.
* Parameters must be passed by reference whenever appropriate.
* Reference parameters must be const whenever appropriate.
* Separate "words" within function names with mixed upper and lowercase. (e.g. ProcessError)
* Constants should be used for magic numbers and strings whenever possible. Points will be deducted from projects with code written like that on the left. A "magic number" is a constant that has some meaning within your program and is often used in multiple places. Use a const int/float/double to give it a name. Likewise, well known mathematical constants (like PI) should also be given a name (const double PI = 3.14159;.

## File Header Comments
1) The file name
2) The project number
3) Your name
4) The date the file was created
5) Your section number
6) Your TAMU e-mail address
7) A description of what the code in the file does

```c++
/*****************************************
** File:    Proj1.cpp
** Project: CSCE 315 Project 1, Fall 2005
** Author:  Bob Smith
** Date:    9/22/05
** Section: 0304
** E-mail:  bsmith32@tamu.edu 
**
**   This file contains the main driver program for Project 1.
** This program reads the file specified as the first command line
** argument, counts the number of words, spaces, and characters, and
** displays the results in the format specified in the project description.
**
**
***********************************************/
```

## Function Header Comments

EACH FUNCTION and CLASS METHOD must have a header comment that includes the following information.

1) The function's name
2) The function's pre-condition(s) (if there are no pre-conditions, say so).
3) The function's post-condition(s).

A pre-condition is a statement giving the condition(s) that is (are) required to be true when the function is called. The function is not guaranteed to perform correctly unless the pre-condition is true (see text page 113). It is NOT just a restatement of the parameter names and types. 
All functions must test for pre-conditions to the extent possible Until we learn about exceptions, if a false pre-condition can be handled in code, do so (see CircleArea function below).
A post-condition is a statement describing what will be true when the function call is completed (assuming the pre-condition is met and the function completes -- see text page 113).

```c++
//-------------------------------------------------------
// Name: CircleArea
// PreCondition:  the radius is greater than zero
// PostCondition: Returns the calculated area of the circle
//---------------------------------------------------------
double CircleArea (double radius):
```