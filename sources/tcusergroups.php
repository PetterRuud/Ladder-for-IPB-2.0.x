<?php
// Usergroups made by x00179 and modified by Phil_B to fit the ladder.
$idx = new tcusergroups;
class tcusergroups {
    var $output     = "";
    var $page_title = "";
    var $nav        = array();
    var $html       = "";
	var $email		= "";
    var $custom_fields  = "";
    function tcusergroups() {
			global $ibforums, $DB, $std, $print;
			$ibforums->lang = $std->load_words($ibforums->lang, 'lang_tcusergroups'   , $ibforums->lang_id );
			$this->html = $std->load_template('skin_tcusergroups');
		/*if($ibforums->member['id']!=1)
			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'ug_no_access' ) );*/
		/*if($ibforums->member['mgroup']==1 or $ibforums->member['mgroup']==2 or $ibforums->member['mgroup']==5)
			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'ug_no_access' ) );*/
			$this->output.=$this->html->page_top();
	    	switch($ibforums->input['code']) {
	    		case 'show':
	    			$this->show();
	    			break;
				case 'det':
					$this->detail();
					break;
					case 'tcmatch':
					$this->tcmatch();
					break;
				case 'join':
					$this->ug_join();
					break;
				case 'unjoin':
					$this->unjoin();
					break;
				case 'modval':
					$this->modval();
					break;
				case 'moddel':
					$this->moddel();
					break;
				case 'addmem':
					$this->addmem();
					break;
				case 'searchmem':
					$this->searchmem();
					break;
	    		default:
	    			$this->show();
	    			break;
			}
			$print->add_output("$this->output");
			$print->do_output( array( 'TITLE' => $this->page_title, 'JS' => 1, NAV => $this->nav ) );
		}

		function show() {
			global $ibforums, $DB, $std, $print;
	 		$this->page_title = $ibforums->lang['show_groups'];
	 		$this->nav        = array( $ibforums->lang['show_groups'] );
			// well lets get all groups
			// wait shouldn't you check if this member has special access ?
			// yes indeed we need to that first well here comes a query :P
			// is user member of the admin group
			//$rq = "WHERE state!='hidden' OR mod_id={$ibforums->member['id']}";
			if($ibforums->member['mgroup']==$ibforums->vars['admin_group']) $rq="";
			if($ibforums->vars['tcug_box_show']) $this->output.=$this->html->tcug_box();
			$outer=$DB->query("SELECT * FROM ibf_tcusergroups ORDER BY 'name'");
			$this->output.=$this->html->show_start();

			while($row=$DB->fetch_row($outer)) {
				$r_arr=explode(",",$row['mod_id']);
				$mod = (in_array($ibforums->member['id'],$r_arr) or $ibforums->member['mgroup']==$ibforums->vars['admin_group']) ? 1:0;
				$DB->query("SELECT * FROM ibf_tcug_validate WHERE mid={$ibforums->member['id']} AND tcugid={$row['tcugid']}");
				$valida=$DB->get_num_rows();
				$DB->query("SELECT id,name FROM ibf_members WHERE id={$ibforums->member['id']} AND ".
						"(clanname LIKE '".$row['name']."' OR clanname LIKE '%,".$row['name']."' OR ".
						"clanname LIKE '".$row['name'].",%' OR clanname LIKE '%,".$row['name'].",%')");
				$unjoin=$DB->get_num_rows();
				if($row['state']!='hidden' OR $unjoin==1 OR $mod==1)
				{
					$row['open'] = (($row['state'] == 'open' or $mod==1) ? "<a href=\"javascript:Join_Unjoin('{$ibforums->base_url}act=tcusergroups&amp;code=join&amp;tcugid={$row['tcugid']}', '{$ibforums->lang['join']}');\">{$ibforums->lang['join']}</a>":$ibforums->lang['closed']);
					$row['open'] = ($unjoin != 0 ? "<a href=\"javascript:Join_Unjoin('{$ibforums->base_url}act=tcusergroups&amp;code=unjoin&amp;tcugid={$row['tcugid']}', '{$ibforums->lang['unjoin']}');\">{$ibforums->lang['unjoin']}</a>":$row['open']);
					$row['open'] = ($valida != 0 ? $ibforums->lang['validating'] :$row['open']);
					$this->output.=$this->html->show_between($row);
				}
			}
			$this->output.=$this->html->show_end();
		}

		function detail() {
			global $ibforums, $DB, $std, $print;
	 		$this->page_title = $ibforums->lang['show_groups']." -> ".$ibforums->lang['details'];
	 		$this->nav        = array( "<a href='{$ibforums->base_url}act=ladder'>{$ibforums->lang['show_ladder']}</a>",$ibforums->lang['details']);
	  		$st = intval($ibforums->input['st']); if ($st < 1) $st = 0;
			$page_query = "&amp;tcugid=".$ibforums->input['tcugid'];
			if($ibforums->input['tcugid']=="") $std->Error( array( 'LEVEL' => 1, 'MSG' => 'incorrect_use' ) );
			//$rq = "WHERE (state!='hidden' OR mod_id={$ibforums->member['id']}) AND tcugid={$ibforums->input['tcugid']}";
			//if($ibforums->member['mgroup']==$ibforums->vars['admin_group'])
			// Get usergroup details
			$DB->query("SELECT * FROM ibf_tcusergroups WHERE tcugid={$ibforums->input['tcugid']}");
			if($DB->get_num_rows() <1) $std->Error( array( 'LEVEL' => 1, 'MSG' => 'ug_no_usergroup' ) );
			$row=$DB->fetch_row();
			$r_arr=explode(",",$row['mod_id']);

			$DB->query("SELECT name,id FROM ibf_members WHERE id IN ({$row['mod_id']}) LIMIT 0,3");
			$row['mod_name']="";while($rw=$DB->fetch_row()) {$row['mod_name'].=$rw['name'].",";} $row['mod_name']=substr($row['mod_name'],0,-1);



			$mod = (in_array($ibforums->member['id'],$r_arr) or $ibforums->member['mgroup']==38 or $ibforums->member['mgroup']==37 or $ibforums->member['mgroup']==$ibforums->vars['admin_group']) ? 1:0;
			// is this member already joined ?
			$DB->query("SELECT id,name FROM ibf_members WHERE id={$ibforums->member['id']} AND ".
						"(clanname LIKE '".$row['name']."' OR clanname LIKE '%,".$row['name']."' OR ".
						"clanname LIKE '".$row['name'].",%' OR clanname LIKE '%,".$row['name'].",%')");
			$unjoin=$DB->get_num_rows();
			// State = hidden
			// this member is not a member yet of this usergroup
			// it ain't the admin group
			// it ain't a moderator
			// so return a error
			if($row['state']=='hidden' AND $unjoin==0 AND $mod==0)
				$std->Error( array( 'LEVEL' => 1, 'MSG' => 'ug_no_usergroup' ) );
			// is this member validating ?
			$DB->query("SELECT * FROM ibf_tcug_validate WHERE mid={$ibforums->member['id']} AND tcugid={$row['tcugid']}");
			$valida=$DB->get_num_rows();
	    	require ROOT_PATH."sources/lib/post_parser.php";
	        $parser = new post_parser();
    		$row['cadd']      = $std->get_date( $row['made'], 'JOINED' );

			$row['description']=$parser-> post_db_parse_html($row['description']);
			$row['open'] = (($row['state'] == 'open' or $mod==1) ? "<a href=\"javascript:Join_Unjoin('{$ibforums->base_url}act=tcusergroups&amp;code=join&amp;tcugid={$row['tcugid']}', '{$ibforums->lang['join']}');\">{$ibforums->lang['join']}</a>":$ibforums->lang['closed']);
			$row['open'] = ($unjoin != 0 ? "<a href=\"javascript:Join_Unjoin('{$ibforums->base_url}act=tcusergroups&amp;code=unjoin&amp;tcugid={$row['tcugid']}', '{$ibforums->lang['unjoin']}');\">{$ibforums->lang['unjoin']}</a>":$row['open']);
			$row['open'] = ($valida != 0 ? $ibforums->lang['validating']:$row['open']);
			$this->output.=$this->html->detail($row);
			if($mod==1) {
				$this->output = str_replace( "<!--IBF_UG_DET-->", "<tr><td class='pformleft'>{$ibforums->lang['add_member']}</td>".
											 "<form action='{$ibforums->base_url}act=tcusergroups&amp;code=addmem&amp;tcugid={$row['tcugid']}&amp;pid={$row['perm_id']}' method='post'>".
											 "<td class='pformright' colspan ='2'><input type='text' size='32' maxlength='32' name='name' class='forminput' />&nbsp;<input type='submit' class='forminput' value='{$ibforums->lang['submit']}' /></td>".
											 "</form></tr>".
											 "<tr><td class='pformleft'><b>Clan Admin Options</b></td>".
											 "<td class='pformright' colspan ='2'><b>[</b><a href='{$ibforums->base_url}act=clans&code=edit&tcugid={$ibforums->input['tcugid']}'>Edit Clan</a><b>]</b> <b>[</b><a href='{$ibforums->base_url}act=clans&code=pw&tcugid={$ibforums->input['tcugid']}'>Change Password</a><b>]</b> <b>[</b><a href='{$ibforums->base_url}act=clans&code=del&tcugid={$ibforums->input['tcugid']}'><i>Delete Clan</i></a><b>]</b></td>", $this->output );
			}
			// Get validting details
			$DB->query("SELECT m.id,m.name FROM ibf_tcug_validate AS ug LEFT JOIN ibf_members AS m ON m.id=ug.mid WHERE ug.tcugid={$ibforums->input['tcugid']}");
			if($DB->get_num_rows()) {
				$this->output.=$this->html->member_start($DB->get_num_rows(),$ibforums->lang['validate_members']);
				while($rw=$DB->fetch_row()) {
					$this->output.=$this->html->member_between($rw);
					if($mod==1) {$this->output = str_replace( "<!--IBF_UG_MB_MOD-->", "<td class='pformleft'><input type='checkbox' name='id-{$rw['id']}' value='1' class='forminput' /></td>", $this->output );}
				}
				$this->output.=$this->html->member_end();
				// do moderator part :D
				if($mod==1)	{
					$this->output = str_replace( "<!--IBF_UG_MS1_MOD-->", "<form action='{$ibforums->base_url}act=tcusergroups&amp;code=modval&amp;tcugid={$row['tcugid']}' method='post'>", $this->output );
					$this->output = str_replace( "<!--IBF_UG_MS2_MOD-->", "<td class='pformlad2'>{$ibforums->lang['member']}</td>", $this->output );
					$this->output = str_replace( "<!--IBF_UG_ME1_MOD-->", "<tr>".
																			"<td class='pformlad2'><select name='type' id='dropdown'><option value='approve'>{$ibforums->lang['approve']}</option><option value='delete'>{$ibforums->lang['delete']}</option></select></td>".
																			"<td class='pformlad2'><input type='submit' class='forminput' value='{$ibforums->lang['submit']}' /></td>".
																		  "</tr>", $this->output );
					$this->output = str_replace( "<!--IBF_UG_ME2_MOD-->", "</form>", $this->output );
				}
			}
			// Make pages for members :o

			$DB->query("SELECT * from ibf_tcusergroups WHERE tcugid!=0 AND ".
									"(name LIKE '".$row['name']."' OR name LIKE '%,".$row['name']."' OR ".
									"name LIKE '".$row['name'].",%' OR name LIKE '%,".$row['name'].",%') LIMIT 1");
			if(!$row['totalgames']) $row['totalgames']=1;
			while( $r = $DB->fetch_row() ) {
			$this->output.=$this->html->clan_statsdetail_start();

			$efficiency= $row['wins'] / $row['totalgames'] * 100;
			$efficiency= round($efficiency,2);

			$this->output.=$this->html->clan_statsdetail($r,$efficiency);
			$this->output.=$this->html->clan_statsdetail_end();

			}

			$DB->query("SELECT COUNT(id) as count FROM ibf_members WHERE id!=0 AND ".
						"(clanname LIKE '".$row['name']."' OR clanname LIKE '%,".$row['name']."' OR ".
						"clanname LIKE '".$row['name'].",%' OR clanname LIKE '%,".$row['name'].",%')");
			$count=$DB->fetch_row();
			$pages = $std->build_pagelinks( array( 'TOTAL_POSS'  => $count['count'],
												   'PER_PAGE'    => 10,
												   'CUR_ST_VAL'  => $ibforums->input['st'],
												   'L_SINGLE'    => "Single Page",
												   'L_MULTI'     => "Multi Page",
												   'BASE_URL'    => $ibforums->base_url."&act=tcusergroups&code=det".$page_query,
												 )
										  );
			// Get members details

			$DB->query("SELECT id,name, lastgame, totalgames,wins, losses, streak, tcpoints FROM ibf_members WHERE id!=0 AND ".
						"(clanname LIKE '".$row['name']."' OR clanname LIKE '%,".$row['name']."' OR ".
						"clanname LIKE '".$row['name'].",%' OR clanname LIKE '%,".$row['name'].",%') ORDER BY tcpoints DESC, losses ASC  LIMIT $st,10 ");
			$this->output.=$this->html->member_start($count['count'],$ibforums->lang['joined_members']);
			while($rw=$DB->fetch_row()) {
				$this->output.=$this->html->member_between($rw);
				if($mod==1) {$this->output = str_replace( "<!--IBF_UG_MB_MOD-->", "<td class='pformleft'><input type='checkbox' name='id-{$rw['id']}' value='1' class='forminput' /></td>", $this->output );}
			}
			$this->output.=$this->html->member_end($pages);
			// do moderator part :D
			if($mod==1)	{
	 			$this->output = str_replace( "<!--IBF_UG_MS1_MOD-->", "<form action='{$ibforums->base_url}act=tcusergroups&amp;code=moddel&amp;tcugid={$row['tcugid']}' method='post'>", $this->output );
				$this->output = str_replace( "<!--IBF_UG_MS2_MOD-->", "<td class='pformlad2'>{$ibforums->lang['member']}</td>", $this->output );
				$this->output = str_replace( "<!--IBF_UG_ME1_MOD-->", "<td class='pformlad2'><input type='submit' class='forminput' value='{$ibforums->lang['del_uncheck']}'></td>", $this->output );
				$this->output = str_replace( "<!--IBF_UG_ME2_MOD-->", "</form>", $this->output );
			}
		$this->output.=$this->html->tcgames_start();


		$tcugid= $ibforums->input['tcugid'];



		$DB->query("SELECT * from ibf_ladder_matches WHERE Clan1 = '$tcugid' OR Clan2 = '$tcugid'  ORDER BY id DESC");
		while ($row = $DB->fetch_row())  {



		{
		$this->output    .= $this->html->tcgames($row);
		}
}

		$this->output.=$this->html->tcgames_end();
		}


		function tcmatch() {
		global $ibforums, $DB, $std, $print;
		$this->page_title = $ibforums->lang['show_groups']." -> ".$ibforums->lang['details'];
		$this->nav        = array( "<a href='{$ibforums->base_url}act=tcusergroups'>{$ibforums->lang['show_groups']}</a>",$ibforums->lang['details']);
		$DB->query("SELECT id from ibf_ladder_matches");
		$id= $DB->fetch_row();
		$id = $ibforums->input['id'];
		$DB->query("SELECT * from ibf_ladder_matches  WHERE id = $id");
		while( $row = $DB->fetch_row() )
		{

		if ($row['Type']==1) {
		$row['Type'] = "{$ibforums->lang['onevsone']}";
			}
		if ($row['Type']==2) {
		$row['Type'] = "{$ibforums->lang['twovstwo']}";
			}
		if ($row['Type']==3) {
		$row['Type'] = "{$ibforums->lang['threevsthree']}";
			}
$comment= $row['comment'];
	    	require ROOT_PATH."sources/lib/post_parser.php";
	        $parser = new post_parser();
    		$row['comment']=$parser-> post_db_parse_html($row['comment']);

		if (empty($comment) or $comment=='0')
				{
					$comment = $ibforums->lang['no_comment'];
				}
				else
				{
					$comment = $comment;
    	}





		$this->output    .= $this->html->tcmatch($row, $comment);
			}
		}

		function ug_join() {
			global $ibforums, $DB, $std, $print;
			if($ibforums->input['tcugid']=="") $std->Error( array( 'LEVEL' => 1, 'MSG' => 'incorrect_use' ) );
			if($ibforums->input['is_js_confirmed']!=1) $std->boink_it($ibforums->base_url."act=tcusergroups&code=show");
			$DB->query("SELECT m.id, m.name, m.org_perm_id,g.perm_id,g.mod_id FROM ibf_members AS m RIGHT JOIN ibf_tcusergroups AS g ON g.tcugid={$ibforums->input['tcugid']} WHERE id={$ibforums->member['id']}");
			$row=$DB->fetch_row();
			// is mod ?
			$r_arr=explode(",",$row['mod_id']);
			if (in_array($ibforums->member['id'],$r_arr) or $ibforums->member['mgroup']==$ibforums->vars['admin_group']) {
				$new_arr = array();
				if($row['org_perm_id'] == "" ) { //uhh, empty well fill it up with the original perms get them from ibf_groups
					$DB->query("SELECT g.g_perm_id FROM ibf_members AS m LEFT JOIN ibf_groups AS g ON g.g_id=m.mgroup WHERE id={$ibforums->member['id']}");
					$rw=$DB->fetch_row(); $new_arr=explode(",",$rw['g_perm_id']);
				}
				else $new_arr=explode(",",$row['org_perm_id']);
				if(!in_array($row['perm_id'],$new_arr)) $new_arr[]=$row['perm_id'];



				$DB->query("SELECT tcugid, name FROM ibf_tcusergroups WHERE tcugid={$ibforums->input['tcugid']}");

					$namestuff= $DB->fetch_row();
					$name=$namestuff['name'];



		$DB->query("SELECT clanid, clanname FROM ibf_members WHERE id={$ibforums->member['id']}");

		$clanstuff= $DB->fetch_row();
		$clanname=$clanstuff['clanname'];
		$clanid=$clanstuff['clanid'];
		$cjoin= time();
		if ($clanname)
		{
			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'to_many' ) );
		}

		else {
				$DB->query("DELETE FROM ibf_tcug_validate WHERE mid='".$ibforums->member['id']."'");
				$DB->query("UPDATE ibf_members SET clanid= {$namestuff['tcugid']}, clanname= '$name', cjoin='$cjoin'  WHERE id={$ibforums->member['id']}");}
				$print->redirect_screen( $ibforums->lang['ug_join'], 'act=tcusergroups&code=show' );
			}
			else { // no, put in hold line :D

		$DB->query("SELECT clanid, clanname FROM ibf_members WHERE id={$ibforums->member['id']}");

		$clanstuff= $DB->fetch_row();
		$clanname=$clanstuff['clanname'];
		if ($clanname)
		{
			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'to_many' ) );
		}

				$DB->query("SELECT tcugid,mid FROM ibf_tcug_validate WHERE mid={$ibforums->member['id']}");
				$valid=$DB->get_num_rows();
		if ($valid > 0)
		{
			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'to_many_valid' ) );
		}

				$DB->query("SELECT tcugid,mid FROM ibf_tcug_validate WHERE mid={$ibforums->member['id']} AND tcugid={$ibforums->input['tcugid']}");
				if($DB->get_num_rows() <1) {
					$db_string = $DB->compile_db_insert_string( array(
												'tcugid'	=> $ibforums->input['tcugid'],
												'mid'	=> $ibforums->member['id'],
									  )       );
					$DB->query("INSERT INTO ibf_tcug_validate (".$db_string['FIELD_NAMES'].") VALUES(".$db_string['FIELD_VALUES'].")");
					$print->redirect_screen( $ibforums->lang['ug_validating'], 'act=tcusergroups&code=show' );
				}
				else $std->Error( array( 'LEVEL' => 1, 'MSG' => 'ug_on_validate' ) );
			}
		}

		function unjoin() {
			global $ibforums, $DB, $std, $print;
			if($ibforums->input['tcugid']=="") $std->Error( array( 'LEVEL' => 1, 'MSG' => 'incorrect_use' ) );
			if($ibforums->input['is_js_confirmed']!=1) $std->boink_it($ibforums->base_url."act=tcusergroups&code=show");
			$DB->query("SELECT m.id, m.name, m.org_perm_id,g.perm_id FROM ibf_members AS m RIGHT JOIN ibf_tcusergroups AS g ON g.tcugid={$ibforums->input['tcugid']} WHERE id={$ibforums->member['id']}");
			if($DB->get_num_rows() <1) $std->Error( array( 'LEVEL' => 1, 'MSG' => 'incorrect_use' ) );
			$row=$DB->fetch_row();
			$new_arr = array();	$pid_array = explode( ",", $row['org_perm_id'] );
			foreach( $pid_array as $sid ) {if ( $sid != $row['perm_id'] ) $new_arr[] = $sid;}

		$name= $ibforums->member['id'];
		$DB->query("SELECT tcugid, mod_id FROM ibf_tcusergroups WHERE mod_id='{$name}'");
		$r = $DB->get_num_rows();

		if ($r >'0') {
			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'mod_no_leave' ) );
			}

			$DB->query("UPDATE ibf_members SET clanid= '0', clanname= '0',lastgame= '{$ibforums->lang['leftclan']}',totalgames= '0', wins= '0',losses= '0',streak= '0',tcpoints= '0', cjoin= '0' WHERE id={$ibforums->member['id']}");
			$print->redirect_screen( $ibforums->lang['ug_unjoin'], 'act=tcusergroups&code=show' );
		}

		function modval() {
			global $ibforums, $DB, $std,$HTTP_POST_VARS, $print;
	 		if ($ibforums->input['request_method'] != 'post') $std->Error( array( 'LEVEL' => 1, 'MSG' => 'poss_hack_attempt' ) );
			$DB->query("SELECT * FROM ibf_tcusergroups AS u WHERE u.tcugid={$ibforums->input['tcugid']}");
			$row=$DB->fetch_row(); $tcugid=$row['tcugid'];$gr_name=$row['name'];
			$r_arr=explode(",",$row['mod_id']);
			if (in_array($ibforums->member['id'],$r_arr) or $ibforums->member['mgroup']==$ibforums->vars['admin_group']) {

				if($ibforums->input['type']=='approve') {
					$outer=$DB->query("SELECT m.name,m.id,m.org_perm_id,m.email,u.perm_id,u.tcugid,u.name FROM ibf_tcug_validate AS ug ".
								"LEFT JOIN ibf_tcusergroups AS u ON u.tcugid=ug.tcugid ".
								"LEFT JOIN ibf_members AS m ON m.id=ug.mid WHERE ug.tcugid={$tcugid}");
					while($row=$DB->fetch_row($outer)) {
						if($ibforums->input['id-'.$row['id']]==1)
						{
							// usergroup stuff
							$new_arr = array();
							if($row['org_perm_id'] == "" ) { //uhh, empty well fill it up with the original perms get them from ibf_groups
								$DB->query("SELECT g.g_perm_id FROM ibf_members AS m LEFT JOIN ibf_groups AS g ON g.g_id=m.mgroup WHERE id={$row['id']}");
								$rw=$DB->fetch_row(); $new_arr=explode(",",$rw['g_perm_id']);
							}
							else $new_arr=explode(",",$row['org_perm_id']);
							$cjoin = time();
							if(!in_array($row['perm_id'],$new_arr)) $new_arr[]=$row['perm_id'];
							$DB->query("UPDATE ibf_members SET clanid={$row['tcugid']} ,clanname='{$row['name']}', cjoin=$cjoin WHERE id={$row['id']}");
							$DB->query("DELETE FROM ibf_tcug_validate WHERE mid={$row['id']} AND tcugid={$row['tcugid']}");
							// if email fails user is approved
							$this->sendpmoremail(array('name'=>		$row['name'],
													   'email'=>	$row['email'],
													   'id' => 		$row['id'],
													   'gr_name'=>	$gr_name,
													   'mode'=>"approve"));
						}
					}
					$print->redirect_screen( $ibforums->lang['ug_ap_val_done'], "act=tcusergroups&amp;code=det&amp;tcugid={$tcugid}" );
				}
				elseif ($ibforums->input['type']=='delete') {
					$outer=$DB->query("SELECT m.name,m.id,m.org_perm_id,m.email,u.perm_id,u.tcugid FROM ibf_tcug_validate AS ug ".
								"LEFT JOIN ibf_tcusergroups AS u ON u.tcugid=ug.tcugid ".
								"LEFT JOIN ibf_members AS m ON m.id=ug.mid WHERE ug.tcugid={$ibforums->input['tcugid']}");
					while($row=$DB->fetch_row($outer)) {
						if($ibforums->input['id-'.$row['id']]==1) {
							// usergroup stuff
							$DB->query("DELETE FROM ibf_tcug_validate WHERE mid={$row['id']} AND tcugid={$row['tcugid']}");
							// if email fails user is deleted
							$this->sendpmoremail(array('name'=>		$row['name'],
													   'email'=>	$row['email'],
													   'id' => 		$row['id'],
													   'gr_name'=>	$gr_name,
													   'mode'=>		"disapprove"));
						}
					}
					$print->redirect_screen( $ibforums->lang['ug_de_val_done'], "act=tcusergroups&amp;code=det&amp;tcugid={$tcugid}" );
				}
			}
		}

		function moddel() {
			global $ibforums, $DB, $std, $print;
	 		if ($ibforums->input['request_method'] != 'post') $std->Error( array( 'LEVEL' => 1, 'MSG' => 'poss_hack_attempt' ) );
			$DB->query("SELECT u.name,u.perm_id,u.tcugid,mod_id FROM ibf_tcusergroups AS u WHERE u.tcugid={$ibforums->input['tcugid']}");
			$row=$DB->fetch_row();
			$r_arr=explode(",",$row['mod_id']);
			if (in_array($ibforums->member['id'],$r_arr) or $ibforums->member['mgroup']==38 or $ibforums->member['mgroup']==37 or $ibforums->member['mgroup']==$ibforums->vars['admin_group']) {
				$outer=$DB->query("SELECT m.id,m.clanname FROM ibf_members AS m WHERE m.id!=0 AND ".
							"(clanname LIKE '".$row['name']."' OR clanname LIKE '%,".$row['name']."' OR ".
							"clanname LIKE '".$row['name'].",%' OR clanname LIKE '%,".$row['name'].",%')");
				while($rw=$DB->fetch_row($outer)) {
					 if($ibforums->input['id-'.$rw['id']]==1) {
						$new_arr = array();$out_arr=array();
						if($rw['clanname'] == "" ) { //uhh, empty well fill it up with the original perms get them from ibf_groups
							$DB->query("SELECT g.g_perm_id FROM ibf_members AS m LEFT JOIN ibf_groups AS g ON g.g_id=m.mgroup WHERE id={$row['id']}");
							$r=$DB->fetch_row(); $new_arr=explode(",",$r['g_perm_id']);
						}
						else $new_arr=explode(",",$rw['clanname']);
						foreach($new_arr as $s) if($row['name']!=$s && !in_array($s,$out_arr)) $out_arr[]=$s;
						$DB->query("UPDATE ibf_members SET clanid= '0', clanname= '0',lastgame= '{$ibforums->lang['leftclan']}',totalgames= '0', wins= '0',losses= '0',streak= '0',tcpoints= '0', cjoin= '0' WHERE id={$rw['id']}");
			}
				}
			}
			$print->redirect_screen( $ibforums->lang['ug_de_val_done'], "act=tcusergroups&amp;code=det&amp;tcugid={$row['tcugid']}" );
		}

		function addmem() {
					global $ibforums, $DB, $std, $print;
					$ibforums->input['name']=urldecode($ibforums->input['name']);
					if ($ibforums->input['name']=="") $std->Error( array( 'LEVEL' => 1, 'MSG' => 'incorrect_use' ) );
					// first lets make sure this member can add members :D
					$DB->query("SELECT * FROM ibf_tcusergroups AS u WHERE u.tcugid={$ibforums->input['tcugid']}");
					$row=$DB->fetch_row();
					$r_arr=explode(",",$row['mod_id']);
					if (in_array($ibforums->member['id'],$r_arr) or $ibforums->member['mgroup']==38 or $ibforums->member['mgroup']==37 or $ibforums->member['mgroup']==$ibforums->vars['admin_group']) {
						$DB->query("SELECT m.id,m.name,m.org_perm_id,g.g_perm_id FROM ibf_members AS m LEFT JOIN ibf_groups AS g ON g.g_id=m.mgroup WHERE m.name='{$ibforums->input['name']}'");
						if($DB->get_num_rows() <1) { // didn't find that name
							$this->searchmem();
						}
						else { //add this member to the usergroup
							$rw=$DB->fetch_row();
							if($rw['org_perm_id'] == "" ) //uhh, empty well fill it up with the original perms get them from ibf_groups
								$new_arr=explode(",",$rw['g_perm_id']);
							else $new_arr=explode(",",$rw['org_perm_id']);
							if(!in_array($row['perm_id'],$new_arr)) $new_arr[]=$row['perm_id'];

							$DB->query("SELECT tcugid, name FROM ibf_tcusergroups WHERE tcugid={$ibforums->input['tcugid']}");

							$namestuff= $DB->fetch_row();
							$name=$namestuff['name'];


					$DB->query("SELECT * FROM ibf_members WHERE name='".$ibforums->input['name']."'");

					$clanstuff= $DB->fetch_row();
					$clanname=$clanstuff['clanname'];
					if ($clanname)
					{
					$std->Error( array( 'LEVEL' => 1, 'MSG' => 'to_many' ) );
					}
					else
					{
					$cjoin= time();
					$DB->query("DELETE FROM ibf_tcug_validate WHERE mid={$clanstuff['id']}");
					$DB->query("UPDATE ibf_members SET clanid= {$namestuff['tcugid']}, clanname= '$name', cjoin= '$cjoin' WHERE id={$rw['id']}");
					$print->redirect_screen( $ibforums->lang['ug_join'], "act=tcusergroups&amp;code=det&amp;tcugid={$row['tcugid']}" );
							}
						}
					}
					else $std->Error( array( 'LEVEL' => 1, 'MSG' => 'incorrect_use' ) );
		}

		function searchmem() {
			global $ibforums, $DB, $std, $print;
	 		$this->page_title = $ibforums->lang['show_groups']." -> ".$ibforums->lang['searchmem'];
	 		$this->nav        = array( "<a href='{$ibforums->base_url}act=tcusergroups'>{$ibforums->lang['show_groups']}</a>",$ibforums->lang['searchmem']);
	  		$st = intval($ibforums->input['st']); if ($st < 1) $st = 0;
			$ibforums->input['name']=urldecode($ibforums->input['name']);
			$pid = intval($ibforums->input['pid']);
			$page_query = "&amp;name=".urlencode($ibforums->input['name'])."&amp;tcugid=".$ibforums->input['tcugid']."&amp;pid=".$ibforums->input['pid'];
			$rq = "m.name LIKE '".substr($ibforums->input['name'],0,1)."%' AND NOT ".
						"(m.org_perm_id LIKE '".$pid."' OR m.org_perm_id LIKE '%,".$pid."' OR ".
						"m.org_perm_id LIKE '".$pid.",%' OR m.org_perm_id LIKE '%,".$pid.",%')";
			$DB->query("SELECT COUNT(m.id) as count FROM ibf_members m WHERE $rq");
			$count = $DB->fetch_row();
			$pages = $std->build_pagelinks( array( 'TOTAL_POSS'  => $count['count'],
												   'PER_PAGE'    => 10,
												   'CUR_ST_VAL'  => $ibforums->input['st'],
												   'L_SINGLE'    => "Single Page",
												   'L_MULTI'     => "Multi Page",
												   'BASE_URL'    => $ibforums->base_url."&act=tcusergroups&code=searchmem".$page_query,
												 )
										  );
			$DB->query("SELECT m.id, m.name, m.clanname	FROM ibf_members m WHERE $rq ORDER BY m.name LIMIT $st,10");
			$this->output.=$this->html->searchmem_start();
			while ( $r = $DB->fetch_row() )
			$this->output.=$this->html->searchmem_between($r+array('tcugid'=>$ibforums->input['tcugid']));
			$this->output.=$this->html->searchmem_end($pages);
		}

		function sendpmoremail($data) {
			global $ibforums,$DB;
			if(!class_exists ("emailer")) require ROOT_PATH."sources/lib/emailer.php";
			$this->email = new emailer();
			if($ibforums->vars['ug_pm_email'] == 'both' or $ibforums->vars['ug_pm_email'] == 'pm') {
				// Can the reciepient use the PM system ? if not send email instead
				$DB->query("SELECT g.g_use_pm,m.view_pop FROM ibf_groups g, ibf_members m WHERE m.id='".$data['id']."' AND g.g_id=m.mgroup");
				$to_msg = $DB->fetch_row();
				$data['view_pop']=(isset($row['view_pop'])? $row['view_pop']:0);
				if ($to_msg['g_use_pm'] != 1) $this->email_it($data);
				elseif ($ibforums->vars['ug_pm_email'] == 'pm') $this->pm_it($data);
				else {$this->pm_it($data);$this->email_it($data);}
			}
			elseif($ibforums->vars['ug_pm_email'] == 'email') $this->email_it($data);
		}

		function pm_it($data) {
			global $ibforums,$std,$DB;
			$new_m=$this->email->get_message("usergroup_validating", array(	'NAME'	    => $data['name'],
											'STATE'         => ($data['mode']=="approve"? $ibforums->lang['approved']:$ibforums->lang['disapproved']),
											'USERGROUP'     => $data['gr_name'],
											'DONT'        	=> ($data['mode']=="approve"? "":$ibforums->lang['dis_dont']),
											)		);

			//Send pm no mather if they can't use or can ;)
			$db_string = $std->compile_db_string( array(
														 'member_id'      => $data['id'],
														 'msg_date'       => time(),
														 'read_state'     => '0',
														 'title'          => $ibforums->lang['SUBMITED'].$data['gr_name'],
														 'message'        => $new_m,
														 'from_id'        => '0',
														 'vid'            => 'in',
														 'recipient_id'   => $data['id'],
														 'tracking'       => '0',
												)      );

			$DB->query("INSERT INTO ibf_messages (" .$db_string['FIELD_NAMES']. ") VALUES (". $db_string['FIELD_VALUES'] .")");
			$new_id = $DB->get_insert_id();
			$DB->query("UPDATE ibf_members SET ".
						"msg_total = msg_total + 1, "    .
						"new_msg = new_msg + 1, "        .
						"msg_from_id='0', "              .
						"msg_msg_id='". $new_id."', "    .
						"show_popup='". $data['view_pop']."'".
						"WHERE id='"  . $data['id']      .  "'");
			unset($db_string);
		}

		function email_it($data) {
			global $ibforums;
				//--------------------------------------------
				// Get the emailer module
				//--------------------------------------------
				$this->email->get_template("usergroup_validating");
				$this->email->build_message( array(	'NAME'	    => $data['name'],
							'STATE'         => ($data['mode']=="approve"? $ibforums->lang['approved']:$ibforums->lang['disapproved']),
							'USERGROUP'     => $data['gr_name'],
							'DONT'        	=> ($data['mode']=="approve"? "":$ibforums->lang['dis_dont']),
					)		);
				$this->email->subject = $ibforums->lang['SUBMITED'].$ibforums->vars['board_name'];
				$this->email->to      = $data['email'];
				$this->email->send_mail();
		}
}
?>