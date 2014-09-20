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
            <table align="center">

                <tr>
                    <td style="vertical-align:top;">
                        <!-- Facebook Badge START --><a href="https://www.facebook.com/Frostlab" target="_TOP" style="font-family: &quot;lucida grande&quot;,tahoma,verdana,arial,sans-serif; font-size: 11px; font-variant: normal; font-style: normal; font-weight: normal; color: #3B5998; text-decoration: none;" title="Frostlab gate">Frostlab gate</a><br/><a href="https://www.facebook.com/Frostlab" target="_TOP" title="Frostlab gate"><img src="https://badge.facebook.com/badge/418707570048.3548.735540899.png" style="border: 0px;" /></a><br/><a href="http://www.facebook.com/business/dashboard/" target="_TOP" style="font-family: &quot;lucida grande&quot;,tahoma,verdana,arial,sans-serif; font-size: 11px; font-variant: normal; font-style: normal; font-weight: normal; color: #3B5998; text-decoration: none;" title="Crea il tuo badge!">Promuovi anche tu<br /> la tua Pagina</a><!-- Facebook Badge END -->
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">

                        <div id='networkedblogs_nwidget_container' style='height:150px;padding-top:10px;'><div id='networkedblogs_nwidget_above'></div><div id='networkedblogs_nwidget_widget' style="border:1px solid #D1D7DF;background-color:#F5F6F9;margin:0px auto;"><div id="networkedblogs_nwidget_logo" style="padding:1px;margin:0px;background-color:#edeff4;text-align:center;height:21px;"><a href="http://www.networkedblogs.com/" target="_blank" title="NetworkedBlogs"><img style="border: none;" src="http://static.networkedblogs.com/static/images/logo_small.png" title="NetworkedBlogs"/></a></div><div id="networkedblogs_nwidget_body" style="text-align: center;"></div><div id="networkedblogs_nwidget_follow" style="padding:5px;"><a style="display:block;line-height:100%;width:90px;margin:0px auto;padding:4px 8px;text-align:center;background-color:#3b5998;border:1px solid #D9DFEA;border-bottom-color:#0e1f5b;border-right-color:#0e1f5b;color:#FFFFFF;font-family:'lucida grande',tahoma,verdana,arial,sans-serif;font-size:11px;text-decoration:none;" href="http://www.networkedblogs.com/blog/blog_frostlab_gate?ahash=937a5cda0e9603383d30d9e4c40f8c89">Follow this blog</a></div></div><div id='networkedblogs_nwidget_below'></div></div><script type="text/javascript">
                        if(typeof(networkedblogs)=="undefined"){networkedblogs = {};networkedblogs.blogId=384172;networkedblogs.shortName="blog_frostlab_gate";}
                    </script><script src="http://nwidget.networkedblogs.com/getnetworkwidget?bid=384172" type="text/javascript"></script>
                    </td>
                </tr>
            </table>
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
	<div class="frostlab" align="center"><a href="http://www.frostlab.it" target="_blank"><img src="/immagini/grafica/layouts/admin/logo_frostlab.jpg" border="0"></a></div>
	<div class="crabscredits">
    ##/framework/installed_modules##
</div>
	</td>
	</tr>
	</table>
</body>
</html>