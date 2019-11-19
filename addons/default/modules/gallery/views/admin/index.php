<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * views/admin/gallery/index.php
 *
 * Display available media in a gallery
 *
 * @version 2.0
 * @package gallery
 *
 */
?>

<section class="title">
	<h4><?php echo lang('gallery_title'); ?></h4>
</section>

<section class="item">
<div class="content">
	<fieldset id="filters">
        <legend><?php echo lang('global:filters'); ?></legend>

        <?php echo form_open('admin/gallery/filterbycategory', array('method' => 'post')); ?>
            <ul>
                <li>
                    <label for="">Category</label>
                    <?php echo form_dropdown('category', array(0 => lang('global:select-all')) + $category_options_without_no, $this->session->userdata('category')); ?>
                    <button style="vertical-align:top;position:relative;top:0px;" class="btn green" type="submit">Filter</button>
                </li>
            </ul>
        <?php echo form_close(); ?>
    </fieldset>
	<form class="crud">

	<?php if (!empty($slides)): ?>

	<ul id="files-uploaded" class="grid clear-both">

	    <?php foreach($slides as $file): ?>
	        <li class="ui-corner-all" style="width: 240px;">
	        	<div class="top-content"><?php echo '<strong>'.$file->title.'</strong>'; echo ($file->published == 'yes') ? ' (<span class="live">Live</span>)' : ' (Draft)'; ?></div>
				<?php $path = 'gallery/'; ?>
		        <a title="<?php echo $file->title; ?>" href="<?php echo base_url(UPLOAD_PATH .$path. ($file->filename)); ?>" rel="cb_0" class="modal">
	            <div style="background: url(<?php echo base_url(UPLOAD_PATH.$path. substr($file->filename, 0, -4) . substr($file->filename, -4));?>) no-repeat center center; background-size: cover; padding-bottom: 90%; margin: 0px 10px;"></div></a>
				<div class="actions">
					<?php
						// echo anchor('admin/gallery/crop/'.$file->id, lang('gallery_crop_label'), 'class="imgcrop"' ) . ' | ';
						//echo anchor('admin/gallery/editmedia/'.$file->id, lang('buttons.edit'), 'class="imgedit"' );					
						if (group_has_role('gallery', 'edit_image')) {
							echo anchor('admin/gallery/edit/'.$file->id, lang('buttons:edit'), 'class="imgedit"' ) . '|';
						}
						if (group_has_role('gallery', 'delete_image')) {
							echo anchor('admin/gallery/delete', lang('buttons:delete'), 'class="imgdel"' );
						}

					?>
	            </div>	
	        <input type="hidden" name="img_media_id[]" value="<?php echo $file->id; ?>" />
	        </li>
	    <?php endforeach; ?>

	</ul>

	<?php else: ?>

		<div class="no_data"><?php echo lang('gallery_no_slides_error'); ?></div>

	<?php endif; ?>

	</form>

	<div class="clearfix"><br /></div>
	<div style="font-size:0.9em; padding-top:9px;"><?php echo lang('gallery_dragndrop_msg'); ?></div>

</div>

<div class="clearfix"></div>
<br />
</section>

			<div class="hidden">
				<div id="files-uploader">
					<div class="files-uploader-browser">
						<form action="<?php echo site_url('/admin/gallery/upload') ?>" method="post" accept-charset="utf-8" enctype="multipart/form-data" name="frmUpload">
							<label for="userfile" class="upload">Upload Files</label>
							<input type="file" name="userfile" value="" class="no-uniform" multiple="multiple" />
							<div style="visibility:hidden;">
							<input type="text" name="mediatitle">
							<textarea rows="3" cols="30" name="mediadescription"></textarea>
							</div>
							<?php if (!empty($gallery->id)): ?>
								<input type="hidden" id="gallery_id" name="gallery_id" value="<?php echo $gallery->id; ?>" />
							<?php endif; ?>
						</form>
						<ul id="files-uploader-queue" class="ui-corner-all"></ul>
		
					</div>
					<div class="buttons align-right padding-top">
						<a href="#" title="" class="button start-upload">Upload</a>
						<a href="#" title="" class="button cancel-upload">Cancel</a>
					</div>
				</div>
			</div>

<script type="text/javascript">

	var gallery_id = jQuery('#gallery_id').val();
	var startbtn = '<?php echo lang('gallery_start_label'); ?>';
	var cancelbtn = '<?php echo lang('gallery_delete_label'); ?>';

	var noimg = '<div class="no_data"><?php echo lang('gallery_no_slides_error'); ?></div>';

(function($){
	// Store data for filesUpload plugin
	$('#files-uploader form').data('fileUpload', {
		lang : {
			start : 'Start',
			cancel : 'Delete'
		}
	});

		// crop media
		$(".imgcrop").livequery(function(){
			$(this).colorbox({
				scrolling	: false,
				width		: '95%',
				height		: '95%',
				scrolling	: true,
				onComplete: function(){
					var form = $('form#files_crud'),
						$loading = $('#cboxLoadingOverlay, #cboxLoadingGraphic');
	
					$('#target').Jcrop({
						setSelect: [ 0, 0, <?php echo $max_width ?>, <?php echo $max_height ?> ],
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

					//$.colorbox.resize();

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

})(jQuery);

</script>
