<section class="title">
	<h4><?php echo lang('banner_upload_label'); ?></h4>
</section>

<section class="item">
<div class="content">

<?php echo form_open_multipart(uri_string(), array('class' => 'crud', 'id' => 'files_crud')); ?>

<div id="upload" class="form_inputs">
<fieldset>
	<ul>
        <li class="even">
            <label for="published"><?php echo lang('banner_published_label'); ?></label>
            <div class="input">
                <?php echo form_dropdown('published', $publish_options, $slide->published); ?>
            </div>
        </li>
        <li>
            <label for="category_id"><?php echo lang('banner_category_label'); ?></label>
            <div class="input">
                <?php echo form_dropdown('category_id', $category_options, $slide->category_id); ?>
            </div>
        </li>
		<li>
			<label><?php echo lang('banner_title_label'); ?></label>
			<div class="input">
				<?php echo form_input('title', $slide->title, ' id="slidetitle"'); ?>
			</div>
		</li>

		<li>
			<label><?php echo lang('banner_current_image_label'); ?></label>
			<div class="input">
				<div id="slidethumb">
				<?php if (!empty($slide->filename)): ?>
					<?php $path = 'banner/'; ?>
					<img title="<?php echo $slide->filename; ?>" src="<?php echo base_url(UPLOAD_PATH.$path. $slide->filename);?>" alt="<?php echo $slide->filename; ?>" id="imgthumb" style="margin-bottom:10px; height: 200px;" />
					<input type="hidden" name="curfile" value="<?php echo $slide->filename; ?>" />
				<?php else: ?>
					<span class="no-image"><?php echo lang('banner_no_image_yet') ?></span>
                    <img src="#" style="display:none;margin-bottom:10px; height: 200px;" id="imgthumb" />
				<?php endif; ?>
				</div>
			</div>
		</li>

		<li>
			<label>Banner<small><?php echo sprintf(lang('banner_image_dimension_label'), $this->settings->banner_width, $this->settings->banner_height); ?></small></label>
			<div class="input">
				<?php echo form_upload('top_image', '', 'id="pic"'); ?>
				<div style="display:inline; padding-top:10px; padding-left:10px; margin:0; height: 40px; line-height:40px; vertical-align:middle;">
				</div>
			</div>
		</li>

		<li>
			<label><?php echo lang('banner_caption_label'); ?></label>
			<div class="input">
				<textarea id="slidebody" name="body" rows="3" cols="25" class="skip" style="width:600px;height:100px;"><?php echo $slide->body; ?></textarea>
				<?php //echo form_textarea('body', $slide->body); ?>
			</div>
		</li>

		<li>
			<label for="slideurl"><?php echo lang('banner_url_label'); ?></label>
			<div class="input">
				<?php echo form_input('url', $slide->url, ' id="slideurl"'); ?>
			</div>
		</li>


		<li>
			<label for="slideurl"><?php echo lang('banner_url_name'); ?></label>
			<div class="input">
				<?php echo form_input('url_name', $slide->url_name, ' id="slideurl"'); ?>
			</div>
		</li>

	</ul>

	</fieldset>

	<fieldset>
		<legend> For internal use </legend>
		<ul>
			<li>
				<label for="slidecredit"><?php echo lang('banner_credit_label'); ?></label>
				<div class="input">
					<?php echo form_input('credit', $slide->credit, ' id="slidecredit"'); ?>
				</div>
			</li>

			<li>
				<label for="slidedescription"><?php echo lang('banner_description_label'); ?></label>
				<div class="input">
					<textarea id="slidedescription" name="description" rows="3" cols="25" class="skip" style="width:600px;height:100px;"><?php echo $slide->description; ?></textarea>
					<?php //echo form_textarea('body', $slide->body); ?>
				</div>
			</li>
		</ul>

	<div class="align-right buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )); ?>
	</div>
</fieldset>
</div>

<?php echo form_close(); ?>

</div>
</section>
<script>
    $(document).ready(function() {
        $("#pic").change(function(){
            readURL(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('#imgthumb').attr('src', e.target.result);
                    $('#imgthumb').css('display', 'block');
                    $('.no-image').css('display', 'none');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    });
</script>