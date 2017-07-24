<?php if (!empty($structure["lines"])) { ?>
	<div class="section-container-<?= 1 //TODO ?>">
		<?php foreach ($structure["lines"] as $lineNumber => $data) { ?>
			<div class="line-container-<?= 1 //TODO ?>">
				<div class="line-<?= 1 //TODO ?>">
					<?php foreach ($data["grids"] as $gridContainer) { ?>

						<div class="col-<?= $gridContainer["col"] ?> col-offset-<?= $gridContainer["offset"] ?>">
							<div class="l-container">
								<div class="row row-offset-<?= (12 - $gridContainer["col"]) ?>">
									<?php $y = 0;
									foreach ($gridContainer["grids"] as $grid) { ?>
										<?php if ($y < $grid["y"]) {
											$y = $grid["y"]; ?>
											<div class="l-clear"></div>
										<?php } ?>
										<div class="col-<?= $grid["col"] ?> col-offset-<?= $grid["offset"]; ?> <?= $grid["class"] ?>">
											<?php $this->renderPartial(
												$grid["view"],
												["model" => $grid["model"]]
											); ?>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>

					<?php } ?>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } ?>