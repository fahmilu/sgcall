<section class="title">
    <h4>Event Tags</h4>
</section>
<section class="item">
    <div class="content">
        <?php if(!empty($tags)): ?>
            <?php echo form_open('admin/event/tags/action', 'class="crud"') ?>
            <table border="0" class="table-list">
                <thead>
                    <tr>
                        <th><!-- <?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?> --></th>
                        <th>Tag</th>
                        <!-- <th class="width-5"><?php echo lang('event_published_label') ?></th> -->
                        <th class="width-10"><span>ACTION</span></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            <div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
                        </td>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach($tags as $c): ?>
                    <tr>
                        <td><!-- <?php echo form_checkbox('action_to[]', $c->id) ?> --></td>
                        <td><?php echo ucwords($c->tag); ?></td>
                        <!-- <td><?php echo $c->published; ?></td> -->
                        <td class="buttons buttons-small">
                            <?php echo anchor('admin/event/delete_tag/'.$c->id, 'DELETE', 'rel="ajax" class="btn red edit button confirm"'); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
<!--             <div class="table_action_buttons">
            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
            </div> -->
            <?php echo form_close(); ?>
        <?php else: ?>
            <div class="no_data">
                <?php echo lang('event_no_tags');?>
            </div>
        <?php endif; ?>
    </div>
</section>