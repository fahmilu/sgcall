<link rel="stylesheet" media="all" href="assets/css/pages/checkscore.css" />
<section id="CottonRanking">
	<div class="container">
		<h3>Sustainable Cotton Ranking 2017</h3>
		<div class="flex-row">		
			<div class="col-md-3">
				<div class="content">
				<div class="header-table">
					<div class="dropdown cotton">
			    		<button class="dropdown-toggle" type="button" data-toggle="dropdown">Select a year
			    		<span class="caret"></span></button>
				    	<ul class="dropdown-menu select-year">
				      		<li>2015</li>
				      		<li>2016</li>
				      		<li>2017</li>
				    	</ul>
			  		</div>			
				</div>
				<div class="body-table">
					<a href="" class="download">
						<span>download THE report</span>
					</a>
					<a href="#WhatResultShow" class="page-scroll see-analysis">
						<span>see our analysis</span>
					</a>
					<div class="max-score">
						<strong>MAXIMUM SCORE</strong>
						<div class="table">
							<div class="policy">Policy<span class="pull-right">3.50</span></div>
							<div class="uptake">Uptake<span class="pull-right">11.50</span></div>
							<div class="tracebility">Tracebility<span class="pull-right">5.00</span></div>
							<div class="total-score">TOTAL SCORE<span class="pull-right">20.00</span></div>
						</div>
						<strong>COLOR</strong>
						<ul class="legends-list">				
							<li class="leading-the-way"><i></i>Leading the way</li>
							<li class="well-on-the-way"><i></i>Well on the way</li>
							<li class="starting-the-journey"><i></i>Starting the journey</li>
							<li class="not-yet-in-the-starting-blocks"><i></i>Not yet in the starting blocks</li>
						</ul>					
					</div>
				</div>				
				</div>
			</div>
			<div class="col-md-8">
				<div class="header-table">
					<div class="td-1">
						<div class="dropdown cotton">
				    		<button class="dropdown-toggle" type="button" data-toggle="dropdown">Company Name
				    		<span class="caret"></span></button>
					    	<ul class="dropdown-menu select-year">
					      		<li>2015</li>
					      		<li>2016</li>
					      		<li>2017</li>
					    	</ul>
				  		</div>						
					</div>
					<div class="td-2">
						<div class="dropdown cotton">
				    		<button class="dropdown-toggle" type="button" data-toggle="dropdown">Policy
				    		<span class="caret"></span></button>
					    	<ul class="dropdown-menu select-year">
					      		<li>2015</li>
					      		<li>2016</li>
					      		<li>2017</li>
					    	</ul>
				  		</div>						
					</div>
					<div class="td-3">
						<div class="dropdown cotton">
				    		<button class="dropdown-toggle" type="button" data-toggle="dropdown">Uptake
				    		<span class="caret"></span></button>
					    	<ul class="dropdown-menu select-year">
					      		<li>2015</li>
					      		<li>2016</li>
					      		<li>2017</li>
					    	</ul>
				  		</div>						
					</div>
					<div class="td-4">
						<div class="dropdown cotton">
				    		<button class="dropdown-toggle" type="button" data-toggle="dropdown">Traceability
				    		<span class="caret"></span></button>
					    	<ul class="dropdown-menu select-year">
					      		<li>2015</li>
					      		<li>2016</li>
					      		<li>2017</li>
					    	</ul>
				  		</div>						
					</div>
					<div class="td-5">
						<div class="dropdown cotton">
				    		<button class="dropdown-toggle" type="button" data-toggle="dropdown">Total score
				    		<span class="caret"></span></button>
					    	<ul class="dropdown-menu select-year">
					      		<li>2015</li>
					      		<li>2016</li>
					      		<li>2017</li>
					    	</ul>
				  		</div>						
					</div>
				</div>
				<div class="body-table">
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
						);
					?>
					<?php for ($i=0; $i < 8; $i++) { ?>
					<a href="" class="tr <?php echo $type[rand(1,4)];?>">
						<div class="td-1">
							<div class="company">
								<?php echo $company[$i]; ?>
							</div>
						</div>
						<div class="td-2 number">
							2.00
						</div>
						<div class="td-3 number">
							6.00
						</div>
						<div class="td-4 number">
							4.00
						</div>
						<div class="td-5 total-score">
							12.00
						</div>					
					</a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>
<section id="WhatResultShow">
	<div class="container">
		<h3>What do results show?</h3>
		<p>Sustainability efforts are driven by 5 frontrunners, followed by 8 more companies that are well on their way and 18 others just starting the journey.</p>
		<p>Of the 75 companies assessed, the remaining 44 scored no points and have not yet started the journey.</p>
		<img src="assets/img/Roadmap-CTS-1440.jpg" />
		<div class="accordion">
			<div class="list">
				<a data-toggle="collapse" href="#policy" aria-expanded="true">POLICY</a>
				<div id="policy" class="panel-collapse collapse in">
					<div class="chck-green row">
						<div class="item">Top 6: Ikea, Marks & Spencer, C&A, H&M, Nike, Levi Strauss & Co.</div>
						<div class="item">19 companies have some kind of target for sourcing more sustainable cotton.</div>
						<div class="item">17 companies are leading the way, 10 are well on the way, 14 are starting the journey, and 34 have not yet started the journey.</div>
						<div class="item">35 companies have no clear policies on cotton.</div>
						<div class="item">11 companies have a target for sourcing 100% more sustainable cotton by 2020 or earlier: IKEA, C&A, Marks & Spencer, Maxingvest, H&M, Adidas, Otto, Nike, Levi Strauss, Woolworths and Decathlon.xx</div>
					</div>
			  	</div>					
			</div>
			<div class="list">
				<a data-toggle="collapse" href="#uptake">UPTAKE</a>
				<div id="uptake" class="panel-collapse collapse">
					<div class="chck-green row">
						<div class="item">Top 5: IKEA, Maxingvest , Adidas, C&A, H&M.</div>
						<div class="item">22 companies report some sourcing of more sustainable cotton (in volume and/or percentage of total use): 18 companies publicly disclose the percentage of more sustainable cotton used; 20 companies disclosed the volume of more sustainable cotton they use, publicly or in confidence.</div>
						<div class="item">4 companies are leading the way, 5 are well on the way, 8 are starting the journey, and 58 have not yet started the journey.</div>
						<div class="item">The rest (53) do not source more sustainable cotton or do not disclose this information publicly.</div>
						<div class="item">IKEA, C&A, Maxingvest and Adidas stand out for sourcing over 50% of the cotton they use as more sustainable cotton.</div>
					</div>
			  	</div>					
			</div>
			<div class="list">
				<a data-toggle="collapse" href="#traceability">TRACEABILITY</a>
				<div id="traceability" class="panel-collapse collapse">
					<div class="chck-green row">
						<div class="item">Top 3: Marks & Spencer, C&A, H&M.</div>
						<div class="item">IKEA, Marks & Spencer, C&A, VF Corporation and Kering publish information on the countries of origin of the cotton they use. </div>
						<div class="item">1 company is leading the way, 6are well on the way, 15 are starting the journey, and 53 have not yet started the journey.</div>
						<div class="item">18 companies publish some information on their tier-1 suppliers (finished products) including 6 (C&A, Marks & Spencer, H&M, Nike, Levi Strauss and VF Corporation) publishing 100% of their suppliers for this tier.</div>
						<div class="item">IKEA, C&A, Marks & Spencer, Otto Group, Woolworths Holding, Tesco (only for its F&F brand), and Hugo Boss publish the absolute volume of all cotton lint used.</div>
						<div class="item">Only 3 companies publish some information on their tier-2 suppliers (fabric makers) (C&A, H&M and Kering).</div>
					</div>
			  	</div>					
			</div>
		</div> 
	</div>

</section>
<script type="text/javascript" src="assets/js/jquery.sticky.js"></script>
<script type="text/javascript" src="assets/js/checkscore.js"></script>
