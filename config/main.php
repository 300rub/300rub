<?php

// Main settings
return [
	"isDebug" => true,
	"host"    => "project.dev",
	"language" => 1,
	"db"      => [
		"host"     => "localhost",
		"user"     => "root",
		"password" => "",
		"name"     => "project",
	],
	"email"   => [
		"adress" => "moyregion@inbox.ru",
	],
	"helpDb"      => [
		"host"     => "localhost",
		"user"     => "root",
		"password" => "",
		"name"     => "help",
	],
	"ssh" => [
		"active" => "fileServer001",
		"list" => [
			"fileServer001" => [
				"host"           => "",
				"port"           => 22,
				"username"       => "",
				"publicKeyPath"  => "",
				"privateKeyPath" => "",
				"passPhrase"     => "",
				"uploadFolder"   => "/var/www/upload"
			]
		]
	],
	"siteId" => 0
];