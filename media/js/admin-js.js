$(document).ready(function() {
	

	$('.do_edit_news').click(function() {
		let title = $('.admin-input input[name=news-title]').val();
		let text = $('.admin-input textarea[name=news-text]').val();
		let type = $('.admin-input select[name=news-type]').val();
		let do_edit_news = $('.do_edit_news').val();

		$.ajax({
			url: '/administrator/forms',
			type: 'POST',
			dataType: 'text',
			data: {do_edit_news: do_edit_news, title: title, text: text, type: type},
		})
		.done(function(data) {
			data = $.parseJSON(data);
			$('.error-message').html("");
			if(data == 1) {
				window.location.replace("/administrator/?data=news");
			}
			else if(data == 0) {
				$('.error-message').html("Попробуйте еще раз");
			} else {
				$.each(data, function(index, val) {
					$('.error-message').append(val+"<br>");
				});
			}


		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		


	});


	$('.do_edit_user').click(function() {
		let email = $('.admin-input input[name=users-email]').val();
		let role = $('.admin-input select[name=users-role]').val();
		let do_edit_user = $('.do_edit_user').val();

		$.ajax({
			url: '/administrator/forms',
			type: 'POST',
			dataType: 'text',
			data: {do_edit_user: do_edit_user, email: email, role: role},
		})
		.done(function(data) {
			
			data = $.parseJSON(data);
			console.log(data);
			// $('.error-message').html("");
			// if(data == 1) {
			// 	window.location.replace("/administrator/?data=users");
			// }
			// else if(data == 0) {
			// 	$('.error-message').html("Попробуйте еще раз");
			// }
			// else {
			// 	$.each(data, function(index, val) {
			// 		$('.error-message').append(val+"<br>");
			// 	});
			// }
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	});


	// Загрузка картинки в проект

	var files;
	$('.admin-input input[name=proj_img]').on('change', function(){
		files = this.files;
	});

	$('.load_proj_img').click(function() {
		$('.error_img_message').html("");
		if( typeof files == 'undefined' ) {
			$('.error_img_message').html("Выберите изображение");
			return;
		}

		let data = new FormData();

		$.each( files, function(index, val) {
			data.append(index, val);
		});

		let id_proj = $('.error_message').attr("id-proj");

		data.append('id_proj', id_proj);
		data.append('load_proj_img', 1);

		$.ajax({
			url: '/administrator/forms',
			type: 'POST',
			dataType: 'text',
			processData : false,
			contentType : false, 
			data: data,
		})
		.done(function(data) {
			data = $.parseJSON(data);
			if(data == 1) {
				document.location.reload();
			} else if(data == 0) {
				$('.error_img_message').html("Что-то не так");
			} else {
				$.each(data, function(index, val) {
					 $('.error_img_message').append(val+"<br>");
				});
			}
		})
	});


	$('.do_edit_proj').click(function() {

		let title = $('.admin-input input[name=proj-title]').val();
		let text = $('.admin-input textarea[name=proj-text]').val();
		let status = $('.admin-input select[name=proj-status]').val();
		let year = $('.admin-input input[name=proj-year]').val();

		let genre = [];
		$('.proj-genre input[name=proj-genre]:checked').each(function(index, el) {
			genre.push($(this).val());
		});

		let do_edit_proj = $('.do_edit_proj').val();

		$.ajax({
			url: '/administrator/forms',
			type: 'POST',
			dataType: 'text',
			data: {do_edit_proj: do_edit_proj, title: title, text: text, status: status, year: year, genre: genre},
		})
		.done(function(data) {
			data = $.parseJSON(data);
			console.log(data);
			$('.error-message').html("");
			if(data == 1) {
				window.location.replace("/administrator/?data=catalog");
			}
			else if(data == 0) {
				$('.error-message').html("Попробуйте еще раз");
			} else {
				$.each(data, function(index, val) {
					$('.error-message').append(val+"<br>");
				});
			}
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		


	});





	$('.do_add_news').click(function() {
		let title = $('.admin-input input[name=news-title]').val();
		let text = $('.admin-input textarea[name=news-text]').val();
		let type = $('.admin-input select[name=news-type]').val();
		let do_add_news = 1;

		$.ajax({
			url: '/administrator/forms',
			type: 'POST',
			dataType: 'text',
			data: {do_add_news: do_add_news, title: title, text: text, type: type},
		})
		.done(function(data) {
			data = $.parseJSON(data);
			$('.error-message').html("");
			if(data == 1) {
				window.location.replace("/administrator/?data=news");
			}
			else if(data == 0) {
				$('.error-message').html("Попробуйте еще раз");
			}
			else {
				$.each(data, function(index, val) {
					$('.error-message').append(val+"<br>");
				});
			}

		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		



	});


	$('.do_add_proj').click(function() {
		let title = $('.admin-input input[name=proj-title]').val();
		let text = $('.admin-input textarea[name=proj-text]').val();
		let status = $('.admin-input select[name=proj-status]').val();
		let year = $('.admin-input input[name=proj-year]').val();

		let genre = [];
		$('.proj-genre input[name=proj-genre]:checked').each(function(index, el) {
			genre.push($(this).val());
		});

		let do_add_proj = 1;

		$.ajax({
			url: '/administrator/forms',
			type: 'POST',
			dataType: 'text',
			data: {do_add_proj: do_add_proj, title: title, text: text, status: status, year: year, genre: genre},
		})
		.done(function(data) {
			data = $.parseJSON(data);
			$('.error-message').html("");
			if(data == 1) {
				window.location.replace("/administrator/?data=catalog");
			}
			else if(data == 0) {
				$('.error-message').html("Попробуйте еще раз");
			}
			else {
				$.each(data, function(index, val) {
					$('.error-message').append(val+"<br>");
				});
			}
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	});


	


	$('.do_hide_and_active').click(function() {
		let is_active = $(this).attr("is_active");
		let id_block = $(this).attr("data-id");
		let category = $(this).attr("category");
		let do_hide_block = 1;


		$.ajax({
			url: '/administrator/forms',
			type: 'POST',
			dataType: 'text',
			data: {do_hide_block: do_hide_block, id: id_block, category: category, is_active: is_active},
		})
		.done(function(data) {
			data = $.parseJSON(data);
			$('.error-message').html("");
			if(data == 1) {
				console.log(data);
				document.location.reload();
			}
			else if(data == 0) {
				$('.error-message').html("Попробуйте еще раз");
			}
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		

	});

	$('.do_block_user').click(function() {
		let user_id = $(this).attr('data-id');
		let is_block = $(this).attr('is_block');
		let do_block_user = 1;

		$.ajax({
			url: '/administrator/forms',
			type: 'POST',
			dataType: 'text',
			data: {do_block_user:do_block_user, user_id: user_id, is_block: is_block  },
		})
		.done(function(data) {
			console.log(data);
			data = $.parseJSON(data);
			$('.error-message').html("");
			if(data == 1) {
				console.log(data);
				document.location.reload();
			}
			else if(data == 0) {
				$('.error-message').html("Попробуйте еще раз");
			}
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});


	});




	$('.do_show_comm').click(function() {
		let id_comm = $(this).attr("data-id");
		let do_show_comm = 1;

		$.ajax({
			url: '/administrator/forms',
			type: 'POST',
			dataType: 'text',
			data: {do_show_comm:do_show_comm, id_comm: id_comm},
		})
		.done(function(data) {
			console.log(data);
			if(data == 1) {
				document.location.reload();
			} else {
				return false;
			}
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		


	});


	$('.admin-tr').on('click', '.add-video-link', function(event) {
		$('.error-message').html("");

		let id_section = $('.table-video-links').attr('id-section');

		let input_data = [];
		$(this).parent().parent().children().children('.input_link').each(function(index, el) {
			input_data.push($(this).val());
		});

		let add_video_link = 1;

		$.ajax({
			url: '/administrator/forms',
			type: 'POST',
			dataType: 'text',
			data: {add_video_link: add_video_link, input_data: input_data, id_section: id_section},
		})
		.done(function(data) {
			data = $.parseJSON(data);

			if(data == 0) {
				$('.error-message').html("Ошибка. Попробуйте позже");
			}
			else if(data[0] == 1) {
				$('.body-video-link').html("");
				$('.table-video-links').attr('id-section', id_section);
				$.each(data[1], function(index, val) {
					$('.body-video-link').append(
						'<tr id-link="'+val.id+'">'+
						'<td><input class="input_link" type="text" placeholder="title" value="'+val.title+'" disabled></td>'+
						'<td><input class="input_link" type="text" placeholder="url" value="'+val.url+'" disabled></td>'+
						'<td><input class="input_link" type="text" placeholder="index" value="'+val.index_number+'" disabled></td>'+
						'<td class="btn-change"><button type="button" class="change-video-link">Изменить</button></td>'+
						'</tr>');
				});

				$('.body-video-link').append(
					'<tr>'+
					'<td><input class="input_link" type="text" placeholder="title"></td>'+
					'<td><input class="input_link" type="text" placeholder="url"></td>'+
					'<td><input class="input_link" type="text" placeholder="index"></td>'+
					'<td class="btn-add"><button type="button" class="add-video-link btn btn-success">Добавить</button></td>'+
					'</tr>');
			}
			else {
				$.each(data, function(index, val) {
					$('.error-message').append(val+"<br>");
				});
			}

		})
	});



	

	$('.admin-tr').on('click', '.change-video-link-confirm', function(event) {
		$('.error-message').html("");

		let id_section = $('.table-video-links').attr('id-section');
		let id_link = $(this).parent().parent().attr('id-link');

		let input_data = [];
		$(this).parent().parent().children().children('.input_link').each(function(index, el) {
			input_data.push($(this).val());
		});

		let confirm_video_link_change = 1;

		$.ajax({
			url: '/administrator/forms',
			type: 'POST',
			dataType: 'text',
			data: {confirm_video_link_change: confirm_video_link_change, input_data: input_data, id_link: id_link, id_section: id_section},
		})
		.done(function(data) {
			data = $.parseJSON(data);

			if(data == 0) {
				$('.error-message').html("Ошибка. Попробуйте позже");
			}
			else if(data[0] == 1) {
				$('.body-video-link').html("");
				$('.table-video-links').attr('id-section', id_section);
				$.each(data[1], function(index, val) {
					$('.body-video-link').append(
						'<tr id-link="'+val.id+'">'+
						'<td><input class="input_link" type="text" placeholder="title" value="'+val.title+'" disabled></td>'+
						'<td><input class="input_link" type="text" placeholder="url" value="'+val.url+'" disabled></td>'+
						'<td><input class="input_link" type="text" placeholder="index" value="'+val.index_number+'" disabled></td>'+
						'<td class="btn-change"><button type="button" class="change-video-link">Изменить</button></td>'+
						'</tr>');
				});
				$('.body-video-link').append(
					'<tr>'+
					'<td><input class="input_link" type="text" placeholder="title"></td>'+
					'<td><input class="input_link" type="text" placeholder="url"></td>'+
					'<td><input class="input_link" type="text" placeholder="index"></td>'+
					'<td class="btn-add"><button type="button" class="add-video-link btn btn-success">Добавить</button></td>'+
					'</tr>');
			}
			else {
				$.each(data, function(index, val) {
					$('.error-message').append(val+"<br>");
				});
			}
		})
	});

	
	$('.admin-tr').on('click', '.change-video-link-cancel', function(event) {
		$('.error-message').html("");

		let video_links_inputs = $(this).parent().parent().children().children('.input_link');
		video_links_inputs.prop('disabled', true);

		let button_parent_block = $(this).parent();
		button_parent_block.html("");
		button_parent_block.append('<button type="button" class="change-video-link">Изменить</button>');
	});

	

	$('.admin-tr').on('click', '.change-video-link', function(event) {
		$('.error-message').html("");

		let video_links_inputs = $(this).parent().parent().children().children('.input_link');
		video_links_inputs.prop('disabled', false);

		let button_parent_block = $(this).parent();
		button_parent_block.html("");
		button_parent_block.append(
			'<button type="button" class="change-video-link-cancel btn btn-warning">Отмена</button>'+
			'<button type="button" class="change-video-link-confirm btn btn-success">Подтвердить</button>'+
			'<button type="button" class="del-video-link btn btn-danger">Удалить</button>');
	});

	

	$('.section-list').on('click', '.video-section', function(event) {
		$('.error-message').remove();
		$('.body-video-link').html("");

		let id_section = $(this).attr('id-section');
		let get_video_links = 1;
		
		$.ajax({
			url: '/administrator/forms',
			type: 'POST',
			dataType: 'text',
			data: {get_video_links: get_video_links, id_section: id_section},
		})
		.done(function(data) {
			data = $.parseJSON(data);

			if($('.error-message').length < 1) {
				$('.table-video-links').prepend('<div class="error-message"></div>');
			}
			$('.table-video-links').attr('id-section', id_section);
			if(data == 0) {
				$('.body-video-link').append(
					'<tr>'+
					'<td><input class="input_link" type="text" placeholder="title"></td>'+
					'<td><input class="input_link" type="text" placeholder="url"></td>'+
					'<td><input class="input_link" type="text" placeholder="index"></td>'+
					'<td class="btn-add"><button type="button" class="add-video-link btn btn-success">Добавить</button></td>'+
					'</tr>');
			} else {

				$.each(data, function(index, val) {
					$('.body-video-link').append(
						'<tr id-link="'+val.id+'">'+
						'<td><input class="input_link" type="text" placeholder="title" value="'+val.title+'" disabled></td>'+
						'<td><input class="input_link" type="text" placeholder="url" value="'+val.url+'" disabled></td>'+
						'<td><input class="input_link" type="text" placeholder="index" value="'+val.index_number+'" disabled></td>'+
						'<td class="btn-change"><button type="button" class="change-video-link">Изменить</button></td>'+
						'</tr>');
				});
					 // add link
					 $('.body-video-link').append(
					 	'<tr>'+
					 	'<td><input class="input_link" type="text" placeholder="title"></td>'+
					 	'<td><input class="input_link" type="text" placeholder="url"></td>'+
					 	'<td><input class="input_link" type="text" placeholder="index"></td>'+
					 	'<td class="btn-add"><button type="button" class="add-video-link btn btn-success">Добавить</button></td>'+
					 	'</tr>');
					}
				})
	});


	


	let is_work = false;
	$('.video-projects').click(function() {

		if(is_work == true) {return}
			is_work = true;
		$('.body-video-link').html("");
		$('.error-message').remove();
		let id_proj = $(this).attr('id-proj');
		let get_video_section = 1;

		let proj_name = $(this).html();

		$.ajax({
			url: '/administrator/forms',
			type: 'POST',
			dataType: 'text',
			data: {get_video_section: get_video_section, id_proj: id_proj},
		})
		.done(function(data) {
			$('.section-list').html("");
			data = $.parseJSON(data);
			
			if(data == 0) {
				$('.section-list').append('<option selected>---Нет секций для проекта: '+proj_name+'---</option>');
			} else {
				$('.section-list').append('<option id-proj="'+id_proj+'" selected>---Текущий проект: '+proj_name+'---</option>'+'</select>');
				
				$.each(data, function(index, val) {
					$('.section-list').append('<option class="video-section" id-section="'+val.id+'">'+val.title+'</option>');
				});
			}

			is_work = false;
		})
	});








	$('.admin-tr').on('click', '.change_video_section', function() {
		let parent_button_block = $(this).parent();
		$(this).parent().parent().children().children('.input_link').prop('disabled', false);
		$('.error_message').html("");
		parent_button_block.html("");

		parent_button_block.append(
			'<button type="button" class="cancel_video_section btn btn-warning">Отмена</button>'+
			'<button type="button" class="confirm_video_section btn btn-success">Обновить</button>'+
			'&#160;&#160;&#160;'+
			'<button type="button" class="del_video_section btn btn-danger">Удалить</button>');

	});

	$('.admin-tr').on('click', '.cancel_video_section', function() {
		$('.error_message').html("");
		$(this).parent().parent().children().children('.input_link').prop('disabled', true);
		let parent_button_block = $(this).parent();

		parent_button_block.html("");
		parent_button_block.append('<button type="button" class="change_video_section">Изменить</button>');
	});

	$('.admin-tr').on('click', '.confirm_video_section', function() {
		$('.error_message').html("");
		let parent_block = $(this).parent().parent().parent();
		let title = $(this).parent().parent().children().children('.input_link').val();
		let id_section = $(this).parent().parent().children().children('.input_link').attr('id-section');
		let id_proj = $('.error_message').attr('id-proj');

		let change_section = 1;

		$.ajax({
			url: '/administrator/forms',
			type: 'POST',
			dataType: 'text',
			data: {change_section: change_section, title:title, id_section: id_section, id_proj: id_proj},
		})
		.done(function(data) {
			data = $.parseJSON(data);

			if(data == 0) {
				$('.error_message').html("Что-то не так");
			}
			else if(data[0] == 1) {
				parent_block.html("");

				$.each(data[1], function(index, val) {
					parent_block.append(
						'<tr id-section="'+val.id+'">'+
						'<td class="input_section">'+
						'<input class="input_link" type="text" value="'+val.title+'" id-section="'+val.id+'" disabled>'+
						'</td>'+
						'<td class="btn-change"><button type="button" class="change_video_section">Изменить</button></td>'+
						'</tr>');
				});

				parent_block.append(
					'<tr>'+
					'<td class="input_section">'+
					'<input class="input_link" type="text" placeholder="Название видео-секции">'+
					'</td>'+
					'<td class="btn-change"><button type="button" class="btn btn-success add_video_section">Добавить</button></td>'+
					'</tr>');


			}
			else {
				$.each(data, function(index, val) {
					$('.error_message').html(val+"<br>");
				});
			}
		})
	});


	$('.admin-tr').on('click', '.add_video_section', function(event) {
		$('.error_message').html("");
		let id_proj = $('.error_message').attr('id-proj');
		let title = $(this).parent().parent().children().children('.input_link').val();
		let add_video_section = 1;
		let parent_block = $(this).parent().parent().parent();
		
		$.ajax({
			url: '/administrator/forms',
			type: 'POST',
			dataType: 'text',
			data: {add_video_section: add_video_section, id_proj: id_proj, title:title },
		})
		.done(function(data) {
			data = $.parseJSON(data);

			if(data == 0) {
				$('.error_message').html("Что-то не так");
			}
			else if(data[0] == 1) {
				parent_block.html("");

				$.each(data[1], function(index, val) {
					parent_block.append(
						'<tr id-section="'+val.id+'">'+
						'<td class="input_section">'+
						'<input class="input_link" type="text" value="'+val.title+'" id-section="'+val.id+'" disabled>'+
						'</td>'+
						'<td class="btn-change"><button type="button" class="change_video_section">Изменить</button></td>'+
						'</tr>');
				});

				parent_block.append(
					'<tr>'+
					'<td class="input_section">'+
					'<input class="input_link" type="text" placeholder="Название видео-секции">'+
					'</td>'+
					'<td class="btn-change"><button type="button" class="btn btn-success add_video_section">Добавить</button></td>'+
					'</tr>');
			}
			else {
				$.each(data, function(index, val) {
					$('.error_message').html(val+"<br>");
				});
			}
		})
	});


	$('.admin-tr').on('click', '.del_video_section', function(event) {
		let id_section = $(this).parent().parent().attr('id-section');
		let id_proj = $('.error_message').attr('id-proj');
		let del_video_section = 1;

		let parent_block = $(this).parent().parent().parent();

		$.ajax({
			url: '/administrator/forms',
			type: 'POST',
			dataType: 'text',
			data: {del_video_section: del_video_section, id_section: id_section, id_proj: id_proj},
		})
		.done(function(data) {
			data = $.parseJSON(data);

			if(data == 0) {
				$('.error_message').html("Что-то не так");
			} else if(data[0] == 1) {
				parent_block.html("");

				$.each(data[1], function(index, val) {
					parent_block.append(
						'<tr id-section="'+val.id+'">'+
						'<td class="input_section">'+
						'<input class="input_link" type="text" value="'+val.title+'" id-section="'+val.id+'" disabled>'+
						'</td>'+
						'<td class="btn-change"><button type="button" class="change_video_section">Изменить</button></td>'+
						'</tr>');
				});

				parent_block.append(
					'<tr>'+
					'<td class="input_section">'+
					'<input class="input_link" type="text" placeholder="Название видео-секции">'+
					'</td>'+
					'<td class="btn-change"><button type="button" class="btn btn-success add_video_section">Добавить</button></td>'+
					'</tr>');
			}

		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});




	$('.admin-tr').on('click', '.del-video-link', function(event) {
		$('.error-message').html("");
		let id_section = $('.table-video-links').attr('id-section');
		let id_link = $(this).parent().parent().attr('id-link');
		let del_video_link = 1;


		$.ajax({
			url: '/administrator/forms',
			type: 'POST',
			dataType: 'text',
			data: {del_video_link: del_video_link, id_section: id_section, id_link: id_link},
		})
		.done(function(data) {
			data = $.parseJSON(data);

			if(data == 0) {
				$('.error-message').html("Ошибка. Попробуйте позже");
			}
			else if(data[0] == 1) {
				$('.body-video-link').html("");
				$('.table-video-links').attr('id-section', id_section);
				$.each(data[1], function(index, val) {
					$('.body-video-link').append(
						'<tr id-link="'+val.id+'">'+
						'<td><input class="input_link" type="text" placeholder="title" value="'+val.title+'" disabled></td>'+
						'<td><input class="input_link" type="text" placeholder="url" value="'+val.url+'" disabled></td>'+
						'<td><input class="input_link" type="text" placeholder="index" value="'+val.index_number+'" disabled></td>'+
						'<td class="btn-change"><button type="button" class="change-video-link">Изменить</button></td>'+
						'</tr>');
				});
				$('.body-video-link').append(
					'<tr>'+
					'<td><input class="input_link" type="text" placeholder="title"></td>'+
					'<td><input class="input_link" type="text" placeholder="url"></td>'+
					'<td><input class="input_link" type="text" placeholder="index"></td>'+
					'<td class="btn-add"><button type="button" class="add-video-link btn btn-success">Добавить</button></td>'+
					'</tr>');
			}
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		


	});









});