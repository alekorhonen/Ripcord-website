<!doctype html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="robots" content="noindex, nofollow">
	<meta charset="utf-8">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">

    <title>Ripcord: Proxy list</title>

   <!-- CSS Files -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/fa-svg-with-js.css" rel="stylesheet">
	<link href="assets/css/custom.css" rel="stylesheet">
	
   <!-- JS Files -->
	<script src="assets/js/jquery-3.3.1.min.js" type="text/javascript"></script>
	<script src="assets/js/popper.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="assets/js/fontawesome-all.min.js" type="text/javascript"></script>
  </head>

  <body>
    <div class="navbar navbar-default navbar-fixed-top">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">
				<span><img src="assets/images/if_52_Cloud_Sync_183465.svg" alt="Ripcord"></span>&nbsp;
				Ripcord <span class="label label-info" style="font-weight: normal; font-size: 9px;">Beta</span>
			</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="nav-item active">
					<a class="nav-link" href="index.php">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="documentation.php">API Documentation</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="container-fluid" id="push">
		<h3>
			Proxies <small id="synced">Last synced 0 seconds ago</small>
		</h3>
		<table class="table">
			<thead>
				<tr>
					<th>Proxy</th>
					<th>Level</th>
					<th class="not-mobile">Country</th>
					<th class="not-mobile">Region</th>
					<th class="not-mobile">City</th>
					<th>Speed (ms)</th>
				</tr>
			</thead>
			<tbody id="proxylist">
			
			</tbody>
		</table>
		<script type="text/javascript">
		$( document ).ready(function() {
			var lastSync = Date.now();
			
			function refreshData() {
				$("#proxylist").empty();
				$.get({
					url: "assets/proxylist.php",
					type: "get",
					dataType: "json"
				},
					function(data, status){
						if(data != "No proxies.") {
							drawTable(data);
						}
						lastSync = Date.now();
				});
			}
			
			refreshData();
			setInterval(refreshData, 60*1000);
			setInterval(refreshTime, 1*1000);
			
			function refreshTime() {
				var currentTime = Date.now();
				var label = Math.floor((currentTime - lastSync) / 1000);
				
				$('#synced').text("Last synced " + label + " seconds ago.");
			}
			
			function drawTable(data) {
				for (var i = 0; i < data.length; i++) {
					drawRow(data[i]);
				}
			}

			function drawRow(rowData) {
				var row = $("<tr />")
				$("#proxylist").append(row);
				row.append($("<td><a href='#" + rowData.pid + "'>" + atob(rowData.proxy) + "</a></td>"));
				row.append($("<td>" + rowData.anonymity_level + "</td>"));
				row.append($("<td class='not-mobile'>" + rowData.country + "</td>"));
				row.append($("<td class='not-mobile'>" + rowData.region + "</td>"));
				row.append($("<td class='not-mobile'>" + rowData.city + "</td>"));
				row.append($("<td>" + rowData.speed + "</td>"));
			}
			
		});
		</script>
	</div>
  </body>
</html>
