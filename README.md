# atl-framework
Framework MVC for team

## Get Started

[Composer Download](https://getcomposer.org/doc/00-intro.md).

``` bash
$ composer install
```

## Load view
```php
View('layout/header')
```

## Use Route

Main index

``` php
$route->get('/','MainController@index');
```

Route Get

``` php
$route->get('/id/{id}', 'MainController@checkRouteGet');
```

Route Post

``` php
$route->post('/validate','MainController@checkRoutePost');
```

Route validate int

``` php
$route->get('/id/{id}', 'MainController@checkRoutePost', array('page' => '\d+'));
```

## Validation Form;

[Exemple detail](http://www.sirius.ro/php/sirius/validation/simple_example.html).

``` php

use Atl\Validation\Validation;
$validator = new Validation;

$validator->add(
    array(

        // the key is in the form [field]:[label]
        'name:Name' => 'required',

        // you can have multiple rules for the same field
        'email:Your email' => 'required | email',

        // validators can have options
        'message:Your message' => 'required | minlength(10)',

        // and you can overwrite the default error message
        'phone:Phone' => 'regex(/your_regex_here/)(This field must be a valid US phone number)'
    )
);

if ($validator->validate($_POST)) {

    // send notifications to stakeholders
    // save the form data to a database

} else {

    // send the error messages to the view
    $view->set('errors', $validator->getMessages();

}

```

## Session;

Handle session.

``` php
// Config file config/app.php
'session' => array( 'status' => true, 'storage' => ''),


 // Use code base
Session()->set('name','Test Session');
echo Session()->get('name');

// Session flash

Session()->getFlashBag()->set('name', 'Test');
var_dump(Session()->getFlashBag()->has('name'));
var_dump(Session()->getFlashBag()->get('name'));

```

## Upload file;

Handle upload.

``` php
	public function upload(Request $request){
		$request->files->get('parametersName')->move( FOLDER_UPLOAD, 'filename.png');

	}

```



## Redirect;

Handle redirect url.

``` php

redirect( url('exemple/id/1') );

```
## __ ;

``` php


```

## Use pagination
```php
use Atl\Pagination\Pagination;

$ofset                = 10; // Result query row number.
$config['pageStart']  = $page; // Number of page.
$config['ofset']      = $ofset; 
$config['totalRow']  = 50; // Number of count total row.
$config['baseUrl']   = url('/page/'); // Url base of pagination.

$pagination          = new Pagination($config);

echo $pagination->link( $config );

```



## Use Model

Use model static

``` php
DB()->insert("account", [
	"user_name" => "foo",
	"email"     => "foo@bar.com"
]);

DB()->update("account", [
	"user_name" => "foo",
	"email"     => "foo@bar.com"
],[
	"id" => 1
]);

DB()->select("account", [
	"user_name",
	"email"
], [
	"user_id[>]" => 100
]);

DB()->select("account", "user_name", [
	"email" => "foo@bar.com"
]);
// WHERE email = 'foo@bar.com'
 
DB()->select("account", "user_name", [
	"user_id" => 200
]);
// WHERE user_id = 200
 
DB()->select("account", "user_name", [
	"user_id[>]" => 200
]);
// WHERE user_id > 200
 
DB()->select("account", "user_name", [
	"user_id[>=]" => 200
]);
// WHERE user_id >= 200
 
DB()->select("account", "user_name", [
	"user_id[!]" => 200
]);
// WHERE user_id != 200
 
DB()->select("account", "user_name", [
	"age[<>]" => [200, 500]
]);
// WHERE age BETWEEN 200 AND 500
 
DB()->select("account", "user_name", [
	"age[><]" => [200, 500]
]);
// WHERE age NOT BETWEEN 200 AND 500
 
// [><] and [<>] is also available for datetime
DB()->select("account", "user_name", [
	"birthday[><]" => [date("Y-m-d", mktime(0, 0, 0, 1, 1, 2015)), date("Y-m-d")]
]);
//WHERE "create_date" BETWEEN '2015-01-01' AND '2015-05-01' (now)
 
// You can use not only single string or number value, but also array
DB()->select("account", "user_name", [
	"OR" => [
		"user_id" => [2, 123, 234, 54],
		"email" => ["foo@bar.com", "cat@dog.com", "admin@medoo.in"]
	]
]);
// WHERE
// user_id IN (2,123,234,54) OR
// email IN ('foo@bar.com','cat@dog.com','admin@medoo.in')
 
// [Negative condition]
DB()->select("account", "user_name", [
	"AND" => [
		"user_name[!]" => "foo",
		"user_id[!]" => 1024,
		"email[!]" => ["foo@bar.com", "cat@dog.com", "admin@medoo.in"],
		"city[!]" => null,
		"promoted[!]" => true
	]
]);
// WHERE
// `user_name` != 'foo' AND
// `user_id` != 1024 AND
// `email` NOT IN ('foo@bar.com','cat@dog.com','admin@medoo.in') AND
// `city` IS NOT NULL
// `promoted` != 1
 
// Or fetched from select() or get() function
DB()->select("account", "user_name", [
	"user_id" => DB()->select("post", "user_id", ["comments[>]" => 40])
]);
// WHERE user_id IN (2, 51, 321, 3431)

```
