<?php

namespace tests\unit\models;

use models\DesignTextModel;

/**
 * Tests for model DesignTextModel
 *
 * @package tests\unit\models
 */
class DesignTextModelTest extends AbstractModelTest
{

	/**
	 * Model object
	 *
	 * @return DesignTextModel
	 */
	protected function getModel()
	{
		return new DesignTextModel;
	}

	/**
	 * Data provider for CRUD test
	 *
	 * @return array
	 */
	public function dataProviderForCRUD()
	{
		return [
			// Insert: empty fields. Update: empty fields.
			[
				[],
				[],
				[
					"t.size"           => 0,
					"t.family"         => DesignTextModel::FAMILY_MYRAD,
					"t.color"          => "",
					"t.isItalic"      => 0,
					"t.isBold"        => 0,
					"t.align"          => DesignTextModel::TEXT_ALIGN_LEFT,
					"t.decoration"     => DesignTextModel::TEXT_DECORATION_NONE,
					"t.transform"      => DesignTextModel::TEXT_TRANSFORM_NONE,
					"t.letterSpacing" => 0,
					"t.lineHeight"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
				],
				[],
				[],
				[
					"t.size"           => 0,
					"t.family"         => DesignTextModel::FAMILY_MYRAD,
					"t.color"          => "",
					"t.isItalic"      => 0,
					"t.isBold"        => 0,
					"t.align"          => DesignTextModel::TEXT_ALIGN_LEFT,
					"t.decoration"     => DesignTextModel::TEXT_DECORATION_NONE,
					"t.transform"      => DesignTextModel::TEXT_TRANSFORM_NONE,
					"t.letterSpacing" => 0,
					"t.lineHeight"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
				],
			],
			// Insert: empty values. Update: empty values.
			[
				[
					"t.size"           => "",
					"t.family"         => "",
					"t.color"          => "",
					"t.isItalic"      => "",
					"t.isBold"        => "",
					"t.align"          => "",
					"t.decoration"     => "",
					"t.transform"      => "",
					"t.letterSpacing" => "",
					"t.lineHeight"    => "",
				],
				[],
				[
					"t.size"           => 0,
					"t.family"         => DesignTextModel::FAMILY_MYRAD,
					"t.color"          => "",
					"t.isItalic"      => 0,
					"t.isBold"        => 0,
					"t.align"          => DesignTextModel::TEXT_ALIGN_LEFT,
					"t.decoration"     => DesignTextModel::TEXT_DECORATION_NONE,
					"t.transform"      => DesignTextModel::TEXT_TRANSFORM_NONE,
					"t.letterSpacing" => 0,
					"t.lineHeight"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
				],
				[
					"t.size"           => "",
					"t.family"         => "",
					"t.color"          => "",
					"t.isItalic"      => "",
					"t.isBold"        => "",
					"t.align"          => "",
					"t.decoration"     => "",
					"t.transform"      => "",
					"t.letterSpacing" => "",
					"t.lineHeight"    => "",
				],
				[],
				[
					"t.size"           => 0,
					"t.family"         => DesignTextModel::FAMILY_MYRAD,
					"t.color"          => "",
					"t.isItalic"      => 0,
					"t.isBold"        => 0,
					"t.align"          => DesignTextModel::TEXT_ALIGN_LEFT,
					"t.decoration"     => DesignTextModel::TEXT_DECORATION_NONE,
					"t.transform"      => DesignTextModel::TEXT_TRANSFORM_NONE,
					"t.letterSpacing" => 0,
					"t.lineHeight"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
				],
			],
			// Insert: correct values. Update: correct values.
			[
				[
					"t.size"           => 20,
					"t.family"         => DesignTextModel::FAMILY_ARIAL,
					"t.color"          => "rgb(0,255,0)",
					"t.isItalic"      => 1,
					"t.isBold"        => 1,
					"t.align"          => DesignTextModel::TEXT_ALIGN_CENTER,
					"t.decoration"     => DesignTextModel::TEXT_DECORATION_UNDERLINE,
					"t.transform"      => DesignTextModel::TEXT_TRANSFORM_CAPITALIZE,
					"t.letterSpacing" => 10,
					"t.lineHeight"    => 150,
				],
				[],
				[
					"t.size"           => 20,
					"t.family"         => DesignTextModel::FAMILY_ARIAL,
					"t.color"          => "rgb(0,255,0)",
					"t.isItalic"      => 1,
					"t.isBold"        => 1,
					"t.align"          => DesignTextModel::TEXT_ALIGN_CENTER,
					"t.decoration"     => DesignTextModel::TEXT_DECORATION_UNDERLINE,
					"t.transform"      => DesignTextModel::TEXT_TRANSFORM_CAPITALIZE,
					"t.letterSpacing" => 10,
					"t.lineHeight"    => 150,
				],
				[
					"t.size"           => "30",
					"t.family"         => DesignTextModel::FAMILY_GEORGIA,
					"t.color"          => "rgba(20,255,40,0.5)",
					"t.isItalic"      => "0",
					"t.isBold"        => "0",
					"t.align"          => DesignTextModel::TEXT_ALIGN_RIGHT,
					"t.decoration"     => DesignTextModel::TEXT_DECORATION_LINE_THROUGH,
					"t.transform"      => DesignTextModel::TEXT_TRANSFORM_LOWERCASE,
					"t.letterSpacing" => "20",
					"t.lineHeight"    => "100",
				],
				[],
				[
					"t.size"           => 30,
					"t.family"         => DesignTextModel::FAMILY_GEORGIA,
					"t.color"          => "rgba(20,255,40,0.5)",
					"t.isItalic"      => 0,
					"t.isBold"        => 0,
					"t.align"          => DesignTextModel::TEXT_ALIGN_RIGHT,
					"t.decoration"     => DesignTextModel::TEXT_DECORATION_LINE_THROUGH,
					"t.transform"      => DesignTextModel::TEXT_TRANSFORM_LOWERCASE,
					"t.letterSpacing" => 20,
					"t.lineHeight"    => 100,
				],
			],
			// Insert: values with incorrect type. Update: values with incorrect type
			[
				[
					"t.size"           => "incorrect_type",
					"t.family"         => "incorrect_type",
					"t.color"          => "incorrect_type",
					"t.isItalic"      => "incorrect_type",
					"t.isBold"        => "incorrect_type",
					"t.align"          => "incorrect_type",
					"t.decoration"     => "incorrect_type",
					"t.transform"      => "incorrect_type",
					"t.letterSpacing" => "incorrect_type",
					"t.lineHeight"    => "incorrect_type",
				],
				[],
				[
					"t.size"           => 0,
					"t.family"         => DesignTextModel::FAMILY_MYRAD,
					"t.color"          => "",
					"t.isItalic"      => 0,
					"t.isBold"        => 0,
					"t.align"          => DesignTextModel::TEXT_ALIGN_LEFT,
					"t.decoration"     => DesignTextModel::TEXT_DECORATION_NONE,
					"t.transform"      => DesignTextModel::TEXT_TRANSFORM_NONE,
					"t.letterSpacing" => 0,
					"t.lineHeight"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
				],
				[
					"t.size"           => "incorrect_type",
					"t.family"         => "incorrect_type",
					"t.color"          => "incorrect_type",
					"t.isItalic"      => "incorrect_type",
					"t.isBold"        => "incorrect_type",
					"t.align"          => "incorrect_type",
					"t.decoration"     => "incorrect_type",
					"t.transform"      => "incorrect_type",
					"t.letterSpacing" => "incorrect_type",
					"t.lineHeight"    => "incorrect_type",
				],
				[],
				[
					"t.size"           => 0,
					"t.family"         => DesignTextModel::FAMILY_MYRAD,
					"t.color"          => "",
					"t.isItalic"      => 0,
					"t.isBold"        => 0,
					"t.align"          => DesignTextModel::TEXT_ALIGN_LEFT,
					"t.decoration"     => DesignTextModel::TEXT_DECORATION_NONE,
					"t.transform"      => DesignTextModel::TEXT_TRANSFORM_NONE,
					"t.letterSpacing" => 0,
					"t.lineHeight"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
				],
			],
			// Insert: incorrect values. Update: incorrect values.
			[
				[
					"t.size"           => DesignTextModel::MIN_SIZE_VALUE - 1,
					"t.family"         => 999,
					"t.color"          => "0,255,0",
					"t.isItalic"      => 8,
					"t.isBold"        => 6,
					"t.align"          => 67,
					"t.decoration"     => 74,
					"t.transform"      => 37,
					"t.letterSpacing" => DesignTextModel::MIN_LETTER_SPACING_VALUE -1,
					"t.lineHeight"    => DesignTextModel::MIN_LINE_HEIGHT_VALUE - 1,
				],
				[],
				[
					"t.size"           => 0,
					"t.family"         => DesignTextModel::FAMILY_MYRAD,
					"t.color"          => "",
					"t.isItalic"      => 1,
					"t.isBold"        => 1,
					"t.align"          => DesignTextModel::TEXT_ALIGN_LEFT,
					"t.decoration"     => DesignTextModel::TEXT_DECORATION_NONE,
					"t.transform"      => DesignTextModel::TEXT_TRANSFORM_NONE,
					"t.letterSpacing" => DesignTextModel::MIN_LETTER_SPACING_VALUE,
					"t.lineHeight"    => DesignTextModel::MIN_LINE_HEIGHT_VALUE,
				],
				[
					"t.size"           => DesignTextModel::MIN_SIZE_VALUE - 100,
					"t.family"         => -12,
					"t.color"          => "#cccccc",
					"t.isItalic"      => -3,
					"t.isBold"        => -1,
					"t.align"          => -10,
					"t.decoration"     => -5,
					"t.transform"      => -12,
					"t.letterSpacing" => DesignTextModel::MIN_LETTER_SPACING_VALUE -1,
					"t.lineHeight"    => DesignTextModel::MIN_LINE_HEIGHT_VALUE - 1,
				],
				[],
				[
					"t.size"           => 0,
					"t.family"         => DesignTextModel::FAMILY_MYRAD,
					"t.color"          => "",
					"t.isItalic"      => 0,
					"t.isBold"        => 0,
					"t.align"          => DesignTextModel::TEXT_ALIGN_LEFT,
					"t.decoration"     => DesignTextModel::TEXT_DECORATION_NONE,
					"t.transform"      => DesignTextModel::TEXT_TRANSFORM_NONE,
					"t.letterSpacing" => DesignTextModel::MIN_LETTER_SPACING_VALUE,
					"t.lineHeight"    => DesignTextModel::MIN_LINE_HEIGHT_VALUE,
				],
			],
		];
	}
}