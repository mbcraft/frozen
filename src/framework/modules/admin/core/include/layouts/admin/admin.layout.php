<?
JS::require_jquery();
CSS::require_css("/css/admin/admin.css");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="it">
<head>

    ##/page/headers##

<style type="text/css">


</style>
</head>
<body>
	<table width="100%">
	<tr>
		<td class="colsx" valign="top">
            ##/pannello_sinistra##

        </td>
		
		<td class="colce" valign="top">
		<table class="paneltable" cellpadding="0" cellspacing="0">
            <tr>
                <td class="altsx"></td><td class="altce">##/pannello_centrale/titolo##</td><td class="altdx"></td>
            </tr>
            <tr>
                <td class="medsx"></td><td class="medce">##/pannello_centrale/contenuto##</td><td class="meddx"></td>
            </tr>
            <tr>
                <td class="bassx"></td><td class="basce"></td><td class="basdx"></td>
            </tr>
        </table>

	</td>
		
		<td class="coldx" valign="top">
		<div class="azienda" align="center"><a href="/" target="_blank" border="0"><img width="180px" src="/immagini/grafica/admin/logo_azienda.png" border="0" /></a><div>
		<table class="paneltable" cellpadding="0" cellspacing="0">
		<tr>
			<td class="altsxg"></td><td class="altceg">AMMINISTRAZIONE</td><td class="altdxg"></td>
		</tr>
		<tr>
			<td class="medsx"></td><td class="medce">
                <?
                if (call("admin","is_logged"))
                    include_block("admin/show_logged_user");
                else
                    include_block("admin/login_form");
                ?>
            </td><td class="meddx"></td>
		</tr>
		<tr>
			<td class="bassx"></td><td class="basce"></td><td class="basdx"></td>
		</tr>
	</table>
	<div class="frostlab" align="center"><a href="http://www.mbcraft.it" target="_blank"><img src="/framework/core/immagini/logo_mbcraft.png" border="0"></a></div>
	<div class="crabscredits">
    ##/framework/installed_modules##
</div>
	</td>
	</tr>
	</table>
</body>
</html>