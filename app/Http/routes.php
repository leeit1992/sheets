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

/*=====  End of Login  ======*/

/*==================================
=            Canculator            =
==================================*/

$route->get('/canculator','CanculatorController@canculator');


/*=====  End of Canculator  ======*/


/*============================
=            User            =
============================*/

$route->get('/add-user','UserController@saveUser');
$route->get('/manage-user','UserController@manageUser');

/*=====  End of User  ======*/


