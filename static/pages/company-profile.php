<link rel="stylesheet" media="all" href="assets/css/pages/company-profile.css" />
<section id="CompanyProfile">
	<div class="title container">
		<a href="" class="prev-company"><i></i> C&A Global</a>
		<h2>IKEA Group</h2>
		<a href="" class="next-company"><i></i> H&M Group</a>
	</div>
	<div class="content container">
		<div class="company-info">
			<div class="detail">			
				<ul class="country">
					<li class="title">COUNTRY HQ</li>
					<li>Sweden</li>
				</ul>
				<ul class="subsidiary">
					<li class="title">SUBSIDIARIES</li>
					<li>Mega Family Shopping Centre</li>
					<li>Sweedwood</li>
					<li>10-Gruppen</li>
					<li>IKEA components</li>
				</ul>
			</div>
			<a href="#PerformanceAnalysis" class="page-scroll">PERFORMANCE ANALYSIS</a>
			<a href="" class="back"><i></i>COTTON RANKING 2017</a>
		</div>
		<div class="company-detail">
			<div class="company-performing">
				<h4>How is the company performing?</h4>
				<?php
					$type = array(	1 => 'leading-the-way',
									2 => 'well-on-the-way',
									3 => 'starting-the-journey',
									4 => 'not-yet-in-the-starting-blocks',
					); 
				?>
				<div class="row">
					<div class="col-xs-3">
						<h5>Score<i class="info"></i></h5>
						<div class="score <?php echo $type[rand(1,4)]; ?> count">
							9.60
						</div>
					</div>
					<div class="col-xs-3">
						<h5>Policy<i class="info"></i></h5>
						<div class="policy <?php echo $type[rand(1,4)]; ?> count">
							2.50
						</div>
					</div>
					<div class="col-xs-3">
						<h5>Uptake<i class="info"></i></h5>
						<div class="uptake <?php echo $type[rand(1,4)]; ?> count">
							8.07
						</div>
					</div>
					<div class="col-xs-3">
						<h5>Traceability<i class="info"></i></h5>
						<div class="traceability <?php echo $type[rand(1,4)]; ?> count">
							2.00
						</div>
					</div>
				</div>
			</div>
			<div class="company-responsibility">
				<h4>Where is IKEA Group on the journey to responsible cotton?<i class="info"></i></h4>
				<div class="roadmap <?php echo $type[3]; ?>">
					<div class="text step1">Not yet in the<br /> starting blocks</div>
					<div class="text step2">Starting the journey <span class="timeline">IKEA Group in 2016, 2017</span></div>
					<div class="text step3">Well on the way <span class="timeline">IKEA Group in 2016, 2017</span></div>
					<div class="text step4">Leading the way <span class="timeline">IKEA Group in 2016, 2017</span></div>
				</div>
			</div>
			<div class="company-performance-analysis accordion" id="#PerformanceAnalysis">
				<h5>Company performance analysis</h5>
				<div class="list">
					<a data-toggle="collapse" data-parent="#PerformanceAnalysis" href="#overall" aria-expanded="true">OVERALL</a>
					<div id="overall" class="panel-collapse collapse in">
				    	<p>As in 2016, Ikea is again the highest scoring company in 2017’s ranking with 76,65 points out of 100. It shows the overall best sustainability performance in relation to cotton production. Ikea has continued to show improvements in policy, uptake and traceability in 2016. This makes it one of the few companies  improving in all areas since 2016. Most notably the scope of its water policy and human rights due diligence procedures have been extended to include the cotton cultivation stage. Only the traceability score is low in comparison; The company does not publish a list of suppliers.</p>
				  	</div>					
				</div>
				<div class="list">
					<a data-toggle="collapse" data-parent="#PerformanceAnalysis" href="#policy">POLICY</a>
					<div id="policy" class="panel-collapse collapse">
				    	<p>Ikea states it is "uncomfortable" with the negative environmental impacts of cotton production. The group is working on improving the conditions of cotton cultivation, through membership of the Better Cotton Initiative (BCI) and sourcing certified cotton. In addition, Ikea Group committed to become ‘water positive’ by 2020. This means Ikea will contribute to improved management in water-stressed areas of operation including countries of origin of Ikea’s cotton. Ikea has a supplier code of conduct, IWAY, which includes provisions on forced and child labour. Ikea states that it audits its suppliers regularly and is working with them towards continuous compliance. The company has extended the scope of home furnishing suppliers to include sub-suppliers, including green plant growers. It commits to continued development of processes for securing compliance with a specific focus on critical supply chains such as cotton. Ikea has no corporate policy addressing highly hazardous pesticides (HHP) and biodiversity issues within cotton cultivation. </p>
				  	</div>					
				</div>
				<div class="list">
					<a data-toggle="collapse" href="#uptake">UPTAKE</a>
					<div id="uptake" class="panel-collapse collapse">
				    	<p>By its own criteria, Ikea claims to be sourcing 100% of its cotton sustainably since 2015. However, this number includes cotton standards, such as E3 and the company’s own standard ‘Towards Better Cotton’. These standards are not recognized in this ranking. In 2016, Ikea demonstrated continued commitment to increase the uptake of quality standards. Ikea sources 17.9% recycled cotton and 69.4% Better Cotton. This results in an uptake of sustainably sourced cotton of 87.3% by the criteria of this ranking and the highest percentage of all companies ranked. </p>
				  	</div>					
				</div>
				<div class="list">
					<a data-toggle="collapse" href="#traceability">TRACEABILITY</a>
					<div id="traceability" class="panel-collapse collapse">
				    	<p>In calendar year 2016, Ikea sourced 131,000 MT of Cotton. Ikea’s CSR Report 2016 shows a diagram of countries of origin. 83% of source is specified, the rest falls under 'other'.  Ikea does not publish Information on supply chain relationships for final products, fabric or yarn manufacturing.</p>
				  	</div>					
				</div>
				<a href="" class="button">Read the interview</a>
			</div> 
		</div>
	</div>
</section>