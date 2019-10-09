<?php

class skin_clans {

function add_start() {
global $ibforums;
return <<<EOF
<div class="borderwrap">
<div class="maintitle">Adding a Clan</div>
<table cellpadding='4' cellspacing='1' border='0' width='100%'>

<tr>
<td colspan=2 class ='row3'>
<tr>

</tr>
<tr>
<td class='row2' width='20%'>Clan Leader</td>
<td class='row2'>{$ibforums->member['name']}</td>
</tr>
<form action='index.php?act=clans&code=doadd' method='POST' name='report'>
<tr>
<td class='row2'>Clan Name</td>
<td class='row2'><input type='text' size='40' maxlength='6' name='cname' class='forminput' /></td>
</tr>
<tr>
<td class='row2' valign='top'>Clan Description</td>
<td class='row2'><textarea cols='60' rows='10' wrap='soft' name='cdesc' class='forminput'></textarea></td>
</tr>

EOF;
}

function add_end() {
global $ibforums;
return <<<EOF
<tr>
<td class='row2'><b>Clan Status</b>
<td class='row2'><select name=state><option class=forminput value=''>Select A Clan State<option class=forminput value='open'>Open<option class=forminput value='closed'>Closed</select> Open if you want people to validate for your clan.</td>
</tr>
<tr>
<td class='row2'><b>Clan Password</b>
<td class='row2'><input type='text' size='40' maxlength='1200' name='password' class='forminput' /></td>
</tr>
<tr>
<td class='pformstrip' colspan='2'><center><input type='submit' name='submit' value='Finish'></center></tr></table></div>
</form>
</table></div>
EOF;
}

function cjoin($clan) {
global $ibforums;
return <<<EOF

<form action='index.php?act=clans&code=docjoin'  method="post" name="clan">
<div class="tableborder">
<div class="maintitle"><b>Clan Password Central</b></div>
<table cellpadding='4' cellspacing='0' border='0' width='100%'>
<tr>
 <td class='row2' colspan='2' width='100%' align='center'><b>Password Validation</b></td>
</tr>
<tr>
 <td class='row2' width='50%'><b>Select Clan</b></td>
 <td class='row2' width='50%'><select name="clan">{$clan}</select></td>
</tr>

<tr>
 <td class='row2'>Clan Password</td>
 <td class='row2' width='50%'><input type='text' name='password' value='' size='30' class='forminput'></td>
</tr>
<tr>
 <td class='pformstrip' colspan='2' width='100%' align='center'><input type='submit' name='joinclan' value='Join'></td>
</tr>
</table>
</div>
</form>

EOF;
}

function edit_start($row)	{
global $ibforums;
return <<<EOF

<div class="borderwrap">
<div class="maintitle">Editing a Clan</div>
<table cellpadding='4' cellspacing='0' border='0' width='100%'>
<form action='index.php?act=clans&code=doedit&tcugid={$ibforums->input['tcugid']}' method='POST' name='report'>
<tr>
<td class='row2'><b>Clan Leader</b></td>
<td class='row2'>{$row['mod_name']}</td>
</tr>
<tr>
<td class='row2'><b>Clan Name</b></td>
<td class='row2'><input type='text' size='40' maxlength='15' name='cname' value="{$row['name']}" class='forminput' /></td>
</tr>
<tr>
<td class='row2' valign='top'><b>Clan Description.</b> <br>You can enter a Clan Flag or Clan Image here by adding the url in an image tag.</td>
<td class='row2'><textarea cols='60' rows='10' wrap='soft' name='cdesc' class='forminput'>{$row['description']}</textarea></td>
</tr>

<tr>
<td class='row2'><b>Clan Status</b>
<td class='row2'><select name=state><option class=forminput value="{$row['state']}">{$row['state']}<option class=forminput value='open'>Open<option class=forminput value='closed'>Closed</select></td>
</tr>
<tr>
<td class='pformstrip' colspan='2'><center><input type='submit' name='submit' value='Finish'></center></tr></table></div>
</form>
</table></div>

EOF;
}

function password($row)	{
global $ibforums;
return <<<EOF

<div class="borderwrap">
<div class="maintitle">Changing Clan Password</div>
<table cellpadding='4' cellspacing='0' border='0' width='100%'>
<form action='index.php?act=clans&code=dopw&tcugid={$ibforums->input['tcugid']}' method='POST' name='report'>

<tr>
<td class='row2' valign='top'>Old Password</td>
<td class='row2'><input type='text' size='40' maxlength='1200' name='current_pass'  class='forminput' /></td>
</tr>
<tr>
<td class='row2'><b>New Password</b>
<td class='row2'><input type='text' size='40' maxlength='1200' name='password_new1'  class='forminput' /></td>
</tr>
<tr>
<td class='row2'><b>Retype New Password</b>
<td class='row2'><input type='text' size='40' maxlength='1200' name='password_new2'  class='forminput' /></td>
</tr>
<tr>
<td class='pformstrip' colspan='2'><center><input type='submit' name='submit' value='Finish'></center></tr></table></div>
</form>
</table></div>

EOF;
}

function clan_del($row)	{
global $ibforums;
return <<<EOF

<div class="borderwrap">
<div class="maintitle"><b>Clan Deletion</b></div>
<table cellpadding='4' cellspacing='0' border='0' width='100%'>
<form action='index.php?act=clans&code=dodel&tcugid={$ibforums->input['tcugid']}' method='POST' name='report'>

<tr>
<td class='row2' valign='top'>Deletion of Clan {$row['name']}</td>
<td class='row2'><b>The changes you make here are none reversible</b>. You clan members will automatically be kicked from the clan and we cannot do anything if you delete by mistake.</td>
</tr>
<tr>
<td class='pformstrip' colspan='2'><center><input type='submit' name='submit' value='Finish'></center></tr></table></div>
</form>
</table></div>

EOF;
}


}
?>