/*-----------------------------------------------------------------------------------
 	Custom JS - All front-end jQuery
-----------------------------------------------------------------------------------*/

jQuery(document).ready(function($) {
	/*
	$('.form select[name=brand).val()').change(function(){
		console.log('change');
		brand = $(this).val();
		if (brand) {
			$.ajax({
				type: 'POST',
				url: ajax.ajaxurl,
				data: {
				  	action: 'get_models',
				  	brand: brand				  	
				},
				success: function(data) {
					console.log(data);
					$('.form select[name=model).val()').html(data);
				}
			});
		}
	});

	$('.form-steps a.step-check').click(function(){
		destination = $(this).attr("to");
		$('div.steps').fadeOut();
		$('#'+destination).fadeIn();
	});

	$('.search-form').validate({
		rules: {
			spare_part_name: "required"
		}
	});

	$('.next-step-1').click(function(){
		console.log($('input[name=spare_part_name).val()').valid({
			rules: {
				spare_part_name: "required"
			}
		}));
	});
	*/

	/****************** SEARCH PROCESSING ******************/
	
	//Запуск ajax-функции
	$('#start-search').click(function(event) {
		if (searchFormValidate()) {
			$('.search-content').slideUp(500, function()  { $('.search-content').remove(); });
			$('.process').css('display','block');

			var gear 				= $('#gear').val();
			var gear_group 			= $('#gear_group').val();
			var gear_type 			= $('#gear_type').val();
			var gear_state 			= $('#gear_state').val();
			var gear_description 	= $('#gear_description').val();
			var number 				= $('#number').val();
			var type 				= $('#auto-type-select').val();
			var year 				= $('#year').val();
			var brand 				= $('#brand-select').val();
			var model 				= $('#model-select').val();
			var modification 		= $('#modification').val();
			var vin 				= $('#vin').val();
			var volume 				= $('#volume').val();
			var body 				= $('#body').val();
			var transmission 		= $('#transmission').val();
			var drive 				= $('#drive').val();
			var fuel 				= $('#fuel').val();
			var city 				= $('#city').val();
			var name 				= $('#name').val();
			var phone 				= $('#phone').val();
			var additional_phone 	= $('#additional_phone').val();
			var email 				= $('#user-email').val();
			var comment			 	= $('#comment').val();

			$.ajax({
				type: 'POST',
				url: ajax.ajaxurl,
				data: {
				  	action				: 'save_search_data',
				  	gear 				: gear,
					gear_group 			: gear_group,
					gear_type 			: gear_type,
					gear_state 			: gear_state,
					gear_description 	: gear_description,
					number 				: number,
					type 				: type,
					year 				: year,
					brand 				: brand,
					model 				: model,
					modification 		: modification,
					vin 				: vin,
					volume 				: volume,
					body 				: body,
					transmission 		: transmission,
					drive 				: drive,
					fuel 				: fuel,
					city 				: city,
					name 				: name,
					phone 				: phone,
					additional_phone 	: additional_phone,
					email			 	: email,
					comment			 	: comment
				},
				success: function(data) {
					$('.process').css('display','none');
					$('.search-success').fadeIn(300);
				}
			});
		}
	});

	//Валидация полей на заполнение
	function searchFormValidate() {
		$('.search-form-error').css('display','none');

		var result = true;

		$('#search-form .required').each(function(event) {
			$(this).removeClass('invalid');			
			if (!$(this).val()) {
				result = false;
				$('.search-form-error').slideDown(300);
				$(this).addClass('invalid');
			}
		});

		return(result);
	}

});