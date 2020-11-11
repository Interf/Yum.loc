$(document).ready(function() {
	
	let a = function(val){

		var example_object = val;
		var object_length = Object.keys(example_object).length;
		let result = "";
		for (var i = 0; i < object_length; i++) {
			result += '<a href=\"catalog/category'+val.translit[i]+'\">'+val.genre[i]+'</a>'+ (i == (object_length - 1) ? '' : ',');
		}

		return result;
	}


	$('.load-more').click(function() {
		let page = $(this).val();
		let do_load = 1;
		let next_page = parseInt($(this).val()) + 1; // parseInt - преобразует строку в число

		$.ajax({
			url: '/load-more',
			type: 'POST',
			dataType: 'text',
			data: {do_load: do_load, page: page},
		})
		.done(function(data) {
			data = $.parseJSON(data);

			if(data == false) {
				$('.load-more ').remove();
				return false;
			}

			$.each(data, function(index, val) {
				$('.proj-home').append('<div class="proj-home-block">'+
					'<div class="proj-home-first-block">'+
					'<a href="/catalog/item/'+val.id+'"><img src="/media/images/'+val.img+'" alt=""></a>'+
					'</div>'+
					'<div class="proj-home-second-block">'+
					'<div class="proj-home-name">'+
					'<a href="/catalog/item/'+val.id+'">'+val.title+'</a>'+
					'</div>'+
					'<div class="proj-home-info">'+
					'Жанры:'+
					a(val.info)
					+'</div>'+
					'</div>'+
					'</div>');
			});

			$('.load-more ').attr('value', next_page);



		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
		
	});





	$('.button-filter').click(function() {
		$('.sidebar-filter').toggle(400);
	});




	let flag = 0;

	$('.do_comment').click(function() {
		if(flag == 1) {return false;}
		let idItem = $('.form-comment input[name=idItem]').val();
		let comment = $('.form-input textarea').val();
		let do_comment = 1;
		
		flag = 1;

		$.ajax({
			url: '/catalog/item/comment',
			type: 'POST',
			dataType: 'text',
			data: {do_comment: do_comment, comment: comment, idItem: idItem},
		})
		.done(function(data) {

			data = $.parseJSON(data);

			if(data == 1) {
				$('.comment-error').html("Комментарий успешно добавлен.");
				document.location.reload();
			}
			else if(data[0] == 0) {
				$.each(data, function(index, val) {
					$('.comment-error').html(val+"<br>");
				});
			}

			else if(data == 0) {
				document.location.reload();
			}

			flag = 0;

		})
		.fail(function() {
			// console.log("error");
		})
		.always(function() {
			// console.log("complete");
		});
		

	});


	$('.do_reg').click(function() {
		
		let reg = {};
		reg.email = $('.form-reg input[name=email]').val();
		reg.login = $('.form-reg input[name=login]').val();
		reg.pass1 = $('.form-reg input[name=pass1]').val();
		reg.pass2 = $('.form-reg input[name=pass2]').val();

		let do_reg = 1;

		$.ajax({
			url: '/check-auth',
			type: 'POST',
			dataType: 'text',
			data: {do_reg: do_reg, reg: reg},
		})
		.done(function(data) {
			$('.reg-error').html("");
			data = $.parseJSON(data);

			if(data == 1) {
				$('.form-reg').remove();
				$('.reg-error').html("Успешная регистрация");
				window.location.replace("/");
			}
			if(data[0] == 0) {
				$.each(data[1], function(index, val) {
					$('.reg-error').append(val+"<br>");
				});
			}
		})
		.fail(function() {
			// console.log("error");
		})
		.always(function() {
			// console.log("complete");
		});
		

	});



	$('.do_log').click(function() {
		let log = {};
		log.login = $('.form-log input[name=login]').val();
		log.pass = $('.form-log input[name=pass]').val();
		log.remember = $('.form-log input[name=remember_me]').prop("checked");
		let do_log = 1;

		$.ajax({
			url: '/check-auth',
			type: 'POST',
			dataType: 'text',
			data: {do_log: do_log, log: log},
		})
		.done(function(data) {
			data = $.parseJSON(data);

			$('.login-error').html("");

			if(data == 1) {
				$('.login-error').html("Успешный вход");
				window.location.replace("/");
			}
			else if(data[0] == 0) {
				$.each(data[1], function(index, val) {
					$('.login-error').append(val+"<br>");
				});
			}
		})
		.fail(function() {
			
		})
		.always(function() {

		});
		

	});


	$('.do_check_email').click(function() {
		let email = $('.form-email input[name=email]').val();
		let do_check_email = 1;


		$.ajax({
			url: '/forgot-pass',
			type: 'POST',
			dataType: 'text',
			data: {do_check_email: do_check_email, email: email},
		})
		.done(function(data) {

			data = $.parseJSON(data);
			$('.recovery-error').html("");

			if(data == 1) {
				$('.form-email').remove();
				$('.recovery-error').html("Проверьте свою почту");
				return false;
			}
			
			$('.recovery-error').html(data);

		})
		.fail(function() {
			
		})
		.always(function() {
			
		});
		

	});








	function getUrlVars()
	{
		var vars = [], hash;
		var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for(var i = 0; i < hashes.length; i++)
		{
			hash = hashes[i].split('=');
			// vars.push(hash[0]);
			vars[hash[0]] = hash[1];
		}
		return vars;
	}




	$('.do_recovery').click(function() {

		

		let pass = {};
		pass.pass1 = $('.form-recovery input[name=pass1]').val();
		pass.pass2 = $('.form-recovery input[name=pass2]').val();
		let urlVars = getUrlVars();
		let rec_hash = urlVars.rec_hash;
		let do_recovery = 1;

		$.ajax({
			url: '/forgot-pass',
			type: 'POST',
			dataType: 'text',
			data: {do_recovery: do_recovery, pass: pass, rec_hash: rec_hash},
		})
		.done(function(data) {
			$('.recovery-error').html("");
			data = $.parseJSON(data);

			if(data == 1) {
				$('.recovery-error').html("Успешная смена пароля");
				window.location.replace("/login");
				return false;
			}

			$.each(data, function(index, val) {
				$('.recovery-error').append(val+"<br>");
			});

			console.log(data);

		})
		.fail(function() {
			
		})
		.always(function() {
			
		});
		

	});



	$('.do_change_pass').click(function() {
		let pass = {};
		pass.oldPass = $('.user-form-change-pass input[name=oldPass]').val();
		pass.newPass1 = $('.user-form-change-pass input[name=newPass1]').val();
		pass.newPass2 = $('.user-form-change-pass input[name=newPass2]').val();
		let do_change_pass = 1;

		$.ajax({
			url: '/user/check-data',
			type: 'POST',
			dataType: 'text',
			data: {do_change_pass: do_change_pass, pass:pass},
		})
		.done(function(data) {
			$('.change-errors').html("");
			data = $.parseJSON(data);
			
			if(data == 1) {
				$('.change-errors').html("Пароль успешно изменен");
				window.location.replace("/logout");
			} 
			else if(data[0] == 0) {
				$.each(data[1], function(index, val) {
					$('.change-errors').append(val+"<br>");
				});
			}

			

		})
		.fail(function() {

		})
		.always(function() {
			
		});




	});



	var files; 

	$('.user-form-upload input[type=file]').on('change', function(){
		files = this.files;
	});


	$('.do_upload').click(function() {

		if( typeof files == 'undefined' ) return;

		let data = new FormData();

		$.each( files, function(index, val) {
			data.append(index, val);
		});

		data.append('do_upload', 1);

		$.ajax({
			url: '/user/check-data',
			type: 'POST',
			dataType: 'text',
			processData : false,
			contentType : false, 
			data: data,
		})
		.done(function(data) {
			$('.change-errors').html("");

			data = $.parseJSON(data);

			if(data == 1) {
				window.location.replace("/user/profile");
			}
			else if(data[0] == 0) {
				$.each(data[1], function(index, val) {
					$('.change-errors').append(val);
				});
			}
		})


	});




	$('.do_hide_comm').click(function() {
		let comm_id = $(this).attr("data-id");
		let do_hide_comm = 1;
		
		$.ajax({
			url: '/catalog/item/comment',
			type: 'POST',
			dataType: 'text',
			data: {do_hide_comm: do_hide_comm, comm_id: comm_id},
		})
		.done(function(data) {
			document.location.reload();
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		

	});




	let is_active = false;
	$('.section').click(function() {

		if(is_active == true) {return;}
		is_active = true;
		$('.choose_video_block').html("");


		if($(this).hasClass('section_active')) {
			$(".section").removeClass('section_active');
			console.log("test");
			is_active = false;
			return false;
		} else {
			$(".section").removeClass('section_active');
			$(this).addClass('section_active');
		}


		let parent_block = $(this).parent().parent();

		is_active = true;

		let section_id = $(this).attr("section-id");
		let get_links = 1;
		

		$.ajax({
			url: '/catalog/item/comment',
			type: 'POST',
			dataType: 'text',
			data: {get_links: get_links, section_id: section_id},
		})
		.done(function(data) {
			data = $.parseJSON(data);
			if(data == false) {
				parent_block.children('.choose_video_block').html("Ошибка. Попробуйте позже");
			} else {
				$.each(data, function(index, val) {
					parent_block.children('.choose_video_block').append('<a href="#" video-url="'+val.url+'">'+val.title+'</a>');
				});
			}
			is_active = false;
			videoByLink();
		})
	});


	let videoByLink = function() {
		$('.choose_video_block a').click(function(event) {
			event.preventDefault();
			$('.choose_video_block a').removeClass('active_choose_video');
			$(this).addClass('active_choose_video');
			$('.video_block').html("");
			let video_url = $(this).attr('video-url');
			$('.video_block').append('<iframe align="absmiddle" width="100%" height="350" src="'+video_url+'" frameborder="0" allowfullscreen></iframe>');
		});
	}








});