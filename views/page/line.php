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
	    $lastY = 0;

		foreach ($yData as $item) {
			if (!array_key_exists("type", $item)) {
				continue;
			}

			switch ($item["type"]) {
				case "block":
                    if ($lastY < $item["y"]) {
                        $html .= '<div class="clear"></div>';
                        $lastY = $item["y"];
                    }

					$html .= sprintf(
						'<div class="grid left-%s width-%s block-%s" style="background: #%s%s%s;">%s</div>',
						$item["x"],
						$item["width"],
						$item["id"],
                        rand(10, 99),
                        rand(10, 99),
                        rand(10, 99),
						$item["html"]
					);

					break;
				case "container":
					$html .= sprintf(
						'<div class="grid left-%s width-%s">%s</div>',
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