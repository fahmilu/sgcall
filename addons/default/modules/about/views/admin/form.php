<section class="item">
<div class="content">

<div id="maincontactform" class="form_inputs">
    <?php echo form_open_multipart(uri_string().'/save', array('id' => 'event-form')) ?>
    <fieldset>
    	<ul>
            <li><label>Content<span>*</span></label>
                <textarea name="content" rows="50" cols="200" id="content" class="wysiwyg-advanced"><?php echo @$data->content; ?></textarea>
            </li>
            <br />
    	</ul>

            <div class="clear"></div>

    	<div class="align-right buttons">
            <button type="submit" name="btnAction" value="save" class="btn blue">
                <span>Update About</span>
            </button>
    	</div>

    <!--
            <a href="#" class="button" id="buttonsend" ><span><?php echo lang('btn_send') ?></span></a>
            <span class="loading" style="display: none"><?php echo lang('lbl_ajax_process') ?></span>
    -->

        <?php echo form_close() ?>
    </fieldset>
</div>
</section>