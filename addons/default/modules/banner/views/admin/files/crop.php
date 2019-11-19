<?php
/**
 * Advertisement admin view - crop form
 *
 * @package  	Advertisement
 * @subpackage	Admin_Views
 * @category  	Module
 */
?>
<style>
.jcrop-holder { text-align: left; }

.jcrop-vline, .jcrop-hline
{
	font-size: 0px;
	position: absolute;
	background: white url('Jcrop.gif') top left repeat;
}
.jcrop-vline { height: 100%; width: 1px !important; }
.jcrop-hline { width: 100%; height: 1px !important; }
.jcrop-vline.right { right: 0px; }
.jcrop-hline.bottom { bottom: 0px; }
.jcrop-handle {
	font-size: 1px;
	width: 7px !important;
	height: 7px !important;
	border: 1px #eee solid;
	background-color: #333;
}

.jcrop-tracker { width: 100%; height: 100%; }

.custom .jcrop-vline,
.custom .jcrop-hline
{
	background: yellow;
}
.custom .jcrop-handle
{
	border-color: black;
	background-color: #C7BB00;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
}
</style>

<h2><?php echo $media->filename;?></h2>

<?php echo form_open_multipart(uri_string(), array('class' => 'media_crud crud', 'id' => 'files_cruds')); ?>
<fieldset>
	<ol>
		<li class="even">
			<img id="target" title="<?php echo $media->title; ?>" src="<?php echo '/'.UPLOAD_PATH.'slideshow/'.$media->filename;?>" alt="<?php echo $media->filename; ?>" />
		</li>
		<li class="even" style="display: block;">
			<input type="hidden" size="4" id="x1" name="thumb_x" />
			<input type="hidden" size="4" id="y1" name="thumb_y" />
			<input type="hidden" size="4" id="x2" name="scaled_width" />
			<input type="hidden" size="4" id="y2" name="scaled_height" />
			<input type="hidden" size="4" id="w" name="thumb_width" />
			<input type="hidden" size="4" id="h" name="thumb_height" />

		</li>
	</ol>

	<div class="align-right buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )); ?>
	</div>
</fieldset>
<?php echo form_close(); ?>

