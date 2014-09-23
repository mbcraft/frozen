<?
if (!isset($timeOffset)) $timeOffset = "local";
if (!isset($faceColor)) $faceColor = "0xFFFFFF";

if (!isset($numbersColor)) $numbersColor = "0x222222";
if (!isset($edgeColor)) $edgeColor = "0xFFFFFF";
if (!isset($centerColor)) $centerColor = "0x555555";
if (!isset($hourHandColor)) $hourHandColor = "0x555555";
if (!isset($minuteHandColor)) $minuteHandColor = "0x555555";
if (!isset($secondHandColor)) $secondHandColor = "0x555555";
if (!isset($width)) $width="150";
if (!isset($height)) $height="150";
?>
<embed src="/swf/clocks/analog-flash-clock.swf?timeOffset=<?=$timeOffset ?>&faceColor=<?=$faceColor ?>&numbersColor=<?=$numbersColor ?>&edgeColor=<?=$edgeColor ?>&centerColor=<?=$centerColor ?>&hourHandColor=<?=$hourHandColor ?>&minuteHandColor=<?=$minuteHandColor ?>&secondHandColor=<?=$secondHandColor ?>" width="<?=$width ?>px" height="<?=$height ?>px" wmode="transparent" type="application/x-shockwave-flash">