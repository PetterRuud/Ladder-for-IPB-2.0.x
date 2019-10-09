<?php
// Usergroups by x00179 editted by Phil_b to fit the ladder

$idx = new ad_ladder();

class ad_ladder {
    var $parser    = "";
	var $perm_masks = array();
	function ad_ladder() {
global $DB, $std, $ibforums;




		switch($ibforums->input['code'])
		{
		case 'show':
				$this->show();
				break;
		case 'main':
				if(!class_exists ("post_parser")) require ROOT_PATH. "sources/lib/post_parser.php";
				$this->parser = new post_parser(1);
				$this->main();
				break;
		case 'domain':
		        if(!class_exists ("post_parser")) require ROOT_PATH. "sources/lib/post_parser.php";
				$this->parser = new post_parser(1);
				$this->domain();
				break;

		case 'edit':
				$this->edit();
				break;
		case 'doedit':
				$this->doedit();
				break;
		case 'delete':
				$this->del();
				break;
		case 'dodel':
				$this->dodel();
				break;
		case 'searchmem':
				$this->searchmem();
				break;
		case 'mdel':
				$this->mdel();
				break;
		default:
				$this->show();
				break;
		}
	}
	function show() {
		global $DB, $std, $ibforums;
		$ibforums->admin->page_detail = "";
		$ibforums->admin->page_title  = "Managing Games";
		$ibforums->adskin->td_header[] = array( "Id"  , "5%" );
		$ibforums->adskin->td_header[] = array( "Clan1", "15%");
		$ibforums->adskin->td_header[] = array( "Clan2"  , "15%" );
		$ibforums->adskin->td_header[] = array( "Map"   , "10%" );
		$ibforums->adskin->td_header[] = array( "Details"    , "10%" );
		$ibforums->adskin->td_header[] = array( "Delete"  , "10%" );
		//+-------------------------------
		$ibforums->html .= $ibforums->adskin->start_table( "Manage Games" );
		$outer=$DB->query("SELECT u.* FROM ibf_ladder_matches AS u ORDER BY id DESC ");
		//foreach ($this->perm_masks as $c=>$d) foreach($d as $e=>$f) echo $c."|".$e."=>".$f."<br>";
		while($row = $DB->fetch_row($outer)) {

			$ibforums->html .= $ibforums->adskin->add_td_row( array( $row['id'],$row['clan1_n'],$row['clan2_n'],$row['Map'],
												"<center><a href='".$ibforums->adskin->base_url."&act=ladder&code=edit&id={$row['id']}'>Details</a></center>",
												"<center><a href='".$ibforums->adskin->base_url."&act=ladder&code=delete&id={$row['id']}'>Delete</a></center>",
									 )      );
		}
		$ibforums->html .= $ibforums->adskin->end_table();
		$ibforums->adskin->td_header[] = array( "&nbsp;"  , "99%" );
		$ibforums->adskin->td_header[] = array( "&nbsp;"  , "1%" );

		$ibforums->admin->output();
	}





	function edit() {
		global $DB, $std, $ibforums;
		if ($ibforums->input['id'] == "") $ibforums->admin->error("You didn't choose a game to edit!");
		$DB->query("SELECT * FROM ibf_ladder_matches WHERE id='".$ibforums->input['id']."'");
		if($DB->get_num_rows() <1) $ibforums->admin->error("Can't find that game");
		$row = $DB->fetch_row();
		$ibforums->adskin->td_header[] = array( "Id"  , "5%" );
				$ibforums->adskin->td_header[] = array( "Clan1", "15%");
				$ibforums->adskin->td_header[] = array( "Player 1", "15%");
				$ibforums->adskin->td_header[] = array( "Player 2", "15%");
				$ibforums->adskin->td_header[] = array( "Player 3", "15%");
				$ibforums->adskin->td_header[] = array( "Clan2"  , "15%" );
				$ibforums->adskin->td_header[] = array( "Player 1", "15%");
				$ibforums->adskin->td_header[] = array( "Player 2", "15%");
				$ibforums->adskin->td_header[] = array( "Player 3", "15%");
				$ibforums->adskin->td_header[] = array( "Map"   , "10%" );

				//+-------------------------------
				$ibforums->html .= $ibforums->adskin->start_table( "Manage Games" );
				$outer=$DB->query("SELECT u.* FROM ibf_ladder_matches AS u WHERE id='".$ibforums->input['id']."'");
				//foreach ($this->perm_masks as $c=>$d) foreach($d as $e=>$f) echo $c."|".$e."=>".$f."<br>";
				while($row = $DB->fetch_row($outer)) {

					$ibforums->html .= $ibforums->adskin->add_td_row( array( $row['id'],$row['clan1_n'],$row['member11_n'],$row['member12_n'],$row['member13_n'],$row['clan2_n'],$row['member21_n'],$row['member22_n'],$row['member23_n'],$row['Map'],

											 )      );
		}


		$ibforums->html .= $ibforums->adskin->end_table();
		$ibforums->admin->output();
	}

	function doedit() {
		global $DB, $std, $ibforums;
		if ($ibforums->input['id'] == "") $ibforums->admin->error("You didn't choose a usergroup to edit!");
		if ($ibforums->input['group_moderator'] == "") $ibforums->admin->error("You didn't choose a moderator!");
		$DB->query("SELECT id FROM ibf_ladder_matches WHERE id='".$ibforums->input['id']."'");
		if($DB->get_num_rows() <1) $ibforums->admin->error("No Games have been played to edit!");
		$row=$DB->fetch_row();
		if($row['perm_id']!=$ibforums->input['group_perm_id']) { // we need to edit all members because you change the mask :@
			$outer=$DB->query("SELECT m.id,m.org_perm_id FROM ibf_members AS m WHERE m.id!=0 AND ".
						"(org_perm_id LIKE '".$row['perm_id']."' OR org_perm_id LIKE '%,".$row['perm_id']."' OR ".
						"org_perm_id LIKE '".$row['perm_id'].",%' OR org_perm_id LIKE '%,".$row['perm_id'].",%')");
			while($rw=$DB->fetch_row($outer)) {
				$new_arr = array();$out_arr=array();
				if($rw['org_perm_id'] == "" ) { //uhh, empty well fill it up with the original perms get them from ibf_groups
					$DB->query("SELECT g.g_perm_id FROM ibf_members AS m LEFT JOIN ibf_groups AS g ON g.g_id=m.mgroup WHERE id={$row['id']}");
					$r=$DB->fetch_row(); $new_arr=explode(",",$r['g_perm_id']);
				}
				else $new_arr=explode(",",$rw['org_perm_id']);
				foreach($new_arr as $s) if($row['perm_id']!=$s && !in_array($s,$out_arr)) $out_arr[]=$s; //kick the old one
				$out_arr[]=$ibforums->input['group_perm_id']; // here comes the new one :D
				$DB->query("UPDATE ibf_members SET org_perm_id='".implode(",",$out_arr)."' WHERE id={$rw['id']}");
			}
		}
		// now we can finaly update the usergroup (w00t)
		$db_string = $DB->compile_db_update_string( array (
													'name'         => $ibforums->input['group_name'],
													'perm_id'	   => $ibforums->input['group_perm_id'],
													'description'  => $ibforums->input['group_description'],
													'mod_id'	   => $ibforums->input['group_moderator'],
													'state'   	   => $ibforums->input['group_state'],
												  )       );
		$DB->query("UPDATE ibf_tcusergroups SET $db_string WHERE tcugid='".$ibforums->input['tcugid']."'");
		$ibforums->admin->save_log("Edit Usergroup '{$ibforums->input['group_name']}'");
		$ibforums->admin->done_screen("Usergroup edit", "Usergroup Control", "act=tcusergroups&code=show" );
	}


	function del() {
			global $DB, $std, $ibforums;
			$ibforums->admin->page_detail = "please make sure that you really want to delete this game";
			$ibforums->admin->page_title  = "Delete a Game";
			$ibforums->admin->nav[] = array( 'act=ladder&code=show', 'Delete Game' );
			$ibforums->adskin->td_header[] = array( "&nbsp;"  , "99%" );
			$ibforums->adskin->td_header[] = array( "&nbsp;"  , "1%" );


			$ibforums->html .= $ibforums->adskin->start_table( "Delete Game id ({$ibforums->input['id']})" );
			$ibforums->html .= $ibforums->adskin->add_td_row( array( "<a href='".$ibforums->adskin->base_url."&act=ladder&code=dodel&id={$ibforums->input['id']}'>Click Here to Delete this Game</a>") );
			$ibforums->html .= $ibforums->adskin->end_table();
			$ibforums->admin->output();
		}

	function dodel() {
			global $DB, $std, $ibforums;
			if ($ibforums->input['id'] == "") {$ibforums->admin->error("You must pass a valid filter id");}
			$DB->query("SELECT * FROM ibf_ladder_matches WHERE id='".$ibforums->input['id']."'");
			//if($DB->get_num_rows() <1) $ibforums->admin->error("Can't find that usergroup");
			while($row=$DB->fetch_row()) {

					$clan1add = $row[clan1add];
					$clan2add = $row[clan2add];
					$clan1 = $row[Clan1];
					$clan2 = $row[Clan2];
					$Member11 = $row[Member11];
					$Member12 = $row[Member12];
					$Member13 = $row[Member13];
					$Member21 = $row[Member21];
					$Member22 = $row[Member22];
					$Member23 = $row[Member23];
					$gamet    = $row[Type];
	}

	//*********************************************/
	//
	// Adding a Character
	//
	//*********************************************/


		//+--------------------------------------------
		//| Sort clan points out
		//+--------------------------------------------

//lots of queries -_- so that all your members are happy there points look correct ;)

	$DB->query("SELECT * FROM ibf_tcusergroups WHERE tcugid = '$clan1' LIMIT 1");
	if($DB->get_num_rows() > 0) {
			$row=$DB->fetch_row();
					$wins = $row[wins] -1;
					$totalgames = $row[totalgames] -1;
					$points = $row[points] - $clan1add;

	$DB->query("UPDATE ibf_tcusergroups SET points = $points, wins = $wins, totalgames = $totalgames WHERE tcugid = '$clan1' LIMIT 1");
}
	$DB->query("SELECT * FROM ibf_tcusergroups WHERE tcugid = '$clan2' LIMIT 1");
	if($DB->get_num_rows() > 0) {
			$row=$DB->fetch_row();
					$loss = $row[loss] -1;
					$totalgames = $row[totalgames] -1;
					$points = $row[points] - $clan2add;

	$DB->query("UPDATE ibf_tcusergroups SET points = $points, loss = $loss, totalgames = $totalgames WHERE tcugid = '$clan2' LIMIT 1");
}

		//+--------------------------------------------
		//| Sort member winner points out
		//+--------------------------------------------

	$DB->query("SELECT * FROM ibf_members WHERE id = '$Member11' LIMIT 1");
			$row=$DB->fetch_row();
	if($row['clanid'] == $clan1) {
					$wins = $row[wins] -1;
					$totalgames = $row[totalgames] -1;
					$tcpoints = $row[tcpoints] - $clan1add;


	$DB->query("UPDATE ibf_members SET tcpoints = $tcpoints, wins = $wins, totalgames = $totalgames WHERE id = '$Member11' LIMIT 1");
	}
	if ($gamet == 2 or $gamet == 3)	{
	$DB->query("SELECT * FROM ibf_members WHERE id = '$Member12' LIMIT 1");
			$row=$DB->fetch_row();
	if($row['clanid'] == $clan1) {
					$wins = $row[wins] -1;
					$totalgames = $row[totalgames] -1;
					$tcpoints = $row[tcpoints] - $clan1add;

	$DB->query("UPDATE ibf_members SET tcpoints = $tcpoints, wins = $wins, totalgames = $totalgames WHERE id = '$Member12' LIMIT 1");
		}
	}
	if ($gamet == 3)	{
	$DB->query("SELECT * FROM ibf_members WHERE id = '$Member13' LIMIT 1");
			$row=$DB->fetch_row();
	if($row['clanid'] == $clan1) {
					$wins = $row[wins] -1;
					$totalgames = $row[totalgames] -1;
					$points = $row[tcpoints] - $clan1add;

	$DB->query("UPDATE ibf_members SET tcpoints = $tcpoints, wins = $wins, totalgames = $totalgames WHERE id = '$Member13' LIMIT 1");
		}
	}
		//+--------------------------------------------
		//| Sort member loser points out
		//+--------------------------------------------


	$DB->query("SELECT * FROM ibf_members WHERE id = '$Member21' LIMIT 1");
			$row=$DB->fetch_row();
	if($row['clanid'] == $clan2) {
					$losses = $row[losses] -1;
					$totalgames = $row[totalgames] -1;
					$tcpoints = $row[tcpoints] - $clan2add;

	$DB->query("UPDATE ibf_members SET tcpoints = $tcpoints, losses = $losses, totalgames = $totalgames WHERE id = '$Member21' LIMIT 1");
	}
	if ($gamet == 2 or $gamet == 3)	{
	$DB->query("SELECT * FROM ibf_members WHERE id = '$Member22' LIMIT 1");
			$row=$DB->fetch_row();
	if($row['clanid'] == $clan2) {
					$losses = $row[losses] -1;
					$totalgames = $row[totalgames] -1;
					$tcpoints = $row[tcpoints] - $clan2add;

	$DB->query("UPDATE ibf_members SET tcpoints = $tcpoints, losses = $losses, totalgames = $totalgames WHERE id = '$Member22' LIMIT 1");
		}
	}
	if ($gamet == 3)	{
	$DB->query("SELECT * FROM ibf_members WHERE id = '$Member23' LIMIT 1");
			$row=$DB->fetch_row();
	if($row['clanid'] == $clan2) {
					$losses = $row[losses] -1;
					$totalgames = $row[totalgames] -1;
					$tcpoints = $row[tcpoints] - $clan2add;

	$DB->query("UPDATE ibf_members SET tcpoints = $tcpoints, losses = $losses, totalgames = $totalgames1 WHERE id = '$Member23' LIMIT 1");
		}
	}

		//+--------------------------------------------
		//| Delete the ladder row
		//+--------------------------------------------

	$DB->query("DELETE FROM ibf_ladder_matches WHERE id='".$ibforums->input['id']."'");


			$ibforums->admin->save_log("Deleted Game ID '{$ibforums->input['id']}'");
			$ibforums->admin->done_screen("Game deleted", "Manage Games", "act=ladder&code=show" );
		}

	function searchmem() {
			global $DB, $std, $ibforums;
			$page_query = "";
			$un_all = "";

			$ibforums->input['name'] = trim(urldecode($ibforums->input['name']));

			if ($ibforums->input['name'] == "") $ibforums->admin->error("You didn't choose a member name to look for!");

			$page_query = "&name=".urlencode($ibforums->input['name']);
			$rq = "name LIKE '".$ibforums->input['name']."%'";
			if($ibforums->input['id']!="") $rq.=" AND m.id NOT IN ({$ibforums->input['id']})";
			$st = intval($ibforums->input['st']);
			if ($st < 1) $st = 0;

			$ibforums->admin->page_title = "Your Member Search Results";
			$ibforums->admin->page_detail = "Your search results.";
			//+-------------------------------
			$ibforums->adskin->td_header[] = array( "IP Address "  		, "20%" );
			$ibforums->adskin->td_header[] = array( "Group"        		, "20%" );
			$ibforums->adskin->td_header[] = array( "Posts"        		, "20%" );
			$ibforums->adskin->td_header[] = array( "Email"        		, "20%" );
			$ibforums->adskin->td_header[] = array( "Add a moderator"   , "20%" );
			$DB->query("SELECT m.id, m.email, m.name, m.mgroup, m.ip_address, m.posts, m.temp_ban, g.g_title
			            FROM ibf_members m
			            LEFT JOIN ibf_groups g ON (g.g_id=m.mgroup)
			            WHERE $rq ORDER BY m.name LIMIT $st,50");
			$count=	$DB->get_num_rows();
			//+-------------------------------
			$pages = $std->build_pagelinks( array( 'TOTAL_POSS'  => $count,
												   'PER_PAGE'    => 50,
												   'CUR_ST_VAL'  => $ibforums->input['st'],
												   'L_SINGLE'    => $un_all."Single Page",
												   'L_MULTI'     => $un_all."Multi Page",
												   'BASE_URL'    => $ibforums->adskin->base_url."&act=tcusergroups&code={$ibforums->input['code']}".$page_query,
												 )
										  );
			//+-------------------------------
			if($count <1) $ibforums->admin->error("Your search query did not return any matches from the member database. Please go back and try again");
			$ibforums->html .= $ibforums->adskin->start_table( "{$count} Search Results" );
			while ( $r = $DB->fetch_row() )
			{
				$mod_ids=($ibforums->input['id']=="" ? $r['id']:$ibforums->input['id'].",".$r['id']);
				$ibforums->html .= $ibforums->adskin->add_td_basic( "<img src='html/sys-img/item.gif' border='0' alt='-'>&nbsp;<a style='font-size:12px' title='View this members profile' href='{$ibforums->info['board_url']}/index.{$ibforums->info['php_ext']}?act=Profile&MID={$r['id']}' target='blank'>{$r['name']}</a> $tban", "left", "pformstrip" );
				$ibforums->html .= $ibforums->adskin->add_td_row( array( "{$r['ip_address']}",
														  $r['g_title'],
														  "<center>".$r['posts']."</center>",
														  "<center>".$r['email']."</center>",
														  "<center><strong><a href='{$ibforums->adskin->base_url}&act=tcusergroups&code={$ibforums->input['rcode']}&id={$mod_ids}&tcugid={$ibforums->input['tcugid']}' title='Add this member as usergroup moderator'>Add Member</a></strong></center>",
										     	 )      );
			}
			$ibforums->html .= $ibforums->adskin->add_td_basic($pages, 'right', 'pformstrip');
			$ibforums->html .= $ibforums->adskin->end_table();
			$ibforums->admin->output();
	}
	function mdel() {
		global $DB, $std, $ibforums;
		$mod_ids="";$mod_arr=explode(",",$ibforums->input['id']);
		foreach($mod_arr as $d) if($d!=$ibforums->input['mid']) $mod_ids.=$d.",";
		$mod_ids=substr($mod_ids,0,-1);
		$std->boink_it($ibforums->adskin->base_url."&act=tcusergroups&code={$ibforums->input['rcode']}&id={$mod_ids}&tcugid={$ibforums->input['tcugid']}");
		exit();
	}
}
?>