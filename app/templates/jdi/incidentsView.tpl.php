<h2><?php echo $summary['title']; ?></h2>
<?php $stats = $summary['stats']; $numPages = $summary['numPages']; $page = $summary['page']; $action = $summary['action']; ?>
<?php if( $action == null ):  ?>
	<hr />
	<p>
		There are <?php echo $summary['noIncidents']; ?> incidents in the database, with a total of <?php echo $summary['noComments']; ?> comments.<br />
		The longest downtime was <?php echo $stats['maxtime']; ?> and the shortest <?php echo $stats['mintime']; ?>.<br />
		The current average resolution time is <?php echo $stats['average']; ?>.
	</p>
<?php elseif( $action == 'all'): ?>
	<hr />
	<div id="filter">
		
		<form action="" method="post">
			<fieldset>
			<label class="heading">Filter:</label>
			<label for="filterFrom">From</label> <input type="text" name="filterFrom" id="filterFrom" value="<?php echo ( isset( $_REQUEST['filterFrom'] ) ) ? $_REQUEST['filterFrom'] : ''; ?>" />
			<label for="filterTo">To</label> <input type="text" name="filterTo" id="filterTo" value="<?php echo ( isset( $_REQUEST['filterTo'] ) ) ? $_REQUEST['filterTo'] : ''; ?>" />
			<input type="submit" name="filter" value="Search" />
			</fieldset>
		</form>
		<span class="filterTip">Format: dd/mm/yyyy hh:mm</span>
	</div>
<?php endif; ?>
<?php if( count( $summary['results'] ) < 1 ): ?>No results found<?php endif; ?>
<?php foreach( $summary['results'] as $key => $incident ): $id = $incident['id'];  $noComments = count($incident['comments']); ?>
	<hr />
	<a name="<?php echo $id; ?>"></a>
	<ul class="hlist">
		<li>
			<strong>Incident time:</strong> <?php echo date("d/m/y H:i", strtotime( $incident['incidentTime'] ) ); ?>
		</li>
		<li>
			<strong>Resolution time:</strong> <?php echo date("d/m/y H:i", strtotime( $incident['resolutionTime'] ) ); ?>
		</li>
		<li>
			<strong>Time Elapsed:</strong> <?php echo $incident['elapsed']; ?>
		</li>
		<li>
			<strong>General explanation:</strong><?php echo( $action == 'single' || $action == null ) ? '<br /><br />' : ''; ?>
			<?php echo nl2br( htmlspecialchars( ( ($page) ? $truncate->txtTruncate( $incident['generalExplanation'], 90, ' ', '...' ) : $incident['generalExplanation'] ) ) ); ?>
		</li>
		<li>
			<strong>Preventive measures:</strong><?php echo( $action == 'single' || $action == null ) ? '<br /><br />' : ''; ?>
			<?php echo nl2br( htmlspecialchars( ( ($page) ? $truncate->txtTruncate( $incident['preventiveMeasures'], 90, ' ', '...' ) : $incident['preventiveMeasures'] ) ) ); ?>
		</li>
		<li>
			<?php if( $action != 'single' ): ?>
				<a class="right" href="/view/single/<?php echo $id; ?>">View incident ( <?php echo $incident['noComments']; ?> Comments )</a>
			<?php else: ?>
				<a class="right" href="/manageIncident/<?php echo $id; ?>/">Manage incident</a>
			<?php endif; ?>
		</li>
	</ul>
<?php endforeach; ?>

<?php if( $action == 'single' ): ////////////////// Show Comments for viewing a single incident ////////////////////////////// ?>
	<hr />
	<div class="comments" id="comments<?php echo $id; ?>">
		<h4>Add a comment</h4>
		<form action="#<?php echo $id; ?>" method="post" class="commentsform">
			<input type="text" name="name" class="clearonfocus" value="Name" /> <?php echo ( $summary['commentValidation'][$id]['name'] ) ? '<span class="CvalidationError">' . $summary['commentValidation'][$id]['name'] .'</span>': ''; ?>
			<textarea name="comment" class="clearonfocus">Comment</textarea> <?php echo ( $summary['commentValidation'][$id]['name'] ) ? '<span class="CvalidationError">' . $summary['commentValidation'][$id]['name'] .'</span>': ''; ?>
			<input type="hidden" name="incidentId" value="<?php echo $id; ?>" />				
			<input type="submit" name="submit" value="Submit" class="submit" />
		</form>
		<?php if( $noComments > 0  ): ?>
			<h4>Comments</h4>
			<?php foreach( $incident['comments'] as $key => $comment ): $cId = $comment['id'] ?>
				<p class="aComment">
					<span class="cTitle">Posted by <?php echo htmlspecialchars( $comment['name'] ); ?> at <?php echo date( "H:i d/m/y", strtotime( $comment['date'] ) ); ?></span>
					<em><?php echo nl2br( htmlspecialchars( $comment['comment'] ) ); ?></em>
				</p>						
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
<?php endif; ?>

<?php if( $action == 'all' ): //////////////////  Display pagination for /incidents/all/*  ////////////////// ?>
	<div id="pagination">
		<?php for( $i=1; $i<=$numPages; $i++ ): ?>
			<a <?php echo ( $i == $page ) ? 'class="current"' : ''; ?> href="/view/all/<?php echo $i; ?><?php echo ( isset($_REQUEST['filterFrom']) ) ? '/?filterFrom=' . urlencode($_REQUEST['filterFrom']) : ''; ?><?php echo (isset($_REQUEST['filterTo']) && isset($_REQUEST['filterTo']) ) ? '&filterTo=' . urlencode($_REQUEST['filterTo']) : ''; ?>"><?php echo $i; ?></a>
		<?php endfor; ?>
	</div>
<?php endif; ?>
