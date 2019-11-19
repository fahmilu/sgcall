<section class="title">
    <h4><?php echo lang('promo'); ?></h4>
</section>

<section class="item">
<div class="content">

    <?php echo form_open('admin/promo/actions'); ?>

    <?php if (!empty($promo)): ?>

        <table border="0" class="table-list">
            <thead>
                <tr>
                    <th width="30"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                    <th width="200"><?php echo lang('lbl_title'); ?></th>
                    <th width="140"><?php echo lang('lbl_photo'); ?></th>
                    <th width="300"><?php echo lang('lbl_description'); ?></th>
                    <th width="100"><?php echo lang('lbl_price'); ?></th>
                    <th width="100"><?php echo lang('lbl_status'); ?></th>
                    <th width="140"><?php echo lang('lbl_created_on'); ?></th>
                    <th width="140"></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="8">
                        <div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($promo as $t): ?>
                    <tr>
                        <td><?php echo form_checkbox('action_to[]', $t->id); ?></td>
                        <td><strong><a href="<?php echo $t->link; ?>" target="_blank"><?php echo $t->title; ?></a></strong></td>
                        <td><?php echo ($t->photo) ? '<img src="'.UPLOAD_PATH.'promo/'.$t->photo.'" style="width: 200px;" />' : '' ; ?></td>
                        <td><?php echo $t->description; ?></td>
                        <td><?php echo $t->price; ?></td>
                        <td><?php echo ($t->status == 1) ? 'Live' : 'Draft' ; ?></td>
                        <td><?php echo date('M d, Y', $t->created_on) ?></td>
                        <td class="align-center buttons buttons-small">
                            <?php echo anchor('admin/promo/edit/' . $t->id, lang('global:edit'), 'class="btn blue"'); ?>
                            <?php echo anchor('admin/promo/delete/' . $t->id, lang('global:delete'), array('class' => 'confirm btn red delete')); ?>
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
                <?php echo lang('msg_no_promo'); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php echo form_close(); ?>

</div>
</section>