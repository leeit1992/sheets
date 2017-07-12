(function($){
	

	var time = 500;
	var el = 1;
	var dom = setInterval(function(){
		$(".atl-task-"+el).fadeIn(200);
		el = el + 1;

		if( 5 == el){
			clearInterval(dom);
		}
	},time);	

	$(".atl-keyup").keyup(function(){
		var bseUrl = $("#form-get").attr('data-url');
		$("#form-get").attr('href',bseUrl + 'id/' + $(this).val());
	})
})(jQuery)