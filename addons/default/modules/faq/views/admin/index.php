<section class="title">
	<h4><?php echo lang('faq_index_title'); ?></h4>
</section>
<section class="item">
    <div class="content">
        <fieldset id="filters">
            <legend><?php echo lang('global:filters'); ?></legend>

            <?php echo form_open('admin/faq/filterbycategory', array('method' => 'post')); ?>
                <ul>
                    <li>
                        <label for="">Category</label>
                        <?php echo form_dropdown('category', array(0 => lang('global:select-all')) + $category_options_without_no, $this->session->userdata('category')); ?>
                        <button style="vertical-align:top;position:relative;top:0px;" class="btn green" type="submit">Filter</button>
                    </li>
                </ul>
            <?php echo form_close(); ?>
        </fieldset>
        <?php if(!empty($faq)): ?>
            <?php echo form_open('admin/faq/action', 'class="crud"') ?>
            <table border="0" class="table-list faq-list">
                <thead>
                        <tr>
                                <th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
                                <th width="300"><?php echo lang('faq_question_label') ?></th>
                                <th width="400"><?php echo lang('faq_answer_label') ?></th>
                                <th><?php echo lang('faq_category_label') ?></th>
                                <th class="width-5"><?php echo lang('faq_published_label') ?></th>
                                <th class="width-10"><span><?php echo lang('faq_actions_label');?></span></th>
                        </tr>
                </thead>
                <tfoot>
                        <tr>
                                <td colspan="6">
                                    <div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
                                </td>
                        </tr>
                </tfoot>
                <tbody>
                    <?php foreach($faq as $f): ?>
                    <tr>
                        <td class="action-to"><?php echo form_checkbox('action_to[]', $f->id) ?></td>
                        <td><?php echo $f->question; ?></td>
                        <td><?php echo $f->answer; ?></td>
                        <td><?php echo $category_options[$f->category_id]; ?></td>
                        <td><?php if($f->published == 'yes') echo 'Live'; else echo 'Draft'; ?></td>
                        <td class="buttons buttons-small">
                            <?php echo anchor('admin/faq/edit/'.$f->id, lang('faq_edit_link'), 'rel="ajax" class="btn orange edit button"'); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="table_action_buttons">
                <?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
            </div>
            <?php echo form_close(); ?>
        <?php else: ?>
            <div class="no_data">
                <?php echo lang('faq_no_questions');?>
            </div>
        <?php endif; ?>
    </div>
</section>
