<?php
/**
 * Advertisement admin view - upload image form
 *
 * @package  	Advertisement
 * @subpackage	Admin_Views
 * @category  	Module
 */
?>
<?php if($media->galeria_id): ?>
 <h2><?php echo lang('galeria.media_edit_label'); ?> - <?php echo $media->media;?></h2>
<?php else: ?>
 <h2><?php echo "Upload" ?> - Media</h2>
<?php endif; ?> 

<?php echo form_open_multipart(uri_string(), array('class' => 'media_crud crud', 'id' => 'files_crud')); ?>
<fieldset>
	<ol>

		<?php //if($media->galeria_id): ?>
		<li class="even">
		<label></label>
			<?php if (in_array(strtolower(trim($media->extension,'.')), $this->format_videos)): ?>
				<?php if ($media->thumbnail): ?>
					<img title="<?php echo $media->thumbnail; ?>" src="<?php echo '/'.UPLOAD_PATH.'galeria/'.$media->galeria_id.'/'. substr($media->thumbnail, 0, -4) . '_thumb' . substr($media->thumbnail, -4);?>" alt="<?php echo $media->thumbnail; ?>" />
				<?php else: ?>
					<?php echo image('icon-video_thumb.jpg', 'galeria', array('alt' => 'Video file - No Thumbnail')); ?>
				<?php endif; ?>
			<?php else: ?>
				<img title="<?php echo $media->media; ?>" src="<?php echo '/'.UPLOAD_PATH.'galeria/'.$media->galeria_id.'/'. substr($media->media, 0, -4) . '_thumb' . substr($media->media, -4);?>" alt="<?php echo $media->media; ?>" />
			<?php endif; ?>
		</li>
		<?php //else: ?>
		<li class="even">
			<label for="nothing"><?php echo lang('gallery_images.upload_label'); ?></label>
			<?php echo form_upload('userfile'); ?>
		</li>
		<?php //endif; ?>

		<?php if ($media->extension == 'yt'): ?>
		<li>
			<?php echo form_label(lang('galeria.youtube_link_label'), 'media'); ?>
			<?php echo form_input('media', $media->media); ?>
		</li>
		<?php endif; ?>

		<li>
			<?php echo form_label(lang('galeria.title_label'), 'title'); ?>
			<?php echo form_input('title', $media->title); ?>
		</li>
		<li class="even">
			<?php echo form_label(lang('galeria.subtitle_label'), 'title'); ?>
			<?php echo form_input('subtitle', $media->subtitle); ?>
		</li>
		<li>
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
		<li class="even">
			<?php echo form_label(lang('galeria.meta_title_label'), 'meta_title'); ?>
			<?php echo form_input('meta_title', $media->meta_title); ?>
		</li>
		<li>
			<?php echo form_label(lang('galeria.meta_keywords_label'), 'meta_keywords'); ?>
			<?php echo form_input('meta_keywords', $media->meta_keywords); ?>
		</li>
		<li class="even">
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