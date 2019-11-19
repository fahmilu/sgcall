(function ($) {
	$(function () {

		form = $("form.crud");

		$('input[name="title"]', form).keyup(function () {
			slug = $('input[name="slug"]', form);
			if (slug.val() == "home" || slug.val() == "404") {
				return
			}
			$.post(SITE_URL + "ajax/url_title", {
				title: $(this).val()
			}, function (new_slug) {
				slug.val(new_slug)
			})
		})

		// slide image reorder
		$('#files-uploaded').livequery(function(){
			$(this).sortable({
				start: function(event, ui) {
					ui.helper.find('a').unbind('click').die('click');
				},
				update: function() {
					order = new Array();
					$('li', this).each(function(){
						order.push( $(this).find('input[name="img_media_id[]"]').val() );
					});
					order = order.join(',');
					$.post(SITE_URL + 'admin/gallery/imgorder', { "order": order });
				}
			}).disableSelection();
		});

		// image delete
		$('.actions a.imgdel').livequery('click', function(e){
			var url = $(this).attr('href');
			var imgdiv = $(this).parent().parent();
			var imgid = $('input[name="img_media_id[]"]', imgdiv).val();

			e.preventDefault();
			imgdiv.fadeTo('slow',0.3);
			if (!confirm(pyro.lang.dialog_message))
			{
				$(this).parent().parent().fadeTo('slow',1);
				return false;
			}

			$.post( url, { imgid: imgid } )
			.success(function(data) {
				if (data.status == 'error')
				{
					pyro.add_notification(data.message, {method: 'prepend'});
					imgdiv.fadeTo('slow',1);
				}
				else if (data.status == 'success')
				{
					pyro.add_notification(data.message, {method: 'prepend'}, function(){
						imgdiv.fadeIn('fast', function(){
							imgdiv.empty().remove();
							if ($('input[name="img_media_id[]"]').length == 0)
							{
								$('#files-uploaded').append(noimg);
							}
						})
					});
				}
			})
			.error(function(data) {
				imgdiv.fadeTo('slow',1);
			});
		});

		// multiple file upload
		$('.open-files-uploader').livequery('click', function(){
			$(this).colorbox({
				scrolling	: false,
				inline		: true,
				href		: '#files-uploader',
				width		: '90%',
				height		: '90%',
				onComplete	: function(){
					$('#files-uploader-queue').empty();
					$.colorbox.resize();
				},
				onCleanup : function(){
					//$(window).hashchange();
				}
			});
		});

		var upload_form = $('#files-uploader form'),
			upload_vars	= upload_form.data('fileUpload'),
			$loading = $('#cboxLoadingOverlay, #cboxLoadingGraphic');

		upload_form.fileUploadUI({
			fieldName		: 'userfile',
			uploadTable		: $('#files-uploader-queue'),
			downloadTable	: $('#files-uploader-queue'),
			previewSelector	: '.file_upload_preview div',
			buildUploadRow	: function(files, index, handler){
				return $('<li><div class="file_upload_preview ui-corner-all"><div class="ui-corner-all"></div></div>' +
						'<div class="filename"><label for="file-name">' + files[index].name + '</label></div>' +
						'<div style="width:350px;"><b>Title</b>:<br /><input id="mediatitle" type="text" name="title"><br />'+
						'<div><b>Body</b>:<br /><textarea id="mediadescription" rows="3" cols="30" name="body"></textarea></div>'+
						'</div>' +
						'<div class="file_upload_progress"><div></div></div>' +
						'<div class="file_upload_cancel buttons buttons-small">' +
						'<button class="button start ui-helper-hidden-accessible"><span>' + startbtn + '</span></button>'+
						'<button class="button cancel"><span>' + cancelbtn + '</span></button>' +
						'</div>' +
						'</li>');
			},
			buildDownloadRow: function(data){
				if (data.status == 'success')
				{
					return $('<li><div>' + data.file.name + '</div></li>');
				}
				else if (data.status == 'error')
				{
					pyro.add_notification(data.message, {method: 'prepend', clear: false});
					return false;
				}
				return false;
			},
			beforeSend: function(event, files, index, xhr, handler, callBack){
				handler.uploadRow.find('button.start').click(function(){
					handler.formData = {
						name: handler.uploadRow.find('input.file-name').val(),
						title: handler.uploadRow.find('#mediatitle').val(),
						body: handler.uploadRow.find('#mediadescription').val()
					};
					$loading.show();
					callBack();
				});
			},
			onComplete: function (event, files, index, xhr, handler){
				handler.onCompleteAll(files);
				$.post('admin/gallery/getuploaded',
					function(data) {
						$('#files-uploaded').html(data);
					}
				);
				$loading.hide();
			},
			onCompleteAll: function (files){
				if ( ! files.uploadCounter)
				{
					files.uploadCounter = 1;  
				}
				else
				{
					files.uploadCounter = files.uploadCounter + 1;
				}

				if (files.uploadCounter === files.length)
				{
					$('#files-uploader a.cancel-upload').click();
				}
			}
		});

		$('#files-uploader a.start-upload').click(function(e){
			e.preventDefault();
			$('#files-uploader-queue button.start').click();
		});
		
		$('#files-uploader a.cancel-upload').click(function(e){
			e.preventDefault();
			$('#files-uploader-queue button.cancel').click();
			$.colorbox.close();
		});

		// edit media
		$(".imgeditXXX").livequery(function(){
			$(this).colorbox({
				scrolling	: false,
				width		: '600',
				height		: '480',
				onComplete: function(){
					var form = $('form#files_crud'),
						$loading = $('#cboxLoadingOverlay, #cboxLoadingGraphic');
	
					$.colorbox.resize();
	
					form.find(':input:last').keypress(function(e){
						if (e.keyCode == 9 && ! e.shiftKey)
						{
							e.preventDefault();
							form.find(':input:first').focus();
						}
					});
	
					form.find(':input:first').keypress(function(e){
						if (e.keyCode == 9 && e.shiftKey)
						{
							e.preventDefault();
							form.find(':input:last').focus();
						}
					});
	
					form.submit(function(e){
	
						e.preventDefault();
	
						form.parent().fadeOut(function(){
	
							$loading.show();
	
							pyro.clear_notifications();
	
							$.post(form.attr('action'), form.serialize(), function(data){
	
								// Update title
								data.title && $('#cboxLoadedContent h2:eq(0)').text(data.title);
	
								if (data.status == 'success')
								{
									$.post('admin/gallery/getuploaded', { galeria_id: galeria_id },
										function(data) {
											$('#files-uploaded').html(data);
										}
									);
	
									// TODO: Create a countdown with an option to cancel before close
									setTimeout(function(){
										$.colorbox.close();
									}, 1800);
								}
	
								$loading.hide();
	
								form.parent().fadeIn(function(){
	
									// Show notification & resize colorbox
									pyro.add_notification(data.message, {ref: '#cboxLoadedContent', method: 'prepend'}, $.colorbox.resize);
	
								});
	
							}, 'json');
	
						});
					});
				},
				onClosed: function(){}
			});
		});


		function processJson(data)
		{
			form.resetForm();
		}


	})
})(jQuery);