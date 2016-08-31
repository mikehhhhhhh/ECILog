<h2>Incident <?php echo ($incidentId) ? 'updated' : 'created'; ?></h2>
<hr />
<p>Your incident has been <?php echo ($incidentId) ? 'updated' : 'created'; ?>.</p>
<ul class="hlist">
	<li>
		<strong>Incident time:</strong> <?php echo  $_POST['incidentTime']; ?>
	</li>
	<li>
		<strong>Resolution time:</strong> <?php echo $_POST['resolutionTime']; ?>
	</li>
	<li>
		<strong>General explanation:</strong>
		<?php echo $_POST['generalExplanation']; ?>
	</li>
	<li>
		<strong>Preventive measures:</strong>
		<?php echo $_POST['preventiveMeasures']; ?>
	</li>
</ul>
