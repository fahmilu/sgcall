jQuery(document).ready(function($)
{

		// crop media
		$(".imgcrop").livequery(function(){
			$(this).colorbox({
				scrolling	: false,
				width		: '80%',
				height		: '80%',
				onComplete: function(){
					var form = $('form#files_crud'),
						$loading = $('#cboxLoadingOverlay, #cboxLoadingGraphic');
	
					$('#target').Jcrop({
						setSelect: [ 0, 0, 600, 350 ],
						addClass: 'custom',
						bgColor: 'yellow',
						bgOpacity: .8,
						sideHandles: false,
						onChange: showCoords,
						onSelect: showCoords
					});

					function showCoords(c)
					{
						$('#x1').val(c.x);
						$('#y1').val(c.y);
						$('#x2').val(c.x2);
						$('#y2').val(c.y2);
						$('#w').val(c.w);
						$('#h').val(c.h);
					};

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

					$.colorbox.resize();

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
									$.post('admin/galeria/getuploaded', { galeria_id: galeria_id },
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

});