<h2 class="page-title" id="page_title"><?php echo lang('user:register_header') ?></h2>

<?php if ( ! empty($error_string)):?>
<!-- Woops... -->
<div class="error-box">
	<?php echo $error_string;?>
</div>
<?php endif;?>

<?php echo form_open('register', array('id' => 'register')) ?>
<ul>
	
	<li>
		<label for="name">Nama Sesuai KTP</label>
		<input type="text" name="name" maxlength="100" value="<?php echo $_user->name ?>" />
	</li>	
	<li>
		<label for="tix_id">Tix ID</label>
		<input type="text" name="tix_id" maxlength="100" value="<?php echo $_user->tix_id ?>" />
	</li>
	
	<li>
		<label for="email"><?php echo lang('global:email') ?></label>
		<input type="text" name="email" maxlength="100" value="<?php echo $_user->email ?>" />
		<?php echo form_input('d0ntf1llth1s1n', ' ', 'class="default-form" style="display:none"') ?>
	</li>	

	<li>
		<label for="phone">Phone</label>
		<input type="number" name="phone" value="<?php echo $_user->phone ?>" />
	</li>
	
	<li>
		<label for="password"><?php echo lang('global:password') ?></label>
		<input type="password" name="password" maxlength="100" />
	</li>	
	<li>
		<label for="re-password">Re Password</label>
		<input type="password" name="re-password" maxlength="100" />
	</li>
	
	<li>
		<?php echo form_submit('btnSubmit', lang('user:register_btn')) ?>
	</li>
</ul>
<?php echo form_close() ?>