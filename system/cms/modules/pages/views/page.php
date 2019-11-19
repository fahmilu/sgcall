		<?php
			if (AUTO_LANGUAGE=='en' && !empty($page->body_en))
			{
				//echo '<h2>'.($page->title_en ? $page->title_en : $page->title).'</h2>'.PHP_EOL;
				echo $page->body_en ? $page->body_en : $page->body; //$page->layout->body_en;
			}
			else
			{
				//echo '<h2>'.$page->title.'</h2>'.PHP_EOL;
				echo $page->body; //$page->layout->body; //
			}

			if (!empty($pg_title))
				$page->title = 'xxx '.$pg_title;

		?>

		<?php //echo ($_SESSION['lang_code']=='en' && $page->layout->body_en) ? $page->layout->body_en : $page->layout->body; ?>

		<?php if (Settings::get('enable_comments') and $page->comments_enabled): ?>

		<div id="comments">
	
			<div id="existing-comments">
		
			<h4><?php echo lang('comments:title') ?></h4>

			<?php echo $this->comments->display() ?>

		</div>

		<?php echo $this->comments->form() ?>

		<?php endif ?>

