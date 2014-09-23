Out of the box example of Securimage CAPTCHA Class.<br /><br />

<img src="include/captcha/securimage/securimage_show.php?sid=<?php echo md5(uniqid(time())); ?>" alt="Captcha" id="image" align="absmiddle" >
<a href="include/captcha/securimage/securimage_play.php" style="font-size: 13px">(Audio)</a><br /><br />

<a href="#" onclick="document.getElementById('image').src = 'include/captcha/securimage/securimage_show.php?sid=' + Math.random(); return false">Reload Image</a>