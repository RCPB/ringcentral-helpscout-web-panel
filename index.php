<?php
session_start();
$auth = isset($_SESSION['auth']) && ($_SESSION['auth'] == 'auth');
if ($auth) {
    $configfile = "rc/engine/_credentials.json";
    $data_raw = file_get_contents($configfile);
    $data_json = json_decode($data_raw);
    if (isset($_POST['action']) && $_POST['action'] == 'update' && isset($_POST['helpscout-key'])) {
	$data_json->helpscout = htmlspecialchars($_POST['helpscout-key']);
	file_put_contents($configfile, json_encode($data_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
	header('Location: /');
    }
    $hs_key = $data_json->helpscout;
} else {
    if (isset($_POST['password']) && $_POST['password'] == 'Gleem') {
	$_SESSION['auth'] = 'auth';
	$auth = true;
	header('Location: /');
    }
}
?><!doctype html>
<html>
  <head>
    <title>Update your Helpscout API key</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <main>
      <?php if ($auth) : ?>
      <section id="content">
        <h2>Welcome</h2>
	<p>Sometimes the connection plugin isn't working.  Only (and only one) reason is broken API key of HelpScout.</p>
	<p>To update it, you have to do few simple actions:</p>
	<h4>On Help Scout:</h4>
	<ol>
	    <li>Login to your Help Scout account here: <a href="https://secure.helpscout.net/members/login/" target="_blank">https://secure.helpscout.net/members/login/</a></li>
	    <li>Go to "Your profile"</li>
	    <li>Click on "API Keys" and generate a new one</li>
	    <li>Copy your personal API Key just generated</li>
	</ol>
	<img alt="Helpscout" src="helpscout-api.png" />
	<h4>On this site:</h4>
	<form action="/" method="POST">
	    <input type="hidden" name="action" value="update" />
	    <p>Paste new api key here: <input type="text" name="helpscout-key" value="<?=$hs_key?>" size="40" /> <small>&lt;- if you see something here, it is your current key</small></p>
	    <p>Then hit this button -&gt; <input type="submit" value="Update" /></p>
	</form>
	<h4>And...</h4>
	<p>If you key is correct, plugin will start working in 10 minutes. All previous missed calls wil be placed in your HelpScout account.</p>
      </section>
	<?php else : ?>
	<section id="auth">
	    <h2>Auth</h2>
	<form action="/" method="POST">
	    <input type="hidden" name="action" value="auth" />
	    <p>Password: <input type="password" name="password" value="" size="40" /></p>
	    <input type="submit" value="Submit" />
	</form>
	</section>
	<?php endif; ?>
    </main>

<script type="text/javascript">
WebFontConfig = {
  google: {
    families: ['Roboto:300,400,500']
  }
};

(function(d) {
  var wf = d.createElement('script'), s = d.scripts[0];
  wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js';
  s.parentNode.insertBefore(wf, s);
})(document);
</script>
  </body>
</html>