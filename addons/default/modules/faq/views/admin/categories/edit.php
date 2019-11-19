<section class="title">
    <h4><?php echo lang('faq_category_edit_title'); ?></h4>
</section>
<section class="item">
    <div class="content">
        <?php echo form_open('admin/faq/categories/edit/'.$category->id, 'id="categories" class="crud"'); ?>
        <div class="form_inputs">
            <fieldset>
                <ul>
                    <li>
                      <div class="one_third">
                        <label for="title"><?php echo lang('faq_category_label'); ?><span class="required-icon tooltip">*</span></label>
                        <div class="input">
                            <input name="title" type="text" value="<?php echo $category->title; ?>" />
                        </div>
                      </div>
                      <div style="clear:both;"></div>
                    </li>
                    <li class="even">
                        <label for="published"><?php echo lang('faq_published_label'); ?></label>
                        <div class="input">
                            <?php echo form_dropdown('published', $publish_options, $category->published); ?>
                        <div class="input">
                    </li>
                    <!--
                    <li>
                        <div class="one_half">
                          <label for="description"><?php echo lang('faq_category_description_label'); ?> (IND)</label>
                          <textarea name="description" rows="5" cols="80" style="width: 90%;"><?php echo $category->description; ?></textarea>
                        </div>
                        <div class="one_half">
                          <label for="description_en"><?php echo lang('faq_category_description_label'); ?> (ENG)</label>
                          <textarea name="description_en" rows="5" cols="80" style="width: 90%;"><?php echo $category->description_en; ?></textarea>
                        </div>
                        <div style="clear:both;"></div>
                    </li>
                  -->
                </ul>
            </fieldset>
        </div>
        <input type="hidden" name="category_id" value="<?php echo $category->id; ?>" />
        <div class="buttons">
        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</section>
