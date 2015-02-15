<?php


?>
<html>
	<head>
	
	</head>
	<body>
		offline

		<iframe id='manifest_iframe_hack' 
		  style='display: none;' 
		  src='manifest_iframe_hack.html'>
		</iframe>

		<script>
	        var favouritesObject = localStorage.getItem("userFavourites");
	        console.log(favouritesObject);
		</script>
	</body>
</html>