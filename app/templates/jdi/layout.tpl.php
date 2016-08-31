<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Unscheduled downtime incident report</title>
		
		<link rel="stylesheet" href="/css/jdi.css" type="text/css" media="screen" />
		<!--[if IE]>
			<link rel="stylesheet" type="text/css" href="/css/iepie.css" />
		<![endif]-->
		<!--[if IE 7]>
			<link rel="stylesheet" type="text/css" href="/css/ie7.css" />
		<![endif]-->
		<link rel="stylesheet" type="text/css" href="/css/overcast/jquery-ui-1.8.14.custom.css" />
		<script type="text/javascript" src="/js/jquery-1.6.2.min.js"></script>
		<script type="text/javascript" src="/js/jquery-ui-1.8.14.custom.min.js"></script>
		<script type="text/javascript" src="/js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="/js/jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="/js/jdi.js"></script>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	</head>
<body>
	<div id="wrapper">
		<div id="header">
			<h1>Unscheduled Downtime Incident Report</h1>
		</div>
		<div id="navigation">
			<ul>
				<li>
					<a href="/">Home</a>
				</li>
				<li>
					<a href="#">Articles</a>
				</li>
				<li>
					<a href="#">FAQ&rsquo;s</a>
				</li>
				<li>
					<a href="#">About Us</a>
				</li>
			</ul>
		</div>
		
		<div id="contentWrap">
			<div id="subNavigation">
				<h3>Site Navigation</h3>
				<ul>
					<li>
						<a href="/manageIncident/new/">Create new Incident</a>
					</li>
					<li>
						<a href="/">Most Recent Incidents</a>
					</li>
					<li class="last">
						<a href="/view/all/1">View All Incidents</a>
					</li>
				</ul>
				
				<h3>Quick Help</h3>
				<ul>
					<li class="last">
						<p>Use this form to report downtime that affects more than one client that is not scheduled and was unexpected. Report must be submitted within 24 hours of the incident.</p>
					</li>
				</ul>
			</div>
			<div id="content">
				<?php echo $content; ?>							
			</div>
			<div class="clear"> </div>
		</div>
		
	</div>
</body>
</html>