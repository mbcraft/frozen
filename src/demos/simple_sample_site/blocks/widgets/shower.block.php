<?
JS::require_jquery();
CSS::require_css("/css/widgets/shower/shower.css");
?>
<script type="text/javascript">
    function open_shower(load_url,params)
    {
        $.get(load_url,params,function(data, status, request)
        {
            if (status=="success" || status=="notmodified")
            {
                $("#shower_content").html(data);
                $("#shower").show("slow");
                //$("#shower_central").css("margin-top",-($("#shower_central").height()/2)+"px")
                $("#shower_central").css("margin-left",-($("#shower_central").width()/2)+"px");
            }
        });
    }
    function close_shower()
    {
        $("#shower").hide("slow");
    }
</script>
<style type="text/css">
    #shower
{
    z-index:100;
    max-width:100%;
    width:100%;
    min-width:100%; 
    max-height:100%;
    height:100%;
    min-height:100%;    
    position:fixed; 
    display:none;
    top:0;
    left:0;
    
    background-color:#ffffff;
    opacity:0.8; 
    filter:alpha(opacity = 80);
}
#shower_central
{
    z-index: 150; 
    position:relative; 
    margin:auto;
    min-width:80%;
    width:80%;
    max-width:80%;
    left:50%; 
    top:5%;
}
#shower_content
{
    width:100%;
    max-width:100%;
    padding:5px;
    background-color : #E5EFFD;
}
#shower_closer
{
    min-width:100%;
    width:100%;
    max-width:100%; 
    padding:5px;
    height:50px;
    
    background-color: #E5EFFD; 
    
}
</style>
<div align="center" id="shower">

    <div id="shower_central">
        <div id="shower_closer">
            <img style="float:right; padding:10px;" src="/immagini/grafica/widgets/shower/close.png" alt="[close]" onclick="close_shower();" title="Chiudi" />
        </div>
        <div id="shower_content">
            BLA BLA BLA E ANCORA BLA
        </div>
    </div>
</div>