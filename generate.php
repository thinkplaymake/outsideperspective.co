<?php

	// error
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	require_once('vendor/autoload.php');
	$twig = new \outsideperspective\twig;



	// fetch and generate flags.
	$fetch_articles = false;
	$generate_articles = true;
	$generate_homepage = true;
	$generate_workwithus = true;
	
	
	
	// fetch articles
	if (!file_exists('cache/articles.json') && $_REQUEST['cc']??false=='cc') $fetch_articles = true;
	if ($fetch_articles) {
		$articles_url = 'https://api.cosmicjs.com/v3/buckets/outsideperspective-production/objects?pretty=true&query=%7B%22type%22:%22memberarticles%22%7D&limit=10&read_key=dFp5XaZFrtOnZEEGiraklewHIcd16MF1ZnHRpMwTI4RXnVXH0R&depth=1&props=slug,title,metadata,';
		$articles_json = file_get_contents($articles_url);
		file_put_contents('cache/articles.json', $articles_json);
		
	}	
	$articles_json = file_get_contents('cache/articles.json');
	$articles = json_decode($articles_json,true);
	
	
	if ($generate_articles) {
		// render articles
		foreach($articles['objects'] as $article) {
			$html = $twig->render('article.html', ['article'=>$article] );
			file_put_contents(\outsideperspective\conf::output_path . '/article/' . $article['slug'] . '.html', $html);
		}
		
		$html = $twig->render('articlelist.html', ['articles'=>$articles['objects']] );
		file_put_contents(\outsideperspective\conf::output_path . '/article/index.html', $html);
		
		
	}
	
	// render homepage
	if ($generate_homepage) {
		$html = $twig->render('index.html', ['articles'=>$articles['objects']] );
		file_put_contents(\outsideperspective\conf::output_path . '/index.html', $html);
		print $html;
	}
	
	// generate workwithus
	if ($generate_workwithus) {
		$html = $twig->render('workwithus.html' );
		file_put_contents(\outsideperspective\conf::output_path . '/workwithus.html', $html);
	}
	
	
	
	
	
	// render sitemap
	$html = $twig->render('sitemap.txt', ['articles'=>$articles['objects']] );
	file_put_contents(\outsideperspective\conf::output_path . '/sitemap.txt', $html);
	
	
	
	