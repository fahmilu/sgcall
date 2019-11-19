<?php
/**
 * Advertisement admin view - view to display newly uploaded images
 *
 * @package  	Advertisement
 * @subpackage	Admin_Views
 * @category  	Module
 */
?>
<!-- newly uploaded images -->
<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * views/admin/files/contents.php
 *
 * Contents view file, used when displaying newly uploaded files or
 * attached file images
 *
 * @version 1.0
 * @package galeria
 *
 */
?>
	<?php if (!empty($files)): ?>

    <?php foreach($files as $file): ?>
        <li class="ui-corner-all">
            <div class="actions">
        	<?php echo form_checkbox('imgid[]', $file->id); ?>
			<?php
				if (!in_array(strtolower(trim($file->extension,'.')), $this->format_videos))
				{
					echo anchor('admin/galeria/crop/'.$file->id, lang('galeria.crop_label'), 'class="imgcrop"' ) . ' | ';
				}

				echo anchor( (in_array(strtolower(trim($file->extension,'.')), $this->format_videos) ? 'admin/galeria/editvideo/' : 'admin/galeria/editmedia/') .$file->id, lang('buttons.edit'), 'class="no-edit"' );

				if (group_has_role('galeria', 'delete_image')) 
				{
					echo ' |'. anchor('admin/galeria/deletemedia', lang('buttons.delete'), 'class="imgdel"' );
				}
			?>
            </div>

		<?php if ((trim($file->extension,'.') == 'yt')): ?>

			<?php if ($file->thumbnail): ?>

					<?php if (substr($file->thumbnail, 0, 4) <> 'http'): ?>
				        <a title="<?php echo $file->thumbnail; ?>" href="<?php echo '/'.UPLOAD_PATH .'galeria/'.$gallery->id.'/'. $file->thumbnail; ?>" rel="cb_0" class="modal">
						<img title="<?php echo $file->thumbnail; ?>" src="<?php echo '/'.UPLOAD_PATH.'galeria/'.$gallery->id.'/'. substr($file->thumbnail, 0, -4) . '_thumb' . substr($file->thumbnail, -4);?>" alt="<?php echo $file->thumbnail; ?>" />
					<?php else: ?>
				        <a title="<?php echo $file->thumbnail; ?>" href="<?php echo str_ireplace('default.jpg', 'hqdefault.jpg', $file->thumbnail); ?>" rel="cb_0" class="modal">
						<img title="<?php echo $file->thumbnail; ?>" src="<?php echo $file->thumbnail;?>" alt="<?php echo $file->thumbnail; ?>" />
					<?php endif; ?>

			<?php else: ?>

		        <a title="<?php echo $file->title; ?>" href="<?php echo image_path('icon-video.jpg', 'galeria'); ?>" rel="cb_0" class="modal">
				<?php echo image('icon-video_thumb.jpg', 'galeria', array('alt' => 'Video file - No Thumbnail')); ?>

			<?php endif; ?>

		<?php elseif (in_array(strtolower(trim($file->extension,'.')), $this->format_videos)): ?>

			<?php if ($file->thumbnail): ?>

		        <a title="<?php echo $file->thumbnail; ?>" href="<?php echo '/'.UPLOAD_PATH .'galeria/'.$gallery->id.'/'. $file->thumbnail; ?>" rel="cb_0" class="modal">
	            <img title="<?php echo $file->title; ?>" src="<?php echo '/'.UPLOAD_PATH.'galeria/'.$gallery->id.'/'. substr($file->thumbnail, 0, -4) . '_thumb' . substr($file->thumbnail, -4);?>" alt="<?php echo $file->thumbnail; ?>" />

			<?php else: ?>

		        <a title="<?php echo $file->title; ?>" href="<?php echo image_path('icon-video.jpg', 'galeria'); ?>" rel="cb_0" class="modal">
				<?php echo image('icon-video_thumb.jpg', 'galeria', array('alt' => 'Video file - No Thumbnail')); ?>

			<?php endif; ?>

		<?php else: ?>
			<?
				$filename = $file->media;
				$ext = substr(strrchr($filename, "."), 1);
				$fn = str_ireplace('.'.$ext, '', $filename);
				$fullfile = ( file_exists(UPLOAD_PATH .'galeria/'.$gallery->id.'/'. $fn . '_full.' . $ext) ? $fn . '_full.' . $ext : $filename );
				$thumbfile = $fn . '_thumb.' . $ext;
				$smallfile = $fn . '_small.' . $ext;
				$medfile = $fn . '_med.' . $ext;
			?>
	        <a title="<?php echo $file->title; ?>" href="<?php echo '/'.UPLOAD_PATH .'galeria/'.$gallery->id.'/'. $fullfile; ?>" rel="cb_0" class="modal">
            <img title="<?php echo $file->title; ?>" src="<?php echo '/'.UPLOAD_PATH.'galeria/'.$gallery->id.'/'. $thumbfile;?>" alt="<?php echo $file->media; ?>" />
		<?php endif; ?>
        </a>
				
<!--         <div style="font-size: 0.90em;padding:5px 0 0 9px; border-top: 1px solid #ccc;"> -->
        <div style="font-size: 0.90em;padding:5px 0 0 9px;">
        	<p><?php echo ($file->title ? $file->title : '[no title]'); ?><br />
        	<?php echo ($file->subtitle ? $file->subtitle : '[no subtitle]'); ?></p>
        	<?php echo ($file->description ? $file->description : '[no description]'); ?></p>
        </div>
        <input type="hidden" name="img_media_id[]" value="<?php echo $file->id; ?>" />
        </li>
    <?php endforeach; ?>

<?php else: ?>
	<li style="list-style-type: none;">
	<div class="blank-slate">	
		<h2><?php echo lang('galeria.no_media_error'); ?></h2>
	</div>
	</li>

<?php endif; ?>
