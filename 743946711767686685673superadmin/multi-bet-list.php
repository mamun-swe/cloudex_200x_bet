<?php require_once('header.php'); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Multi Bets</h1>
	</div>
	<?php if($_SESSION['admin']['role'] == 'Super admin') { ?>
	<div class="content-header-right">
		<form method="post">
			<button type="submit" name="submit" class="btn btn-danger">Delete All</button>
			<?php 
				if(isset($_POST['submit'])){
					$statement = $pdo->prepare("DELETE FROM tbl_bet WHERE bet_type = 'multi'");
					$statement->execute();
				}
			?>
		</form>
	</div>
	
	<div class="content-header-right">
		<button type="button" class="btn btn-info" id="test" style="margin-right: 8px;">Delete Selected</button>
	</div>
	<?php } ?>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<?php if(isset($_REQUEST['message'])) { ?>
				<div class="callout callout-success">
					<p><?php echo $_REQUEST['message']; ?></p>
				</div>
			<?php } ?>
			<div class="box box-info">
				<div class="box-body table-responsive">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th width="30">Select</th>
								<th width="30">SL</th>
								<th width="30">Bet By</th>
								<th width="160">Date & Time</th>
								<th width="100">Match</th>
								<th width="100">Question</th>
								<th width="100">Answer</th>
								<th width="100">Amount</th>
								<th width="100">Return Rate</th>
								<th width="100">Total Win</th>
								<th width="100">Return Amount(Won)[Minus 0.01% sponsor fee]</th>
								<th width="100">Sponsor Fee(0.01%)</th>
								<th width="100">Bet Sell Price</th>
								<th width="100">Status</th>
								<th width="100">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=0;
							$statement = $pdo->prepare("SELECT * FROM tbl_bet 
								JOIN tbl_member ON tbl_bet.bet_by=tbl_member.user_id
								JOIN tbl_game ON tbl_bet.game_id=tbl_game.game_id
								JOIN tbl_stake ON tbl_bet.stake_id=tbl_stake.stake_id
								WHERE bet_type = 'multi'
								ORDER BY bet_id DESC
								");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);						
							foreach ($result as $row) {
								$i++;
								$amount=$row['return_amount'];
								$sponsor_amount=$amount * 0.01;
								$final_amount=$amount-$sponsor_amount;
								$game=$row['desh1'].' VS '.$row['desh2']." , ".$row['tournament']." || ".$row['date']." , ".$row['time'];
								
								$statementd = $pdo->prepare("SELECT tbl_bet.date FROM tbl_bet WHERE bet_id=?");
								$statementd->execute(array($row['bet_id']));
								$resultd = $statementd->fetchAll(PDO::FETCH_ASSOC);
								foreach ($resultd as $rowd) {
									$date=$rowd['date'];
								}
								?>
								<tr>
									<td>
										<input type="checkbox" class="form-check-input" value="<?php echo $row['bet_id']; ?>">
									</td>
									<td><?php echo $i; ?></td>
									<td><?php echo $row['user_name']; ?></td>
									<td><?php echo $date;?></td>
									<td><?php echo $game; ?></td>
									<td><?php echo $row['stake_name']; ?></td>
									<td><?php echo $row['bet_name']; ?></td>
									<td><?php echo $row['amount']; ?></td>
									<td><?php echo $row['current_rate']; ?></td>
									<td><?php echo $row['return_amount']; ?></td>
									<td><?php echo $final_amount; ?></td>
									<td><?php echo $sponsor_amount; ?></td>
									<td><?php echo $row['amount'] * $row['sell_price']; ?></td>
									<td><?php if($row['bet_status']==1) {echo 'WIN';} else if($row['bet_status']==2) {echo 'LOSS';} else if($row['bet_status']==3) {echo 'SOLD';} else if($row['bet_status']=="Canceled") {echo 'CANCELED';} else {echo 'RUNNING';} ?></td>
									<td>
										<a href="cancel-bet.php?id=<?php echo $row['bet_id']; ?>" class="btn btn-danger btn-xs">Cancel Bet</a>
									</td>
								</tr>
								<?php
							}
							?>							
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>


</section>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
			</div>
			<div class="modal-body">
				<p>Are you sure want to delete this item?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a class="btn btn-danger btn-ok">Delete</a>
			</div>
		</div>
	</div>
</div>


<script>
$("#test").click(function(e) {
    var myArray = [];
    $(":checkbox:checked").each(function() {
        myArray.push({
			id: this.value
		});
    });
   $.ajax({
		type: 'POST',
		url: 'delete_selected_bet.php',
		data: {myArray},
		success : function(response){
			var obj = JSON.parse(response);
			var res = obj.success;
			if(res == 1){
				location.reload();
			}
		}
	});
});
</script>

<?php require_once('footer.php'); ?>