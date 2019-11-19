<section class="title">
    <h4><?php echo lang('faq_create_title'); ?></h4>
</section>
<section class="item">
    <div class="content">
        <?php echo form_open_multipart('admin/faq/create', 'id="faq" class="crud"'); ?>
        <div class="form_inputs">
            <fieldset>
                <ul>
                    <li class="even">
                        <label for="published"><?php echo lang('faq_published_label'); ?></label>
                        <div class="input">
                            <?php echo form_dropdown('published', $publish_options, set_value('published')); ?>
                        </div>
                    </li>
                    <li>
                        <label for="category_id"><?php echo lang('faq_category_label'); ?></label>
                        <div class="input">
                            <?php echo form_dropdown('category_id', $category_options, set_value('category_id')); ?>
                        </div>
                    </li>
                    <li>
                        <label for="question"><?php echo lang('faq_question_label'); ?><span>*</span></label>
                        <div class="input">
                            <input type="text" id="question" name="question" style="width:60%;" value="<?php echo set_value('question'); ?>">
                        </div>
                    </li>
                    <li>
                        <label for="answer"><?php echo lang('faq_answer_label'); ?></label><br style="clear: both;"/>
                        <textarea name="answer" rows="15" style="width:80%;" id="answer" class="wysiwyg-simple"><?php echo set_value('answer'); ?></textarea>
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
