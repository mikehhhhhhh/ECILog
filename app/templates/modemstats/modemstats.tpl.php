<div class="row">
	<div class="span3">
	<div class="well">
	  <h3>Line Data</h3>
	  <table class="table table-condensed">
	  	<tbody>
	  		<tr>
	  			<td><strong>Status:</strong></td>
	  			<td><?php echo $lineData['line_status']; ?></td>
	  		</tr>
	  		<tr>
	  			<td><strong>Profile:</strong></td>
	  			<td><?php echo $lineData['profile']; ?></td>
	  		</tr>
	  		<tr>
	  			<td><strong>Down Sync:</strong></td>
	  			<td><?php echo number_format($lineData['down_sync'] / 1000, 0); ?> kbps</td>
	  		</tr>
	  		<tr>
	  			<td><strong>Down Attainable:</strong></td>
	  			<td><?php echo number_format($lineData['down_attainable'] / 1000, 0); ?> kbps</td>
	  		</tr>
	  		<tr>
	  			<td><strong>Down Power:</strong></td>
	  			<td><?php echo $lineData['down_power']; ?> dBm</td>
	  		</tr>
	  		<tr>
	  			<td><strong>Up Sync:</strong></td>
	  			<td><?php echo number_format($lineData['up_sync'] / 1000, 0); ?> kbps</td>
	  		</tr>
	  		<tr>
	  			<td><strong>Up Attainable:</strong></td>
	  			<td><?php echo number_format($lineData['up_attainable'] / 1000, 0); ?> kbps</td>
	  		</tr>
	  		<tr>
	  			<td><strong>Up Power:</strong></td>
	  			<td><?php echo $lineData['up_power']; ?> dBm</td>
	  		</tr>
	  	</tbody>
	  </table>
	</div>
	</div>
	<div class="span9">
	<ul class="nav nav-tabs aTabs">
		<li class="active">
			<a href="#connection_information" class="tabBtn">Connection Information</a>
		</li>
		<li><a href="#sync" class="tabBtn">Sync</a></li>
		<li><a href="#snr" class="tabBtn">SNR</a></li>
		<li><a href="#bit" class="tabBtn">Bit Loading</a></li>
		<li><a href="#gain" class="tabBtn">Gain</a></li>
		<li><a href="#hlog" class="tabBtn">HLog</a></li>
		<li><a href="#ping" class="tabBtn">Ping</a></li>
	</ul>

	<script type="text/javascript">
		$(function(){
			setTimeout(function(){
				$('.aTab').hide();
				$('#connection_information').show();
			},1);
			$('.tabBtn').click(function(){
				$('.aTab').hide();
				$($(this).attr('href')).fadeIn(100);
				$('.aTabs li').attr('class','');
				$(this).parent('li').attr('class','active');
			});

		});
	</script>

	<div id="connection_information" class="aTab">	
		<h3>Downstream Info</h3>
		<table class="table table-condensed">
		  	<thead>
		  		<tr>
		  			<th>&nbsp;</th>
		  			<th>Band U0</th>
		  			<th>Band U1</th>
		  			<th>Band U2</th>
		  			<th>Band U3</th>
		  			<th>Band U4</th>
		  			<th>&nbsp;</th>
		  		</tr>
		  	</thead>
		  	<tbody>
		  		<tr>
		  			<th>Line Atn.</th>
			  		<?php for( $i=0; $i<=5; $i++ ): ?>
			  			<td><?php echo str_replace('-999.9 dB','n/a', $lineData['down_latn_'.$i] .' dB' ); ?></td>
			  		<?php endfor; ?>
			  	</tr>
			  	<tr>
		  			<th>Signal Atn.</th>
			  		<?php for( $i=0; $i<=5; $i++ ): ?>
			  			<td><?php echo str_replace('-999.9 dB','n/a', $lineData['down_satn_'.$i] .' dB' ); ?></td>
			  		<?php endfor; ?>
			  	</tr>
			  	<tr>
		  			<th>SNR</th>
			  		<?php for( $i=0; $i<=5; $i++ ): ?>
			  			<td><?php echo str_replace('-999.9 dB','n/a', $lineData['down_snr_'.$i] .' dB' ); ?></td>
			  		<?php endfor; ?>
			  	</tr>
			</tbody>
		</table>

		<h3>Upstream Info</h3>
		  <table class="table table-condensed">
		  	<thead>
		  		<tr>
		  			<th>&nbsp;</th>
		  			<th>Band U0</th>
		  			<th>Band U1</th>
		  			<th>Band U2</th>
		  			<th>Band U3</th>
		  			<th>Band U4</th>
		  			<th>&nbsp;</th>
		  		</tr>
		  	</thead>
		  	<tbody>
		  		<tr>
		  			<th>Line Atn.</th>
			  		<?php for( $i=0; $i<=5; $i++ ): ?>
			  			<td><?php echo str_replace('-999.9 dB','n/a', $lineData['up_latn_'.$i] .' dB' ); ?></td>
			  		<?php endfor; ?>
			  	</tr>
			  	<tr>
		  			<th>Signal Atn.</th>
			  		<?php for( $i=0; $i<=5; $i++ ): ?>
			  			<td><?php echo str_replace('-999.9 dB','n/a', $lineData['up_satn_'.$i] .' dB' ); ?></td>
			  		<?php endfor; ?>
			  	</tr>
			  	<tr>
		  			<th>SNR</th>
			  		<?php for( $i=0; $i<=5; $i++ ): ?>
			  			<td><?php echo str_replace('-999.9 dB','n/a', $lineData['up_snr_'.$i] .' dB' ); ?></td>
			  		<?php endfor; ?>
			  	</tr>
			</tbody>
		</table>
	</div>
	
	<div id="sync" class="aTab">	
		<h3>Historic Sync Graph</h3>
		<div id="syncLoad" style="width:100%; height: 400px; "> </div>
		<script type="text/javascript">
			$(document).ready(function(){
		        $('#syncLoad').highcharts({
		            chart: {
		                type: 'area'
		            },
		            title: {
		                text: 'Sync'
		            },
		            subtitle: {
		                text: 'Placeholder'
		            },
		            xAxis: {
		                type: 'datetime',
		                dateTimeLabelFormats: { // don't display the dummy year
		                    month: '%e. %b',
		                    year: '%b'
		                }
		          
		            },
		            yAxis: {
		                title: {
		                    text: 'Sync'
		                },
		                labels: {
		                    /*formatter: function() {
		                        return this.value / 1000 +'k';
		                    }*/
		                }
		            },
		            tooltip: {
		          		 	 formatter: function() {
		                        return Highcharts.numberFormat(this.point.y / 1000 ,0) +'k';
		                    }
		            },
		            plotOptions: {
		                area: {
		                    connectNulls: false,
		                    marker: {
		                        enabled: false,
		                        symbol: 'circle',
		                        radius: 2,
		                        states: {
		                            hover: {
		                                enabled: true
		                            }
		                        }
		                    }
		                }
		            },
		            series: [{
		                name: 'Down Attainable',
		                data: [<?php echo $sync['down_attainable']; ?>]
		            },
		            {
		                name: 'Down Sync',
		                data: [<?php echo $sync['down_sync']; ?>]
		            },
		            {
		                name: 'Up Attainable',
		                data: [<?php echo $sync['up_attainable']; ?>]
		            },
		            {
		                name: 'Up Sync',
		                color: '#41591d',
		                data: [<?php echo $sync['up_sync']; ?>]
		            },
		            ]
		        });
		    });
		</script>
	</div>
	
	<div id="snr" class="aTab">	
		<h3>SNR Data</h3>
		<div id="downAtn" style="width:100%; height: 400px; "> </div>
		<script type="text/javascript">
			$(document).ready(function(){
		        $('#downAtn').highcharts({
		            chart: {
		                type: 'area'
		            },
		            title: {
		                text: 'Downstream SNR'
		            },
		            subtitle: {
		                text: 'Placeholder'
		            },
		            xAxis: {
		                labels: {
		                    formatter: function() {
		                        return this.value; // clean, unformatted number for year
		                    }
		                }
		            },
		            yAxis: {
		                title: {
		                    text: 'SNR (dB)'
		                },
		                labels: {
		                    /*formatter: function() {
		                        return this.value / 1000 +'k';
		                    }*/
		                }
		            },
		            tooltip: {
		                pointFormat: '{series.name} - <b>{point.y:,.0f} dB </b> at tone {point.x}'
		            },
		            plotOptions: {

		                area: {
		                    marker: {
		                        enabled: false,
		                        symbol: 'circle',
		                        radius: 2,
		                        states: {
		                            hover: {
		                                enabled: true
		                            }
		                        }
		                    }
		                }
		            },
		            series: [{
		                name: 'Downstream SNR',
		                data: [<?php echo $downSnrX; ?>]
		            }]
		        });
		    });
		</script>
	</div>

	<div id="bit" class="aTab">	
		<h3>Bit Loading Data</h3>
		<div id="bitLoad" style="width:100%; height: 400px; "> </div>
		<script type="text/javascript">
			$(document).ready(function(){
		        $('#bitLoad').highcharts({
		            chart: {
		                type: 'area'
		            },
		            title: {
		                text: 'Bit Loading'
		            },
		            subtitle: {
		                text: 'Placeholder'
		            },
		            xAxis: {
		                labels: {
		                    formatter: function() {
		                        return this.value; // clean, unformatted number for year
		                    }
		                }
		            },
		            yAxis: {
		                title: {
		                    text: 'Bits'
		                },
		                labels: {
		                    /*formatter: function() {
		                        return this.value / 1000 +'k';
		                    }*/
		                }
		            },
		            tooltip: {
		                pointFormat: '{series.name} - {point.y:,.0f} bits at tone {point.x}'
		            },
		            plotOptions: {
		                area: {
		                    connectNulls: false,
		                    marker: {
		                        enabled: false,
		                        symbol: 'circle',
		                        radius: 2,
		                        states: {
		                            hover: {
		                                enabled: true
		                            }
		                        }
		                    }
		                }
		            },
		            series: [{
		                name: 'Upstream',
		                data: [<?php echo $up_bit; ?>]
		            },
		            {
		            	name: 'Downstream',
		            	data: [<?php echo $down_bit; ?>]
		            }]
		        });
		    });
		</script>
	</div>

	<div id="gain" class="aTab">	
		<h3>Gain Data</h3>
		<div id="gainLoad" style="width:100%; height: 400px; "> </div>
		<script type="text/javascript">
			$(document).ready(function(){
		        $('#gainLoad').highcharts({
		            chart: {
		                type: 'area'
		            },
		            title: {
		                text: 'Gain'
		            },
		            subtitle: {
		                text: 'Placeholder'
		            },
		            xAxis: {
		                labels: {
		                    formatter: function() {
		                        return this.value; // clean, unformatted number for year
		                    }
		                }
		            },
		            yAxis: {
		                title: {
		                    text: 'Gain (dB)'
		                },
		                labels: {
		                    /*formatter: function() {
		                        return this.value / 1000 +'k';
		                    }*/
		                }
		            },
		            tooltip: {
		                pointFormat: '{series.name} - {point.y:,.0f} dB at tone {point.x}'
		            },
		            plotOptions: {
		                area: {
		                    connectNulls: false,
		                    marker: {
		                        enabled: false,
		                        symbol: 'circle',
		                        radius: 2,
		                        states: {
		                            hover: {
		                                enabled: true
		                            }
		                        }
		                    }
		                }
		            },
		            series: [{
		                name: 'Upstream',
		                data: [<?php echo $up_gain; ?>]
		            },
		            {
		            	name: 'Downstream',
		            	data: [<?php echo $down_gain; ?>]
		            }]
		        });
		    });
		</script>
	</div>

	<div id="hlog" class="aTab">	
		<h3>Hlog Data</h3>
		<div id="hlogLoad" style="width:100%; height: 400px; "> </div>
		<script type="text/javascript">
			$(document).ready(function(){
		        $('#hlogLoad').highcharts({
		            chart: {
		                type: 'area'
		            },
		            title: {
		                text: 'Hlog'
		            },
		            subtitle: {
		                text: 'Placeholder'
		            },
		            xAxis: {
		                labels: {
		                    formatter: function() {
		                        return this.value; // clean, unformatted number for year
		                    }
		                }
		            },
		            yAxis: {
		                title: {
		                    text: 'Hlog (dBm/Hz)'
		                },
		                labels: {
		                    /*formatter: function() {
		                        return this.value / 1000 +'k';
		                    }*/
		                }
		            },
		            tooltip: {
		                pointFormat: '{series.name} - {point.y:,.0f} dB at tone {point.x}'
		            },
		            plotOptions: {
		                area: {
		                    connectNulls: false,
		                    marker: {
		                        enabled: false,
		                        symbol: 'circle',
		                        radius: 2,
		                        states: {
		                            hover: {
		                                enabled: true
		                            }
		                        }
		                    }
		                }
		            },
		            series: [{
		                name: 'Hlog',
		                data: [<?php echo $hlog; ?>]
		            }]
		        });
		    });
		</script>
	</div>
	
	<div id="ping" class="aTab">	
		<h3>Ping</h3>
		<div id="pingGraph" style="width:100%; height: 400px; "> </div>
		<script type="text/javascript">
			$(document).ready(function(){
		        $('#pingGraph').highcharts({
		            chart: {
		                type: 'spline',
		                animation: Highcharts.svg, // don't animate in old IE
		                marginRight: 10,
		                events: {
				            load: function() {
				
				                // set up the updating of the chart each second
				                var series = this.series[0];
				                setInterval(function() {
									$.getJSON('/ajax/ping/', function(dat){
										series.addPoint([parseInt(dat.date), parseFloat(dat.avg)], true, true);
									});			                   
				                    
				                }, 6000);
				            }
				        }
		            },
		            title: {
		                text: 'Ping'
		            },
		            subtitle: {
		                text: '5 Minutes'
		            },
		            xAxis: {
		                type: 'datetime'		            },
		            yAxis: {
		                title: {
		                    text: 'Latency (ms)',
		                    minRange: 10
		                },
		                labels: {
		                    /*formatter: function() {
		                        return this.value / 1000 +'k';
		                    }*/
		                },
		                plotLines: [{
		                    value: 0,
		                    width: 1,
		                    color: '#808080'
		                }]
		            },
		            tooltip: {
		            },
		            exporting: {
		                enabled: false
		            },
		            series: [{
		                name: 'Ping',
		                data: [<?php echo $ping; ?>]
		            }]
		         });
		    });
		</script>
	</div>
	
	

	</div>
</div> <!-- /row -->