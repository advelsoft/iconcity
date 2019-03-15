<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="tab-pane fade" id="pams">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="CONDOMINIUMID" class="create-label col-md-2">Condominium ID</label>
							<div class="col-md-2">
								<input id="CONDOMINIUMID" name="CONDOMINIUMID" placeholder="Condominium ID" type="text" class="form-control" value="" />
								<span class="text-danger"><?php echo form_error('CONDOMINIUMID'); ?></span>
							</div>
						</div>
						<div align="center">
							<input type="submit" class="btn btn-lg btn-default" value="OK" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>