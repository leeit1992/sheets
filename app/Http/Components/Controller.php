<?php
namespace App\Http\Components;

use Atl\Routing\Controller as baseController;
use App\Http\Components\Backend\AdminDataMenu;
use App\Model\LogsModel;

class Controller extends baseController{
	
	public function __construct(){
		parent::__construct();
		$this->mdLogs = new LogsModel;
	}

	/**
	 * Load template default.
	 * 
	 * @param  string $path Template file name.
	 * @param  array $parameters Parameters for template.
	 * @return string
	 */
	public function loadTemplate( $path, $parameters = array(), $options = array() ){

		$output = View(
			'layout/header.tpl',
			[
				'userId'    => Session()->get('op_user_id'),
				'userInfo'  => Session()->get('op_user_meta'),
			]
		);

		$output .= View(
			'layout/sidebar.tpl',
			[
				'menuAdmin' => AdminDataMenu::getInstance( $this->getRoute() )
			]
		);
		$output .= View( $path, $parameters );
		$output .= View(
					'layout/footer.tpl',
					[
					]
					);

		return $output;
	}

	/**
	 * Check curent access. login or not login.
	 * 
	 * @return void
	 */
	public function userAccess(){
		if (true !== Session()->has('op_user_id')) {
            redirect( url( '/login' ) );
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

	/**
	 * Handle redirect to page 404
	 * 
	 * @param  string $route Link or router project
	 * @return void
	 */
	public function redirect404( $route ){
		redirect( url( '/error-404?url=' . $route ) );
	}


	/**
	 * convertDateToYmd 
	 * Handle format date.
	 * 
	 * @param  string $dateString Date string.
	 * @return string
	 */
	public function convertDateToYmd( $dateString ) {	
		return date( 'Y-m-d', strtotime( $dateString ) );		
	}

}