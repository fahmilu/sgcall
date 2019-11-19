<?php
/**
 * Advertisement admin view - upload video form
 *
 * @package  	Advertisement
 * @subpackage	Admin_Views
 * @category  	Module
 */
?>
<h2><?php echo ( $this->method == 'edit' ? lang('galeria.video_edit_title') : lang('galeria.create_video_label') ); ?></h2>

<div id="frmResult"></div>

<?php echo form_open_multipart(uri_string(), array('class' => 'crud media_crud', 'id' => 'files_crud')); ?>

<fieldset>
	<ol>
		<input type="hidden" name="galeria_id" value="<?php echo $galeria_id; ?>" />

		<li class="even">
			<?php echo form_label(lang('galeria.youtube_link_label'), 'media'); ?>
			<?php if ($this->method == 'edit' && $media->extension <> 'yt'): ?>
				<?php echo form_textarea('media', $media->media, 'style="width: 35em; height: 3em;" disabled="disabled"'); ?><br />
			<?php else: ?>
				<?php echo form_textarea('media', $media->media, 'cols="40" rows="4" style="font-family: \'Courier New\', Courier, mono; width: 500px; height: 60px;"'); ?><br />
			<?php endif; ?>
			<textarea id="media_ori_id" name="media_ori" style="display: none;"><?php echo $media->media; ?></textarea>
		</li>

		<li>
			<label for="nothing"><?php echo lang('galeria.thumbnail_label'); ?></label>
			<?php echo form_upload('userfile'); ?> | <a href="#" id="getYTthumb"><?php echo lang('galeria.get_youtube_thumbnail'); ?></a>
		</li>

		<li>
		<label></label>
			<div id="checkingthumb" class="checkingthumb"><?php echo lang('galeria.checking_thumbnail');?></div>

			<div id="thumb" style="padding-left:160px;">

				<?php if (!empty($media->thumbnail)): ?>

					<?php if (substr($media->thumbnail, 0, 4) <> 'http'): ?>

						<img title="<?php echo $media->thumbnail; ?>" src="<?php echo '/'.UPLOAD_PATH.'galeria/'.$galeria_id.'/'. substr($media->thumbnail, 0, -4) . '_thumb' . substr($media->thumbnail, -4);?>" alt="<?php echo $media->thumbnail; ?>" />
						<br /><label class="normal"><input type="checkbox" name="imgremove" value="1"> <?php echo lang('galeria.remove_image_label');?></label>


					<?php else: ?>

						<img title="<?php echo $media->thumbnail; ?>" src="<?php echo $media->thumbnail;?>" alt="<?php echo $media->thumbnail; ?>" />
						<br /><label class="normal"><input type="checkbox" name="imgremove" value="1"> <?php echo lang('galeria.remove_image_label');?></label>


					<?php endif; ?>

				<?php else: ?>

					<?php echo image('icon-video_thumb.jpg', 'galeria', array('alt' => 'Video file - No Thumbnail')); ?><br />

				<?php endif; ?>

			</div>

			<div class="clear-both"></div>
			<div style="padding-left:160px;">
				<a href="#" style="display: none;" id="resettodefault"><?php echo lang('galeria.remove_image_label'); ?></a>
				<input type="hidden" name="youtube_thumb" value="<?php echo $media->thumbnail; ?>" id="thumburl">
				<div class="clear-both"><br /></div>
				<div class="float-left text-small1">[<?php echo lang('galeria.default_thumbnail_label'); ?>]</div>
			</div>

		</li>

		<li class="even">
			<?php echo form_label(lang('galeria.title_label'), 'title'); ?>
			<?php echo form_input('title', $media->title); ?>
		</li>
		<li>
			<?php echo form_label(lang('galeria.subtitle_label'), 'title'); ?>
			<?php echo form_input('subtitle', $media->subtitle); ?>
		</li>
		<li class="even">
			<?php echo form_label(lang('galeria.description_label'), 'description'); ?>
			<?php echo form_textarea(array(
				'name'	=> 'description',
				'id'	=> 'description',
				'value'	=> $media->description,
				'style' => 'width:60%',
				'rows'	=> '3',
				'cols'	=> '5'
			)); ?>
		</li>
		<li>
			<?php echo form_label(lang('galeria.meta_title_label'), 'meta_title'); ?>
			<?php echo form_input('meta_title', $media->meta_title); ?>
		</li>
		<li class="even">
			<?php echo form_label(lang('galeria.meta_keywords_label'), 'meta_keywords'); ?>
			<?php echo form_input('meta_keywords', $media->meta_keywords); ?>
		</li>
		<li>
			<?php echo form_label(lang('galeria.meta_description_label'), 'meta_description'); ?>
			<?php echo form_textarea(array(
				'name'	=> 'meta_description',
				'id'	=> 'meta_description',
				'value'	=> $media->meta_description,
				'style' => 'width:60%',
				'rows'	=> '3',
				'cols'	=> '5'
			)); ?>
		</li>
	</ol>

	<div class="align-right buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	</div>
</fieldset>
<?php echo form_close(); ?>

<script>
(function ($) {
	$(function () {

		form = $("form.crud");

		$('#getYTthumb').click(function(e){
			e.preventDefault();

			if (!$('textarea[name="media"]', form).val()) {
				alert('<?php echo lang('galeria.media_field_empty_msg');?>');
				$('textarea[name="media"]', form).focus();
				return false;
			}

			$('#thumb').fadeTo('slow', 0, function(){
				$('#checkingthumb').fadeIn('slow');
			});

			var jqxhr = $.post(SITE_URL + "admin/galeria/yt_thumbnail", {media: $('textarea[name="media"]', form).val()}, function(yt) {
				if (yt)
				{
					$('#thumb img').attr('src', yt);
					$('#thumburl').val(yt);
					$('#thumb img').load();
					$('#thumb label').remove();
				}
			})
			.success(function() {
					$('#checkingthumb').fadeOut('slow', function(){
						$('#resettodefault').fadeIn('fast');
						$('#thumb').fadeTo('fast', 1);
					});
			})
			.error(function() {
				$('#checkingthumb').fadeOut(function(){
					$('#checkingthumb').css('z-index', '-1');
					$('#thumb').fadeTo('slow', 1);
				});			
			 });

		});

		$('#resettodefault').click(function(e){
			e.preventDefault();
			var srcdef = '<?php echo image_path('icon-video_thumb.jpg', 'galeria', 'width="310"'); ?>';
			$('#thumburl').val('');
			$('#thumb img').fadeOut('slow', function(){
				$('#thumb img').attr('src', srcdef);
				$('#thumb img').load(function(){
					$('#thumb img').fadeTo('fast', 1);
				});
				$('#resettodefault').fadeOut('fast');
			});
		});

	})
})(jQuery);
</script>

