jQuery(function( $ ) {
	'use strict';

	$('#win__mycode').on("keyup", function () {
		if ($(this).val().length > 0) {
			$('#win__mycode').css('border-color', '#ddd');
		}
	})

	$('.win__send').on("click", function () {
		let code = $('#win__mycode').val();
		if (code !== "") {
			$.ajax({
				type: "post",
				url: check_my_code.ajaxurl,
				data: {
					action: "check_my_code_validity",
					code: code,
					nonce: check_my_code.nonce
				},
				beforeSend: () => {
					$('.progress').html('<p class="loading"><i class="fas fa-spinner fa-pulse"></i></p>');
				},
				dataType: 'json',
				success: function (response) {
					if (response.success) {
						$('#checkCounter').text(response.counter);
						$('.progress').html(response.success);
					}

					if (response.error) {
						$('.progress').html(response.error);
					}
				}
			});	
		} else {
			$('#win__mycode').css('border-color', '#ffaeae');
		}
	});
});
