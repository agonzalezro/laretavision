<?php
$chios = simplexml_load_file('http://lareta.net/rss');
$chio = $chios->item;
$link = $chio->link;
$title = utf8_decode($chio->title);
$description = utf8_decode($chio->description);
$dc = $chio->children('http://purl.org/dc/elements/1.1/');
$creator = $dc->creator;

echo $title . $link . $descripton . $creator;
?>
