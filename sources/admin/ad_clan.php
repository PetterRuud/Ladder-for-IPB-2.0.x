<?php
// Usergroups by x00179 editted by Phil_b to fit the ladder

$idx = new ad_clan();



class ad_clan {




    var $parser    = "";
	var $perm_masks = array();
	function ad_clan() {
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
		case 'add':
				$this->add();
				break;
		case 'doadd':
				$this->doadd();
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
		$ibforums->admin->page_title  = "Changing Clan";

		$ibforums->html .= $ibforums->adskin->start_table( "Links" );
						$ibforums->admin->html .= $ibforums->adskin->add_td_row( array( "<a href='".$ibforums->adskin->base_url."&act=clan&code=add'>Click Here to Add a Clan</a>") );
						$ibforums->admin->html .= $ibforums->adskin->add_td_row( array( "<a href='".$ibforums->adskin->base_url."&act=clan&code=main'>Click Here to Customize the main settings</a>") );
		$ibforums->html .= $ibforums->adskin->end_table();

		$ibforums->adskin->td_header[] = array( "Name"  , "30%" );
		$ibforums->adskin->td_header[] = array( "Leader"  , "20%" );
		$ibforums->adskin->td_header[] = array( "State"   , "10%" );
		$ibforums->adskin->td_header[] = array( "Edit"    , "10%" );
		$ibforums->adskin->td_header[] = array( "Delete"  , "10%" );
		//+-------------------------------

		$ibforums->html .= $ibforums->adskin->start_table( "clan" );
		$outer=$DB->query("SELECT u.* FROM ibf_tcusergroups AS u ");
		//foreach ($this->perm_masks as $c=>$d) foreach($d as $e=>$f) echo $c."|".$e."=>".$f."<br>";
		while($row = $DB->fetch_row($outer)) {
			$DB->query("SELECT name,id FROM ibf_members WHERE id IN ({$row['mod_id']}) LIMIT 0,3");
			$row['mod_name']="";while($rw=$DB->fetch_row()) {$row['mod_name'].=$rw['name'].",";} $row['mod_name']=substr($row['mod_name'],0,-1);
			$ibforums->html .= $ibforums->adskin->add_td_row( array( $row['name'],$row['mod_name'],$row['state'],
												"<center><a href='".$ibforums->adskin->base_url."&act=clan&code=edit&tcugid={$row['tcugid']}'>Edit</a></center>",
												"<center><a href='".$ibforums->adskin->base_url."&act=clan&code=delete&tcugid={$row['tcugid']}&name={$row['name']}'>Delete</a></center>",
									 )      );
		}
		$ibforums->html .= $ibforums->adskin->end_table();
		$ibforums->adskin->td_header[] = array( "&nbsp;"  , "99%" );
		$ibforums->adskin->td_header[] = array( "&nbsp;"  , "1%" );

		$ibforums->admin->output();
	}

	function main() {
		global $ibforums;
		$ibforums->admin->page_detail = "check your data before hitting submit";
		$ibforums->admin->page_title  = "Change Settings";
		$ibforums->admin->nav[] = array( 'act=clan&code=show', 'Change Clans' );
		$ibforums->html .= $ibforums->adskin->start_form( array( 1 => array( 'code'  , 'domain' ),
												  2 => array( 'act'   , 'clan'     ),
									     )      );
		$ibforums->adskin->td_header[] = array( "&nbsp;"  , "20%" );
		$ibforums->adskin->td_header[] = array( "&nbsp;"  , "80%" );
		$ibforums->html .= $ibforums->adskin->start_table( "Settings" );

		$ibforums->html .= $ibforums->adskin->add_td_row( array( "<b>Show Explain Box</b>" ,
										  $ibforums->adskin->form_yes_no( "tcug_box_show", $ibforums->info['tcug_box_show']  )
						 )      );

		$ibforums->info['ug_box_det']= $this->parser->unconvert($ibforums->info['tcug_box_det'],1,1);
		$ibforums->info['tcug_box_det'] = addslashes($ibforums->info['tcug_box_det']);
                $ibforums->html .= $ibforums->adskin->add_td_row( array( "<b>Ladder Explain Box</b><br />HTML,Emoticons,IBF code enabled" ,
									  $ibforums->adskin->form_textarea( "tcug_box_det", $ibforums->info['tcug_box_det'] , 60, 15 )
							     )      );
		$ibforums->html .= $ibforums->adskin->end_form("Submit");
		$ibforums->html .= $ibforums->adskin->end_table();
		$ibforums->admin->output();
	}


	function domain() {
		global $ibforums, $HTTP_POST_VARS;
		$sav['tcug_box_det']= $this->parser->convert( array(
								 'TEXT'    => $HTTP_POST_VARS['tcug_box_det'],
								 'CODE'    => 1,
								 'SMILIES' => 1,
								 'HTML'    => 1
						)      );

		$sav['tcug_box_show'] = $HTTP_POST_VARS['tcug_box_show'];
		$ibforums->admin->rebuild_config($sav);
		$ibforums->admin->done_screen("Ladder Information Updated", "Ladder Home", "act=clan" );
	}

	function add() {
		global $DB, $std, $ibforums;
		$mods=array(); $mod_ids = trim(urldecode($IN['id']));
		if($mod_ids!="") {
			$DB->query("SELECT name,id FROM ibf_members WHERE id IN ({$mod_ids})");
  		    while($rw=$DB->fetch_row()) { $mods[]=$rw;}
		}
		$ibforums->admin->page_detail = "check your data before hitting submit";
		$ibforums->admin->page_title  = "Add a Clan";
		$ibforums->admin->nav[] = array( 'act=clan&code=show', 'Change Clan' );
		// search part
		$ibforums->html .= $ibforums->adskin->start_form( array( 1 => array( 'code'  , 'searchmem' ),
												  2 => array( 'act'   , 'clan'     ),
												  3 => array( 'rcode' , 'add' ),
												  4 => array( 'id'	  , $mod_ids ),
									     )      );
		//+-------------------------------
		$ibforums->adskin->td_header[] = array( "&nbsp;"  , "40%" );
		$ibforums->adskin->td_header[] = array( "&nbsp;"  , "60%" );
		//+-------------------------------
		$ibforums->html .= $ibforums->adskin->start_table( "Member Quick Search" );
		$ibforums->html .= $ibforums->adskin->add_td_row( array( "<b>Enter part or all of the usersname</b>" ,
												  $ibforums->adskin->form_input( "name" )
									     )      );
		$ibforums->html .= $ibforums->adskin->end_form("Find Member");
		$ibforums->html .= $ibforums->adskin->end_table();
		// add part
		$ibforums->html .= $ibforums->adskin->start_form( array( 1 => array( 'code'  , 'doadd' ),
												  2 => array( 'act'   , 'clan'     ),
									     )      );
		$ibforums->adskin->td_header[] = array( "&nbsp;"  , "20%" );
		$ibforums->adskin->td_header[] = array( "&nbsp;"  , "80%" );
		$ibforums->html .= $ibforums->adskin->start_table( "Clan details" );
		$ibforums->html .= $ibforums->adskin->add_td_row( array( "<b>Clan Name</b>",
									$ibforums->adskin->form_input( "group_name", "" )
								 )      );

		$ibforums->html .= $ibforums->adskin->add_td_row( array( "<b>Clan Description</b>" ,
									  $ibforums->adskin->form_textarea( "group_description", "" , 60, 15 )
							     )      );
		$mod_name="";$mod_id="";
		foreach ($mods as $c) {$mod_name.="<a href='".$ibforums->adskin->base_url."&act=clan&code=mdel&id={$mod_ids}&mid={$c['id']}&rcode=add'>Delete<a>&nbsp;-&nbsp;{$c['name']}<br><br>";$mod_id.=$c['id'].",";}
		$mod_name=substr($mod_name,0,-8);$mod_id=substr($mod_id,0,-1);
		$ibforums->html .= $ibforums->adskin->add_td_row( array( "<b>Clan Leader</b><br />use search above to add",
									$ibforums->adskin->form_hidden( array( 1=>array("group_moderator", $mod_id))) .$mod_name,
									)      );

		$ibforums->html .= $ibforums->adskin->end_form("Submit");
		$ibforums->html .= $ibforums->adskin->end_table();
		$ibforums->admin->output();
	}

	function doadd() {
		global $DB, $std, $ibforums;
		if ($ibforums->input['group_moderator'] == "") $ibforums->admin->error("You didn't choose a Clan Leader!");
		$db_string = $DB->compile_db_insert_string( array(
													'name'         => $ibforums->input['group_name'],

													'description'  => $ibforums->input['group_description'],
													'mod_id'	   => $ibforums->input['group_moderator'],

										  )       );
		$DB->query("INSERT INTO ibf_tcusergroups (".$db_string['FIELD_NAMES'].") VALUES(".$db_string['FIELD_VALUES'].")");
		$ibforums->admin->save_log("Added Clan '{$ibforums->input['group_name']}'");
		$ibforums->admin->done_screen("Added Clan", "Clan Control", "act=clan&code=show" );
	}

		function edit() {
			global $DB, $std, $ibforums;
			if ($ibforums->input['tcugid'] == "") $ibforums->admin->error("You didn't choose a tcusergroup to edit!");
			$DB->query("SELECT * FROM ibf_tcusergroups WHERE tcugid='".$ibforums->input['tcugid']."'");
			if($DB->get_num_rows() <1) $ibforums->admin->error("Can't find that usergroup");
			$row = $DB->fetch_row();
			// Get moderator names
			$mod_ids = trim(urldecode($ibforums->input['id']));
			$mod_ids = ($mod_ids==""? $row['mod_id']:$mod_ids);
			$DB->query("SELECT name,id FROM ibf_members WHERE id IN ({$mod_ids})");
	  	    $mods=array();while($rw=$DB->fetch_row()) { $mods[]=$rw;}
			$ibforums->admin->page_detail = "check your data before hitting submit";
			$ibforums->admin->page_title  = "Edit a Usergroup";
			$ibforums->admin->nav[] = array( 'act=clan&code=show', 'Change Usergroups' );
			// search part
			$ibforums->html .= $ibforums->adskin->start_form( array( 1 => array( 'code'  , 'searchmem' ),
													  2 => array( 'act'   , 'clan'     ),
													  3 => array( 'rcode' , 'edit' ),
													  4 => array( 'tcugid'  , $ibforums->input['tcugid'] ),
													  5 => array( 'id'	  , $mod_ids ),
										     )      );
			//+-------------------------------
			$ibforums->adskin->td_header[] = array( "&nbsp;"  , "40%" );
			$ibforums->adskin->td_header[] = array( "&nbsp;"  , "60%" );
			//+-------------------------------
			$ibforums->html .= $ibforums->adskin->start_table( "Member Quick Search" );
			$ibforums->html .= $ibforums->adskin->add_td_row( array( "<b>Enter part or all of the usersname</b>" ,
													  $ibforums->adskin->form_input( "name" )
										     )      );
			$ibforums->html .= $ibforums->adskin->end_form("Find Member");
			$ibforums->html .= $ibforums->adskin->end_table();
			// edit part
			$ibforums->html .= $ibforums->adskin->start_form( array( 1 => array( 'code'  , 'doedit' ),
													  2 => array( 'act'   , 'clan'     ),
													  3 => array( 'tcugid'	  , $ibforums->input['tcugid'] ),
										     )      );
			$ibforums->adskin->td_header[] = array( "&nbsp;"  , "20%" );
			$ibforums->adskin->td_header[] = array( "&nbsp;"  , "80%" );
			$ibforums->html .= $ibforums->adskin->start_table( "Clan details" );
			$ibforums->html .= $ibforums->adskin->add_td_row( array( "<b>Clan Name</b>",
										$ibforums->adskin->form_input( "group_name", $row['name'] )
									 )      );

			$row['description']=preg_replace( "/&lt;br&gt;|&lt;br \/&gt;/", "\n", $row['description'] );
			$ibforums->html .= $ibforums->adskin->add_td_row( array( "<b>Clan Description</b>" ,
										  $ibforums->adskin->form_textarea( "group_description", $std->txt_stripslashes($row['description']) , 60, 15 )
								     )      );
			$mod_name="";$mod_id="";
			foreach ($mods as $c) {$mod_name.="<a href='".$ibforums->adskin->base_url."&act=clan&code=mdel&id={$mod_ids}&mid={$c['id']}&rcode=edit&tcugid={$ibforums->input['tcugid']}'>Delete<a>&nbsp;-&nbsp;{$c['name']}<br><br>";$mod_id.=$c['id'].",";}
			$mod_name=substr($mod_name,0,-8);$mod_id=substr($mod_id,0,-1);
			$ibforums->html .= $ibforums->adskin->add_td_row( array( "<b>Clan Leader</b><br />use search above to add",
										$ibforums->adskin->form_hidden( array( 1=>array("group_moderator", $mod_id))) .$mod_name,
									 )      );

			$ibforums->html .= $ibforums->adskin->end_form("Submit");
			$ibforums->html .= $ibforums->adskin->end_table();
			$ibforums->admin->output();
		}

	function doedit() {
		global $DB, $std, $ibforums;
		if ($ibforums->input['tcugid'] == "") $ibforums->admin->error("You didn't choose a Clan to edit!");
		if ($ibforums->input['group_moderator'] == "") $ibforums->admin->error("You didn't choose a moderator!");
		$DB->query("SELECT name FROM ibf_tcusergroups WHERE tcugid='".$ibforums->input['tcugid']."'");
		if($DB->get_num_rows() <1) $ibforums->admin->error("Can't find that usergroup");
		$row=$DB->fetch_row();
		if($row['name']!=$ibforums->input['group_name']) { // we need to edit all members because you change the mask :@
			$outer=$DB->query("SELECT m.id,m.clanname FROM ibf_members AS m WHERE m.id!=0 AND ".
						"(clanname LIKE '".$row['name']."' OR clanname LIKE '%,".$row['name']."' OR ".
						"clanname LIKE '".$row['name'].",%' OR clanname LIKE '%,".$row['name'].",%')");
			while($rw=$DB->fetch_row($outer)) {
				$new_arr = array();$out_arr=array();
				if($rw['clanname'] == "" ) { //uhh, empty well fill it up with the original perms get them from ibf_groups
					$DB->query("SELECT g.g_name FROM ibf_members AS m LEFT JOIN ibf_groups AS g ON g.g_id=m.mgroup WHERE id={$row['id']}");
					$r=$DB->fetch_row(); $new_arr=explode(",",$r['g_name']);
				}
				else $new_arr=explode(",",$rw['clanname']);
				foreach($new_arr as $s) if($row['name']!=$s && !in_array($s,$out_arr)) $out_arr[]=$s; //kick the old one
				$out_arr[]=$ibforums->input['group_name']; // here comes the new one :D
				$DB->query("UPDATE ibf_members SET clanname='".implode(",",$out_arr)."' WHERE id={$rw['id']}");
			}
		}
		// now we can finaly update the usergroup (w00t)
		$db_string = $DB->compile_db_update_string( array (
													'name'         => $ibforums->input['group_name'],

													'description'  => $ibforums->input['group_description'],
													'mod_id'	   => $ibforums->input['group_moderator'],

												  )       );
			$DB->query("UPDATE ibf_tcusergroups SET $db_string WHERE tcugid='".$ibforums->input['tcugid']."'");
			$ibforums->admin->save_log("Edit Clan '{$ibforums->input['group_name']}'");
			$ibforums->admin->done_screen("Clan edit", "Clan Control", "act=clan&code=show" );
	}




	function del() {
		global $DB, $std, $ibforums;
		$ibforums->admin->page_detail = "please make sure that really want to delete this usergroup";
		$ibforums->admin->page_title  = "Delete a Usergroup";
		$ibforums->admin->nav[] = array( 'act=clan&code=show', 'Change Usergroups' );
		$ibforums->adskin->td_header[] = array( "&nbsp;"  , "99%" );
		$ibforums->adskin->td_header[] = array( "&nbsp;"  , "1%" );
		$ibforums->html .= $ibforums->adskin->start_table( "Delete Usergroup called: {$ibforums->input['name']}" );
		$ibforums->html .= $ibforums->adskin->add_td_row( array( "<a href='".$ibforums->adskin->base_url."&act=clan&code=dodel&tcugid={$ibforums->input['tcugid']}&name={$ibforums->input['name']}'>Click Here to Delete the Usergroup: {$ibforums->input['name']}</a>") );
		$ibforums->html .= $ibforums->adskin->end_table();
		$ibforums->admin->output();
	}

	function dodel() {
		global $DB, $std, $ibforums;
		if ($ibforums->input['tcugid'] == "") {$ibforums->admin->error("You must pass a valid filter id");}
		$DB->query("SELECT name FROM ibf_tcusergroups WHERE tcugid='".$ibforums->input['tcugid']."'");
		if($DB->get_num_rows() <1) $ibforums->admin->error("Can't find that Clan");
		$row=$DB->fetch_row();
		$DB->query("DELETE FROM ibf_tcusergroups WHERE tcugid='".$ibforums->input['tcugid']."'");
		//delete all members from the premission mask
		$outer=$DB->query("SELECT m.id,m.clanname FROM ibf_members AS m WHERE m.id!=0 AND ".
					"(clanname LIKE '".$row['name']."' OR clanname LIKE '%,".$row['name']."' OR ".
					"clanname LIKE '".$row['name'].",%' OR clanname LIKE '%,".$row['name'].",%')");
		while($rw=$DB->fetch_row($outer)) {
			$new_arr = array();$out_arr=array();
			if($rw['clanname'] == "" ) { //uhh, empty well fill it up with the original perms get them from ibf_groups
				$DB->query("SELECT g.g_name FROM ibf_members AS m LEFT JOIN ibf_groups AS g ON g.g_id=m.mgroup WHERE id={$row['id']}");
				$r=$DB->fetch_row(); $new_arr=explode(",",$r['g_name']);
			}
			else $new_arr=explode(",",$rw['clanname']);
			foreach($new_arr as $s) if($row['name']!=$s && !in_array($s,$out_arr)) $out_arr[]=$s;
			$DB->query("UPDATE ibf_members SET clanname='".implode(",",$out_arr)."' WHERE id={$rw['id']}");
		}
		$ibforums->admin->save_log("Deleted Clan '{$IN['name']}'");
		$ibforums->admin->done_screen("Clan deleted", "Clan Control", "act=clan&code=show" );
	}




	function searchmem() {
		global $DB, $std, $ibforums;
		$page_query = "";
		$un_all = "";

		$ibforums->input['name'] = trim(urldecode($ibforums->input['name']));

		if ($ibforums->input['name'] == "") $ibforums->admin->error("You didn't choose a member name to look for!");

		$page_query = "&name=".urlencode($IN['name']);
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
											   'BASE_URL'    => $ibforums->adskin->base_url."&act=clan&code={$ibforums->input['code']}".$page_query,
											 )
									  );
		//+-------------------------------
		if($count <1) $ibforums->admin->error("Your search query did not return any matches from the member database. Please go back and try again");
		$ibforums->admin->html .= $ibforums->adskin->start_table( "{$count} Search Results" );
		while ( $r = $DB->fetch_row() )
		{
			$mod_ids=($ibforums->input['id']=="" ? $r['id']:$ibforums->input['id'].",".$r['id']);
			$ibforums->html .= $ibforums->adskin->add_td_basic( "<img src='html/sys-img/item.gif' border='0' alt='-'>&nbsp;<a style='font-size:12px' title='View this members profile' href='{$ibforums->info['board_url']}/index.{$ibforums->info['php_ext']}?act=Profile&MID={$r['id']}' target='blank'>{$r['name']}</a> $tban", "left", "pformstrip" );
			$ibforums->html .= $ibforums->adskin->add_td_row( array( "{$r['ip_address']}",
													  $r['g_title'],
													  "<center>".$r['posts']."</center>",
													  "<center>".$r['email']."</center>",
													  "<center><strong><a href='{$ibforums->adskin->base_url}&act=clan&code={$ibforums->input['rcode']}&id={$mod_ids}&tcugid={$ibforums->input['tcugid']}' title='Add this member as usergroup moderator'>Add Member</a></strong></center>",
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
		$std->boink_it($ibforums->adskin->base_url."&act=clan&code={$ibforums->input['rcode']}&id={$mod_ids}&tcugid={$ibforums->input['tcugid']}");
		exit();
	}
}
?>