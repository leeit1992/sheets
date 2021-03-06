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
$route->post('/register-user','LoginController@registerUser');
$route->get('/active-account/{token}','LoginController@activeAccount');

/*=====  End of Login  ======*/


/*==============================
=            Sheets            =
==============================*/

$route->get('/sheet','SheetsController@handleSheet');
$route->get('/view-sheet/{id}','SheetsController@handleSheet');
$route->get('/view-sheet/{id}/{mesId}','SheetsController@handleSheet');
$route->get('/sheets-manage','SheetsController@manageSheets');
$route->post('/save-sheets','SheetsController@saveSheets');
$route->get('/get-sheets','SheetsController@getSheets');
$route->post('/send-sheet','SheetsController@sendSheet');
$route->post('/share-sheet','SheetsController@shareSheet');
$route->post('/transfer-sheet','SheetsController@transferSheet');

$route->get('/add-sheet','SheetsController@addNewSheet');
$route->post('/hand-add-sheet','SheetsController@handleAddSheet');

/*=====  End of Sheets  ======*/



/*================================
=            Massages            =
================================*/

$route->get('/massages-manage','MessagesController@manageMessages');
$route->get('/message-notice','MessagesController@messageNotice');
$route->post('/write-messages','MessagesController@writeMessages');
$route->post('/delete-messages','MessagesController@removeMessages');
$route->get('/filter-messages','MessagesController@filterMessages');
$route->post('/update-inbox','MessagesController@updateInbox');
$route->get('/autoload-inbox','MessagesController@autoLoadInbox');
$route->post('/accept-sheet','MessagesController@acceptSheet');
$route->post('/sendback-inbox','MessagesController@sendBackInbox');
$route->post('/cancel-order','MessagesController@cancelOrder');

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
$route->get('/filter-logs','LogsController@filterLogs');
$route->post('/remove-log','LogsController@removeLogs');
$route->post('/clear-logs','LogsController@clearLogs');

/*=====  End of Logs  ======*/

$route->get('/lech','LechController@lech');
$route->get('/rounding','LechController@rounding');


