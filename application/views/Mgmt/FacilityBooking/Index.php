<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>On Going Facilities Booking</h4>
				</div>
				<div class="panel-body">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
							<th>Facility</th>
							<th>Bookings</th>
						</tr>
						</thead>
						<tbody>
							<?php for ($i = 0; $i < count($facilityBookingList); ++$i) { ?>
								<?php if ($facilityBookingList[$i]->ManageBookAdmin != '1') { ?>
									<tr data-href="<?php echo base_url()."index.php/Common/FacilityBooking/Listed/".$facilityBookingList[$i]->BookingTypeID; ?>">
										<td><?php echo $facilityBookingList[$i]->Description; ?></td>
										<td><?php echo $facilityBookingList[$i]->Booked; ?></td>              
									</tr>
								<?php } else { ?>
									<tr onclick="alert('Online booking is not allowed, please contact management office.');">
										<td><?php echo $facilityBookingList[$i]->Description; ?></td>
										<td><?php echo $facilityBookingList[$i]->Booked; ?></td>              
									</tr>
								<?php } ?>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="panel-footer"></div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>