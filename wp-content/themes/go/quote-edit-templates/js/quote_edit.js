$(document).ready(function() {
	const form = $('form#editedScope');
	$('.saveScope').click(function(){
		$('#saveScopeResponse').html('');
		var url = "/wp-content/themes/go/quote-edit-templates/ajax/editScope.php";
		showLoader();
		jQuery.ajax({
		  	url: url,
		 	type: "POST",
			dataType: 'json',
			cache: false,
			data: $('#editedScope').serialize(),
		 	success: function(response) {
		        if(response.status == 'fail') {
		        	removeLoader();
		        	$('#saveScopeResponse').html(response.message);
		        }
		        else if(response.status == 'success') {
		        	var url = response.redirect;
		        	window.location.href = url;
					//console.log(response.log);
		        }

		 	},
		error: function(response) {
		        removeLoader();
		        $('#saveScopeResponse').html("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>Something went wrong! Unknown error!</div>");
	  		}
	  	});

	});
	
	let calculateQuoteTotal = () => {
		if($(this).data('notCallCalculating')) return;
		
        var url = "/wp-content/themes/go/quote-templates-v2/ajax/calculateQuote.php";
		$.ajax({
			type: 'post',
			url: url,
			data: form.serialize()
        }).done(function(res) {
			res = JSON.parse(res);
			$('#total-quote').html(`\$${res.message}`);
			$('input[name="projectPrice"]').val(res.message);
        }).fail(function() {
          console.log('fail');
        });
    };
	form.on('change', 'input', calculateQuoteTotal);
	form.on('click', 'i.icon.wb-plus, i.icon.wb-minus', calculateQuoteTotal);

});
