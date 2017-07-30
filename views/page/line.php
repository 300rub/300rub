<?php

/**
 * @var int   $id
 * @var array $structure
 */

/**
 * Builds structure
 *
 * @param array $structure
 *
 * @return string
 */
function buildStructureHtml($structure)
{
	$html = "";

	foreach ($structure as $yLine => $yData) {
		foreach ($yData as $item) {
			if (!array_key_exists("type", $item)) {
				continue;
			}

			switch ($item["type"]) {
				case "block":
					$html .= sprintf(
						'<div class="left-%s width-%s block-%s">%s</div>',
						$item["x"],
						$item["width"],
						$item["id"],
						$item["html"]
					);

					break;
				case "container":
					$html .= sprintf(
						'<div class="left-%s width-%s">%s</div>',
						$item["x"],
						$item["width"],
						buildStructureHtml($item["data"])
					);

					break;
			}
		}

		$html .= '<div class="clear"></div>';
	}

	return $html;
}

echo sprintf(
	'<div class="line-%s"><div class="line-container">%s</div></div>',
	$id,
	buildStructureHtml($structure)
);