<meta charset="utf-8">
<title>Ukázka jednoduchých převodů BB kódu do HTML</title>

<h1>Jednoduché formátování BB značkami</h1>

<p>Vztahuje se k článku <a href="http://jecas.cz/bb-code">BB Code</a>.</p>

<hr>

<?php 
// Text ke zformátování
$text = "[b]Tučný [i]text[/i][/b], [i]kur[b]s[/b]iva[/i] [i]a[/i] [code]kód[/code]. [img]http://kod.djpw.cz/i/20' onclick='alert(\"Baf\")[/img]
[url=http://example.com onclick='alert(\"Baf\")]Example.[b]com[/b][/url]
";

// Obyčejný BB kód
function obycejnyBbKod($znacky, $text) {
	foreach ($znacky as $znacka) {
		$text = preg_replace(
		  "~\[($znacka)\](.+?)\[/\\1\]~ui", 
		  "<\\1>\\2</\\1>", 
		  $text
		);
	}
	return $text;
}	

// Značka [img]
function imgBbKod($text) {
	$text = preg_replace(
	  "~\[img\](.+?)\[/img]~ui", 
	  "<img src='\\1'>", 
	  $text
	);
	return $text;
}

// Značka [url]
function urlBbKod($text) {
	$text = preg_replace(
	  "~\[url=(.+?)\](.+?)\[/url]~ui", 
	  "<a href='\\1'>\\2</a>", 
	  $text
	);
	return $text;
}

// Značka [url] s použitím callbacku
function urlBbKodCallback($text) {
	$text = preg_replace_callback(
	  "~\[url=(.+?)\](.+?)\[/url]~ui", 
	  function($vyskyty) {
	  	$cilOdkazu = $vyskyty["1"];
	  	$textOdkazu = $vyskyty["2"];
	  	// nějaké operace
	  	return "<a href='" . $cilOdkazu . "'>" . $textOdkazu . "</a>"; 
	  },
	  $text
	);
	return $text;
}

// Ošetření HTML
$text = htmlspecialchars($text, ENT_QUOTES);

// Obyčejné značky
$text = obycejnyBbKod(
	array("b", "i", "code"), $text
);

// Obrázky
$text = imgBbKod($text);

// Odkazy
//$text = urlBbKod($text);
$text = urlBbKodCallback($text);

// Vypsání zformátovaného textu
echo "<h2>Výsledek</h2>" . $text;
echo "<hr><h2>Zdrojový kód</h2><xmp>" . $text . "</xmp>";