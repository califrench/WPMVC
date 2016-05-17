jQuery(document).ready(function($){
	
	$('.form-container').on('click', 'input[type="button"]', function(){

		$.ajax({
			url : $(this).closest('form').attr('action'),
			data : $(this).closest('form').find('input, select, textarea'),
			type : $(this).closest('form').attr('method'),
			success: function(d){

				var fn = window[d.callback];

				if (typeof fn === "function") {

					fn(d);
				}
			}
		})
	});
});

function campaign_add(d){
	console.log(d)
}