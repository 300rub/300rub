<?php
/**
 * @var \controllers\SectionController $this
 * @var array                          $structure
 * @var int                            $sectionId
 */
?>
	<script>
		var SECTION_ID = <?= $sectionId ?>;
	</script>
<?php if (!empty($structure["lines"])) { ?>
	<div class="section-container section-<?= $sectionId ?>">
		<?php foreach ($structure["lines"] as $lineNumber => $data) { ?>
			<div
				class="line-<?= $lineNumber ?> design-block-<?= $data["line"]->outsideDesignModel->id ?>"
				style="<?php $this->renderPartial(
					"/design/block_style",
					["model" => $data["line"]->outsideDesignModel]
				); ?>"
				>
				<div
					class="container design-block-<?= $data["line"]->insideDesignModel->id ?>"
					style="width: <?= $structure["width"] ?>; <?php
					$this->renderPartial("/design/block_style", ["model" => $data["line"]->insideDesignModel]); ?>"
					>
					<div class="row">
						<?php foreach ($data["grids"] as $gridContainer) { ?>
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
											<div
												class="col-<?php echo $grid["col"]; ?> col-offset-<?= $grid["offset"]; ?> <?= $grid["class"] ?>">
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
			</div>
		<?php } ?>
	</div>
<?php } ?>