<?php                                                                                                                                                                               
include	"lib/functions.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title>LAЯETAvision</title>
	<meta name="keywords" content="lareta, laretavision, mashup, chios, microblogging, google maps, web, 2.0, web2.0, galiza, galicia, irc, chat">
	<meta name="description" content="LAЯETAvision, un mashup de Lareta, sistema de microbloguexo galego con xeoposicionamento mediante Google Maps.">
	<link href="stylesheets/style.css" type="text/css" rel="stylesheet" />
	<!-- para cuppido.homelinux.com-->
	<!-- <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAm85YhpjwWOAjVRurtFoZeBQH4asma63rhMYLjZTPGfeFoZYYLhRZe2InlB1INdGB_yYDfOsyxv9SRQ" type="text/javascript"></script>	 -->
	<!-- para stuff.mabishu.com-->
	<!-- <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAm85YhpjwWOAjVRurtFoZeBQEQxGD5vbrb78_Xnlk82C3jyfKnhTpU8qQYbrh_3z5oUgP5kwXKbWsTQ" type="text/javascript"></script> -->
    <!-- para xota.selfip.com -->
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAIUiRh9vGTU8GIfuQooImRxS404_c7nXWvUC0SBtiNk1hLGlCDRTrx43csMqlzVPtFqsAR0qoEf7_kQ" type="text/javascript"></script>
	<script type="text/javascript" charset="utf-8" src="js/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="js/main.js"></script>
	<script type="text/javascript" charset="utf-8">
		$(document).ready(function() {

			var delayTime = 5; // seconds between update
			var delayTimeHide = 8; // seconds between update

			// variable to cache the previous response from server and don't update if is the same
			var cacheResponse = "";

			//future function to show the number of messages sent from the previous actualization
			function updateCountMessages( user){
				message = '<div><a href="http://www.lareta.net/' + user + '">@' + user + '</a>' + ' escrib&iacute;u unha nova mensaxe.</div>';
				$('#messages').html(message);
				$("#messages").fadeIn("slow");
			}

			// hide hint messages after an long period of time without changes
			function hideMessage(){
				setTimeout(function (){
					$("#messages").fadeOut("slow");
				},delayTimeHide * 1000)
			}
			
			// show the last message from the public timeline
			function showPoolMessages() { 
				$.ajax( { url: 'lib/getLatest.php', success: function(response){
					if (response != cacheResponse) {
						eval(response);
						map.checkResize();
						updateCountMessages(user);
						cacheResponse = response;
						hideMessage();
					};
				}}); 
			}

			// Show the first message when the page is loaded
			showPoolMessages();

			// Setting callback function to periodically show the new messages from lareta.net
			setInterval( showPoolMessages , delayTime * 1000 );

			// Show the menu bubble when we clic the logo button
			$('#logo').click(function(event) {
				$('#menu').toggle("fast");
				return false;
			});
			$('#message').click(function(event) {
				$('#menu').hide("slow");
				return false;
			});

		});
	</script>

</head>

<body onload="initialize()" onunload="GUnload()">
	<div id="map"><div class="loading">Cargando...</div></div>
	<div id="logo">
		<img style="border:none" src="images/laretavision.png" width="200" height="44" alt="Laretavision Logo" />
	</div>
	<div id="messages">
		<div>
			Benvido a LAЯETAvision, un mashup de Lareta e Google Maps.
		</div>
	</div>
	<div id="menu">
		<ul>
			<li><a href="http://www.lareta.net" title="Ir a lareta.net">Ir a Lareta.net</a></li>
			<li><a href="http://www.lareta.net/users" title="Que usuarios hai?">Usuarios</a></li>
			<li><a href="http://wiki.lareta.net/QueroCamisola" title="Quero Camisola">Merchandising</a></li>
			<li><a href="http://wiki.lareta.net">Wiki</a></li>
			<li><a href="http://www.lareta.net/misc">&Uacute;tiles</a></li>
		</ul>
	</div>

</body>
</html>

