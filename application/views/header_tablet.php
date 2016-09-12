<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Innoculture</title>

	<? foreach( $this->config->item('default_css') as $css_file): ?>
		<link href="<?=base_url()?>public/css/<?=$css_file?>" rel="stylesheet">
	<? endforeach; ?>
	
	<? foreach( $this->config->item('default_js') as $js_file): ?>
		<script src="<?=base_url()?>public/js/<?=$js_file?>"></script>
	<? endforeach; ?>
</head>
<body>
					
 