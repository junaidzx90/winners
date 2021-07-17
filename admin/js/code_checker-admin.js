jQuery(function( $ ) {
	'use strict';
	$('#counter-reset').on("click", function (e) {
		e.preventDefault();
		$.ajax({
			type: "post",
			url: resetcounter.ajaxurl,
			data: {
				action: "reset_counters"
			},
			success: function (response) {
				if (response) {
					alert("Counter has been reset successfully.");
				}
			}
		});
	});
});
