<?php
try {
  if (! @include_once( __DIR__ . '/vendor/autoload.php' )) {
	  throw new Exception ('Autoload error');
  }
//	include_once __DIR__ . '/vendor/autoloasd.php';
} catch (\Exception $e) {
	echo <<<HTML
<div style="color: red; border: 1px solid black; text-align: center;">
		<h3>{$e->getMessage()}</h3>
		<p>Please run: "composer dump-autoload"</p>
</div>
HTML;
	exit(1);
}