<!doctype html>
<html lang="en">
	<head>
		<title>JSON Testing</title>
		<meta name="charset" 	content="UTF-8" />
		<meta name="keywords" 	content="JSON, testing, PHP, HTML, CSS" />
		<meta name="author" 	content="John van den Elzen" />
		<meta name="viewport"	content="width=device-width, initial-scale=1.0" />
		<style>
			* {
				margin: 0;
				padding: 0;
				-webkit-box-sizing: border-box;
    			-moz-box-sizing: border-box;
    			box-sizing: border-box;
			}
			body {
				background-color: #f1f1f1;
				margin-top: 100px;
				width: 100vw;
				font-family: "Verdana", sans-serif;
				font-size: 0.9rem;
			}

			.box {
				width: 100%;
			}

			#title {
				background-color: #789dca;
				padding: 10px;
				border-top-left-radius: 10px;
			}
			#content {
				background-color: #fff;
				padding: 10px;

			}
			#footer {
				background-color: #d6d6d6;
				padding: 5px 10px;
				font-size: small;
				color: rgba(0,0,0,0.4);
			}

			#newsbox {
				margin: 0 auto;
				width: 500px;
				box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
				margin-bottom: 25px;
				border-top-left-radius: 10px;
			}

			.newstitle {
				color: #fff;
			}

			form {
				width: 500px;
				margin: 0 auto;
				margin-bottom: 25px;
			}

			label {
				margin-bottom: 5px;
				display: block;
			}

			input, textarea {
				width: 100%;
				padding: 10px;
				border: 0;
				box-shadow: 2px 2px 3px rgba(0,0,0,0.2);
				border-radius: 5px;
				font-family: inherit;
				font-size: inherit;
			}

			textarea {
				height: 200px;
				resize: none;
			}

			input[type=submit] {
				background-color: #789dca;
				color: #fff;
				border: 1px solid #fff;
			}

			input[type=submit]:hover {
				background-color: #fff;
				color: #789dca;
				border: 1px solid #789dca;
				cursor: pointer;
			}

			hr {
				width: 500px;
				margin: 20px auto;
				color: rgba(0,0,0,0.2);
			}

			.system_message {
				text-align: center;
				margin-bottom: 25px;
			}
		</style> 
	</head>
	<body>

		<form method="GET">

			<label for="naam">Naam</label>
			<input type="text" name="naam" placeholder="naam" required />

			<br/>
			<br/>

			<label for="titel">Titel</label>
			<input type="text" name="titel" placeholder="titel" required />

			<br/>
			<br/>

			<label for="bericht">Bericht</label>
			<textarea name="bericht" placeholder="bericht" required></textarea>

			<br/>
			<br/>


			<input type="submit" value="Plaats bericht!" />
		</form>

		<hr />

		<?php
			// CHECK GET VARIABLES AND HANDLE THEM
			if(isset($_GET['titel']) && isset($_GET['bericht']) && isset($_GET['naam'])) {
				
				// GET VARIABLES ARE SET
				$naam 		= $_GET['naam'];
				$titel 		= $_GET['titel'];
				$bericht 	= $_GET['bericht'];
				
				// DECODE JSON FILE
				$_newsData	= json_decode(file_get_contents("news.json"), true);

				// PUSH THESE INTO AN ARRAY
				$_newsNew = array(
					"naam"		=>	$naam,
					"titel"		=>	$titel,
					"bericht"	=>	$bericht
				);

				// APPEND NEW NEWS TO ARRAY
				$_newsData[] 	= $_newsNew;
				$_finalData		= json_encode($_newsData);

				// PUSH DATA INTO JSON FILE
				file_put_contents("news.json", $_finalData);

			}

			// LOAD JSON FROM NEWS FILE
			if(!$_news = json_decode(file_get_contents("news.json"), true)) {
				
				// IF $_NEWS ARRAY IS NOT EMPTY
				if($_news != "" || $_news != null) {

					// DISPLAY A NEWS MARKUP FOR EVERY ITEM IN ARRAY
					for($i = (sizeof($_news)-1) ; $i >= 0 ; $i--) {			

						echo '<article id="newsbox">';
						echo 	'<div id="title"	class="box">';
						// TITEL
						echo 		'<h3 class="newstitle">'.$_news[$i]["titel"].'</h3>';

						echo 	'</div>';

						echo 	'<div id="content"	class="box">';
						// BERICHT
						echo 	$_news[$i]["bericht"];

						echo 	'</div>';
						echo 	'<div id="footer"	class="box">';
						echo 		'Geschreven door ' . $_news[$i]["naam"] . ' op 21 november 2018';
						echo 	'</div>';
						echo '</article>';

					}
				// IF $_NEWS ARRAY IS EMPTY
				} else {
					// DISPLAY MESSAGE
					echo '<p class="system_message">Er zijn geen berichten.</p>';
				}
			}
		?>

	</body>
</html>