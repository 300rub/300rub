<?php

// Main settings
return [
	"isDebug" => true,
	"host"    => "localhost",
	"language" => 1,
	"db"      => [
		"host"     => "127.0.0.1",
		"user"     => "root",
		"password" => "root",
		"name"     => "testS",
	],
	"email"   => [
		"address" => "donvasilion@gmail.com",
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
	"siteId" => 0,
	"memcached" => [
		"host" => "localhost",
		"port" => 11211
	]
];