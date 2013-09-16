<div class="catalog-grid-row">
							<div class="container">
								<div class="row-fluid">
									<div class="field span1"><div class="valign-text"><p><span class="un-check blue-check"></span><input type="hidden" name="" value="<?=$data->id?>" /></p></div></div>
									<div class="field span3">
										<div class="valign-text">
											<p><?=$data->brand?></p>
										</div>
									</div>
									<div class="field span1">
										<div class="valign-text">
											<p><?=$data->model?></p>
										</div>
									</div>
									<div class="field span1">
										<div class="valign-text">
											<p><?=$data->mileage?></p>
										</div>
									</div>
									<div class="field span1">
										<div class="valign-text">
											<p><?=$data->year?></p>
										</div>
									</div>
									<div class="field span3">
										<div class="valign-text">
											<p><?=$data->VIN?></p>
										</div>
									</div>
									<div class="field span1">
										<div class="valign-text">
											<p><a href="<?=$this->createUrl("cabinet/carform", array("id" => $data->id))?>" data-id-car="<?=$data->id?>" class="pencil"></a></p>
										</div>
									</div>
								</div>
							</div>
						</div>
