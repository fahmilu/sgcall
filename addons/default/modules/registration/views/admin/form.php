<link rel="stylesheet" href="<?= site_url() ?>bootstrap/css/bootstrap.css"/>
<link rel="stylesheet" href="<?= site_url() ?>bootstrap/vendor/bootstrap-fileinput/css/fileinput.min.css"/>
<section class="title">
	<!-- We'll use $this->method to switch between address.create & address.edit -->
	<h4><?php echo lang(''.$this->method); ?></h4>
</section>

<section class="item">

	<div class="content">
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>

			<div class="row">
				<div class="col-xs-12 col-sm-3">
					<div class="form-group">
						<label for="phone"><?php echo lang('phone'); ?></label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-phone"></i></span>
							<?php echo form_input('phone', set_value('phone', $address->phone), 'class="form-control"'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="fax"><?php echo lang('fax'); ?></label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-print"></i></span>
							<?php echo form_input('fax', set_value('fax', $address->fax), 'class="form-control"'); ?>
						</div>
					</div>
					<hr/>
					<div class="form-group">
						<label for="latitude"><?php echo lang('latitude'); ?></label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
							<?php echo form_input('latitude', set_value('latitude', $address->latitude), 'class="form-control"'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="longitude"><?php echo lang('longitude'); ?></label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
							<?php echo form_input('longitude', set_value('longitude', $address->longitude), 'class="form-control"'); ?>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-9">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group">
							<label for="address"><?php echo lang('title'); ?></label>
							<?php echo form_input('title', set_value('title', $address->title), 'class="form-control"'); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group <?php echo alternator('', 'even'); ?>">
								<label for="description"><?php echo lang('description'); ?> <span>*</span></label>
								<?php echo form_textarea('description', set_value('description', $address->description), 'class="form-control wysiwyg-simple"'); ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="form-group <?php echo alternator('', 'even'); ?>">
								<label for="address"><?php echo lang('address'); ?> <span>*</span></label>
								<?php echo form_textarea('address', set_value('address', $address->address), 'class="form-control wysiwyg-advanced"'); ?>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="buttons">
								<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )); ?>
							</div>
						</div>
					</div>
				</div>
			</div>

		<?php echo form_close(); ?>
	</div>
</section>
<script type="text/javascript" src="<?= site_url() ?>bootstrap/vendor/bootstrap-fileinput/js/fileinput.min.js"></script>
