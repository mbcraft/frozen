<form name="form__logout_admin" action="/actions/admin/logout.php" method="POST">
    <button type="submit">
        <span>LOGOUT</span>
    </button>
    <? Form::after("/admin/"); ?>
</form>
<br />
<br />
<?
$durata_sessione = time() - Session::get("/session/timestamp_inizio_sessione");
$mm = intval(floor($durata_sessione / 60) % 60);
$hh = intval(floor($durata_sessione / 3600));
?>
Connesso da : <b><?=$hh ?>h <?=$mm ?> min</b><br />
Utente connesso : <b><?=Session::get("/session/username") ?></b><br />
IP : <b><?= Request::getRemoteIp() ?></b><br />
<br />
Contatta<br />
MBCRAFT<br />
info@mbcraft.it<br />
349 3510861<br />
<br />
<a href="mailto:info@INSERT-YOUR-MAIL-HERE.it?Subject=Richiesta assistenza per <?=Host::current() ?>">[Richiedi assistenza via mail]</a><br />
<a href="mailto:info@INSERT-YOUR-MAIL-HERE.it?Subject=Segnalazione bug per <?=Host::current() ?>">[Segnala un bug]</a><br />