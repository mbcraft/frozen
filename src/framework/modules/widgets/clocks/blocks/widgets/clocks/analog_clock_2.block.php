<?
if (!isset($timeOffset)) $timeOffset = "local";
if (!isset($faceColor)) $faceColor = "0x000000";

if (!isset($numbersColor)) $numbersColor = "0xffffff";
if (!isset($edgeColor)) $edgeColor = "0xffffff";
if (!isset($glowColor)) $glowColor = "0x000000";
if (!isset($centerColor)) $centerColor = "0x555555";
if (!isset($hourHandColor)) $hourHandColor = "0xffffff";
if (!isset($minuteHandColor)) $minuteHandColor = "0xffffff";
if (!isset($secondHandColor)) $secondHandColor = "0xffffff";
if (!isset($width)) $width="150";
if (!isset($height)) $height="150";
?>
<embed src="/swf/clocks/neon-flash-clock.swf?timeOffset=<?=$timeOffset ?>&faceColor=<?=$faceColor ?>&numbersColor=<?=$numbersColor ?>&edgeColor=<?=$edgeColor ?>&glowColor=<?=$glowColor ?>&glowBlur=10&glowStrength=2&hourHandColor=<?=$hourHandColor ?>&minuteHandColor=<?=$minuteHandColor ?>&secondHandColor=<?=$secondHandColor ?>" width="<?=$width ?>px" height="<?=$height ?>px" wmode="transparent" type="application/x-shockwave-flash">