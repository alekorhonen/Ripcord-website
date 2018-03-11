<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="#">

    <title>Ripcord: API Documentation</title>

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
				<li class="nav-item">
					<a class="nav-link" href="index.php">Home</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="documentation.php">API Documentation</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<h2>API Documentation</h2>
		<hr>
		
		<h3>Required parameters</h3>
		The parameters <code>action</code> and <code>apikey</code> are required on every request.
		<hr>
		
		<h3>Error messages</h3>
		<p>There will always be a json value named <code>success</code> and it will return value <code>false</code> if the request wont succeed.</p>
		<table class="table table-striped table-responsive">
			<thead>
				<tr>
					<th>Message</th>
				<tr>
			</thead>
			<tbody>
				<tr>
				<td>Invalid API call.</td>
				</tr>
				<tr>
					<td>Invalid API key.</td>
				</tr>
				<tr>
					<td>Incorrect parameters.</td>
				</tr>
				<tr>
					<td>You have reached your daily limit.</td>
				</tr>
				<tr>
					<td>Proxy was inputted incorrectly.</td>
				</tr>
				<tr>
					<td>Proxy was not found in our database.</td>
				</tr>
				<tr>
					<td>Proxy was not set in inputted data.</td>
				</tr>
				<tr>
					<td>Anonymity was not set in inputted data.</td>
				</tr>
				<tr>
					<td>Country was not set in inputted data.</td>
				</tr>
				<tr>
					<td>Region was not set in inputted data.</td>
				</tr>
				<tr>
					<td>City was not set in inputted data.</td>
				</tr>
				<tr>
					<td>Response was not set in inputted data, or was inputted incorrectly.</td>
				</tr>
				<tr>
					<td>Proxy was inputted incorrectly.</td>
				</tr>
				<tr>
					<td>Anonymity was inputted incorrectly.</td>
				</tr>
				<tr>
					<td>Country was inputted incorrectly.</td>
				</tr>
				<tr>
					<td>Region was inputted incorrectly.</td>
				</tr>
				<tr>
				<td>City was inputted incorrectly.</td>
				</tr>
			</tbody>
		</table>
		<hr>
		
		<!-- START KEY DETAIL API -->
		<h3>Get API key details <code>getdetails</code></h3>
		<p>Does not require any extra parameters.</p>
		<pre><code>GET</code> /api/v1/index.php?action=getdetails&apikey=X</pre>
		<h4>Response</h4>
		<pre>{"success":true,"apikey":"X","my_limit":"0","total_lookups":"0"}</pre>
		<hr>
		
		<!-- START PROXY DETAIL API -->
		<h3>Get proxy details <code>getproxy</code></h3>
		<p>Will require you to add parameter <code>proxy</code> into <code>GET</code> parameters</p>
		<pre><code>GET</code> /api/v1/index.php?action=getproxy&apikey=X<kbd>&proxy=X</kbd></pre>
		<h4>Response</h4>
		<p>The proxy will always return in base64 format.</p>
		<pre>{"success":true,"proxy":"MDAwLjAwMC4wMDA6ODg4OA==","anonymity_level":"Transparent","country":"Finland","region":"Uusimaa","city":"Helsinki","speed":"3233","first_found_on":"0000-00-00 00:00:00","last_checked":"0000-00-00 00:00:00","total_times_checked":"0"}</pre>
		<hr>
		
		<!-- START POST PROXY API -->
		<h3>Post/Update proxy <code>postproxy</code></h3>
		<p>Will require you to add parameter <code>data</code> into <code>POST</code> parameters.</p>
		<pre>
<code>POST</code> /api/v1/index.php?action=getdetails&apikey=X
data={"proxy":"000.000.000:8888","anonymity_level":"Transparent","country":"Helsinki","region":"Uusimaa","city":"Helsinki","response_time":3000}
</pre>
		<h4>Response</h4>
		<p>If the proxy is already in our database.</p>
		<pre>{"success":true,"message":"Proxy was updated in our database."}</pre>
		<p>If the proxy is not in our database.</p>
		<pre>{"success":true,"message":"Proxy was inserted into our database."}</pre>
		<hr>
	</div>
  </body>
</html>
