<?php

	// server name or ip
    $server = 'http://scutum-html.local/';
    $folder = '../dist/';

    function curl_html($url,$out) {
        $cmd = "curl '$url' -o $out";
        exec($cmd);
    }

	function rsearch($folder, $pattern) {
		$dir = new RecursiveDirectoryIterator($folder);
		$ite = new RecursiveIteratorIterator($dir);
		$files = new RegexIterator($ite, $pattern, RegexIterator::GET_MATCH);
		$fileList = array();
		foreach($files as $file) {
			$fileList[] = $file[0];
		}
		return $fileList;
	}

    if (is_dir($folder)) {
	    array_map('unlink', glob($folder."*.html"));
    } else {
	    mkdir($folder, 0775, true);
    }
    $files = rsearch("./php/views","/^.*\.(php)$/");

	if(isset($argv[1])) {
		foreach($files as $file) {
			$file = str_replace('./php/views/', '', $file);
			$filename = dirname($file);
			$_file = str_replace('/', '_', $filename) . '-' . str_replace('.php', '', basename($file));
			echo '"' . $_file . '",' . PHP_EOL;
		}
		die();
	}

    foreach($files as $file) {
	    $file = str_replace('./php/views/', '', $file);
	    $filename = dirname($file);
	    $_file = str_replace('/', '_', $filename) . '-' . str_replace('.php', '', basename($file));
	    echo $_file;
	    curl_html($server."index.php?generate&page=".$_file, $folder.$_file.".html");
	    if($_file === 'dashboard-v1') {
            curl_html($server."index.php?generate&page=".$_file, $folder."index.html");
        }
    }

    curl_html($server."login_page.php?generate",$folder."login_page.html");
    curl_html($server."error_404.php?generate",$folder."error_404.html");
    curl_html($server."error_500.php?generate",$folder."error_500.html");