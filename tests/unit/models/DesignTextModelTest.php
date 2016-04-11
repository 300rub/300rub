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
					"size"           => 0,
					"family"         => DesignTextModel::FAMILY_MYRAD,
					"color"          => "",
					"is_italic"      => 0,
					"is_bold"        => 0,
					"align"          => DesignTextModel::TEXT_ALIGN_LEFT,
					"decoration"     => DesignTextModel::TEXT_DECORATION_NONE,
					"transform"      => DesignTextModel::TEXT_TRANSFORM_NONE,
					"letter_spacing" => 0,
					"line_height"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
				],
				[],
				[],
				[
					"size"           => 0,
					"family"         => DesignTextModel::FAMILY_MYRAD,
					"color"          => "",
					"is_italic"      => 0,
					"is_bold"        => 0,
					"align"          => DesignTextModel::TEXT_ALIGN_LEFT,
					"decoration"     => DesignTextModel::TEXT_DECORATION_NONE,
					"transform"      => DesignTextModel::TEXT_TRANSFORM_NONE,
					"letter_spacing" => 0,
					"line_height"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
				],
			],
			// Insert: empty values. Update: empty values.
			[
				[
					"size"           => "",
					"family"         => "",
					"color"          => "",
					"is_italic"      => "",
					"is_bold"        => "",
					"align"          => "",
					"decoration"     => "",
					"transform"      => "",
					"letter_spacing" => "",
					"line_height"    => "",
				],
				[],
				[
					"size"           => 0,
					"family"         => DesignTextModel::FAMILY_MYRAD,
					"color"          => "",
					"is_italic"      => 0,
					"is_bold"        => 0,
					"align"          => DesignTextModel::TEXT_ALIGN_LEFT,
					"decoration"     => DesignTextModel::TEXT_DECORATION_NONE,
					"transform"      => DesignTextModel::TEXT_TRANSFORM_NONE,
					"letter_spacing" => 0,
					"line_height"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
				],
				[
					"size"           => "",
					"family"         => "",
					"color"          => "",
					"is_italic"      => "",
					"is_bold"        => "",
					"align"          => "",
					"decoration"     => "",
					"transform"      => "",
					"letter_spacing" => "",
					"line_height"    => "",
				],
				[],
				[
					"size"           => 0,
					"family"         => DesignTextModel::FAMILY_MYRAD,
					"color"          => "",
					"is_italic"      => 0,
					"is_bold"        => 0,
					"align"          => DesignTextModel::TEXT_ALIGN_LEFT,
					"decoration"     => DesignTextModel::TEXT_DECORATION_NONE,
					"transform"      => DesignTextModel::TEXT_TRANSFORM_NONE,
					"letter_spacing" => 0,
					"line_height"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
				],
			],
			// Insert: correct values. Update: correct values.
			[
				[
					"size"           => 20,
					"family"         => DesignTextModel::FAMILY_ARIAL,
					"color"          => "rgb(0,255,0)",
					"is_italic"      => 1,
					"is_bold"        => 1,
					"align"          => DesignTextModel::TEXT_ALIGN_CENTER,
					"decoration"     => DesignTextModel::TEXT_DECORATION_UNDERLINE,
					"transform"      => DesignTextModel::TEXT_TRANSFORM_CAPITALIZE,
					"letter_spacing" => 10,
					"line_height"    => 150,
				],
				[],
				[
					"size"           => 20,
					"family"         => DesignTextModel::FAMILY_ARIAL,
					"color"          => "rgb(0,255,0)",
					"is_italic"      => 1,
					"is_bold"        => 1,
					"align"          => DesignTextModel::TEXT_ALIGN_CENTER,
					"decoration"     => DesignTextModel::TEXT_DECORATION_UNDERLINE,
					"transform"      => DesignTextModel::TEXT_TRANSFORM_CAPITALIZE,
					"letter_spacing" => 10,
					"line_height"    => 150,
				],
				[
					"size"           => "30",
					"family"         => DesignTextModel::FAMILY_GEORGIA,
					"color"          => "rgba(20,255,40,0.5)",
					"is_italic"      => "0",
					"is_bold"        => "0",
					"align"          => DesignTextModel::TEXT_ALIGN_RIGHT,
					"decoration"     => DesignTextModel::TEXT_DECORATION_LINE_THROUGH,
					"transform"      => DesignTextModel::TEXT_TRANSFORM_LOWERCASE,
					"letter_spacing" => "20",
					"line_height"    => "100",
				],
				[],
				[
					"size"           => 30,
					"family"         => DesignTextModel::FAMILY_GEORGIA,
					"color"          => "rgba(20,255,40,0.5)",
					"is_italic"      => 0,
					"is_bold"        => 0,
					"align"          => DesignTextModel::TEXT_ALIGN_RIGHT,
					"decoration"     => DesignTextModel::TEXT_DECORATION_LINE_THROUGH,
					"transform"      => DesignTextModel::TEXT_TRANSFORM_LOWERCASE,
					"letter_spacing" => 20,
					"line_height"    => 100,
				],
			],
			// Insert: values with incorrect type. Update: values with incorrect type
			[
				[
					"size"           => "incorrect_type",
					"family"         => "incorrect_type",
					"color"          => "incorrect_type",
					"is_italic"      => "incorrect_type",
					"is_bold"        => "incorrect_type",
					"align"          => "incorrect_type",
					"decoration"     => "incorrect_type",
					"transform"      => "incorrect_type",
					"letter_spacing" => "incorrect_type",
					"line_height"    => "incorrect_type",
				],
				[],
				[
					"size"           => 0,
					"family"         => DesignTextModel::FAMILY_MYRAD,
					"color"          => "",
					"is_italic"      => 0,
					"is_bold"        => 0,
					"align"          => DesignTextModel::TEXT_ALIGN_LEFT,
					"decoration"     => DesignTextModel::TEXT_DECORATION_NONE,
					"transform"      => DesignTextModel::TEXT_TRANSFORM_NONE,
					"letter_spacing" => 0,
					"line_height"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
				],
				[
					"size"           => "incorrect_type",
					"family"         => "incorrect_type",
					"color"          => "incorrect_type",
					"is_italic"      => "incorrect_type",
					"is_bold"        => "incorrect_type",
					"align"          => "incorrect_type",
					"decoration"     => "incorrect_type",
					"transform"      => "incorrect_type",
					"letter_spacing" => "incorrect_type",
					"line_height"    => "incorrect_type",
				],
				[],
				[
					"size"           => 0,
					"family"         => DesignTextModel::FAMILY_MYRAD,
					"color"          => "",
					"is_italic"      => 0,
					"is_bold"        => 0,
					"align"          => DesignTextModel::TEXT_ALIGN_LEFT,
					"decoration"     => DesignTextModel::TEXT_DECORATION_NONE,
					"transform"      => DesignTextModel::TEXT_TRANSFORM_NONE,
					"letter_spacing" => 0,
					"line_height"    => DesignTextModel::DEFAULT_LINE_HEIGHT,
				],
			],
			// Insert: incorrect values. Update: incorrect values.
			[
				[
					"size"           => DesignTextModel::MIN_SIZE_VALUE - 1,
					"family"         => 999,
					"color"          => "0,255,0",
					"is_italic"      => 8,
					"is_bold"        => 6,
					"align"          => 67,
					"decoration"     => 74,
					"transform"      => 37,
					"letter_spacing" => DesignTextModel::MIN_LETTER_SPACING_VALUE -1,
					"line_height"    => DesignTextModel::MIN_LINE_HEIGHT_VALUE - 1,
				],
				[],
				[
					"size"           => 0,
					"family"         => DesignTextModel::FAMILY_MYRAD,
					"color"          => "",
					"is_italic"      => 1,
					"is_bold"        => 1,
					"align"          => DesignTextModel::TEXT_ALIGN_LEFT,
					"decoration"     => DesignTextModel::TEXT_DECORATION_NONE,
					"transform"      => DesignTextModel::TEXT_TRANSFORM_NONE,
					"letter_spacing" => DesignTextModel::MIN_LETTER_SPACING_VALUE,
					"line_height"    => DesignTextModel::MIN_LINE_HEIGHT_VALUE,
				],
				[
					"size"           => DesignTextModel::MIN_SIZE_VALUE - 100,
					"family"         => -12,
					"color"          => "#cccccc",
					"is_italic"      => -3,
					"is_bold"        => -1,
					"align"          => -10,
					"decoration"     => -5,
					"transform"      => -12,
					"letter_spacing" => DesignTextModel::MIN_LETTER_SPACING_VALUE -1,
					"line_height"    => DesignTextModel::MIN_LINE_HEIGHT_VALUE - 1,
				],
				[],
				[
					"size"           => 0,
					"family"         => DesignTextModel::FAMILY_MYRAD,
					"color"          => "",
					"is_italic"      => 0,
					"is_bold"        => 0,
					"align"          => DesignTextModel::TEXT_ALIGN_LEFT,
					"decoration"     => DesignTextModel::TEXT_DECORATION_NONE,
					"transform"      => DesignTextModel::TEXT_TRANSFORM_NONE,
					"letter_spacing" => DesignTextModel::MIN_LETTER_SPACING_VALUE,
					"line_height"    => DesignTextModel::MIN_LINE_HEIGHT_VALUE,
				],
			],
		];
	}
}