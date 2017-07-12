<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Atl application instance
| which serves as the "glue" for all the components of Atl, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Atl\Foundation\Application(
    realpath(__DIR__.'/../')
);

$_GLOBAL['app'] = $app;

$app['router'] = function(){
	return Atl\Routing\Route::getInstance();
};

/*
|--------------------------------------------------------------------------
| Create function begin action controller.
|--------------------------------------------------------------------------
*/


function atlBeginAction( $className = null, $action = null, $parameters = array() ){
	global $app;

	if( $className ) {
		eval('$class = new ' . $className . ';');

		// Check method using API request.
		$ReflectionMethod  = new ReflectionMethod($class, $action);

		// Set value for parameters
    	$argsNewParameters = array();
    	foreach ($ReflectionMethod->getParameters() as $keyParam => $param) {
       		if( 'request' == $param->name ) {
       			$argsNewParameters[$param->name] = $app['router']->getRequest();
       		}else{
       			$argsNewParameters[$param->name] = isset( $parameters[$param->name] ) ? $parameters[$param->name] : null;
       		}	
    	}

		call_user_func_array(array($class, $action), $argsNewParameters );
	}
}

return $app;