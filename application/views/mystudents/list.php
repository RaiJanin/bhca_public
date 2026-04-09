<link rel="stylesheet" href="<?=base_url()?>assets/css/Dashboard/students_list.css">
<div class="col-md-12" style="display:none;">
	<div class="" style="text-align:center;">
		<a href="<?= site_url("students/enrollnew") ?>" type="button" class="btn btn-success btn-fw btn-lg">
			<i class="mdi mdi-file-document"></i>Enroll New/Old Student</a>
	</div>
</div>

<div class="col-lg-12 grid-margin stretch-card">
	<div class="card">
		<div class="card-body">

			<?php
			if ($this->session->flashdata('message')) {
				echo '<div class="text-primary" style="margin-bottom:10px;">
			' . $this->session->flashdata("message") . '
		</div>';
			}
			?>

			<h3 class="students-header" style="text-align:center;">My Students
				<?= ($this->uri->segment(3) ? "(" . $this->uri->segment(3) . ")" : "") ?>
			</h3>

			<div class="d-flex justify-content-between">

			</div>

			<table class="table students-table">
				<thead>
					<tr>
						<th width="5%">#</th>
						<th width="45%">Name</th>
						<th width="10%">Able for PT?</th>
						<th width="20%">Level</th>
						<th width="15%">Status</th>
						<th width="5%">Action</th>
					</tr>
				</thead>
				<tbody>

					<?php

					if ($query->num_rows() > 0) {
						$ctr = 1;


						foreach ($query->result() as $row):

							$newold = $row->newold == "old" ? "" : "&nbsp;<code>" . $row->newold . "</code>";
							if ($this->session->userdata('current_usertype') == 'Accounting') {
								if ($row->ableforpt == "Yes") {
									$ableforpt = "<a title='Change to No' class='btn btn-secondary btn-rounded' href='" . site_url("payments/ableforpt/" . $row->enroll_id . "/No") . "'>Yes</a>";
								} else {
									$ableforpt = "<a title='Change to Yes' class='btn btn-danger btn-rounded' href='" . site_url("payments/ableforpt/" . $row->enroll_id . "/Yes") . "'>No</a>";
								}

							} else {
								$ableforpt = $row->ableforpt == "Yes" ? "Yes" : "<code class='text-danger'>No</code>";
							}
							echo "<tr>";
							echo "<td>$ctr</td>";
							echo "<td><a href='" . site_url("students/details/" . $row->id) . "'>" . $row->lastname . ", " . $row->firstname . "</a>" . $newold . "</td>";
							echo "<td class='text-center'>" . $ableforpt . "</td>";
							echo "<td>" . $row->gradelevel . "</td>";
							echo "<td class='text-danger'><mark><code>" . $row->enrollstatus . "</code></mark></td>";
							echo "<td style='text-align:center'>";

							echo "<a href='" . site_url("students/details/" . $row->id) . "' class='btn btn-icons btn-secondary btn-rounded'><i class='mdi mdi-account'></i></a>";

							echo "</td>";
							echo "</tr>";
							$ctr++;

							?>

							<?php


						endforeach;
					}

					?>

				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		$('.table').DataTable({
			dom: 'Bfrtip',
			buttons: {
				buttons: [
					//{ extend: 'copy', className: 'btn btn-warning btn-xs' },
					{ extend: 'excel', className: 'btn btn-success btn-xs btn-export' },
					//{ extend: 'csv', className: 'btn btn-primary btn-xs' },
					//{ extend: 'pdf', className: 'btn btn-info btn-xs' }
				]
			},
			"searching": true,
			"bLengthChange": false,
			"info": true,
			"drawCallback": function () {
				$('a.paginate_button').addClass("btn btn-sm");
			},
		});

	});
</script>

<script>
	var js_variable_as_placeholder = <?= json_encode($query->result(), JSON_HEX_TAG); ?>;
	console.log(`student query`, js_variable_as_placeholder);
</script>