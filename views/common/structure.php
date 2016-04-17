<?php
/**
 * @var \controllers\SectionController $this
 * @var array                          $structure
 * @var \models\SectionModel           $model
 */
?>
	<script>
		window.Core.sectionId = parseInt("<?= $model->id ?>");
	</script>
<?php if (!empty($structure["lines"])) { ?>
	<div
		class="l-section-container j-section-<?= $model->id ?> j-design-block-<?= $model->designBlockModel->id ?>"
		style="<?php $this->renderPartial("/templates/design/block_style", ["model" => $model->designBlockModel]); ?>"
		>
		<?php foreach ($structure["lines"] as $lineNumber => $data) { ?>
			<div
				class="l-line-container j-line-<?= $lineNumber ?> j-design-block-<?= $data["line"]->outsideDesignModel->id ?>"
				style="<?php $this->renderPartial(
					"/templates/design/block_style",
					["model" => $data["line"]->outsideDesignModel]
				); ?>"
				>
				<div
					class="l-container j-design-block-<?= $data["line"]->insideDesignModel->id ?>"
					style="width: <?= $structure["width"] ?>; <?php
					$this->renderPartial("/templates/design/block_style", ["model" => $data["line"]->insideDesignModel]); ?>"
					>
					<div class="l-row">
						<?php foreach ($data["grids"] as $gridContainer) { ?>
							<?php
							/**
							 * @var array $gridContainer
							 */
							?>
							<div class="l-col-<?= $gridContainer["col"] ?> l-col-offset-<?= $gridContainer["offset"] ?>">
								<div class="l-container">
									<div class="l-row l-row-offset-<?= (12 - $gridContainer["col"]) ?>">
										<?php $y = 0;
										foreach ($gridContainer["grids"] as $grid) { ?>
											<?php if ($y < $grid["y"]) {
												$y = $grid["y"]; ?>
												<div class="l-clear"></div>
											<?php } ?>
											<div
												class="l-col-<?= $grid["col"] ?> l-col-offset-<?= $grid["offset"]; ?> <?= $grid["class"] ?>">
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