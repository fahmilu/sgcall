<section class="title">
    <h4><?php echo lang('lbl_pending'); ?></h4>
</section>

<section class="item">
<div class="content">

    <?php echo form_open('admin/speakers/actions'); ?>

    <?php if (!empty($speakers)): ?>

        <table border="0" class="table-list">
            <thead>
                <tr>
                    <th width="30"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                    <th><?php echo lang('lbl_name'); ?></th>
                    <th width="140"><?php echo lang('lbl_email'); ?></th>
                    <th width="140"><?php echo lang('lbl_website'); ?></th>
                    <th width="140"><?php echo lang('lbl_company'); ?></th>
                    <th width="140"><?php echo lang('lbl_created_on'); ?></th>
                    <th width="300"></th>
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
                <?php foreach ($speakers as $t): ?>
                    <tr>
                        <td><?php echo form_checkbox('action_to[]', $t->id); ?></td>
                        <td><?php echo $t->name; ?></td>
                        <td><?php echo ($t->photo) ? '<img src="'.UPLOAD_PATH.'speaker/'.$t->photo.'" style="width: 100px;" />' : '' ; ?></td>
                        <td><?php echo $t->role; ?></td>
                        <td><?php echo format_date($t->created_on) ?></td>
                        <td class="align-center buttons buttons-small">
                            <?php echo anchor('admin/speakers/preview/' . $t->id, lang('btn_preview'), 'rel="modal-large" class="iframe btn green" target="_blank"'); ?>
                            <?php echo anchor('admin/speakers/approve/' . $t->id, lang('btn_approve'), 'class="btn blue confirm" title="Are you sure you want to approve this speaker?"'); ?>
                            <?php echo anchor('admin/speakers/delete/' . $t->id, lang('global:delete'), array('class' => 'confirm btn red')); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="table_action_buttons">
            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete', 'approve'))); ?>
        </div>

    <?php else: ?>
        <div class="blank-slate">
            <div class="no_data">
                <?php echo lang('msg_no_pending_speaker'); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php echo form_close(); ?>

</div>
</section>