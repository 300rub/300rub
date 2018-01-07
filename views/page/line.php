<?php

/**
 * Variables
 *
 * @var int   $id
 * @var array $structure
 *
 * phpcs:disable PSR1.Files.SideEffects
 * phpcs:disable Squiz.Functions.GlobalFunction
 */

/**
 * Builds structure
 *
 * @param array $structure Structure
 *
 * @return string
 */
function buildStructureHtml($structure)
{
    $html = '';

    foreach ($structure as $yData) {
        $lastY = 0;

        foreach ($yData as $item) {
            if (array_key_exists('type', $item) === false) {
                continue;
            }

            switch ($item['type']) {
                case 'block':
                    if ($lastY < $item['y']) {
                        $html .= '<div class="clear"></div>';
                        $lastY = $item['y'];
                    }

                    $html .= sprintf(
                        '<div class="grid width-%s" ' .
                        'style="margin-left: %s%%;">%s</div>',
                        $item['width'],
                        $item['left'],
                        $item['html']
                    );

                    break;
                case 'container':
                    $html .= sprintf(
                        '<div class="grid width-%s" ' .
                        'style="margin-left: %s%%;">%s</div>',
                        $item['width'],
                        $item['left'],
                        buildStructureHtml($item['data'])
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
