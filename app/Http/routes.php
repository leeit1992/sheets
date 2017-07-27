<?php
/*
|--------------------------------------------------------------------------
| Router for project
|--------------------------------------------------------------------------
*/

// Main index
$route->get('/','MainController@index');
$route->get('/error-404','MainController@page404');

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


/*==============================
=            Sheets            =
==============================*/

$route->get('/sheet','SheetsController@handleSheet');
$route->get('/view-sheet/{id}','SheetsController@handleSheet');
$route->get('/sheets-manage','SheetsController@manageSheets');
$route->post('/save-sheets','SheetsController@saveSheets');
$route->get('/get-sheets','SheetsController@getSheets');

/*=====  End of Sheets  ======*/



/*================================
=            Massages            =
================================*/

$route->get('/massages-manage','MessagesController@manageMessages');

/*=====  End of Massages  ======*/



/*============================
=            User            =
============================*/

$route->get('/manage-user','UserController@manageUsers');
$route->get('/manage-user/page/{page}','UserController@manageUsers');
$route->get('/add-user','UserController@handleUser');
$route->get('/edit-user/{id}','UserController@handleUser', array( 'id' => '\d+' ));
$route->get('/ajax-manage-user','UserController@ajaxManageUser');
$route->post('/validate-user','UserController@validateUser' );
$route->post('/delete-user','UserController@ajaxDelete' );

/*=====  End of User  ======*/

/*============================
=            Logs            =
============================*/

$route->get('/logs','LogsController@manageLogs');
$route->get('/logs/page/{page}','LogsController@manageLogs');

/*=====  End of Logs  ======*/


