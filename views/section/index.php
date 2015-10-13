<?php
/**
 * @var \controllers\SectionController $this
 * @var array $structure
 */
?>
<?php foreach ($structure["lines"] as $lineNumber => $gridContainers) { ?>
	<div class="line-<?= $lineNumber ?>">
		<div class="container" style="width: <?= $structure["width"] ?>">
			<div class="row">
				<?php foreach ($gridContainers as $gridContainer) { ?>
					<?php
					/**
					 * @var array $gridContainer
					 */
					?>
					<div class="col-<?= $gridContainer["col"] ?> col-offset-<?= $gridContainer["offset"] ?>">
						<div class="container">
							<div class="row row-offset-<?= (12 - $gridContainer["col"]) ?>">
								<?php $y = 0;
								foreach ($gridContainer["grids"] as $grid) { ?>
									<?php if ($y < $grid["y"]) {
										$y = $grid["y"]; ?>
										<div class="clear"></div>
									<?php } ?>
									<div class="col-<?php echo $grid["col"]; ?> col-offset-<?= $grid["offset"]; ?> <?= $grid["class"] ?>">
										<?php $this->renderPartial($grid["view"], ["model" => $grid["model"]]); ?>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>
