<?php
namespace App\Http\Components;

use Atl\Routing\Controller as baseController;
use App\Http\Components\Backend\AdminDataMenu;
use App\Model\LogsModel;
use App\Model\MessagesModel;
use App\Model\UserModel;

class Controller extends baseController{
	
	protected $infoUser = [];

	public function __construct(){
		parent::__construct();
		$this->mdLogs = new LogsModel;
		$this->mdMessages = new MessagesModel;
		$this->mdUser = new UserModel;
	}

	/**
	 * Load template default.
	 * 
	 * @param  string $path Template file name.
	 * @param  array $parameters Parameters for template.
	 * @return string
	 */
	public function loadTemplate( $path, $parameters = array(), $options = array() ){

		$listMessages = $this->mdMessages->getBy( 
			[
				'op_user_receiver' => Session()->get('op_user_id'),
				'op_status' => 1,
				'ORDER' => [
						'id' => 'DESC'
					]
			]
		);

		$allInfoUser = $this->mdUser->getUserBy('id', Session()->get('op_user_id'));
		$output = View(
			'layout/header.tpl',
			[
				'userId'    => Session()->get('op_user_id'),
				'userInfo'  => [
						'id'     => Session()->get('op_user_id'),
						'email'  => Session()->get('op_user_email'),
						'name'   => Session()->get('op_user_name'),
						'all_info' => $allInfoUser[0],
						'meta'   => Session()->get('op_user_meta')
					],
				'listMessages' => $listMessages,
				'mdUser'       => $this->mdUser
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

        $this->infoUser =  [
							'id'     => Session()->get('op_user_id'),
							'email'  => Session()->get('op_user_email'),
							'name'   => Session()->get('op_user_name'),
							'meta'   => Session()->get('op_user_meta')
						];
	}

	public function userRole(){
		$module = [];
		$argsRule = [];
		$router = $this->getRoute();
		$userMeta = Session()->get('op_user_meta');
		
		if( 1 == $userMeta['user_role'] ) {
			$module = [
				'/manage-user',
				'/manage-user/page/{page}',
				'/add-user',
				'/edit-user/{id}',
				'/ajax-manage-user',
				'/validate-user',
				'/delete-user',
				'/logs',
				'/filter-logs',
				'/clear-logs',
				'/add-sheet',
			];
		}

		if( 2 == $userMeta['user_role'] ) {
			$module = [
				'/edit-user/{id}',
				'/validate-user',
			];
		}

		if( 3 == $userMeta['user_role'] ) {
			$module = [
				'/edit-user/{id}',
				'/validate-user',
			];
		}

		if( in_array( $router['_route'], $module ) ) {
			$argsRule[] = true;
		}else{
			$argsRule[] = false;
		}

		if( in_array( false, $argsRule ) ) {
			redirect( url('/error-404?url=' . $_SERVER['REDIRECT_URL']) );
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

	public function slug($str, $is_url = false, $lower = true) {
        $str = strip_tags(trim($str));
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);

        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/i", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/i", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/i", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/i", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/i", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/i", 'y', $str);
        $str = preg_replace("/(đ)/i", 'd', $str);
        $str = preg_replace(array('#(amp;|quot;|;|-)#i', '#[^\w]+#i', '#[\s]+#iU'), '-', $str);
        $str = trim($str, '- ');
        $str = $lower ? strtolower($str) : $str;
        return $str;
    }

    public function autoCreatDataSheetEmpty(){
    	$data = [];
		for ($i = 0; $i <= 100; $i++) { 
			$data[] = [
					    null,
					    null,
					    null,
					    null,
					    null,
					    null,
					    null,
					    null,
					    null,
					    null,
					    null,
					    null,
					    null,
					    null,
					    null,
					    null
					 ];
		}

		return $data;
    }
}