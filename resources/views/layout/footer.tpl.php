<?php  
enqueueScripts(
	array(	
			'common'  	 => assets('assets/js/common.min.js'),
			'uikit_custom'  => assets('assets/js/uikit_custom.min.js'),
			'altair_admin_common'  => assets('assets/js/altair_admin_common.min.js'),
			
			
			'jquery-ui'  => assets('bower_components/jquery-ui/jquery-ui.js'),
		    'underscore' => assets('bower_components/backbone/underscore.js'),
		    'backbone'   => assets('bower_components/backbone/backbone-min.js'), 
		    
		    'backend'   => assets('js/backend-scripts.min.js'),
		)
);
?>
	</div>
</div>
<!-- end page content -->
</body>
</html>