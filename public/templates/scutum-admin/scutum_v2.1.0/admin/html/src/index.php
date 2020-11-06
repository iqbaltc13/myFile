<?php
define('safe_access',true);
include('php/variables.php');
?>
<!doctype html>
<html lang="en"<?php if(isset($htmlClass)){echo ' class="'.$htmlClass.'"';};?>>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Scutum Admin Template</title>
    <meta name="description" content="Scutum Admin Template" />

    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/fav/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="assets/img/fav/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="assets/img/fav/favicon-16x16.png">
	<link rel="mask-icon" href="assets/img/fav/safari-pinned-tab.svg" color="#5bbad5">

	<link rel="manifest" href="manifest.json">
	<meta name="theme-color" content="#00838f">

<?php if (isset($customMeta)) { echo $customMeta; }; PHP_EOL; ?>

	<!-- polyfills -->
	<script src="assets/js/vendor/polyfills.min.js"></script>

	<!-- UIKit js -->
    <script src="assets/js/uikit<?php echo $dist_min; ?>.js"></script>
</head>
<body>
<script>
	// prevent FOUC
	var html = document.getElementsByTagName('html')[0];
	html.style.backgroundColor = '#f5f5f5';
	document.body.style.visibility = 'hidden';
	document.body.style.overflow = 'hidden';
	document.body.style.apacity = '0';
	document.body.style.maxHeight = "100%";
</script>
<?php include('php/partials/header.php'); ?>

<?php include('php/partials/sidebar.php'); ?>

<?php if( isset($includePage) && file_exists(realpath(__DIR__).'/php/views/' . $includePage) ) {
	global $dt;
	include('php/views/' . $includePage);
} else {
	echo '<div id="sc-page-wrapper"><div id="sc-page-content">';
	echo('<pre>');
	var_dump($includePage);
	echo('</pre>');
	echo '<div class="uk-alert uk-alert-danger">Page not found</div></div></div>';
} ?>

<?php if($page === 'footer') { ?>
	<?php include('php/partials/footer.php'); ?>
<?php }; ?>

<!-- async assets-->
<script>
// loadjs.js (assets/js/vendor/loadjs.js)
loadjs=function(){function v(a,d){a=a.push?a:[a];var c=[],b=a.length,e=b,g,k;for(g=function(a,b){b.length&&c.push(a);e--;e||d(c)};b--;){var h=a[b];(k=n[h])?g(h,k):(h=p[h]=p[h]||[],h.push(g))}}function r(a,d){if(a){var c=p[a];n[a]=d;if(c)for(;c.length;)c[0](a,d),c.splice(0,1)}}function t(a,d){a.call&&(a={success:a});d.length?(a.error||q)(d):(a.success||q)(a)}function u(a,d,c,b){var e=document,g=c.async,k=c.preload;try{var h=document.createElement("link").relList.supports("preload")}catch(y){h=0}var l=
(c.numRetries||0)+1,p=c.before||q,m=a.replace(/^(css|img)!/,"");b=b||0;if(/(^css!|\.css$)/.test(a)){var n=!0;var f=e.createElement("link");k&&h?(f.rel="preload",f.as="style"):f.rel="stylesheet";f.href=m}else/(^img!|\.(png|gif|jpg|svg)$)/.test(a)?(f=e.createElement("img"),f.src=m):(f=e.createElement("script"),f.src=a,f.async=void 0===g?!0:g);f.onload=f.onerror=f.onbeforeload=function(e){var g=e.type[0];if(n&&"hideFocus"in f)try{f.sheet.cssText.length||(g="e")}catch(w){18!=w.code&&(g="e")}if("e"==g&&
(b+=1,b<l))return u(a,d,c,b);k&&h&&(f.rel="stylesheet");d(a,g,e.defaultPrevented)};!1!==p(a,f)&&(n?e.head.insertBefore(f,document.getElementById("main-stylesheet")):e.head.appendChild(f))}function x(a,d,c){a=a.push?a:[a];var b=a.length,e=b,g=[],k;var h=function(a,c,e){"e"==c&&g.push(a);if("b"==c)if(e)g.push(a);else return;b--;b||d(g)};for(k=0;k<e;k++)u(a[k],h,c)}function l(a,d,c){var b;d&&d.trim&&(b=d);var e=(b?c:d)||{};if(b){if(b in m)throw"LoadJS";m[b]=!0}x(a,function(a){t(e,a);r(b,a)},e)}var q=
function(){},m={},n={},p={};l.ready=function(a,d){v(a,function(a){t(d,a)});return l};l.done=function(a){r(a,[])};l.reset=function(){m={};n={};p={}};l.isDefined=function(a){return a in m};return l}();
</script>
<script>
	var html = document.getElementsByTagName('html')[0];
	// ----------- CSS
	// md icons
	loadjs('assets/css/materialdesignicons.min.css', {
        preload: true
	});
    // UIkit
    loadjs('node_modules/uikit/dist/css/uikit.min.css', {
        preload: true
    });
	// themes
	loadjs('assets/css/themes/themes_combined.min.css', {
        preload: true
    });
	// mdi icons (base64) & google fonts (base64)
	loadjs(['assets/css/fonts/mdi_fonts.css', 'assets/css/fonts/roboto_base64.css', 'assets/css/fonts/sourceCodePro_base64.css'], {
        preload: true
    });
	// main stylesheet
	loadjs('assets/css/main<?php echo $dist_min; ?>.css', function() {});
	// vendor
	loadjs('assets/js/vendor<?php echo $dist_min; ?>.js', function () {
			// scutum common functions/helpers
			loadjs('assets/js/scutum_common<?php echo $dist_min; ?>.js', function() {
				scutum.init();
				<?php if(isset($js)) {
					$success = isset($js_success) ? $js_success : '';
					echo 'loadjs(\''.$js.'\', { success: function() { $(function(){'.$success.'}); } })';
				}; echo PHP_EOL; ?>
				// show page
				setTimeout(function () {
					// clear styles (FOUC)
					$(html).css({
						'backgroundColor': '',
					});
					$('body').css({
						'visibility': '',
						'overflow': '',
						'apacity': '',
						'maxHeight': ''
					});
				}, 100);
				// style switcher
				loadjs(['assets/js/style_switcher<?php echo $dist_min; ?>.js', 'assets/css/plugins/style_switcher.min.css'], {
					success: function() {
						$(function(){
							scutum.styleSwitcher();
						});
					}
				});
			});
	});
</script>
<?php if(isset($_GET["demo"])) { ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-136690566-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-136690566-2');
    </script>
<?php }; ?>

<?php include('php/partials/style_switcher.php'); ?>
</body>
</html>
