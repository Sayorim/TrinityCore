<?php
include 'server_info.php';
$connection = mysql_connect($hostip, $username , $password)
or die("Verbindung zur Datenbank konnte nicht hergestellt werden");
mysql_select_db("realmd") or die ("Datenbank konnte nicht ausgewaaml;hlt werden");
$mysqluser = mysql_real_escape_string($_POST["mysqluser"]);
$email = mysql_real_escape_string($_POST["email"]);
$pw = mysql_real_escape_string($_POST["pw"]);
$pw2 = mysql_real_escape_string($_POST["pw2"]);
$ip = getenv("REMOTE_ADDR");
$expansion = mysql_real_escape_string($_POST["expansion"]);

if ($mysqluser == "" || $pw != $pw2 || $pw == "" || $email == "")
{
	echo "<body text=\"61100c\" bgcolor=\"000\" link=\"61100c\" alink=\"61100c\" vlink=\"61100c\">
	<center>
	Es wurden nicht alle Felder korrekt ausgef&uuml;llt!
	<br>
	<a href=\"index.php\">Zur&uuml;ck</a>
	</center>
	</body>";
	exit;
}

if (!preg_match('/^[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+(?:\.[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+)*\@[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+(?:\.[^\x00-\x20()<>@,;:\\".[\]\x7f-\xff]+)+$/i', $email))
{
        echo '<body text="61100c" bgcolor="000" link="61100c" alink="61100c" vlink="61100c">
        <center>
        Die angegebene E-Mail Adresse ist nicht korrekt!
        <br>
        <a href="index.php">Zur&uuml;ck</a>
        </center>
        </body>';
        exit();
}
{
$result = mysql_query("SELECT * FROM account WHERE username LIKE '$mysqluser'");
$menge2 = mysql_num_rows($result);

if ($menge2 == 0)
{
	$entry = "INSERT INTO account (username, sha_pass_hash, email, last_ip, expansion) VALUES (UPPER('".$mysqluser."'), SHA1(CONCAT(UPPER('".$mysqluser."'),':',UPPER('".$pw."'))),'".$email."','".$ip."','".$expansion."')";
	$enter = mysql_query($entry);
	$prem = "INSERT INTO rbac_account_groups VALUES ((SELECT id FROM account WHERE username = '".$mysqluser."'), 1, -1)";
	$enter2 = mysql_query($prem)or die(mysql_error()) ;
if ($enter == true && $enter2 == true)
{
	echo "<body text=\"61100c\" bgcolor=\"000\" link=\"61100c\" alink=\"61100c\" vlink=\"61100c\">
	<center>
	Ihr Account wurde erfolgreich erstellt!
	<br>
	Sie k&ouml;nnen sich nun auf dem Server einloggen.
	<br>
	<a href=\"index.php\">Zur&uuml;ck</a>
	</center>
	</body>";
}
else
{
	echo "<body text=\"61100c\" bgcolor=\"000\" link=\"61100c\" alink=\"61100c\" vlink=\"61100c\">
	<center>
	Es gab einen Fehler beim Speichern!
	<br>
	Bitte wenden sie sich an den Server-Administrator.
	<br>
	<a href=\"index.php\">Zur&uumlck</a>
	</center>
	</body>";
}
}
else
{
	echo "<body text=\"61100c\" bgcolor=\"0000\" link=\"61100c\" alink=\"61100c\" vlink=\"61100c\">
	<center
	Ein Account mit diesem Benutzernamen ist bereits vorhanden, bitte versuchen Sie es erneut!
	<br>
	<a href=\"index.php\">Zur&uumlck</a>
	</center>
	</body>";
}
}
?>