<?
if (!isset($timeOffset)) $timeOffset = "local";
if (!isset($faceColor)) $faceColor = "0x000000";
if (!isset($faceColorAlpha)) $faceColorAlpha = "0";
if (!isset($numbersColor)) $numbersColor = "0x4F77A0";
if (!isset($width)) $width="150";
if (!isset($height)) $height="50";
?>
<embed src="/swf/clocks/digital-flash-clock-2.swf?timeOffset=<?=$timeOffset ?>&faceColor=<?=$faceColor ?>&faceColorAlpha=<?=$faceColorAlpha ?>&numbersColor=<?=$numbersColor ?>" width="<?=$width ?>px" height="<?=$height ?>px" wmode="transparent" type="application/x-shockwave-flash">