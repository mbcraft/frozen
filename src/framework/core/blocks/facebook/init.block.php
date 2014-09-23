<?
JS::require_script("http://connect.facebook.net/it_IT/all.js");
?>
<div id="fb-root"></div>
<script>
  FB.init({
    appId      : '<?=Config::instance()->FACEBOOK_APP_ID ?>',
    status     : true,
    cookie     : true,
    xfbml      : true
  });
</script>