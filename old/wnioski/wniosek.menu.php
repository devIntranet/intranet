<?
if  ($ile_sprawdz_usera == 1)
	{
	$user_dzial=mysql_fetch_array($sprawdz_usera);
	$dzial_ad=$wpis[0][department][0];		
	if (($entry[0]['directreports'][0]) && ($wpis[0]['department'][0] == NK))
		{
		$wniosek_user='kxx';
		}
	if (($entry[0]['directreports'][0]) && ($wpis[0]['department'][0] != NK) && ($wpis[0]['department'][0] != NI))
		{
		$wniosek_user='kxx';
		}
	if ((!$entry[0]['directreports'][0]) && ($wpis[0]['department'][0] == NK))
		{
		$wniosek_user='pnk';
		}
	if ((!$entry[0]['directreports'][0]) && ($wpis[0]['department'][0] != NK) && ($wpis[0]['department'][0] != NI))
		{
		$wniosek_user='pxx';
		}
	if (($entry[0]['directreports'][0]) && ($wpis[0]['department'][0] == NI))
		{
		$wniosek_user='ni';
		}
	if ((!$entry[0]['directreports'][0]) && ($wpis[0]['department'][0] == NI))
		{
		$wniosek_user='ni';
		}
	//echo "Profil: $wniosek_user";
	
		if ($wniosek_user == ni)
			{
			echo "
			<table>
			<tr>
			<td>
			<form method=post action=?m=up>
			<input type=hidden name=d value=1>
			<input class= s_zloz type=submit name=go value=''>
			</form>
			</td>
			<td>
			</form>
			<form action=index.php?m=up& method=post>
			<input type=hidden name=d value=7>
			<input class=s_nowe type=submit name=wybierz value=''>
			</form>
			</td>
			<td>
			</form>
			<form action=index.php?m=up& method=post>
			<input type=hidden name=d value=4>
			<input class=s_otwarte type=submit name=wybierz value=''>
			</form>
			</td>
			<td>
			</form>
			<form action=index.php?m=up& method=post>
			<input type=hidden name=d value=3>
			<input class=s_zakonczone type=submit name=wybierz value=''>
			</form>
			</td>
			<td>
			</form>
			<form action=index.php?m=up& method=post>
			<input type=hidden name=d value=6>
			<input class=s_odwolane type=submit name=wybierz value=''>
			</form>
			</td>
			<td>
			<form method=post action=index.php?m=up&>
			<input type=hidden name=d value=2>
			<input class=s_wszystkie type=submit name=wroc value=''>
			</form>
			</td>
			</tr>
			<tr>
			<td></td>
			<td></td>
			<td></td>
			<td>
			</form>
			<form action=index.php?m=up& method=post>
			<input type=hidden name=d value=5>
			<input class=s_zaspap type=submit name=wybierz value=''>
			</form>
			</td>
			<td>
			</form>
			<form action=index.php?m=up& method=post>
			<input type=hidden name=d value=8>
			<input class=s_moduly type=submit name=wybierz value=''>
			</form>
			</td>
			<td>
			<form method=post action=index.php?m=up&>
			<input type=hidden name=d value=9>
			<input class=s_ewidencja type=submit name=wroc value=''>
			</form>
			</td>
			</tr>
			</table>
			";
			//include('../wnioski/wniosek.det.ni.php');
			}
		if ($wniosek_user == kxx)
			{
			$menu = "
			<table>
			<tr>
			<td>
			<form method=post action=index.php?m=up&>
			<input type=hidden name=d value=1>
			<input class=s_nowy type=submit name=go value=''>
			</form>
			</td>
			<td>
			<form method=post action=index.php?m=up&>
			<input type=hidden name=d value=2>
			<input class=s_mojewn type=submit name=wroc value='moje wnioski'>
			</form>
			</td>
			<td>
			</form>
			<form action=index.php?m=up& method=post>
			<input type=hidden name=d value=5>
			<input class=s_zaspap type=submit name=wybierz value='zasoby papierowe'>
			</form>
			</td>
			</tr>
			</table>
			";
			require('../wnioski/wniosek.det.kxx.php');
			}
		if ($wniosek_user == pnk)
			{
			$menu = "
			<table>
			<tr>
			<td>
			</form>
			<form action=index.php?m=up& method=post>
			<input type=hidden name=d value=1>
			<input type=submit name=wybierz value='nowe'>
			</form>
			</td>
			<td>
			</form>
			<form action=index.php?m=up& method=post>
			<input type=hidden name=d value=3>
			<input type=submit name=wybierz value='zakoñczone wnioski'>
			</form>
			</td>
			<td>
			</form>
			<form action=index.php?m=up& method=post>
			<input type=hidden name=d value=6>
			<input type=submit name=wybierz value='odwo³ane wnioski'>
			</form>
			</td>
			<td>
			<form method=post action=index.php?m=up&>
			<input type=hidden name=d value=4>
			<input type=submit name=wroc value='wszystkie wnioski'>
			</form>
			</td>
			<td>
			<form method=post action=index.php?m=up&>
			<input type=hidden name=d value=9>
			<input type=submit name=wroc value='ewidencja upowa¿nieñ'>
			</form>
			</td>
			</tr>
			</table>
			";
			require('../wnioski/wniosek.det.pnk.php');
			}
		if ($wniosek_user == pxx)
			{
			require('../wnioski/wniosek_pxx.inc.php');
			}
		if ($wniosek_user == ni)
			{
			#require('../strona/wniosek_ni.inc.php');
			}
	}
?>