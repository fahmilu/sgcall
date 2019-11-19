<section class="title">
    <h4><?php echo lang('gallery_category_create_title'); ?></h4>
</section>
<section class="item">
    <div class="content">
        <?php echo form_open('admin/gallery/category/create', 'id="category" class="crud"'); ?>
        <div class="form_inputs">
            <fieldset>
                <ul>
                    <li>
                        <div class="one_third">
                          <label for="title"><?php echo lang('gallery_category_label'); ?><span class="required-icon tooltip">*</span></label>
                          <div class="input">
                              <input name="title" type="text" value="<?php echo set_value('title'); ?>" />
                          </div>
                        </div>
                        <div style="clear:both;"></div>
                    </li>
                    <li class="even">
                        <label for="published"><?php echo lang('gallery_published_label'); ?></label>
                        <div class="input">
                            <?php echo form_dropdown('published', $publish_options, set_value('published')); ?>
                        </div>
                    </li>
                </ul>
            </fieldset>
        </div>
        <div class="buttons">
        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</section>
