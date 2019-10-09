<?php
class skin_tcusergroups {
function show_start() {
global $ibforums;
return <<<EOF


<div class="borderwrap">
		<div class="maintitle"></div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
		<tr>
<td class='pformmain'><div align="center">
      <b><a href="{$ibforums->base_url}act=ladder"><img src='style_images/<#IMG_DIR#>/arrow.gif'><font color='orange'>STANDINGS
  </font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'></a></b> </div></td>

<td class='pformmain'><div align="center">
      <b><a href="{$ibforums->base_url}act=tcusergroups"><img src='style_images/<#IMG_DIR#>/arrow.gif'><font color='orange'>CLAN
  CENTRAL</font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'></a></b> </div></td>

<td class='pformmain'><div align="center">
      <b><a href="{$ibforums->base_url}act=ladder&code=show"><img src='style_images/<#IMG_DIR#>/arrow.gif'><font color='orange'>REPORT A GAME
  </font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'></a></b> </div></td>

<td class='pformmain'><div align="center">
      <b><a href="{$ibforums->base_url}act=ladder&code=stats"><img src='style_images/<#IMG_DIR#>/arrow.gif'><font color='#369BED'>GAME STATS</font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'></a></b> </div></td>

				</tr>


		<tr>
<td class='pformmain'><div align="center">Back to the Ladder Standings</div></td>

<td class='pformmain'><div align="center">View details of all current TC Clans</div></td>

<td class='pformmain'><div align="center">Here is where you report a ladder game</div></td>

<td class='pformmain'><div align="center">
      <b><a href="{$ibforums->base_url}act=ladder&code=player"><img src='style_images/<#IMG_DIR#>/arrow.gif'><font color='#369BED'>PLAYER
  STATS</font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'> </a></b></div></td>

				</tr>
</table></div>




<br>


<div class="borderwrap">
		<div class="maintitle">{$ibforums->lang['show_groups']}</div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
		<tr>
		<td class='row3'>{$ibforums->lang['name']}</td>
		<td class='row3'>{$ibforums->lang['details']}</td>
		<td class='row3'>{$ibforums->lang['state']}</td>
		<td class='row3'>{$ibforums->lang['state_to_users']}</td>
		</tr>
EOF;
}
function show_between($data) {
global $ibforums;
return <<<EOF
		<tr>
		<td class='row2'>{$data['name']}</td>
		<td class='row2'><a href='{$ibforums->base_url}act=tcusergroups&amp;code=det&amp;tcugid={$data['tcugid']}'>{$ibforums->lang['details']}</a></td>
		<td class='row2'>{$data['open']}</td>
		<td class='row2' width='10%'>{$data['state']}</td>
		</tr>
EOF;
}
function show_end() {
global $ibforums;
return <<<EOF
		</table>
	</div>
	<br />
EOF;
}
function detail($data) {
global $ibforums;
return <<<EOF
<div class="borderwrap">
		<div class="maintitle"></div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
		<tr>
<td class='pformmain'><div align="center">
      <b><a href="{$ibforums->base_url}act=ladder"><img src='style_images/<#IMG_DIR#>/arrow.gif'><font color='orange'>STANDINGS
  </font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'></a></b> </div></td>

<td class='pformmain'><div align="center">
      <b><a href="{$ibforums->base_url}act=tcusergroups"><img src='style_images/<#IMG_DIR#>/arrow.gif'><font color='orange'>CLAN
  CENTRAL</font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'></a></b> </div></td>

<td class='pformmain'><div align="center">
      <b><a href="{$ibforums->base_url}act=ladder&code=show"><img src='style_images/<#IMG_DIR#>/arrow.gif'><font color='orange'>REPORT A GAME
  </font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'></a></b> </div></td>

<td class='pformmain'><div align="center">
      <b><a href="{$ibforums->base_url}act=ladder&code=stats"><img src='style_images/<#IMG_DIR#>/arrow.gif'><font color='#369BED'>GAME STATS</font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'></a></b> </div></td>

				</tr>


		<tr>
<td class='pformmain'><div align="center">Back to the Ladder Standings</div></td>

<td class='pformmain'><div align="center">View details of all current TC Clans</div></td>

<td class='pformmain'><div align="center">Here is where you report a ladder game</div></td>

<td class='pformmain'><div align="center">
      <b><a href="{$ibforums->base_url}act=ladder&code=player"><img src='style_images/<#IMG_DIR#>/arrow.gif'><font color='#369BED'>PLAYER
  STATS</font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'> </a></b></div></td>

				</tr>
</table></div>




<br>
	<div class="borderwrap">
		<div class="maintitle">Clan Overview</div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
		<tr>
					<td class='row3'>{$ibforums->lang['name']}</td>
					<td class='row3'>{$data['name']}</td>
					<td class='row3'><b>Clan made on:</b> {$data['cadd']}</td>
					</tr>

					<tr>
					<td class='row2'>{$ibforums->lang['description']}</td>
					<td class='row2' colspan='2'>{$data['description']}</td>
					</tr>
					<tr>
										<td class='row2'>Clan Founder</td>
										<td class='row3' colspan='2'><a href='{$ibforums->base_url}showuser={$data['mod_id']}'>{$data['mod_name']}</a></td>
					</tr>
					<tr>
					<td class='row2'>{$ibforums->lang['state']}</td>
					<td class='row2' colspan='2'>{$data['open']}</td>
					</tr>

		<!--IBF_UG_DET-->
		</table>
	</div>
	<br>
EOF;
}

function tcmatch($row, $comment) {
global $ibforums;
return <<<EOF

<div class="borderwrap">
		<div class="maintitle"></div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
		<tr>
<td class='pformmain'><div align="center">
      <b><a href="{$ibforums->base_url}act=ladder"><img src='style_images/<#IMG_DIR#>/arrow.gif'><font color='orange'>STANDINGS
  </font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'></a></b> </div></td>

<td class='pformmain'><div align="center">
      <b><a href="{$ibforums->base_url}act=tcusergroups"><img src='style_images/<#IMG_DIR#>/arrow.gif'><font color='orange'>CLAN
  CENTRAL</font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'></a></b> </div></td>

<td class='pformmain'><div align="center">
      <b><a href="{$ibforums->base_url}act=ladder&code=show"><img src='style_images/<#IMG_DIR#>/arrow.gif'><font color='orange'>REPORT A GAME
  </font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'></a></b> </div></td>

<td class='pformmain'><div align="center">
      <b><a href="{$ibforums->base_url}act=ladder&code=stats"><img src='style_images/<#IMG_DIR#>/arrow.gif'><font color='#369BED'>GAME STATS</font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'></a></b> </div></td>

				</tr>


		<tr>
<td class='pformmain'><div align="center">Back to the Ladder Standings</div></td>

<td class='pformmain'><div align="center">View details of all current TC Clans</div></td>

<td class='pformmain'><div align="center">Here is where you report a ladder game</div></td>

<td class='pformmain'><div align="center">
      <b><a href="{$ibforums->base_url}act=ladder&code=player"><img src='style_images/<#IMG_DIR#>/arrow.gif'><font color='#369BED'>PLAYER
  STATS</font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'> </a></b></div></td>

				</tr>
</table></div>




<br>
	<div class="borderwrap">
							<div class="maintitle">Game # $id Stats</div>


			  <table cellpadding='4' cellspacing='0' border='0' width='100%'>
			    <!--DWLayoutTable-->
			    <tr>
				<td height="15" class='row2'><strong>Details</strong></td>
				<td class='row3'>Reported on {$row['Time']} by {$row['member11_n']}</td>
				<td class='row4' width="334" rowspan="6"><div align="center"><b>{$row['Map']}</b><br><br><img src="uploads/maps/{$row['Map']}.gif" width="189" height="94" align="middle"></div></td>
			    </tr>
			    <tr>
			      <td height="15" class='row2'><strong>Clan Stats</strong></td>
			      <td class='row3'>{$row['clan1_n']} defeats {$row['clan2_n']} [{$row['Type']}]</td>
			    </tr>
			    <tr>
			      <td height="15" class='pformleft'><strong>{$row['clan1_n']} Players</strong></td>
			      <td class='main'>{$row['member11_n']}&nbsp;{$row['member12_n']}&nbsp;{$row['member13_n']}</td>
			    </tr>
			    <tr>
			      <td height="15" class='row2'><strong>{$row['clan2_n']} Players</strong></td>
			      <td class='row3'>{$row['member21_n']}&nbsp;{$row['member22_n']}&nbsp;{$row['member23_n']}</td>
			    </tr>
			    <tr>
			      <td height="15" class='row2'><strong>{$row['clan1_n']} Point Change</strong></td>
			      <td class='row3'>+{$row['clan1add']}</td>
			    </tr>
			    <tr>
			      <td height="15" class='row2'><strong>{$row['clan2_n']} Point Change</strong></td>
			      <td class='row3'>{$row['clan2add']}</td>
			    </tr>

<tr>
<td class='pformstrip' colspan='3'></td>
</tr>
<tr>
<td class='pformstrip' colspan='3'></td>
</tr>
<tr>
<td class='pformstrip' colspan='3'></td>
</tr>

				<tr>
				<td class='row2'><div align="right">
				<b>Game Comment</b>  &nbsp;&nbsp;&nbsp;&nbsp;</div></td>

				<td class='row2' colspan ='2'><div align="top">
				$comment</div></td>
				</tr>

	      <td class='maintitle' valign="top" colspan='3'><div align="right">Quick Links&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
			    </tr>
			    <tr>
			      <td height="15" class='row3'><div align="center"><strong>{$row['clan1_n']} New
			          Points = {$row['clan1points']}</strong></div></td>
			      <td class='row3'><div align="center"><strong>{$row['clan2_n']} New Points = {$row['clan2points']}</strong></div></td>

		      <td class='row3' valign="top"><div align="center"><a href="{$ibforums->base_url}act=ladder">BACK
	          TO LADDER</a></div></td>
			    </tr>
			  </table>
</div>

EOF;
}



function tcgames_start() {
global $ibforums;
return <<<EOF

<div class="borderwrap">
		<div class="maintitle">Clan Games</div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>

EOF;
}

function tcgames($row) {
global $ibforums;
return <<<EOF

<div class="tableborder">


<tr>

                <td class='row2'>{$row['Time']}</td>
                 <td class='row2'><div align="left">Game #{$row['id']} {$row['clan1_n']} ({$row['clan1points']} pts) defeats {$row['clan2_n']} ({$row['clan2points']} pts) </div></td>
				<td class='row2'><div align="left">[<a href='{$ibforums->base_url}act=tcusergroups&code=tcmatch&id={$row['id']}'><font color="#409FFF">Details</font></a>]</div></td>


              </tr>
EOF;
}


function clan_statsdetail_start() {
global $ibforums;
return <<<EOF

<div class="borderwrap">
		<div class="maintitle"></div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
		<tr>
		<td class='row3'><center>CLAN NAME</center></td>
		<td class='row3'><div align="center">GAMES</div></td>
		<td class='row3'><div align="center">STATS</div></td>

		<td class='row3'><div align="center">POINTS</div></td>
		<td class='row3'><div align="center">STREAK</div></td>
		<td class='row3'><div align="center">DETAILS</div></td>
		</tr>
<div class="maintitle"></div>
<tr>
              <td class='row3' colspan='7' height = '15'></td>
                </tr>
EOF;
}


function clan_statsdetail($r,$efficiency) {
global $ibforums;
return <<<EOF

<tr>

                <td class='row5'><a href='{$ibforums->base_url}act=tcusergroups&amp;code=det&amp;tcugid={$r['tcugid']}'><b>{$r['name']}</b></a></td>
                 <td class='row5'><div align="center">{$r['totalgames']}</div></td>
                <td class='row5'><div align="center">{$r['wins']} wins / {$r['loss']} losses</div></td>

                <td class='row5'><div align="center">{$r['points']}</div></td>
                <td class='row5'><div align="center">{$r['streak']}</div></td>

<td class='row5'><div align="center">{$r['name']} has won $efficiency% of its games</div></td>
              </tr>
<tr>
              <td class='row3' colspan='7' height = '15'></td>
                </tr>

EOF;
}
function clan_statsdetail_end() {
global $ibforums;
return <<<EOF

</table></div>

EOF;
}

function tcgames_end() {
global $ibforums;
return <<<EOF

</table></div>

EOF;
}

function tcug_box() {
global $ibforums;
return <<<EOF
	<div class="borderwrap">
		<div class="maintitle">{$ibforums->lang['about_groups']}</div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
		<tr class ="row4">
		<td>{$ibforums->vars['tcug_box_det']}</td>
		</tr>
		</table>
	</div>
	<br />
EOF;
}
function page_top() {
global $ibforums;
return <<<EOF
<script language='javascript' type='text/javascript'>
	<!--
	function Join_Unjoin(theUrl, theText)
	{
		var is_confirmed = confirm('{$ibforums->lang['sure']}' + ' ' + theText);
		if (is_confirmed) {
			theUrl += '&is_js_confirmed=1';
		}
		window.location.href = theUrl;
	} // end of the 'confirmLink()' function
	//-->
</script>
EOF;
}
function member_start($data,$title) {
global $ibforums;
return <<<EOF
	<div class="borderwrap">
		<div class="maintitle">{$data} {$title}</div>
		<!--IBF_UG_MS1_MOD-->
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
		<tr>

		<td class='row3'>{$ibforums->lang['name']}</td>
		<td class='row3'>Total Games</td>
		<td class='row3'>Wins</td>
		<td class='row3'>Losses</td>
		<td class='row3'>Points</td>
		<!--IBF_UG_MS2_MOD-->
		</tr>
EOF;
}



function member_between($data) {
global $ibforums;
return <<<EOF
		<tr>

		<td class='row2'>{$data['name']}</td>
		<td class='row2'>{$data['totalgames']}</td>
		<td class='row2'>{$data['wins']}</td>
		<td class='row2'>{$data['losses']}</td>
		<td class='row2'>{$data['tcpoints']}</td>
		<!--IBF_UG_MB_MOD-->
		</tr>
EOF;
}
function member_end($data="") {
global $ibforums;
return <<<EOF
		<tr>

		<td class='row2'>{$data}</td>
		<td class='row2'></td>
		<td class='row2'></td>
		<td class='row2'></td>
		<td class='row2'></td>
		<!--IBF_UG_ME1_MOD-->
		</table>
		<!--IBF_UG_ME2_MOD-->
	</div>
	<br />
EOF;
}
function searchmem_start() {
global $ibforums;
return <<<EOF
	<div class="tableborder">
		<div class="maintitle">{$ibforums->lang['searchmem']}</div>
		<!--IBF_UG_MS1_MOD-->
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
		<tr>
		<td class='pformstrip'>{$ibforums->lang['add']}</td>
		<td class='pformstrip'>{$ibforums->lang['name']}</td>
		<td class='pformstrip'>{$ibforums->lang['clan']}</td>
		</tr>
EOF;
}
function searchmem_between($data) {
global $ibforums;
return <<<EOF
		<tr>
		<td class='row2'><a href='{$ibforums->base_url}act=tcusergroups&amp;code=addmem&amp;name={$data['name']}&amp;tcugid={$data['tcugid']}'>{$ibforums->lang['add']}</a></td>
		<td class='row2'>{$data['name']}</td>
		<td class='row2'>{$data['clanname']}</td>
		</tr>
EOF;
}

function searchmem_between1($data) {
global $ibforums;
return <<<EOF
		<tr>
		<td class='row2'><a href='{$ibforums->base_url}act=tcusergroups&amp;code=addmem&amp;name={$data['name']}&amp;tcugid={$data['tcugid']}'>{$ibforums->lang['add']}</a></td>
		<td class='row2'>{$data['name']}</td>
		<td class='row2'>{$data['clanname']}</td>
		</tr>
EOF;
}

function searchmem_end($data) {
global $ibforums;
return <<<EOF
		<tr>
		<td colspan='3' class='pformstrip'>$data</td>
		</tr>
		</table>
	</div>
	<br />
EOF;
}
}
?>