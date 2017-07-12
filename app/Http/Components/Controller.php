<?php
namespace App\Http\Components;

use Atl\Routing\Controller as baseController;
use App\Http\Components\Backend\AdminDataMenu;


class Controller extends baseController{
	
	public function __construct(){
		parent::__construct();

	}

	/**
	 * Load template default.
	 * 
	 * @param  string $path Template file name.
	 * @param  array $parameters Parameters for template.
	 * @return string
	 */
	public function loadTemplate( $path, $parameters = array() ){

		$output = View(
			'layout/header.tpl',
			[
				'userId'    => 1,
				'userInfo'  => array( 'user_avatar' => 1 )
			]
		);

		$output .= View(
			'layout/sidebar.tpl',
			[
				'menuAdmin' => AdminDataMenu::getInstance( $this->getRoute() )
			]
		);
		$output .= View( $path, $parameters );
		$output .= View('layout/footer.tpl');

		return $output;
	}

	/**
	 * Check curent access. login or not login.
	 * 
	 * @return void
	 */
	public function userAccess(){
		if (true !== Session()->has('atl_user_id')) {
            redirect( url( '/atl-login' ) );
        }
	}

	/**
	 * Handle render input form.
	 * 
	 * @param  array  $args Attr input
	 * @return string
	 */
	public function renderInput( $args = array() ){
        $atts = parametersExtra(
            array(
                'type'  => '',
                'name'  => '',
                'class' => '',
                'value' => '',
                'attr'  => array(),
            ),
            $args
        );

        $attrInput = '';
        foreach ($atts['attr'] as $key => $value) {
        	if( empty( $value ) ) {
        		$attrInput .= ' ' .$key. ' ';
        	}else{
        		$attrInput .= ' ' .$key . '="' . $value . '" ';
        	}
           
        }

        return '<input class="'.$atts['class'].'" type="'.$atts['type'].'" name="'.$atts['name'].'"  value="'.$atts['value'].'" '.$attrInput.'>';
    }

    /**
     * Handle chek is md5.
     * 
     * @param  string  $md5 String md5
     * @return boolean      
     */
    public function isValidMd5($md5 =''){
	    return preg_match('/^[a-f0-9]{32}$/', $md5);
	}

}