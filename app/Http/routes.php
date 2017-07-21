<?php
/*
|--------------------------------------------------------------------------
| Router for project
|--------------------------------------------------------------------------
*/

// Main index
$route->get('/','MainController@index');

// Check method Get
$route->get('/id/{id}','MainController@checkRouteGet');

$route->get('/page/{id}','MainController@index');

// Check method Post
$route->post('/validate','MainController@checkRoutePost');


/*=============================
=            Login            =
=============================*/

$route->get('/login','LoginController@login');
$route->get('/logout','LoginController@logout');
$route->post('/check-login','LoginController@checkLogin');

/*=====  End of Login  ======*/

/*==================================
=            Canculator            =
==================================*/

$route->get('/sheet','SheetsController@handleSheet');
$route->get('/edit-sheet/{id}','SheetsController@handleSheet');
$route->get('/sheets-manage','SheetsController@manageSheets');
$route->post('/save-sheets','SheetsController@saveSheets');


/*=====  End of Canculator  ======*/



/*================================
=            Massages            =
================================*/

$route->get('/massages-manage','MessagesController@manageMessages');

/*=====  End of Massages  ======*/



/*============================
=            User            =
============================*/

$route->get('/add-user','UserController@saveUser');
$route->get('/manage-user','UserController@manageUser');

/*=====  End of User  ======*/


