<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>

    ##/page/headers##
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="Generator" content="Serif PagePlus X5">

<style type="text/css">

.azioni { text-align: right; }
.tabella_admin {width:100%; border:0px; }
.tabella_admin td { border-bottom:1px solid #f2f2f2; }
.paneltable {padding:0px; font-family:arial; font-size:11px; width:100%;}
.altsx {width:11px; height:46px; background-image:url(/immagini/grafica/layouts/admin/altsx.png);}
.altce {height:46px; background-image:url(/immagini/grafica/layouts/admin/altce.png); font-weight:bold;}
.altdx {height:46px; background-image:url(/immagini/grafica/layouts/admin/altdx.png);width:20px;}
.altsxg {width:11px; height:46px; background-image:url(/immagini/grafica/layouts/admin/altsxg.png);}
.altceg {height:46px; background-image:url(/immagini/grafica/layouts/admin/altceg.png); font-weight:bold;}
.altdxg {height:46px; background-image:url(/immagini/grafica/layouts/admin/altdxg.png);width:20px;}
.medsx {width:11px; background-image:url(/immagini/grafica/layouts/admin/medsx.png);}
.medce {background-image:url(/immagini/grafica/layouts/admin/medce.png);}
.meddx { background-image:url(/immagini/grafica/layouts/admin/meddx.png);width:20px;}
.bassx {width:11px; height:15px; background-image:url(/immagini/grafica/layouts/admin/bassx.png);}
.basce {height:15px; background-image:url(/immagini/grafica/layouts/admin/basce.png);}
.basdx {height:15px; background-image:url(/immagini/grafica/layouts/admin/basdx.png);width:20px;}
.coldx {width:200px;}
.colsx {width:200px;}
.mbcraft {padding-top:10px;padding-bottom:10px;}
.crabscredits {font-size:10px; color:#666; text-align:left; font-family:arial;}

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
		<div class="azienda" align="center"><a href="/" target="_blank" border="0"><img src="/immagini/grafica/admin/logo_azienda.png" border="0" /></a><div>
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
	<div class="mbcraft" align="center"><a href="http://www.mbcraft.it" target="_blank"><img src="/framework/core/immagini/logo_mbcraft.png" border="0"></a></div>
	<div class="crabscredits">
    ##/framework/installed_modules##
</div>
	</td>
	</tr>
	</table>
</body>
</html>
