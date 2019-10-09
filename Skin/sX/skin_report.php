<?php

class skin_report {


function tc_start($valida,$tgames,$w) {
global $ibforums;
return <<<EOF

<div class="borderwrap">
		<div class="maintitle"></div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
		<tr>
<td class='pformmain'><div align="center">
      <b><a href="{$ibforums->base_url}act=ladder"><img src='style_images/<#IMG_DIR#>/arrow.gif'> <font color='orange'><!--CLAN--></font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'></a></b></div></td>

<td class='pformmain'><div align="center">
      <b><a href="{$ibforums->base_url}act=tcusergroups"><img src='style_images/<#IMG_DIR#>/arrow.gif'> <font color='orange'>CLAN
  CENTRAL</font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'></a></b> </div></td>

<td class='pformmain'><div align="center">
      <b><a href="{$ibforums->base_url}act=ladder&code=show"><img src='style_images/<#IMG_DIR#>/arrow.gif'> <font color='orange'>REPORT A GAME
  </font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'></a></b> </div></td>

<td class='pformmain'><div align="center">
      <b><a href="{$ibforums->base_url}act=ladder&code=stats"><img src='style_images/<#IMG_DIR#>/arrow.gif'> <font color='#369BED'>GAME STATS</font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'></a></b> </div></td>

				</tr>


		<tr>
<td class='pformmain'><div align="center"><b><img src='style_images/<#IMG_DIR#>/arrow.gif'> <font color='orange'><!--JOIN--> <img src='style_images/<#IMG_DIR#>/arrow1.gif'></b></div></td>

<td class='pformmain'><div align="center">View details of all current TC Clans</div></td>

<td class='pformmain'><div align="center">Here is where you report a ladder game</div></td>

<td class='pformmain'><div align="center">
      <b><a href="{$ibforums->base_url}act=ladder&code=player"><img src='style_images/<#IMG_DIR#>/arrow.gif'><font color='#369BED'>PLAYER
  STATS</font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'> </a></b></div></td>

				</tr>
</tr>
</table></div>
<br>
<div class="borderwrap">
		<div class="maintitle"></div>
		<table cellpadding='4' cellspacing='1' border='0' width='100%'>
		<tr>

								<td class='row3'><font color="orange">LADDER STATS</font></td>
								<td class='row3'><div align="left"><font color="orange">TOP PLAYERS</font></div></td>
								<td class='row3'><div align="center"><font color="orange">LAST GAMES</font></div></td>

				</tr>

				<tr>
								<td class='row2'><font color=yellow>-</font> Total Games Played:<b>$valida</b><br><font color=yellow>-</font> Games Played Today:<b>$tgames</b><br><font color=yellow>-</font> Total Players:<b>$w</b></td>
								<td class='row2'>





EOF;
}


function top_member ($row)   {
global $ibforums;
return <<<EOF

- <a href='{$ibforums->base_url}showuser={$row['id']}'>{$row['name']}</a> [<font color="#409FFF">{$row['clanname']}</font>] with {$row['tcpoints']} pts.<br>

EOF;
}


function top_member_middle ()   {
global $ibforums;
return <<<EOF
</td>


				<td class='row2'><div align="left">

EOF;
}

function RenderRow($post="",$author="") {
global $ibforums;
$IPBHTML = "";
//--starthtml--//

EOF;
//startif
if ( $author['custom_fields'] != "" )
{
$IPBHTML .= <<<EOF
&nbsp;{$author['custom_fields']}
</span></td>
		
EOF;
}
$IPBHTML .= <<<EOF
EOF;


//--endhtml--//
return $IPBHTML;
}







function tc_stats ($row)   {
global $ibforums;
return <<<EOF



				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Game #{$row['id']}</b>: {$row['clan1_n']} ({$row['clan1points']} pts) defeats {$row['clan2_n']} ({$row['clan2points']} pts) [<a href='{$ibforums->base_url}act=tcusergroups&code=tcmatch&id={$row['id']}'><font color="#409FFF">Details</font></a>]<br>

EOF;
}


function tc_middle ()   {
global $ibforums;
return <<<EOF


</div></td>

		</tr>

</table></div><br/>

		<div class="borderwrap">

		<table cellpadding='0' cellspacing='1' border='0' width='100%'>



		<tr>

		<td class='maintitle' colspan='6'> </td>

			 	<form name='ibform' action='{$ibforums->base_url}act=ladder&code=dorank' method='post'>

			 		  <td width='5%' class='row2' colspan='1' align='center'><b>Rank:</b></td>
			 		  <td width='5%' class='row2' colspan='1' align='center'><input type='text' size='5' name='sc' value='' class='forminput'></td>
			 		  <td width='10%' class='row2' colspan='1' align='center'><input type='submit' value='Submit' class='forminput' /></td>
			 	</form>

		</tr>

<form action='{$ibforums->base_url}' method='post'>
<input type='hidden' name='act' value='ladder' />
<input type='hidden' name='' value='asc' />
<input type='hidden' name='s'   value='' />
  <tr>
   <td  class='darkrow2' colspan="9" align='center' valign='middle'>
     Order by <select name='sort_key' class='forminput'>
<option value='wins'>Wins</option>
<option value='loss'>Losses</option>
<option value='points' selected>TC Points</option>
<option value='totalgames'>Total Games</option>
</select> in <select name='sort_order' class='forminput'>
<option value='asc'>Ascending Order</option>
<option value='desc' selected>Descending Order</option>
</select> with <select name='max_results' class='forminput'>
<option value='25' selected>25</option>
<option value='30'>30</option>
<option value='40'>40</option>
<option value='50'>50</option>
<option value='100'>100</option>
</select> results per page&nbsp;<input type='submit' value='Go!' class='forminput' />
   </td>
 </tr>
 </form>
		<tr>



		<tr>
		<td class='row3' width='8%'><font color="orange">RANK</font></td>
		<td class='row3' width='5%'><font color="orange">CLAN NAME</font></td>
		<td class='row3' width='3%'></td>
		<td class='row3' width='5%'><div align="center"><font color="orange">GAMES</font></div></td>
		<td class='row3' width='10%'><div align="center"><font color="orange">STATS</font></div></td>
		<td class='row3' width='15%'><div align="center"><font color="orange">LAST GAME</font></div></td>


		<td class='row3' width='5%'><div align="center"><font color="orange">POINTS</font></div></td>
		<td class='row3' width='5%'><div align="center"><font color="orange">STREAK</font></div></td>
		<td class='row3' width='7%'><font color="orange">CLAN LEADER</font></td>

		</tr>

<tr>
              <td class='row3' colspan='9' height = '15'></td>
                </tr>



EOF;
}

function tc1($data) {
global $ibforums;
return <<<EOF
              <tr>
              <td class='row5'>{$data['rank']}&nbsp;<img src="{$ibforums->vars['img_url']}/gold.gif">&nbsp;&nbsp;<img src="{$ibforums->vars['img_url']}/blue5g.gif"></td>
                <td class='row5'><a href='{$ibforums->base_url}act=tcusergroups&amp;code=det&amp;tcugid={$data['tcugid']}'><b>{$data['name']}</b></a></td>
                  <td class='row5'></td>
                 <td class='row5'><div align="center">{$data['totalgames']}</div></td>
                <td class='row5'><div align="center">{$data['wins']} wins / {$data['loss']} losses</div></td>
                <td class='row5'></td>
                <td class='row5'><div align="center">{$data['points']}</div></td>
                <td class='row5'><div align="center">{$data['streak']}</div></td>
                <td class='row5'><div align="center"><a href='{$ibforums->base_url}showuser={$data['mod_id']}'>{$data['mod_name']}</div></a></td>


              </tr>
<tr>
              <td class='row3' colspan='9' height = '15'></td>
                </tr>

EOF;
}

function tc($data) {
global $ibforums;
return <<<EOF
              <tr>
              <td class='row4'>{$data['rank']}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="{$ibforums->vars['img_url']}/blue3g.gif"></td>
                <td class='row4'><a href='{$ibforums->base_url}act=tcusergroups&amp;code=det&amp;tcugid={$data['tcugid']}'><b>{$data['name']}</b></a></td>
                <td class='row4'></td>
                 <td class='row4'><div align="center">{$data['totalgames']}</div></td>
                <td class='row4'><div align="center">{$data['wins']} wins / {$data['loss']} losses</div></td>
                <td class='row4'></td>


                <td class='row4'><div align="center">{$data['points']}</div></td>
                <td class='row4'><div align="center">{$data['streak']}</div></td>
                 <td class='row4'><div align="center"><a href='{$ibforums->base_url}showuser={$data['mod_id']}'>{$data['mod_name']}</div></a></td>
              </tr>


EOF;
}


function tc2($data) {
global $ibforums;
return <<<EOF
              <tr>
              <td class='row6'>{$data['rank']}&nbsp;<img src="{$ibforums->vars['img_url']}/silver.gif">&nbsp;&nbsp;<img src="{$ibforums->vars['img_url']}/blue1g.gif"></td>
                <td class='row6'><a href='{$ibforums->base_url}act=tcusergroups&amp;code=det&amp;tcugid={$data['tcugid']}'><b>{$data['name']}</b></a></td>
                    <td class='row6'></td>
                 <td class='row6'><div align="center">{$data['totalgames']}</div></td>
                <td class='row6'><div align="center">{$data['wins']} wins / {$data['loss']} losses</div></td>
                <td class='row6'></td>

                <td class='row6'><div align="center">{$data['points']}</div></td>
                <td class='row6'><div align="center">{$data['streak']}</div></td>
                <td class='row6'><div align="center"><a href='{$ibforums->base_url}showuser={$data['mod_id']}'>{$data['mod_name']}</div></a></td>

              </tr>
<tr>
              <td class='row3' colspan='9' height = '15'></td>
                </tr>


EOF;
}

function tc3($data) {
global $ibforums;
return <<<EOF
              <tr>
              <td class='row6'>{$data['rank']}&nbsp;<img src="{$ibforums->vars['img_url']}/bronze.gif">&nbsp;&nbsp;<img src="{$ibforums->vars['img_url']}/blue1g.gif"></td>
                <td class='row6'><a href='{$ibforums->base_url}act=tcusergroups&amp;code=det&amp;tcugid={$data['tcugid']}'><b>{$data['name']}</b></a></td>
                 <td class='row6'></td>
                 <td class='row6'><div align="center">{$data['totalgames']}</div></td>
                <td class='row6'><div align="center">{$data['wins']} wins / {$data['loss']} losses</div></td>
                  <td class='row6'></td>

                <td class='row6'><div align="center">{$data['points']}</div></td>
                <td class='row6'><div align="center">{$data['streak']}</div></td>
                 <td class='row6'><div align="center"><a href='{$ibforums->base_url}showuser={$data['mod_id']}'>{$data['mod_name']}</div></a></td>

              </tr>
<tr>
              <td class='row3' colspan='9' height = '15'></td>
                </tr>

EOF;
}

function tc4($data) {
global $ibforums;
return <<<EOF
              <tr>
              <td class='row4'>{$data['rank']}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="{$ibforums->vars['img_url']}/blue3g.gif"></td>
                <td class='row4'><a href='{$ibforums->base_url}act=tcusergroups&amp;code=det&amp;tcugid={$data['tcugid']}'><b>{$data['name']}</b></a></td>
                    <td class='row4'></td>
                 <td class='row4'><div align="center">{$data['totalgames']}</div></td>
                <td class='row4'><div align="center">{$data['wins']} wins / {$data['loss']} losses</div></td>
                   <td class='row4'></td>

                <td class='row4'><div align="center">{$data['points']}</div></td>
                <td class='row4'><div align="center">{$data['streak']}</div></td>
                <td class='row4'><div align="center"><a href='{$ibforums->base_url}showuser={$data['mod_id']}'>{$data['mod_name']}</div></a></td>

              </tr>


EOF;
}

function tc_end() {
global $ibforums;
return <<<EOF


              </table></div>
<br/>
<div class='borderwrap'>

   <div class='maintitle' colspan='6'></div>
			 		<table cellpadding='4' cellspacing='1' border='0' width='100%'>
<tr>

<form name='ibform' action='{$ibforums->base_url}act=ladder&code=player&code=dosearch_pstats' method='post'>
	  <td width='10%' class='row2'><b>Search Clan Member</b></td>
	  <td width='16%' class='row2'><input type='text' size='40' name='cm' value='' class='forminput'></td>
	  <td width='10%' class='row1'><input type='submit' value='Submit' class='forminput' /></td>
          </form>


	  <td class='row2'></td>
<form name='ibform' action='{$ibforums->base_url}act=ladder&code=player&code=dosearch_pstats1' method='post'>
	  <td width='16%' class='row2'><b>Search Clan</b></td>
	  <td width='16%' class='row2'><input type='text' size='40' name='sc' value='' class='forminput'></td>
	  <td width='10%' class='row1'><input type='submit' value='Submit' class='forminput' /></td>
</form>
</tr>
			   </table>
			   <div class='maintitle' colspan='6'></div>

</div>


              <center><p><b><a target="_blank" href="http://www.cncgamer.com/">Ladder Mod by Phil_b</a></b></p></center>
EOF;
}



function stats_start($m, $tg, $a, $b, $c) {
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
		<div class="maintitle"></div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
		<tr>
<td class='row3'><div align="center">
      <b>GAME STATS</b> </div></td>

<td class='row3'><div align="center">
      <b>GAME
  CENTRAL</b> </div></td>




				</tr>
<tr>
<td class='row2'><div align="left">
		Total Games Played: $tg Games Played<br>
		Total 1v1 Games: $a<br>
		Total 2v2 Games: $b<br>
		Total 3v3 Games: $c<br>
    </div></td>

<td class='row2'><div align="center">Welcome to Game Central {$ibforums->member['name']}. Below you will find the last 25 games in the Ladder. You can also find certain statistics on the left side panel such as top 1v1, 2v2 and 3v3 games.</div></td>



				</tr>
</table></div>
<br>
<div class="borderwrap">
		<div class="maintitle">Last 25 Games</div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>



EOF;
}


function stats_data ($r)   {
global $ibforums;
return <<<EOF


EOF;
}

function stats_middle ($data)   {
global $ibforums;
return <<<EOF

<tr>
              <td class='row3'><div align="center">Game #{$data['id']}:</div></td>
                <td class='row3'>{$data['clan1_n']} ({$data['clan1points']} pts) defeats {$data['clan2_n']} ({$data['clan2points']} pts) </td>
				<td class='row3'>[<a href='{$ibforums->base_url}act=tcusergroups&code=tcmatch&id={$data['id']}'><font color="#409FFF">Details</font></a>]</td>

              </tr>

EOF;
}

function stats_end ()   {
global $ibforums;
return <<<EOF


</table></div><br>

EOF;
}

function stats_start1($w) {
global $ibforums;
return <<<EOF
<div class="borderwrap">

		<table cellpadding='4' cellspacing='1' border='0' width='100%'>

		<div class="maintitle">Warrior Rankings (top 25 out of $w)</div>

<tr>
		<td class='row3'><font color="orange">RANK</td>
		<td class='row3'><font color="orange">NAME</td>
		<td class='row3'><font color="orange">WINS</td>
		<td class='row3'><div align="center"><font color="orange">LOSSES</font></div></td>
		<td class='row3'><div align="center"><font color="orange">TOTAL GAMES</font></div></td>
		<td class='row3'><div align="center"><font color="orange">LAST GAME</font></div></td>
		<td class='row3'><div align="center"><font color="orange">POINTS</font></div></td>
		<td class='row4' width='7%'><div align="center">TC POINTS</div></td>
		</tr>





EOF;
}


function warrior1($row) {
global $ibforums;
return <<<EOF

<div class="maintitle"></div>
<tr>
              <td class='row3' colspan='7' height =' 15'></td>
                </tr>
              <tr>
              <td class='row5'>{$row['rank']}&nbsp;<img src="{$ibforums->vars['img_url']}/gold.gif">&nbsp;&nbsp;<img src="{$ibforums->vars['img_url']}/blue5g.gif"></td>
                   <td class='row5'><a href='{$ibforums->base_url}showuser={$row['id']}'><b>{$row['name']}</b></a> [<font color="#409FFF">{$row['clanname']}</font>]</td>
                   <td class='row5'>{$row['wins']}</td>
												                <td class='row5'>{$row['losses']}</td>
												                <td class='row5'>{$row['totalgames']}</td>
												                <td class='row5'>{$row['lastgame']}</td>
												                <td class='row5'>{$row['tcpoints']}</td>

<tr><td class='row3' colspan='9' height =' 15'></td></tr>

EOF;
}

function warrior($row) {
global $ibforums;
return <<<EOF
              <tr>
              <td class='row4'>{$row['rank']}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="{$ibforums->vars['img_url']}/blue3g.gif"></td>
                 <td class='row4'><a href='{$ibforums->base_url}showuser={$row['id']}'><b>{$row['name']}</b></a> [<font color="#409FFF">{$row['clanname']}</font>]</td>
                 <td class='row4'>{$row['wins']}</td>
								                <td class='row4'>{$row['losses']}</td>
								                <td class='row4'>{$row['totalgames']}</td>
								                <td class='row4'>{$row['lastgame']}</td>
								                <td class='row4'>{$row['tcpoints']}</td>

<tr>
              <td class='row3' colspan='9' height = '15'></td>
                </tr>


EOF;
}


function warrior2($row) {
global $ibforums;
return <<<EOF
              <tr>
              <td class='row6'>{$row['rank']}&nbsp;<img src="{$ibforums->vars['img_url']}/silver.gif">&nbsp;&nbsp;<img src="{$ibforums->vars['img_url']}/blue1g.gif"></td>
                 <td class='row6'><a href='{$ibforums->base_url}showuser={$row['id']}'><b>{$row['name']}</b></a> [<font color="#409FFF">{$row['clanname']}</font>]</td>
                 <td class='row6'>{$row['wins']}</td>
								                <td class='row6'>{$row['losses']}</td>
								                <td class='row6'>{$row['totalgames']}</td>
								                <td class='row6'>{$row['lastgame']}</td>
								                <td class='row6'>{$row['tcpoints']}</td>

<tr>
              <td class='row3' colspan='9' height = '15'></td>
                </tr>


EOF;
}

function warrior3($row) {
global $ibforums;
return <<<EOF
              <tr>
              <td class='row6'>{$row['rank']}&nbsp;<img src="{$ibforums->vars['img_url']}/bronze.gif">&nbsp;&nbsp;<img src="{$ibforums->vars['img_url']}/blue1g.gif"></td>
                <td class='row6'><a href='{$ibforums->base_url}showuser={$row['id']}'><b>{$row['name']}</b></a> [<font color="#409FFF">{$row['clanname']}</font>]</td>
                <td class='row6'>{$row['wins']}</td>
								                <td class='row6'>{$row['losses']}</td>
								                <td class='row6'>{$row['totalgames']}</td>
								                <td class='row6'>{$row['lastgame']}</td>
								                <td class='row6'>{$row['tcpoints']}</td>

 <tr>
              <td class='row3' colspan='9' height = '15'></td>
                </tr>

EOF;
}

function warrior4($row) {
global $ibforums;
return <<<EOF
              <tr>
              <td class='row4'>{$row['rank']}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="{$ibforums->vars['img_url']}/blue3g.gif"></td>
                 <td class='row4'><a href='{$ibforums->base_url}showuser={$row['id']}'><b>{$row['name']}</b></a> [<font color="#409FFF">{$row['clanname']}</font>]</td>
                 <td class='row4'>{$row['wins']}</td>
								                <td class='row4'>{$row['losses']}</td>
								                <td class='row4'>{$row['totalgames']}</td>
								                <td class='row4'>{$row['lastgame']}</td>
								                <td class='row4'>{$row['tcpoints']}</td>

<tr>
              <td class='row3' colspan='9' height = '15'></td>
                </tr>


EOF;
}


function stats_middle1 ($row)   {
global $ibforums;
return <<<EOF

<tr>
              <td class='row4'><div align="center"><a href='{$ibforums->base_url}showuser={$row['id']}'>{$row['name']}</a></div></td>
                <td class='row4'>{$row['wins']}</td>
                <td class='row4'>{$row['losses']}</td>
                <td class='row2'>{$row['totalgames']}</td>
                <td class='row2'>{$row['lastgame']}</td>
                <td class='row2'>{$row['tcpoints']}</td>

              </tr></td>

EOF;
}


function stats_end1 ()   {
global $ibforums;
return <<<EOF


</table></div>

EOF;
}

function player_start ($w, $t, $tp)   {
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
		<div class="maintitle"></div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
		<tr>
<td class='row3'><div align="center">
      <b>TOP WARRIOR STATS</b> </div></td>

<td class='row3'><div align="center">
      <b>CLAN
  CENTRAL</b> </div></td>


				</tr>
<tr>
<td class='row2'><div align="left">
		Most Active Member: <a href='{$ibforums->base_url}showuser={$t['id']}'><b>{$t['name']}</b></a> - {$t['totalgames']} games<br>
		Top Player: <a href='{$ibforums->base_url}showuser={$tp['id']}'><b>{$tp['name']}</b></a> - {$tp['tcpoints']} points<br>
		Total Players: $w <br>
<br>
    </div></td>

<td class='row2'><div align="center">Welcome to Warrior Central {$ibforums->member['name']}. Below you will find the top 25 players in the Ladder. You can also find certain statistics on the left side panel and a search player function on the right control panel.</div></td>


				</tr>
</table></div>
<br>
		<div class="borderwrap">
		<div class="maintitle">Warrior Rankings (top 25 out of $w)</div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>

<tr>
		<td class='row3'><font color="orange">RANK</font></td>
		<td class='row3'><font color="orange">NAME</font></td>
		<td class='row3'><font color="orange">WINS</font></td>
		<td class='row3'><div align="center"><font color="orange">LOSSES</font></div></td>
		<td class='row3'><div align="center"><font color="orange">TOTAL GAMES</font></div></td>
		<td class='row3'><div align="center"><font color="orange">LAST GAME</font></div></td>
		<td class='row3'><div align="center"><font color="orange">POINTS</font></div></td>
		</tr>
EOF;
}
function player_middle ()   {
global $ibforums;
return <<<EOF

</table></div>

EOF;
}
function player_end ()   {
global $ibforums;
return <<<EOF



EOF;
}

function mcsearch() {
global $ibforums;
return <<<EOF
<div class="borderwrap">
		<div class="maintitle"></div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
		<tr>
<td class='row3'><div align="center">
      <b><a href="{$ibforums->base_url}act=ladder"><img src='style_images/<#IMG_DIR#>/arrow.gif'><font color='orange'>STANDINGS
  </font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'></a></b> </div></td>

<td class='row3'><div align="center">
      <b><a href="{$ibforums->base_url}act=tcusergroups"><img src='style_images/<#IMG_DIR#>/arrow.gif'><font color='orange'>CLAN
  CENTRAL</font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'></a></b> </div></td>

<td class='row3'><div align="center">
      <b><a href="{$ibforums->base_url}act=ladder&code=show"><img src='style_images/<#IMG_DIR#>/arrow.gif'><font color='orange'>REPORT A GAME
  </font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'></a></b> </div></td>

<td class='row3'><div align="center">
      <b><a href="{$ibforums->base_url}act=ladder&code=stats"><img src='style_images/<#IMG_DIR#>/arrow.gif'><font color='#369BED'>GAME STATS</font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'></a></b> </div></td>

				</tr>

		<tr>
<td class='row3'><div align="center">Back to the Ladder Standings</div></td>

<td class='row3'><div align="center">View details of all current TC Clans</div></td>

<td class='row3'><div align="center">Here is where you report a ladder game</div></td>

<td class='row3'><div align="center">
      <b><a href="{$ibforums->base_url}act=ladder&code=player"><img src='style_images/<#IMG_DIR#>/arrow.gif'><font color='#369BED'>PLAYER
  STATS</font> <img src='style_images/<#IMG_DIR#>/arrow1.gif'> </a></b></div></td>

				</tr>
</table></div>
<br>
<form name='ibform' action='{$ibforums->base_url}act=ladder&code=player&code=dosearch_pstats' method='post'>
<div class="borderwrap">
  <div class='maintitle'></div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
	<tr>
	  <td class='row2'><b>Search Clan Member</b></td>
	  <td class='row2'><input type='text' size='40' name='cm' value='' class='forminput'></td>
	  	  <td width='40%' class='row1'><input type='submit' value='Submit' class='forminput' /></td>
</tr>

	 <td class=pformstrip colspan='4'></td>

	<tr>
	  <td colspan='4' align='center' class='row1'></td>
	 </tr>
  </table>
  <div class='pformstrip' align='center'></div>
</div>
</form>
<form name='ibform' action='{$ibforums->base_url}act=ladder&code=player&code=dosearch_pstats1' method='post'>
<div class="borderwrap">
  <div class='maintitle'></div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
<tr>
	  <td class='row2'><b>Search Clan</b></td>
	  <td class='row2'><input type='text' size='40' name='sc' value='' class='forminput'></td>
	  <td width='40%' class='row1'><input type='submit' value='Submit' class='forminput' /></td>
	 </tr>

	 <td class='pformstrip' colspan='4'></td>

	<tr>
	  <td colspan='4' align='center' class='row1'></td>
	 </tr>
  </table>
  <div class='pformstrip' align='center'></div>
</div>
</form>

EOF;
}

function gssearch() {
global $ibforums;
return <<<EOF

EOF;
}

function search_pstats ($select)   {
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
		<div class="maintitle"></div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
		<tr>
<td class='row2'><div align="center">
      <b>NAME</b> </div></td>
<td class='row2'><div align="center">
      <b>CLAN NAME</b> </div></td>
<td class='row2'><div align="center">
      <b>MEMBER STATS</b> </div></td>
				</tr>

$select
</table></div>



EOF;
}

function search_pstats1 ($select)   {
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
		<div class="maintitle"></div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
		<tr>
<td class='row2'><div align="center">
      <b>CLAN NAME</b> </div></td>
<td class='row2'><div align="center">
      <b>LEADER</b> </div></td>
<td class='row2'><div align="center">
      <b>CLAN STATS</b> </div></td>
				</tr>

$select
</table></div>



EOF;
}

function show_start($r) {
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
		<div class="maintitle"></div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>

<form action='index.php?act=ladder&code=det' method='POST' name='report'>
<tr>
<td class=pformleft><b>Your ID</b><td class='pformright'>
{$ibforums->member['id']}
</tr>

<tr>
<td class='pformleft'><b>Your Name</b><td class='pformright'>
{$ibforums->member['name']}
</tr>

<tr>
<td class='pformleft'><b>Status</b><td class='pformright'>
<font color="#FF0000" face="Verdana, Arial, Helvetica"><strong>WIN - ONLY REPORT THIS IF YOU HAVE GENUINLY WON.
IF YOUR UNSURE OPEN A TOPIC IN TC DISPUTES</strong></font>
</tr>
<tr>
 <td class='pformleft'><b>Your Clan</b><td class='pformright'>{$r['clanname']}

EOF;
}

function function1($data) {
global $ibforums;
return <<<EOF
<tr>
 <td class='pformleft'><b>Your Clan</b><td class='pformright'>
 <select name=clan1>
 <option class=forminput value=''>Select A Clan</option>
 $data
 </select>
EOF;
}

function function2($data) {
global $ibforums;
return <<<EOF
<tr>
 <td class='pformleft'><b>Opponents Clan</b><td class='pformright'>
 <select name=clan2>
 <option class=forminput value=''>Select A Clan</option>
 $data
 </select>
EOF;
}

function show_middle() {
global $ibforums;
return <<<EOF


<tr>
<td class='pformleft'><b>Game Type</b>
<td class='pformright'><select name=gamet><option class=forminput value=''>Select A Game Type<option class=forminput value='1'>1 vs 1<option class=forminput value='2'>2 vs 2<option class=forminput value='3'>3 vs 3</select></td>


<tr>
<td class='pformleft'><b>Map</b>
<td class='pformright'><select name=gmmap><option class=forminput value=''>Select A Map
	 <option class=forminput value='Terrace'>Terrace
     <option class=forminput value='Forest Fires'>Forest Fires
     <option class=forminput value='Other'>Other
     </select></td>

<tr>
<td class='pformstrip' colspan='2'><center><input type='submit' name='submit' value='Next'></center></form></table>
</form></table></div>

EOF;
}

function show_start1($r) {
global $ibforums;
return <<<EOF

<script language="javascript1.2" type="text/javascript">
<!--
var MessageMax  = "{$ibforums->lang['the_max_length']}";
var Override    = "{$ibforums->lang['override']}";
MessageMax      = parseInt(MessageMax);

if ( MessageMax < 0 )
{
	MessageMax = 0;
}

function emo_pop()
{
  window.open('index.{$ibforums->vars['php_ext']}?act=legends&CODE=emoticons&s={$ibforums->session_id}','Legends','width=250,height=500,resizable=yes,scrollbars=yes');
}
function bbc_pop()
{
  window.open('index.{$ibforums->vars['php_ext']}?act=legends&CODE=bbcode&s={$ibforums->session_id}','Legends','width=700,height=500,resizable=yes,scrollbars=yes');
}
function CheckLength() {
	MessageLength  = document.REPLIER.Post.value.length;
	message  = "";
		if (MessageMax > 0) {
			message = "{$ibforums->lang['js_post']}: {$ibforums->lang['js_max_length']} " + MessageMax + " {$ibforums->lang['js_characters']}.";
		} else {
			message = "";
		}
		alert(message + "      {$ibforums->lang['js_used']} " + MessageLength + " {$ibforums->lang['js_characters']}.");
}

	function ValidateForm(isMsg) {
		MessageLength  = document.REPLIER.Post.value.length;
		errors = "";

		if (isMsg == 1)
		{
			if (document.REPLIER.msg_title.value.length < 2)
			{
				errors = "{$ibforums->lang['msg_no_title']}";
			}
		}

		if (MessageLength < 2) {
			 errors = "{$ibforums->lang['js_no_message']}";
		}
		if (MessageMax !=0) {
			if (MessageLength > MessageMax) {
				errors = "{$ibforums->lang['js_max_length']} " + MessageMax + " {$ibforums->lang['js_characters']}. {$ibforums->lang['js_current']}: " + MessageLength;
			}
		}
		if (errors != "" && Override == "") {
			alert(errors);
			return false;
		} else {
			document.REPLIER.submit.disabled = true;
			return true;
		}
	}

	// IBC Code stuff
	var text_enter_url      = "{$ibforums->lang['jscode_text_enter_url']}";
	var text_enter_url_name = "{$ibforums->lang['jscode_text_enter_url_name']}";
	var text_enter_image    = "{$ibforums->lang['jscode_text_enter_image']}";
	var text_enter_email    = "{$ibforums->lang['jscode_text_enter_email']}";
	var text_enter_flash    = "{$ibforums->lang['jscode_text_enter_flash']}";
	var text_code           = "{$ibforums->lang['jscode_text_code']}";
	var text_quote          = "{$ibforums->lang['jscode_text_quote']}";
	var error_no_url        = "{$ibforums->lang['jscode_error_no_url']}";
	var error_no_title      = "{$ibforums->lang['jscode_error_no_title']}";
	var error_no_email      = "{$ibforums->lang['jscode_error_no_email']}";
	var error_no_width      = "{$ibforums->lang['jscode_error_no_width']}";
	var error_no_height     = "{$ibforums->lang['jscode_error_no_height']}";
	var prompt_start        = "{$ibforums->lang['js_text_to_format']}";

	var help_bold           = "{$ibforums->lang['hb_bold']}";
	var help_italic         = "{$ibforums->lang['hb_italic']}";
	var help_under          = "{$ibforums->lang['hb_under']}";
	var help_font           = "{$ibforums->lang['hb_font']}";
	var help_size           = "{$ibforums->lang['hb_size']}";
	var help_color          = "{$ibforums->lang['hb_color']}";
	var help_close          = "{$ibforums->lang['hb_close']}";
	var help_url            = "{$ibforums->lang['hb_url']}";
	var help_img            = "{$ibforums->lang['hb_img']}";
	var help_email          = "{$ibforums->lang['hb_email']}";
	var help_quote          = "{$ibforums->lang['hb_quote']}";
	var help_list           = "{$ibforums->lang['hb_list']}";
	var help_code           = "{$ibforums->lang['hb_code']}";
	var help_click_close    = "{$ibforums->lang['hb_click_close']}";
	var list_prompt         = "{$ibforums->lang['js_tag_list']}";


	//-->
</script>

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
<div class="maintitle"></div>





<table><form name='REPLIER' action='index.php?act=ladder&code=fin' method='post'>
<input type=hidden name=clan1 value={$r['clanname']}>
<input type=hidden name=clan2 value={$ibforums->input["clan2"]}>
<input type=hidden name=gamet value={$ibforums->input["gamet"]}>
<input type=hidden name=gmmap value={$ibforums->input["gmmap"]}>
<input type=hidden name=rworl value={$ibforums->input["rworl"]}>
<input type=hidden name=today value={$ibforums->input["today"]}>
<input type=hidden name=allie1 value={$ibforums->input["allie1"]}>
<input type=hidden name=allie2 value={$ibforums->input["allie2"]}>
<input type=hidden name=oppt1 value={$ibforums->input["oppt1"]}>
<input type=hidden name=oppt2 value={$ibforums->input["oppt2"]}>
<input type=hidden name=oppt3 value={$ibforums->input["oppt3"]}>


EOF;
}

function main_detail($r, $clan2_n) {
global $ibforums;
return <<<EOF

<table cellpadding='4' cellspacing='0' border='0' width='100%'>
<tr>
 <td class='pformleft'><b>Game Result</b></td>
 <td class=<'pformright'>{$r['clanname']} defeats {$clan2_n}</td>
 </tr>
 <tr>
  <td class='pformleft'><b>Map Played</b></td>
  <td class='pformright'>{$ibforums->input["gmmap"]}</td>
 </tr>


EOF;
}

function allie1($data) {
global $ibforums;
return <<<EOF

<tr>
 <td class='pformleft'><b>Allie #1</b></td>
 <td class='pformright' colspan='2'>
 <select name=allie1>
 <option class=forminput value=''>Select An Allie</option>
 $data
 </select></td>
 </tr>

EOF;
}

function allie2($data) {
global $ibforums;
return <<<EOF


<table cellpadding='4' cellspacing='0' border='0' width='100%'>
<tr>
 <td class='pformleft'><b>Allie #2</b></td>
 <td class='pformright' colspan='2'>

 <select name=allie2>
 <option class=forminput value=''>Select An Allie</option>
 $data
 </select></td>
 </tr>

EOF;
}

function opponent1($data) {
global $ibforums;
return <<<EOF

<table cellpadding='4' cellspacing='0' border='0' width='100%'>
<tr>
 <td class='pformleft'><b>Opponent #1</b></td>
 <td class='pformright' colspan='2'>
 <select name=oppt1>
 <option class=forminput value=''>Select An Opponent</option>
 $data
 </select></td>
 </tr>

EOF;
}

function opponent2($data) {
global $ibforums;
return <<<EOF

<table cellpadding='4' cellspacing='0' border='0' width='100%'>
<tr>
 <td class='pformleft'><b>Opponent #2</b></td>
 <td class='pformright' colspan='2'>
 <select name=oppt2>
 <option class=forminput value=''>Select An Opponent</option>
 $data
 </select></td>
 </tr>

EOF;
}

function opponent3($data) {
global $ibforums;
return <<<EOF

<table cellpadding='4' cellspacing='0' border='0' width='100%'>
<tr>
 <td class='pformleft'><b>Opponent #3</b></td>
 <td class='pformright' colspan='2'>
 <select name=oppt3>
 <option class=forminput value=''>Select An Opponent</option>
 $data
 </select></td>
 </tr>

EOF;
}

function endresult2() {
global $ibforums;
return <<<EOF

<tr>
<td class='row2' valign='top'><b>Game Description (optional)</b><br><br><!--SMILIE TABLE--><br>
			<input type='radio' name='bbmode' value='ezmode' onClick='setmode(this.value)'>&nbsp;<b>{$ibforums->lang['bbcode_guided']}</b>
			<input type='radio' name='bbmode' value='normal' onClick='setmode(this.value)' checked>&nbsp;<b>{$ibforums->lang['bbcode_normal']}</b>
<script type='text/javascript' src='html/ibfcode.js'></script>

<td class='row2'><font size="1">
	   <input type='button' accesskey='b' value=' B '       onclick='simpletag("B")' class='codebuttons' name='B' style="font-weight:bold" onmouseover="hstat('bold')" />
	   <input type='button' accesskey='i' value=' I '       onclick='simpletag("I")' class='codebuttons' name='I' style="font-style:italic" onmouseover="hstat('italic')" />
	   <input type='button' accesskey='u' value=' U '       onclick='simpletag("U")' class='codebuttons' name='U' style="text-decoration:underline" onmouseover="hstat('under')" />

	   <select name='ffont' class='codebuttons' onchange="alterfont(this.options[this.selectedIndex].value, 'FONT')"  onmouseover="hstat('font')">
	   <option value='0'>{$ibforums->lang['ct_font']}</option>
	   <option value='Arial' style='font-family:Arial'>{$ibforums->lang['ct_arial']}</option>
	   <option value='Times' style='font-family:Times'>{$ibforums->lang['ct_times']}</option>
	   <option value='Courier' style='font-family:Courier'>{$ibforums->lang['ct_courier']}</option>
	   <option value='Impact' style='font-family:Impact'>{$ibforums->lang['ct_impact']}</option>
	   <option value='Geneva' style='font-family:Geneva'>{$ibforums->lang['ct_geneva']}</option>
	   <option value='Optima' style='font-family:Optima'>Optima</option>
	   </select><select name='fsize' class='codebuttons' onchange="alterfont(this.options[this.selectedIndex].value, 'SIZE')" onmouseover="hstat('size')">
	   <option value='0'>{$ibforums->lang['ct_size']}</option>
	   <option value='1'>{$ibforums->lang['ct_sml']}</option>
	   <option value='7'>{$ibforums->lang['ct_lrg']}</option>
	   <option value='14'>{$ibforums->lang['ct_lest']}</option>
	   </select><select name='fcolor' class='codebuttons' onchange="alterfont(this.options[this.selectedIndex].value, 'COLOR')" onmouseover="hstat('color')">
	   <option value='0'>{$ibforums->lang['ct_color']}</option>
	   <option value='blue' style='color:blue'>{$ibforums->lang['ct_blue']}</option>
	   <option value='red' style='color:red'>{$ibforums->lang['ct_red']}</option>
	   <option value='purple' style='color:purple'>{$ibforums->lang['ct_purple']}</option>
	   <option value='orange' style='color:orange'>{$ibforums->lang['ct_orange']}</option>
	   <option value='yellow' style='color:yellow'>{$ibforums->lang['ct_yellow']}</option>
	   <option value='gray' style='color:gray'>{$ibforums->lang['ct_grey']}</option>
	   <option value='green' style='color:green'>{$ibforums->lang['ct_green']}</option>
	   </select>
	   &nbsp; <a href='javascript:closeall();' onmouseover="hstat('close')">{$ibforums->lang['js_close_all_tags']}</a>
	   <br />
	   <input type='button' accesskey='h' value=' http:// ' onclick='tag_url()'            class='codebuttons' name='url' onmouseover="hstat('url')" />
	   <input type='button' accesskey='g' value=' IMG '     onclick='tag_image()'          class='codebuttons' name='img' onmouseover="hstat('img')" />
	   <input type='button' accesskey='e' value='  @  '     onclick='tag_email()'          class='codebuttons' name='email' onmouseover="hstat('email')" />
	   <input type='button' accesskey='q' value=' QUOTE '   onclick='simpletag("QUOTE")'   class='codebuttons' name='QUOTE' onmouseover="hstat('quote')" />
	   <input type='button' accesskey='p' value=' CODE '    onclick='simpletag("CODE")'    class='codebuttons' name='CODE' onmouseover="hstat('code')" />
	   <input type='button' accesskey='l' value=' LIST '     onclick='tag_list()'          class='codebuttons' name="LIST" onmouseover="hstat('list')" />
	   <!--<input type='button' accesskey='l' value=' SQL '     onclick='simpletag("SQL")'     class='codebuttons' name='SQL'>
	   <input type='button' accesskey='t' value=' HTML '    onclick='simpletag("HTML")'    class='codebuttons' name='HTML'>-->
	   <br />
	   {$ibforums->lang['hb_open_tags']}:&nbsp;<input type='text' name='tagcount' size='3' maxlength='3' style='font-size:10px;font-family:verdana,arial;border:0px;font-weight:bold;' readonly="readonly" class='row1' value="0" />
	   &nbsp;<input type='text' name='helpbox' size='50' maxlength='120' style='width:auto;font-size:10px;font-family:verdana,arial;border:0px' readonly="readonly" class='row1' value="{$ibforums->lang['hb_start']}" />


        <br><textarea cols='60' rows='10' wrap='soft' name='Post' class='forminput'></textarea><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td>
        <td class='row2' valign='top'><br><br><br>The Game Description area is optional. You are allowed to post smileys and BB code(forum code) using the buttoms provided. The more you describe your game here the more information other people have on how the game went.<br><br> This is <b>not</b> a place to brag and antagonise your opponents. Please keep all descriptions clean and sensible.
        <br><br>Remember the systems success is judged on the fairness of people who play within it.</td>
</tr>
<tr>
<td class='pformstrip' colspan='3'><center><input type='submit' name='submit' value='Finish' class='forminput'></center></tr></table></div>
</form>
</table>
</div>
EOF;
}





function tcshow_start() {
global $ibforums;
return <<<EOF
	<div class="borderwrap">
		<div class="maintitle">{$ibforums->lang['show_groups']}</div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
		<tr>
		<td class='pformstrip'>{$ibforums->lang['name']}</td>
		<td class='pformstrip'>{$ibforums->lang['details']}</td>
		<td class='pformstrip'>{$ibforums->lang['state']}</td>
		<td class='pformstrip'>{$ibforums->lang['state_to_users']}</td>
		</tr>
EOF;
}
function tcshow_between($data) {
global $ibforums;
return <<<EOF
		<tr>
		<td class='pformleft'>{$data['name']}</td>
		<td class='pformright'><a href='{$ibforums->base_url}act=Usergroups&amp;code=det&amp;ugid={$data['ugid']}'>{$ibforums->lang['details']}</a></td>
		<td class='pformleft'>{$data['open']}</td>
		<td class='pformright' width='10%'>{$data['state']}</td>
		</tr>
EOF;
}
function tcshow_end() {
global $ibforums;
return <<<EOF
		</table>
	</div>
	<br />
EOF;
}
function tcdetail($data) {
global $ibforums;
return <<<EOF
	<div class="borderwrap">
		<div class="maintitle">{$ibforums->lang['show_group']}</div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
		<tr>
		<td class='row2'>{$ibforums->lang['name']}</td>
		<td class='row2'>{$data['name']}</td>
		</tr>
		<tr>
		<td class='row2'>{$ibforums->lang['description']}</td>
		<td class='row2'>{$data['description']}</td>
		</tr>
		<tr>
		<td class='row2'>{$ibforums->lang['state']}</td>
		<td class='row2'>{$data['open']}</td>
		</tr>
		<tr>
		<td class='row2'>{$ibforums->lang['state_to_users']}</td>
		<td class='row2'>{$data['state']}</td>
		</tr>
		<!--IBF_UG_DET-->
		</table>
	</div>
	<br />
EOF;
}
function tcug_box() {
global $ibforums;
return <<<EOF
	<div class="borderwrap">
		<div class="maintitle">{$ibforums->lang['about_groups']}</div>
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
		<tr class ="row2">
		<td>{$ibforums->vars['tcug_box_det']}</td>
		</tr>
		</table>
	</div>
	<br />
EOF;
}
function tcpage_top() {
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
function tcmember_start($data,$title) {
global $ibforums;
return <<<EOF
	<div class="borderwrap">
		<div class="maintitle">{$data} {$title}</div>
		<!--IBF_UG_MS1_MOD-->
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
		<tr>
		<!--IBF_UG_MS2_MOD-->
		<td class='pformstrip'>{$ibforums->lang['name']}</td>
		</tr>
EOF;
}
function tcmember_between($data) {
global $ibforums;
return <<<EOF
		<tr>
		<!--IBF_UG_MB_MOD-->
		<td class='row2'>{$data['name']}</td>
		</tr>
EOF;
}
function tcmember_end($data="") {
global $ibforums;
return <<<EOF
		<tr>
		<!--IBF_UG_ME1_MOD-->
		<td class='pformstrip'>{$data}</td>
		</table>
		<!--IBF_UG_ME2_MOD-->
	</div>
	<br />
EOF;
}
function tcsearchmem_start() {
global $ibforums;
return <<<EOF
	<div class="borderwrap">
		<div class="maintitle">{$ibforums->lang['searchmem']}</div>
		<!--IBF_UG_MS1_MOD-->
		<table cellpadding='4' cellspacing='0' border='0' width='100%'>
		<tr>
		<td class='pformstrip'>{$ibforums->lang['add']}</td>
		<td class='pformstrip'>{$ibforums->lang['name']}</td>
		</tr>
EOF;
}
function tcsearchmem_between($data) {
global $ibforums;
return <<<EOF
		<tr>
		<td class='row2'><a href='{$ibforums->base_url}act=Usergroups&amp;code=addmem&amp;name={$data['name']}&amp;ugid={$data['ugid']}'>{$ibforums->lang['add']}</a></td>
		<td class='row2'>{$data['name']}</td>
		</tr>
EOF;
}
function tcsearchmem_end($data) {
global $ibforums;
return <<<EOF
		<tr>
		<td colspan='2' class='pformstrip'>$data</td>
		</tr>
		</table>
	</div>
	<br />
EOF;
}


function smilie_table() {
global $ibforums;
return <<<EOF
<table class='tablefill' cellpadding='4' align='center'>
<tr>
<td align="center" colspan="{$ibforums->vars['emo_per_row']}"><b>{$ibforums->lang['click_smilie']}</b></td>
</tr>
<!--THE SMILIES-->
<tr>
<td align="center" colspan="{$ibforums->vars['emo_per_row']}"><b><a href='javascript:emo_pop()'>{$ibforums->lang['all_emoticons']}</a></b></td>
</tr>
</table>
EOF;
}


}
?>