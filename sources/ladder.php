<?php
// Ladder by Phil_b
//Modified for IPB 2.0.x by Ruud
$idx = new report;
class report {
    var $output     = "";
    var $page_title = "";
    var $nav        = array();
    var $html       = "";
	var $email		= "";
	var $parser    = "";
    function report() {
		global $ibforums, $DB, $std, $print;
		$this->page_title = $ibforums->lang['show_groups']." -> ".$ibforums->lang['details'];
		$this->nav        = array( "<a href='{$ibforums->base_url}act=ladder&code=show'>{$ibforums->lang['show_groups']}</a>",$ibforums->lang['details']);
		$ibforums->lang = $std->load_words($ibforums->lang, 'lang_report'   , $ibforums->lang_id );
		$this->html = $std->load_template('skin_report');
				/*if($ibforums->member['id']!=1)
			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'ug_no_access' ) );*/
		/*if($ibforums->member['mgroup']==1 or $ibforums->member['mgroup']==2 or $ibforums->member['mgroup']==5)
			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'ug_no_access' ) );*/
		switch($ibforums->input['code']) {
    		case 'tc':
			$this->tc();
    			break;

    		case 'show':
    			$this->show();
    			break;
    case '01':
     $this->modfuncs->ban_member();
     break;
    case '02':
     $this->modfuncs->unban_member();
     break;

    		case 'stats':
				$this->stats();
    			break;

    		case 'player':
				$this->player();
    			break;

    		case 'search_pstats':
				$this->search_pstats();
    			break;

    		case 'dosearch_pstats':
				$this->dosearch_pstats();
    			break;

    		case 'dosearch_pstats1':
				$this->dosearch_pstats1();
    			break;

    		case 'search_cstats':
				$this->search_cstats();
    			break;

    		case 'dosearch_cstats':
				$this->dosearch_cstats();
    			break;

			case 'det':
				$this->detail();
				break;

			case 'fin':
				$this->finish();
				break;

			default:
    			$this->tc();
    			break;
		}

$print->add_output("$this->output");
$print->do_output( array( 'TITLE' => $this->page_title, 'JS' => 1, NAV => $this->nav ) );
}


function tc() {
global $ibforums, $DB, $std, $print;
$this->page_title = $ibforums->lang['tc_stand']." -> ".$ibforums->lang['standings'];
$this->nav        = array( $ibforums->lang['tc_stand'] );

$today= date("F j, Y");

$DB->query("SELECT * FROM ibf_ladder_matches");
				$valida=$DB->get_num_rows();

$DB->query("SELECT * FROM ibf_ladder_matches WHERE time = '$today'");
				$tgames=$DB->get_num_rows();
$DB->query("SELECT * from ibf_members WHERE id !=0 AND clanname !='' AND clanname !='0'");
				$w = $DB->get_num_rows();

$DB->query("SELECT * from ibf_members WHERE id ={$ibforums->member['id']} AND clanname!='0' AND clanname!=''");
				$hu = $DB->get_num_rows();

$this->output.=$this->html->tc_start($valida,$tgames, $w);


if ($hu) {
$row = $DB->fetch_row();
$this->output = str_replace( "<!--CLAN-->", "<a href='{$ibforums->base_url}act=tcusergroups&code=det&tcugid={$row['clanid']}'><font color='orange'>VIEW CLAN</font></a>", $this->output );
$this->output = str_replace( "<!--JOIN-->", "View your clan here.", $this->output );

} else {
$this->output = str_replace( "<!--CLAN-->", "<a href='{$ibforums->base_url}act=clans'><font color='orange'>ADD CLAN</font></a>", $this->output );
$this->output = str_replace( "<!--JOIN-->", "<a href='{$ibforums->base_url}act=clans&code=cjoin'><font color='orange'>JOIN CLAN</font></a>", $this->output );
}

$DB->query("SELECT * from ibf_members WHERE id !=0 AND clanname !='' AND clanname !='0' ORDER BY tcpoints DESC LIMIT 3");
while( $row = $DB->fetch_row() )	{

	$this->output    .= $this->html->top_member($row);
}

$this->output    .= $this->html->top_member_middle();

$DB->query("SELECT * from ibf_ladder_matches ORDER BY id DESC LIMIT 3");
while( $row = $DB->fetch_row() )
{
	$this->output    .= $this->html->tc_stats($row);
}
$this->output.=$this->html->tc_middle();

$DB->query("SELECT * from ibf_tcusergroups ORDER BY points DESC, loss ASC");
$rank = 1;
while( $r = $DB->fetch_row() )

if($rank == "1")	{
	$r["rank"] = $rank++;
    $this->output.= $this->html->tc1($r);
}
else if ($rank == "2")	{
	$r["rank"] = $rank++;
	$this->output.= $this->html->tc2($r);
}
else if ($rank == "3")	{
	$r["rank"] = $rank++;
	$this->output.= $this->html->tc3($r);
}
else if ($rank == "4" or $rank == "5" or $rank == "6" or $rank == "7" or $rank == "8" or $rank == "9")	{
	$r["rank"] = $rank++;
	$this->output.= $this->html->tc4($r);
}
else	{
	$r["rank"] = $rank++;
	$this->output.= $this->html->tc($r);
}
$this->output.=$this->html->tc_end();
}

function stats() {
global $ibforums, $DB, $std, $print;
$this->page_title = $ibforums->lang['stats_show']." -> ".$ibforums->lang['details'];
$this->nav        = array( $ibforums->lang['stats_show'] );

$DB->query("SELECT Type from ibf_ladder_matches WHERE Type ='1'");
$a = $DB->get_num_rows();
$DB->query("SELECT Type from ibf_ladder_matches WHERE Type ='2'");
$b = $DB->get_num_rows();
$DB->query("SELECT Type from ibf_ladder_matches WHERE Type ='3'");
$c = $DB->get_num_rows();
$DB->query("SELECT id from ibf_ladder_matches");
$tg = $DB->get_num_rows();

$this->output.=$this->html->stats_start($m, $tg, $a, $b, $c);


$DB->query("SELECT * from ibf_ladder_matches ORDER BY id DESC LIMIT 25");
	while( $row = $DB->fetch_row() )
	{
$this->output    .= $this->html->stats_middle($row);
}
$this->output.=$this->html->stats_end();


}

function player() {
global $ibforums, $DB, $std, $print;
$this->page_title = $ibforums->lang['stats_show']." -> ".$ibforums->lang['details'];
$this->nav        = array( $ibforums->lang['stats_show'] );

$DB->query("SELECT * from ibf_members WHERE id !=0 AND clanname !='' AND clanname !='0' ORDER BY tcpoints DESC, losses ASC");
$w = $DB->get_num_rows();
$tp = $DB->fetch_row();

$DB->query("SELECT * from ibf_members WHERE id !=0 AND clanname !='' AND clanname !='0' ORDER BY totalgames DESC, losses ASC LIMIT 1");
$t = $DB->fetch_row();





$this->output.=$this->html->player_start($w, $t, $tp);


$DB->query("SELECT * from ibf_members WHERE id !=0 AND clanname !='' AND clanname !='0' ORDER BY tcpoints DESC, losses ASC  LIMIT 25 ");
$rank = 1;
while( $row = $DB->fetch_row() )

							if($rank == "1")	{
								$row["rank"] = $rank++;
								$this->output.= $this->html->warrior1($row);
							}
							else if ($rank == "2")	{
								$row["rank"] = $rank++;
								$this->output.= $this->html->warrior2($row);
							}
							else if ($rank == "3")	{
								$row["rank"] = $rank++;
								$this->output.= $this->html->warrior3($row);
							}
							else if ($rank == "4" or $rank == "5" or $rank == "6" or $rank == "7" or $rank == "8" or $rank == "9")	{
								$row["rank"] = $rank++;
								$this->output.= $this->html->warrior4($row);
							}
							else	{
								$row["rank"] = $rank++;
								$this->output.= $this->html->warrior($row);
}


$this->output.= $this->html->player_middle();

$this->output.=$this->html->player_end();
}


function search_pstats() {
global $ibforums, $DB, $std, $print;
$this->page_title = $ibforums->lang['stats_show']." -> ".$ibforums->lang['details'];
$this->nav        = array( $ibforums->lang['stats_show'] );

$this->output.=$this->html->mcsearch();

	}

function dosearch_pstats() {
global $ibforums, $DB, $std, $print;
$this->page_title = $ibforums->lang['stats_mc']." -> ".$ibforums->lang['details'];
$this->nav        = array( $ibforums->lang['stats_mc'] );

		if ($ibforums->input['cm'] == "")
		{
			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'no_input' ) );
		}

		$DB->query("SELECT id, name, clanname, wins, losses, tcpoints FROM ibf_members WHERE name LIKE '".$ibforums->input['cm']."%' LIMIT 0,100");

		if ( $DB->get_num_rows() )
		{


			while ( $member = $DB->fetch_row() )
			{

    		    	if ($member['clanname'])
			    	{
			    		$member['clanname'] = $member['clanname'];
			    	}
			    	else
			    	{
			    		$member['clanname'] = $ibforums->lang['no_clan'];
    	}

				$select .= "<tr><td class='pformleft'><div align='center'>" . $member['name'] . "</div></td>";
				$select .= "<td class='pformright'><div align='center'>" . $member['clanname'] . "</div></td>";
				$select .= "<td class='pformright'><div align='center'>" . $member['wins'] . " wins/ " . $member['losses'] . " losses - " . $member['tcpoints'] . " points</div></td></tr>";
			}


			$this->output.=$this->html->search_pstats($select);
		}
		else
		{
			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'no_name_search_results' ) );
		}

	}

function dosearch_pstats1() {
global $ibforums, $DB, $std, $print;
$this->page_title = $ibforums->lang['stats_mc']." -> ".$ibforums->lang['details'];
$this->nav        = array( $ibforums->lang['stats_mc'] );

		if ($ibforums->input['sc'] == "")
		{
			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'no_input' ) );
		}


		$DB->query("SELECT tcugid, name, mod_id, wins, loss, points FROM ibf_tcusergroups WHERE name LIKE '".$ibforums->input['sc']."%' LIMIT 0,100");

		if ( $DB->get_num_rows() )
		{


			while ( $member = $DB->fetch_row() )
			{

		$DB->query("SELECT id, name FROM ibf_members WHERE id = '".$member['mod_id']."'");
		$mod = $DB->fetch_row();

				$select .= "<tr><td class='pformleft'><div align='center'>" . $member['name'] . "</div></td>";
				$select .= "<td class='pformright'><div align='center'>" . $mod['name'] . "</div></td>";
				$select .= "<td class='pformright'><div align='center'>" . $member['wins'] . " wins/ " . $member['loss'] . " losses - " . $member['points'] . " points</div></td></tr>";
			}


			$this->output.=$this->html->search_pstats1($select);
		}
		else
		{
			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'no_name_search_results' ) );
		}

	}

function search_cstats() {
global $ibforums, $DB, $std, $print;
$this->page_title = $ibforums->lang['show_groups']." -> ".$ibforums->lang['details'];
$this->nav        = array( $ibforums->lang['show_groups'] );

$this->output.=$this->html->gssearch();

	}

function show() {
global $ibforums, $DB, $std, $print;
$this->page_title = $ibforums->lang['show_groups']." -> ".$ibforums->lang['details'];
$this->nav        = array( $ibforums->lang['show_groups'] );


$DB->query("SELECT clanid, clanname FROM ibf_members WHERE id=". $ibforums->member['id'] ."");
$r= $DB->fetch_row();
$clanname=$r['clanname'];
if (!$clanname)
		{
			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'report_no' ) );
		}

$this->output.=$this->html->show_start($r);

//- Opponent Clan

$DB->query("SELECT * FROM ibf_tcusergroups WHERE name != '$clanname' ORDER BY 'name' ");
$out2 = "";
while($result=$DB->fetch_row())
{
$out2.="<option class=forminput value='$result[tcugid]'>$result[name]</option>";
}
$this->output.=$this->html->function2($out2);
$this->output.=$this->html->show_middle();
}

function detail() {
global $ibforums, $DB, $std, $print;
$this->page_title = $ibforums->lang['show_groups']." -> ".$ibforums->lang['details'];
 		$this->nav        = array( "{$ibforums->lang['show_groups']}",$ibforums->lang['details']);
//$row=$ibforums->input;if(is_array($row)) foreach ($row as $d=>$e) echo "{$d}=>{$e}<br />";


$DB->query("SELECT clanid, clanname FROM ibf_members WHERE id=". $ibforums->member['id'] ."");
$r= $DB->fetch_row();
$clanid=$r['clanid'];
$clan1= $clanid;
$clan2= $ibforums->input["clan2"];
$gamet= $ibforums->input["gamet"];
$gmmap= $ibforums->input["gmmap"];
$rworl= $ibforums->input["rworl"];
//$row=$ibforums->input;if(is_array($row)) foreach ($row as $d=>$e) echo "{$d}=>{$e}<br />";

  if (strlen($clan2) <= 0) {
   $std->Error( array( 'LEVEL' => 1, 'MSG' => 'ladder_no_opp_clan' ) );
  }

  if (strlen($gamet) <= 0) {
   $std->Error( array( 'LEVEL' => 1, 'MSG' => 'ladder_no_game' ) );
  }

  if (strlen($gmmap) <= 0) {
   $std->Error( array( 'LEVEL' => 1, 'MSG' => 'ladder_no_map' ) );
  }



$this->output.=$this->html->show_start1($r);

$DB->query("SELECT * from ibf_tcusergroups WHERE tcugid = '$clan2'");
$clan2_n=$DB->fetch_row();

$clan2_n= $clan2_n["name"];

$this->output.=$this->html->main_detail($r, $clan2_n);

//- Allies Names

if ($gamet >= 2) {
$DB->query("SELECT * FROM ibf_members WHERE clanid = '$clan1' AND id!=". $ibforums->member['id'] ."");
$allie1 = "";
while($result=$DB->fetch_row())
{
$out3.="<option class=forminput value='$result[id]'>$result[name]</option>";
}
$this->output.=$this->html->allie1($out3);
}

if ($gamet >= 3) {
$DB->query("SELECT * FROM ibf_members WHERE clanid = '$clan1' AND id!=". $ibforums->member['id'] ."");
$allie2 = "";
while($result=$DB->fetch_row())
{
$allie2.="<option class=forminput value='$result[id]'>$result[name]</option>";
}
$this->output.=$this->html->allie2($allie2);
}


//- Opponents Names

$DB->query("SELECT * FROM ibf_members WHERE clanid = '$clan2'");
$out1 = "";
while($result=$DB->fetch_row())
{
$out1.="<option class=forminput value='$result[id]'>$result[name]</option>";
}
$this->output.=$this->html->opponent1($out1);

if ($gamet >= 2) {
$DB->query("SELECT * FROM ibf_members WHERE clanid = '$clan2'");
$out2 = "";
while($result=$DB->fetch_row())
{
$out2.="<option class=forminput value='$result[id]'>$result[name]</option>";
}

$this->output.=$this->html->opponent2($out2);
}

if ($gamet >= 3) {
$DB->query("SELECT * FROM ibf_members WHERE clanid = '$clan2'");
$out3 = "";
while($result=$DB->fetch_row())
{
$out3.="<option class=forminput value='$result[id]'>$result[name]</option>";
}

$this->output.=$this->html->opponent3($out2);
}

{

		//+--------------------------------------------
		//| Start Smiley box. Modified from IPB code.
		//+--------------------------------------------

			$show_table = 0;
			$count      = 0;
			$smilies    = "<tr align='center'>\n";
			// Get the smilies from the DB
			$DB->query("SELECT * FROM ibf_emoticons WHERE clickable='1'");
			while ($elmo = $DB->fetch_row() )
			{
				$show_table++;
				$count++;
				if (strstr( $elmo['typed'], "&#39;" ) )
				{
					$in_delim  = '"';
					$out_delim = "'";
				}
				else
				{
					$in_delim  = "'";
					$out_delim = '"';
				}
				$smilies .= "<td><a href={$out_delim}javascript:emoticon($in_delim".$elmo['typed']."$in_delim){$out_delim}><img src=\"".$ibforums->vars['EMOTICONS_URL']."/".$elmo['image']."\" alt='smilie' border='0'></a>&nbsp;</td>\n";
				if ($count == $ibforums->vars['emo_per_row'])
				{
					$smilies .= "</tr>\n\n<tr align='center'>";
					$count = 0;
				}
			}

			if ($count != $ibforums->vars['emo_per_row'])
			{
				for ($i = $count ; $i < $ibforums->vars['emo_per_row'] ; ++$i)
				{
					$smilies .= "<td>&nbsp;</td>\n";
				}
				$smilies .= "</tr>";
			}
			$table = $this->html->smilie_table();
		}
		$ibforums->lang = $std->load_words($ibforums->lang, 'lang_post', $ibforums->lang_id );
$this->output.=$this->html->endresult2();

	$this->output = preg_replace( "/<!--THE SMILIES-->/", $smilies, $this->output );
			if ($show_table != 0)
			{
				$table = preg_replace( "/<!--THE SMILIES-->/", $smilies, $table );
				$this->output = preg_replace( "/<!--SMILIE TABLE-->/", $table, $this->output );
			}

		//+--------------------------------------------
		//| End Smiley box. Modified from IPB code.
		//+--------------------------------------------

		}


function finish() {
global $ibforums, $DB, $std, $print;
$this->page_title = $ibforums->lang['show_groups']." -> ".$ibforums->lang['details'];
 		$this->nav        = array( "{$ibforums->lang['show_groups']}",$ibforums->lang['finish']);


$DB->query("SELECT clanid, clanname FROM ibf_members WHERE id=". $ibforums->member['id'] ."");
$r= $DB->fetch_row();
$clanid=$r['clanid'];
$clan1= $clanid;
  $clan1a= $ibforums->input ["clan1"];
  $clan2= $ibforums->input ["clan2"];
  $gamet= $ibforums->input ["gamet"];
  $gmmap= $ibforums->input ["gmmap"];

  $allie1= $ibforums->input ["allie1"];
  $allie2= $ibforums->input ["allie2"];
  $oppt1= $ibforums->input ["oppt1"];
  $oppt2= $ibforums->input ["oppt2"];
  $oppt3= $ibforums->input ["oppt3"];
  $name1 = "{$ibforums->member['id']}";
  $comment = "{$ibforums->input['Post']}";


if (($gamet == 1) AND ( empty($oppt1) ))
 		{
 			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'complete_form' ) );
 		}

 if (($gamet == 2) AND ((( empty($oppt1) ) or ( empty($oppt2) ) or ( empty($allie1) )) OR ($name1 == $allie1) OR ($oppt1 == $oppt2)))
  		{
  			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'complete_form' ) );
 		}

 if (($gamet == 3) AND ((( empty($oppt1) ) or ( empty($oppt2) ) or ( empty($allie1) ) or ( empty($allie2) ) or ( empty($oppt3) )) OR ($name1 == $allie1) OR ($name1 == $allie2) OR ($allie1 == $allie2) OR ($oppt1 == $oppt2) OR ($oppt1 == $oppt3) OR ($oppt2 == $oppt3)))
  		{
  			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'complete_form' ) );
 		}


  //$row=$ibforums->input;if(is_array($row)) foreach ($row as $d=>$e) echo "{$d}=>{$e}<br />";

  $today= date("F j, Y");


$clanwin = 1;
$clan1winlose = win;
$clan2winlose = lose;
$clan1winlosenum = 1;
$clan2winlosenum = 0;

$clan1rating = 50;
$clan2rating = 50;
$RO = $clan1rating;
$RO1 = $clan2rating;


$DB->query("select * from ibf_tcusergroups WHERE tcugid = '$clan1'");

        while($result=$DB->fetch_row()) {
        $clan1rating = $result[points];


        }


 $DB->query("select * from ibf_tcusergroups WHERE tcugid = '$clan2'");

         while($result=$DB->fetch_row()) {
         $clan2rating = $result[points];

        }


//Start Formula//

$RO = $clan1rating;
$RO1 = $clan2rating;

$DR = $clan1rating - $clan2rating;


$tenpower = -$DR / 400;
$power = pow ( 10, $tenpower)+1;
$WE = 1 / $power;
$K = 64;
$WWE = 1 - $WE;
$KWWE = round($K * $WWE);

if ($KWWE > 64) $KWWE == 64;
$RN = $RO + $KWWE;
$KWWE1 = $RO1 * -0.1;

$huhu = -1 * $KWWE1;
$hihu = -$KWWE;
if ($huhu>=$KWWE) $KWWE1= $hihu;

$RN1 = $KWWE1 + $RO1;

//End Formula//






        $DB->query("select * FROM ibf_tcusergroups WHERE tcugid='$clan1'");
        while($result=$DB->fetch_row()) {
        $clan1name = $result[name];
        }

        $DB->query("select * from ibf_tcusergroups WHERE tcugid='$clan2'");
        while($result=$DB->fetch_row()) {
        $clan2name = $result[name];
        }


        $DB->query("select * from ibf_members WHERE id='$allie1'");
        while($result=$DB->fetch_row()) {
        $allie1name = $result[name];
        }

        $DB->query("select * from ibf_members WHERE id='$allie2'");
        while($result=$DB->fetch_row()) {
        $allie2name = $result[name];
        }

        $DB->query("select * from ibf_members WHERE id='$oppt1'");
        while($result=$DB->fetch_row()) {
        $oppt1name = $result[name];
        }

        $DB->query("select * from ibf_members WHERE id='$oppt2'");
        while($result=$DB->fetch_row()) {
        $oppt2name = $result[name];
        }

        $DB->query("select * from ibf_members WHERE id='$oppt3'");
        while($result=$DB->fetch_row()) {
        $oppt3name = $result[name];
        }




//
//--Update ladder_clan Winners

$DB->query("select * from ibf_tcusergroups WHERE tcugid = '$clan1'");

if($DB->get_num_rows() <1) {
	$std->Error( array( 'LEVEL' => 1, 'MSG' => 'clan_changed' ) );
	}
        while($result=$DB->fetch_row()) {
        $clannewwins = $clan1winlosenum + $result[wins];
        $clannewgames = 1 + $result[totalgames];
        $clan1newpoints = $result[points] + $KWWE;
        $newstreak = $result[streak] + 1;

        }

$DB->query("UPDATE ibf_tcusergroups SET wins = $clannewwins, totalgames = $clannewgames, streak = $newstreak, points = $clan1newpoints WHERE tcugid = '$clan1' LIMIT 1");



//
//--Update ladder_clan Losers


$DB->query("select * from ibf_tcusergroups WHERE tcugid = '$clan2'");
if($DB->get_num_rows() <1) {
	$std->Error( array( 'LEVEL' => 1, 'MSG' => 'clan_changed' ) );
	}
        while($result=$DB->fetch_row()) {
        $clannewwins = $result[wins];
        $clannewgames = 1 + $result[totalgames];
		$clannewloss = 1 + $result[loss];
		$clan2newpoints = $result[points] + $KWWE1;
		        }

$DB->query("UPDATE ibf_tcusergroups SET wins = $clannewwins, loss = $clannewloss, streak = 0, totalgames = $clannewgames, points = $clan2newpoints WHERE tcugid = '$clan2' LIMIT 1");



//--Update ladder_members

        $DB->query("select * from ibf_members WHERE id='$name1'");
        while($result=$DB->fetch_row()) {
        $newwins = $clan1winlosenum + $result[name];
        $newgames = 1 + $result[totalgames];
        $newstreak = $result[streak] + 1;
        $clannewwins = $clan1winlosenum + $result[wins];
        $clannewgames = 1 + $result[totalgames];
        $tcpoints = $result[tcpoints] + $KWWE;
        }

        if ($clan1winlosenum == 1){
        $DB->query("UPDATE ibf_members SET wins = $clannewwins, totalgames = $clannewgames, lastgame = '$today', tcpoints ='$tcpoints' WHERE id = '$name1' LIMIT 1");
        $DB->query("UPDATE ibf_members SET streak = $newstreak WHERE id = '$name1' LIMIT 1");

        }

        $query= mysql_query("select * from ibf_members WHERE id='$allie1'");
        while ($result= mysql_fetch_array($query)) {
        $newwins = $clan1winlosenum + $result[name];
		        $newgames = 1 + $result[totalgames];
		        $newstreak = $result[streak] + 1;
		        $clannewwins = $clan1winlosenum + $result[wins];
		        $clannewgames = 1 + $result[totalgames];
        $tcpoints = $result[tcpoints] + $KWWE;
        }
        $DB->query("UPDATE ibf_members SET wins = $clannewwins, totalgames = $clannewgames, lastgame = '$today', tcpoints ='$tcpoints' WHERE id = '$allie1' LIMIT 1");
        if ($clan1winlosenum == 1){
        $DB->query("UPDATE ibf_members SET streak = $newstreak WHERE id = '$allie1' LIMIT 1");
        }

        $query= mysql_query("select * from ibf_members WHERE id='$allie2'");
        while ($result= mysql_fetch_array($query)) {
        $newwins = $clan1winlosenum + $result[name];
		        $newgames = 1 + $result[totalgames];
		        $newstreak = $result[streak] + 1;
		        $clannewwins = $clan1winlosenum + $result[wins];
		        $clannewgames = 1 + $result[totalgames];
        $tcpoints = $result[tcpoints] + $KWWE;
        }
        $DB->query("UPDATE ibf_members SET wins = $clannewwins, totalgames = $clannewgames, `lastgame` = '$today', tcpoints ='$tcpoints' WHERE id = '$allie2' LIMIT 1");
        if ($clan1winlosenum == 1){
        $DB->query("UPDATE ibf_members SET streak = $newstreak WHERE `id` = '$allie2' LIMIT 1");
        }


        $query= mysql_query("select * from ibf_members WHERE id='$oppt1'");
		        while ($result= mysql_fetch_array($query)) {
		        $newwins = $clan2winlosenum + $result[name];
		        $newgames = 1 + $result[totalgames];
		        $newstreak = $result[streak] = 1;
		        $clannewloss = 1 + $result[losses];
		        $clannewgames = 1 + $result[totalgames];
		        $tcpoints = $result[tcpoints] + $KWWE1;
		        }
		        {

		        $DB->query("UPDATE ibf_members SET losses = '$clannewloss', streak = '0', totalgames = '$clannewgames', lastgame = '$today', tcpoints ='$tcpoints' WHERE `id` = '$oppt1' LIMIT 1");
		        }


		        $query= mysql_query("select * from ibf_members WHERE id='$oppt2'");
		        while ($result= mysql_fetch_array($query)) {
		         $newwins = $clan2winlosenum + $result[name];
						        $newgames = 1 + $result[totalgames];
						        $newstreak = $result[streak] = 1;
						        $clannewloss = 1 + $result[losses];
						        $clannewgames = 1 + $result[totalgames];
		        $tcpoints = $result[tcpoints] + $KWWE1;

		        $tcpoints = $result[tcpoints] + $KWWE1;
		        }
		        {
		        $DB->query("UPDATE ibf_members SET losses = '$clannewloss', streak = '0', totalgames = '$clannewgames', lastgame = '$today', tcpoints ='$tcpoints' WHERE `id` = '$oppt2' LIMIT 1");
		        }

		        $query= mysql_query("select * from ibf_members WHERE id='$oppt3'");
		        while ($result= mysql_fetch_array($query)) {
		         $newwins = $clan2winlosenum + $result[name];
						        $newgames = 1 + $result[totalgames];
						        $newstreak = $result[streak] = 1;
						        $clannewloss = 1 + $result[losses];
						        $clannewgames = 1 + $result[totalgames];
		        $tcpoints = $result[tcpoints] + $KWWE1;

		        }

		        {
		        $DB->query("UPDATE ibf_members SET losses = '$clannewloss', streak = '0', totalgames = '$clannewgames', lastgame = '$today', tcpoints ='$tcpoints' WHERE `id` = '$oppt3' LIMIT 1");
        }



        $DB->query("SELECT id, name from ibf_members WHERE id!='0' AND id='$name1'");
        $m11=$DB->fetch_row();

$name1_n= $m11['name'];

        $DB->query("SELECT id, name from ibf_members WHERE id!='0' AND id='$allie1'");
        $m12=$DB->fetch_row();

$allie1_n= $m12['name'];

        $DB->query("SELECT id, name from ibf_members WHERE id!='0' AND id='$allie2'");
        $m13=$DB->fetch_row();

$allie2_n= $m13['name'];

        $DB->query("SELECT id, name from ibf_members WHERE  id!='0' AND id='$oppt1'");
        $m21=$DB->fetch_row();

$oppt1_n= $m21['name'];

        $DB->query("SELECT id, name from ibf_members WHERE id!='0' AND id='$oppt2'");
        $m22=$DB->fetch_row();

$oppt2_n= $m22['name'];

        $DB->query("SELECT id, name from ibf_members WHERE id!='0' AND id='$oppt3'");
        $m23=$DB->fetch_row();

$oppt3_n= $m23['name'];

$DB->query("SELECT tcugid, name from ibf_tcusergroups WHERE tcugid = '$clan1'");
        $c1=$DB->fetch_row();
        $clan1_n= $c1['name'];

$DB->query("SELECT tcugid, name from ibf_tcusergroups WHERE tcugid = '$clan2'");
        $c2=$DB->fetch_row();
		$clan2_n= $c2['name'];


$clan1add = $KWWE;
$clan2add = $KWWE1;

$clan1points = $clan1newpoints;
$clan2points = $clan2newpoints;


        require ROOT_PATH."sources/lib/post_parser.php";
        $this->parser = new post_parser();

		    		$match = array(
						'id'          => 0,
						'Time'         => $today,
						'clan1_n'		=> $clan1_n,
						'Clan1'       	=> $clan1,
						'member11_n'	=> $name1_n,
						'Member11'		=> $name1,
						'member12_n'	=> $allie1_n,
						'Member12'		=> $allie1,
						'member13_n'	=> $allie2_n,
						'Member13'		=> $allie2,
						'clan2_n'		=> $clan2_n,
						'Clan2'			=> $clan2,
						'member21_n'	=> $oppt1_n,
						'Member21'		=> $oppt1,
						'member22_n'	=> $oppt2_n,
						'Member22'		=> $oppt2,
						'member23_n'	=> $oppt3_n,
						'Member23'		=> $oppt3,
						'Type'			=> $gamet,
						'Map'			=> $gmmap,
						'rworl'			=> $rworl,
						'comment'        => $this->parser->convert( array( TEXT    => $comment,
													   SMILIES => 1,
													   CODE    => 1,
													   HTML    => 0
												)  ),
						'clan1points'	=> $clan1points,
						'clan2points'	=> $clan2points,
						'clan1add'		=> $clan1add,
						'clan2add'		=> $clan2add

					 );

		    		$db_string = $DB->compile_db_insert_string( $match );
				$DB->query("INSERT INTO ibf_ladder_matches (" .$db_string['FIELD_NAMES']. ") VALUES (". $db_string['FIELD_VALUES'] .")");






$print->redirect_screen( $ibforums->lang['pass_redirect'], "act=ladder" );

}









}


?>

