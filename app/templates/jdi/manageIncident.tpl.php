<h2><?php echo ($incident['id']) ? 'Update Incident' : 'Submit New Incident'; if( !isset($incident) ) $incident = array(); ?></h2>
<hr />
<form action="#" method="post" class="cssform" id="incidentForm">
	<fieldset>	
		<ol>
			<li>
				<label for="incidentTime">Date / Time of Incident:</label>
				<input type="text" id="incidentTime" name="incidentTime" value="<?php echo ( isset($_POST['incidentTime']) ) ? $_POST['incidentTime'] : $incident['incidentTime']; ?>" /> <span class="noJsTip">Format: dd/mm/yyyy hh:mm (24h)</span>
				<?php if( isset($validationErrors['incidentTime']) ) : ?><span class="validationError"><?php echo $validationErrors['incidentTime']; ?></span><?php endif; ?>
			</li>
			<li>
				<label for="resolutionTime">Date / Time of Resolution:</label>
				<input type="text" id="resolutionTime" name="resolutionTime" value="<?php echo ( isset($_POST['resolutionTime']) ) ? $_POST['resolutionTime'] : $incident['resolutionTime']; ?>" /> <span class="noJsTip">Format: dd/mm/yyyy hh:mm (24h)</span>
				<?php if( isset($validationErrors['resolutionTime']) ) : ?><span class="validationError"><?php echo $validationErrors['resolutionTime']; ?></span><?php endif; ?>
			</li>
			<li>
				<label for="generalExplanation">General Explanation:</label>
				<textarea class="textarea" id="generalExplanation" name="generalExplanation" rows="20" cols="100"><?php echo ( isset($_POST['generalExplanation']) ) ? $_POST['generalExplanation'] : $incident['generalExplanation']; ?></textarea>
				<?php if( isset($validationErrors['generalExplanation']) ) : ?><span class="validationError"><?php echo $validationErrors['generalExplanation']; ?></span><?php endif; ?>
			</li>
			<li>
				<label for="preventiveMeasures">Preventive Measures Taken:</label>
				<textarea class="textarea" id="preventiveMeasures" name="preventiveMeasures" rows="20" cols="100"><?php echo ( isset($_POST['preventiveMeasures']) ) ? $_POST['preventiveMeasures'] : $incident['preventiveMeasures']; ?></textarea>
				<?php if( isset($validationErrors['preventiveMeasures']) ) : ?><span class="validationError"><?php echo $validationErrors['preventiveMeasures']; ?></span><?php endif; ?>
			</li>
			<li>
				<input type="submit" id="submitReport" class="purpleButton right" name="submit" value="<?php echo ($incident['id']) ? 'Update' : 'Submit'; ?> Report" />
			</li>
		</ol>
	</fieldset>
</form>
