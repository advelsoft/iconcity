<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div id="page-wrapper">
	<div class="row"></div>
	<div class="row row-header">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Facilities Booking</h4>
				</div>
				<div class="panel-body">
					<?php for ($i = 0; $i < count($facilityBookingList); ++$i) { ?>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 thumbimg">
							<a class="thumbnail" href="<?php echo base_url()."index.php/Common/FacilityBooking/Calendar/".$facilityBookingList[$i]->BookingTypeID.'?Date='.date("Y-m-d"); ?>">
								<img src="<?php echo base_url()."application/uploads/facility/".$facilityBookingList[$i]->ImgToShown;?>" alt="Facilities">
								<div class="facilityType"><?php echo $facilityBookingList[$i]->Description;?></div>
							</a>
						</div>
					<?php } ?>
				</div>
				<div class="panel-footer"></div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->session->flashdata('msg'); ?>