/*-----------------------------------------------------------------------------------
 	Custom JS - All front-end jQuery
-----------------------------------------------------------------------------------*/

jQuery(window).load(function() {
	//Валидация регистрации
	
});



jQuery(document).ready(function($) {

	//register form
	$('.registration input').keyup(function(){
		$('.'+$(this).attr('name')).val($(this).val());
	});

	$('.req-reg, .required').keyup(function(event) {
		$(this).removeClass('warning');	
		$(this).removeClass('invalid');	
	});

	$('.req-reg, .required').change(function(event) {
		$(this).removeClass('warning');	
		$(this).removeClass('invalid');	
	});

	$('.registration input').change(function(){
		$('.'+$(this).attr('name')).val($(this).val());
	});

	//login form
	$('.login a').toggle(
		function(event) {
			$('.login-form').fadeIn(200);
		},
		function() {
			$('.login-form').fadeOut(200);
		}
	);
	$('#email').change(function(event) {
		emailField = $(this);
		$.ajax({
			type: 'POST',
			url: ajax.ajaxurl,
			data: {
			  	action: 'check_email',
			  	email: emailField.val()
			},
			success: function(data) {
				console.log('validated');
				if (data) {
					emailField.removeClass('invalid');
					emailField.addClass('valid');
				} else {
					emailField.addClass('invalid');
					emailField.removeClass('valid');
					alert('Такой адрес уже зарегистрирован');
				}

				var pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				str = emailField.val();
				if (str.match(pattern) == null && emailField.hasClass('valid') && str) {
					emailField.addClass('invalid');
					emailField.removeClass('valid');
					alert('Email имеет не верный формат');
				}
				if (!str) {
					emailField.removeClass('invalid');
					emailField.removeClass('valid');
				}
			}
		});
		
	});

	

	/*****************************************************/
	/******************** FILTERS ************************/
	/*****************************************************/
	$('.popup').css({left: $(window).width()/2-320 + 'px'});

	$('.select').click(function(event) {
		showPopup($(this).attr('popup'));
	});		
	

	$('.close-popup, .layout').click(function(event) {
		hidePopup();
	});

	$(document).keyup(function(e) { 
		if (e.which == 27) {
			hidePopup();
		}  
	});

	function showPopup(popup) {
		$('.popup.'+popup).fadeIn(200, function() {
			$('.popup').animate({top: $(window).height()/2-$('.popup.'+popup).height()/2 + 'px'}, 400);
		});
		$('.layout').fadeIn(200);
	}

	function hidePopup() {
		$('.popup').css({display:'none','top':-100+'px'});
		$('.layout').fadeOut(200);
	}

	////////////////////////////////NEW/////////////////////////////////////
	//------------- Фильтры | общее --------------------//
	$('.filter .btn-add').on('click', function(event) {
		if ($(this).hasClass('btn-add'))
			$(this).html('Скрыть').removeClass('btn-add').parent().find('select').show();
		else {
			$(this).html('Добавить').addClass('btn-add').parent().find('select').hide();
		}
	});
	$('.filter .btn-hide').on('click', function(event) {
		$(this).hide().parent().find('select').hide();
		$(this).parent().find('.info').show();
	});


	//------------- Фильтр по типам авто ---------------//

	//Добавляем тип авто
	$('#select_auto_type option').dblclick(function(event) {
		addNewAutoType($(this).val(), $(this).html());
		var autoTypes = getAutoTypes();
		$.ajax({
			type: 'POST',
			url: ajax.ajaxurl,
			data: {
			  	action: 'add_auto_type',
			  	autoTypes: autoTypes,
			  	id: user_ID
			},
			success: function(data) {
				console.log(data);
				//$('#select_brands').html(data);
			}
		});
	});

	function addNewAutoType(val, label) {
		var content = $('#auto_types ul').html();
		var newItem = '<li auto-type="'+val+'"><i class="icon-remove"></i> <a href="#">'+label+'</a></li>';
		if (validateList('#auto_types ul li', 'auto-type', val))
			$('#auto_types ul').html(content+newItem);
	}

	function validateList(list, field, val) {
		var render = true;
		$(list).each(function(event) {
			if ($(this).attr(field) == val) render = false;
		});
		return(render);
	}

	function getAutoTypes() {
		var autoTypes = [];
		$('#auto_types li').each(function(event) {
			autoTypes.push($(this).attr('auto-type'));
		});
		return(autoTypes);
	}

	//Удаляем тип авто
	$('#auto_types .icon-remove').on('click',function(event) {
		if(confirm('Удалить тип техники?')) {
			var typeID = $(this).parent().attr('auto-type');
			console.log(typeID);
			$(this).parent().remove();
			$.ajax({
				type: 'POST',
				url: ajax.ajaxurl,
				data: {
				  	action: 'delete_auto_type',
				  	filterID: user_ID,
				  	typeID: typeID
				},
				success: function(data) {
					console.log(data);
					//$('#select_brands').html(data);
				}
			});
		}
	});

	//------------- Фильтр по брендам ---------------//
	
	//Кликаем на тип авто
	$('#auto_types ul li').on('click', function(event) {
		var autoType = $(this).attr('auto-type');
		var brandsList;
		//get brands list and show select
		$.ajax({
		  url: ajax.ajaxurl,
		  type: 'POST',
		  data: {
		  	action: 'get_brands_list',
		  	autoType: autoType
		  },
		  success: function(data) {
		    brandsList = JSON.parse(data);
		    
		    //add list data
		    var select = $('#select_brand');
		    select.html('');
		    var selectHTML = '';
		    for (i=0; i<brandsList.length; i++) {
		    	item = brandsList[i];
		    	selectHTML += '<option value="'+item.id+'">'+item.name+'</option>';
		    }
		    $('#auto_brands .btn').show();
		    $('#select_brand').html(selectHTML).show();
		    $('#auto_brands .info').hide();

		    //Добавляем бренд
			$('#select_brand option').on('dblclick',function(event) {
				console.log('click');
				addNewBrand($(this).val(), $(this).html());
				var currentBrands = getCurrentBrands();
				$.ajax({
					type: 'POST',
					url: ajax.ajaxurl,
					data: {
					  	action: 'add_brand',
					  	currentBrands: currentBrands,
					  	id: user_ID
					},
					success: function(data) {
						console.log(data);
						//$('#select_brands').html(data);
					}
				});
			});
		  }
		});
	});

	


	function addNewBrand(val, label) {
		var content = $('#auto_brands ul').html();
		var newItem = '<li brand="'+val+'"><i class="icon-remove"></i> <a href="#">'+label+'</a></li>';
		if (validateList('#auto_brands ul li', 'brand', val))
			$('#auto_brands ul').html(content+newItem);
	}

	function validateList(list, field, val) {
		var render = true;
		$(list).each(function(event) {
			if ($(this).attr(field) == val) render = false;
		});
		return(render);
	}

	function getCurrentBrands() {
		var currentBrands = [];
		$('#auto_brands li').each(function(event) {
			currentBrands.push($(this).attr('brand'));
		});
		return(currentBrands);
	}

	//------------- Фильтр по моделям ---------------//
	
	//Кликаем на бренд авто
	$('#auto_brands ul li').bind('click', function(event) {
		var brand = $(this).attr('brand');
		var modelsList;
		//get brands list and show select
		$.ajax({
		  url: ajax.ajaxurl,
		  type: 'POST',
		  data: {
		  	action: 'get_models_list',
		  	brand: brand
		  },
		  success: function(data) {
		    modelsList = JSON.parse(data);
		    
		    //add list data
		    var select = $('#select_model');
		    select.html('');
		    var selectHTML = '';
		    for (i=0; i<modelsList.length; i++) {
		    	item = modelsList[i];
		    	selectHTML += '<option value="'+item.id+'">'+item.name+'</option>';
		    }
		    $('#auto_models .btn').show();
		    $('#select_model').html(selectHTML).show();
		    $('#auto_models .info').hide();

		    //Добавляем бренд
			$('#select_model option').on('dblclick',function(event) {
				console.log('click');
				addNewModel($(this).val(), $(this).html());
				var currentModels = getCurrentModels();
				$.ajax({
					type: 'POST',
					url: ajax.ajaxurl,
					data: {
					  	action: 'add_model',
					  	currentModels: currentModels,
					  	id: user_ID
					},
					success: function(data) {
						console.log(data);
						//$('#select_brands').html(data);
					}
				});
			});
		  }
		});
	});

	function addNewModel(val, label) {
		var content = $('#auto_models ul').html();
		var newItem = '<li model="'+val+'"><i class="icon-remove"></i><a href="#">'+label+'</a></li>';
		if (validateList('#auto_models ul li', 'model', val))
			$('#auto_models ul').html(content+newItem);
	}

	function validateList(list, field, val) {
		var render = true;
		$(list).each(function(event) {
			if ($(this).attr(field) == val) render = false;
		});
		return(render);
	}

	function getCurrentModels() {
		var currentModels = [];
		$('#auto_models li').each(function(event) {
			currentModels.push($(this).attr('model'));
		});
		return(currentModels);
	}


	/////////////////////////////////OLD////////////////////////////////////

	//actions
	
	// Добавляем данные в пользовательский список
	$('.data option').live('dblclick', function(event) {
		if (!$('.user-data option[value="'+$(this).val()+'"]').html()) {
			$(this).parents('.popup').find('.user-data')
				 .append($("<option></option>")
				 .attr("value",$(this).val())
				 .text($(this).val()));
		}	 
	});

	// Убираем данные из пользовательского списка
	$('.user-data option').live('dblclick', function(event) {
		$(this).remove();
		console.log($(this).html());
	});
	
	// Сохраняем данные из пользовательского списка
	$('.save').click(function(event) {
		id 			= $(this).attr('user');
		key 		= $(this).attr('key');
		value 		= [];

		$(this).parents('.popup').find('.user-data option').each(function(event) {
			value.push($(this).val());
		});

		$(this).parents('.filter').find('.current-value').html('Пользовательская');

		if (!value.length) {
			alert('Выберите минимум одно значение!');
		} else {
			$.ajax({
				type: 'POST',
				url: ajax.ajaxurl,
				data: {
				  	action: 'set_filter_value',
				  	id: id,
				  	key: key,
				  	value: value
				},
				success: function(data) {
					$('.saved').fadeIn(300, function() {$('.saved').delay(3000).fadeOut(300); })
				}
			});	
		}			
	});

	//Выбираем значение Все
	$('.custom').click(function(event) {
		id 			= $(this).attr('user');
		key 		= $(this).attr('key');
		value 		= $(this).attr('value');

		$(this).parent().find('.current-value').html($(this).html());

		$.ajax({
			type: 'POST',
			url: ajax.ajaxurl,
			data: {
			  	action: 'set_filter_value',
			  	id: id,
			  	key: key,
			  	value: value
			}
		});	
		
	});

	// Подгружаем текущие виды техники в марки
	$('#select-brands').click(function(event) {
		id = $(this).attr('user');

		$('#current-tech-type').html('<option disabled>Загрузка...</option>');
		$.ajax({
			type: 'POST',
			url: ajax.ajaxurl,
			data: {
			  	action: 'get_current_tech_type',
			  	id: id
			},
			success: function(data) {
				$('#current-tech-type').html(data);
			}
		});	
		
	});

	// Подгружаем марки до типу техники для фильтров
	$('#current-tech-type option').live('click', function(event) {
		
		type = $(this).val();
		
		$('#group-data, #brands-list').html('<option disabled>Загрузка...</option>');
		$.ajax({
			type: 'POST',
			url: ajax.ajaxurl,
			data: {
			  	action: 'load_groups',
			  	type: type
			},
			success: function(data) {
				$('#group-data').html(data);
			}
		});
		$.ajax({
			type: 'POST',
			url: ajax.ajaxurl,
			data: {
			  	action: 'load_brands',
			  	type: type
			},
			success: function(data) {
				$('#brands-list').html(data);
			}
		});
	});


	//////////////////// ФОРМА ПОИСКА //////////////////////

	// Подгружаем марки до типу техники для формы поиска
	$('#auto-type-select').change(function(event) {
		type = $(this).val();
		
		$('#brand-select').html('<option disabled>Загрузка...</option>');
		$('#model-select').html('<option disabled>- Выберите марку -</option>');
		
		$.ajax({
			type: 'POST',
			url: ajax.ajaxurl,
			data: {
			  	action: 'load_brands',
			  	type: type
			},
			success: function(data) {
				console.log(data);
				$('#brand-select').html('<option disabled selected="">- Выберите марку -</option>'+data);
			}
		});
	});

	// Подгружаем марки до группе
	$('#group-data option').live('dblclick', function(event) {				
		group = $(this).val();		
		$('#your-brands').html('<option disabled>Загрузка...</option>');
		$.ajax({
			type: 'POST',
			url: ajax.ajaxurl,
			data: {
			  	action: 'load_brands_by_group',
			  	group: group
			},
			success: function(data) {
				$('#your-brands').html(data);
			}
		});

	});

	// Подгружаем текущие марки в модели
	$('#select-models').click(function(event) {
		id = $(this).attr('user');

		$('#current-brands').html('<option disabled>Загрузка...</option>');
		$.ajax({
			type: 'POST',
			url: ajax.ajaxurl,
			data: {
			  	action: 'get_current_brands',
			  	id: id
			},
			success: function(data) {
				$('#current-brands').html(data);
			}
		});	
		
	});

	// Подгружаем модели до марке для фильтров
	$('#current-brands option').live('click', function(event) {				
		brand = $(this).val();		
		$('#models-list').html('<option disabled>Загрузка...</option>');
		$.ajax({
			type: 'POST',
			url: ajax.ajaxurl,
			data: {
			  	action: 'load_models',
			  	brand: brand
			},
			success: function(data) {
				$('#models-list').html(data);
			}
		});
	});

	// Подгружаем модели до марке для формы поиска
	$('#brand-select').change(function(event) {
		console.log('change');
		brand = $(this).val();		
		$('#model-select').html('<option disabled>Загрузка...</option>');
		$.ajax({
			type: 'POST',
			url: ajax.ajaxurl,
			data: {
			  	action: 'load_models',
			  	brand: brand
			},
			success: function(data) {
				$('#model-select').html('<option disabled selected="">- Выберите модель -</option>'+data);
			}
		});

	});


	// Сохраняем дополнительные параметры
	$('#save-additional-options').click(function(event) {

		email_on 	= $('input[name="email_on"]').val();
		vin_only 	= $('input[name="vin_only"]').val();
		number_only = $('input[name="number_only"]').val();
		email_only 	= $('input[name="email_only"]').val();

		console.log(email_on);
		console.log(vin_only);
		console.log(number_only);
		console.log(email_only);

		$.ajax({
			type: 'POST',
			url: ajax.ajaxurl,
			data: {
			  	action: 'save_additional',
			  	email_on: email_on,
			  	vin_only: vin_only,
			  	number_only: number_only,
			  	email_only: email_only
			},
			success: function(data) {
				$('.saved-additional').fadeIn(300, function(){ $('.saved-additional').delay(3000).fadeOut(300); });
				
			}
		});

	});

	// Переходим по шагам формы поиска
	$('.form-steps li a').click(function(event) {
		$('.form-steps li a').removeClass('active');
		$(this).addClass('active');
		step = $(this).attr('step');
		$('.steps').css('display','none');
		$('#'+step).css('display','block');
	});

	$('.form-nav button').click(function(event) {
		step = $(this).attr('step');
		$('.steps').css('display','none');
		$('#'+step).css('display','block');
		$('.form-steps li a').removeClass('active');
		$('.menu-'+step).addClass('active');
		$('#'+step).css('display','block');
	});
	
	//Сохраняем комментарий к запросу
	$('#save-request-comment').click(function(event) {
		if (!$('#request-comment').val()) {
			alert('Введите комментарий');
		} else {
			var comment = $('#request-comment').val();
			$.ajax({
				type: 'POST',
				url: ajax.ajaxurl,
				data: {
				  	action: 'save_request_comment',
				  	request: request_ID,
				  	user: user_ID,
				  	comment: comment
				},
				success: function(data) {
					$('#save-request-comment-success').fadeIn(300, function(){ $('#save-request-comment-success').delay(3000).fadeOut(300); });			
					console.log(data);
				}
			});
		}
	});

	//Изменяем статус запроса
	$('#select-request-status').change(function(event) {
		$.ajax({
			type: 'POST',
			url: ajax.ajaxurl,
			data: {
			  	action: 'change_request_status',
			  	id: request_ID,
			  	status: $('#select-request-status').val()
			},
			success: function(data) {
				$('#change-request-status-success-wrap').removeClass('res');
				$('#change-request-status-success').fadeIn(300, function(){ $('#change-request-status-success').delay(2000).fadeOut(300, function() { $('#change-request-status-success-wrap').addClass('res'); }); });			
				console.log(data);
			}
		});
	});

	//Отправляем почту заказчику через web
	$('#send-user-email').click(function(event) {
		var to = $('#user-email-content').attr('email');
		if (!$('#user-email-content').val()) {
			alert('Введите текст письма');
		} else {
			var mail = $('#user-email-content').val();
			$.ajax({
				type: 'POST',
				url: ajax.ajaxurl,
				data: {
				  	action: 'send_user_email',
				  	user: user_ID,
				  	to: to,
				  	mail: mail
				},
				success: function(data) {
					console.log(data);
					$('#send-user-email-success').fadeIn(300, function(){ $('#send-user-email-success').delay(3000).fadeOut(300); });			
				}
			});
		}
	});

	//Обновляем базу запчастей
	$('#update-gears-data').click(function(event) {
		if (!$('#gears-data-file').val()) {
			alert('Файл не выбран');
		} else {			
			$.ajax({
				type: 'POST',
				url: ajax.ajaxurl,
				data: {
				  	action: 'update_gears_data',
				  	file: $('#gears-data-file').val()
				},
				success: function(data) {
					console.log(data);
					//$('#send-user-email-success').fadeIn(300, function(){ $('#send-user-email-success').delay(3000).fadeOut(300); });			
				}
			});
		}
	});
	//Обновляем базу автомобилей
	$('#update-auto-data').click(function(event) {
		if (!$('#auto-data-file').val()) {
			alert('Файл не выбран');
		} else {			
			$.ajax({
				type: 'POST',
				url: ajax.ajaxurl,
				data: {
				  	action: 'update_auto_data',
				  	file: $('#auto-data-file').val()
				},
				success: function(data) {
					console.log(data);
					//$('#send-user-email-success').fadeIn(300, function(){ $('#send-user-email-success').delay(3000).fadeOut(300); });			
				}
			});
		}
	});

	/*****************************************************/
	/********************** USERS ************************/
	/*****************************************************/
	// Меняем статус пользователя
	$('.user-status').click(function(event) {
		var status = $(this).attr('status');
		var newStatus = 'not_approved';
		var button = $(this);
		if (status == 'not_approved') newStatus = 'approved';
		
		var user = $(this).parents('tr').attr('user');
		$.ajax({
			type: 'POST',
			url: ajax.ajaxurl,
			data: {
			  	action: 'change_user_status',
			  	status: newStatus,
			  	user: user
			},
			success: function(data) {
				button.removeClass(status).addClass(newStatus).attr('status',newStatus).html(data);	
			}
		});
	});


});

