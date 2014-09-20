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