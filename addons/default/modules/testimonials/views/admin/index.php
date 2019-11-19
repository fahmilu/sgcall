<section class="title">
    <h4><?php echo lang('testimonials'); ?></h4>
</section>

<section class="item">
<div class="content">

    <?php echo form_open('admin/testimonials/actions'); ?>

    <?php if (!empty($testimonials)): ?>

        <table border="0" class="table-list testi-list">
            <thead>
                <tr>
                    <th width="30"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                    <th width="200"><?php echo lang('lbl_name'); ?></th>
                    <th width="140"><?php echo lang('lbl_photo'); ?></th>
                    <th width="300"><?php echo lang('lbl_message'); ?></th>
                    <th width="140"><?php echo lang('lbl_status'); ?></th>
                    <th width="140"><?php echo lang('lbl_created_on'); ?></th>
                    <th width="140"></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="7">
                        <div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($testimonials as $t): ?>
                    <tr>
                        <td class="action-to"><?php echo form_checkbox('action_to[]', $t->id); ?></td>
                        <td>
                            <?php echo $t->name; ?><br />
                            <strong><?php echo $t->occupation; ?></strong>    
                        </td>
                        <td><?php echo ($t->photo) ? '<img src="'.UPLOAD_PATH.'testimonial/'.$t->photo.'" style="width: 100px;" />' : '' ; ?></td>
                        <td><?php echo $t->message; ?></td>
                        <td><?php echo ($t->status == 1) ? 'Live' : 'Draft' ; ?></td>
                        <td><?php echo format_date($t->created_on) ?></td>
                        <td class="align-center buttons buttons-small">
                            <?php echo anchor('admin/testimonials/edit/' . $t->id, lang('global:edit'), 'class="btn blue"'); ?>
                            <?php echo anchor('admin/testimonials/delete/' . $t->id, lang('global:delete'), array('class' => 'confirm btn red delete')); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="table_action_buttons">
            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
        </div>

    <?php else: ?>
        <div class="blank-slate">
            <div class="no_data">
                <?php echo lang('msg_no_testimonials'); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php echo form_close(); ?>

</div>
</section>