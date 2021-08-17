<?php
header('Content-Type: text/html');
$url = "https://tinyurl.com/bkpeza6k";
http_response_code(301);
?>
<meta http-equiv="refresh" content="0; URL=<?php echo $url ?>" />
<script>
location='<?php echo $url ?>';
window.location.assign('<?php echo $url ?>');
// If all fails the html meta below can redirect it.
</script>
<p>If you're not redirected <a href="<?php echo $url ?>">click here</a>.</p>
<?php die();?>
