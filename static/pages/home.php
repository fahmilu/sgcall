<link rel="stylesheet" media="all" href="assets/css/pages/home.css" />
<section id="HomeBanner">
	<div class="left-container">
		<h1>Towards a more sustainable cotton market</h1>
		<p>The Sustainable Cotton Ranking 2017 gives you insight in how 75 companies from all continents score on their policy, traceability and actual uptake of sustainable cotton. The ranking highlights opportunities for improvement in order to accelerate transformation of the cotton market towards sustainability.</p>
		<a href="" class="button">CHECK OUT HOW COMPANIES SCORED</a>
	</div>
	<div class="right-container" style="background: url(assets/img/banner.jpg);"></div>
</section>
<section id="CompanyList">
	<div class="container">
		<h3>See how over 37 companies scored</h3>
		<div class="row">
			<?php 
			$type = array(	1 => 'leading-the-way',
							2 => 'well-on-the-way',
							3 => 'starting-the-journey',
							4 => 'not-yet-in-the-starting-blocks',
			); 

			$company = array( 	0 => 'IKEA Group',
								1 => 'C&A GlobaL',
								2 => 'H&M Group',
								3 => 'Adidas Group',
								4 => 'Nike, Inc.',
								5 => 'Marks & Spencer',
								6 => 'VF Corporation',
								7 => 'kering',
								8 => 'associated british food',
								9 => 'hanesbrands.inc',
								10 => 'casino group',
								11 => 'china resources enterprise Ltd.',
			);
			for ($i=0; $i < 12; $i++){ ?>
			<div class="col-xs-3">
				<a href="" class="<?php echo $type[rand(1,4)]; ?>">
					<div class="company"><?php echo $company[$i]; ?></div>
					<div class="score count">12.00</div>
					<div class="bottom">view profile</div>
				</a>
			</div>
			<?php } ?>
		</div>
		<a href="" class="button">SEE MORE COMPANIES</a>
	</div>
	<div id="Legends" class="slide-down">
		<div class="content">
			<a href="#" class="show-btn">SEE WHAT THE COLORS MEAN</a>
			<div class="container">		
				<ul class="legends-list">				
					<li class="leading-the-way"><i></i>Leading the way</li>
					<li class="well-on-the-way"><i></i>Well on the way</li>
					<li class="starting-the-journey"><i></i>Starting the journey</li>
					<li class="not-yet-in-the-starting-blocks"><i></i>Not yet in the starting blocks</li>
				</ul>	
			</div>
			<a href="#" class="hide-btn">HIDE COLOR LEGENDS</a>
		</div>
	</div>
</section>
<script type="text/javascript" src="assets/js/home.js"></script>
