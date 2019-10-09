<?php
// Clans by Phil_b
//Modified for IPB 2.0.x by Ruud
$idx = new clans;
class clans {
    var $output     = "";
    var $page_title = "";
    var $nav        = array();
    var $html       = "";
	var $email		= "";
    function clans() {
		global $ibforums, $DB, $std, $print;
		$this->page_title = $ibforums->lang['clan']." -> ".$ibforums->lang['clan'];
		$this->nav        = array( "<a href='{$ibforums->base_url}act=clan&code=add'>{$ibforums->lang['clan']}</a>",$ibforums->lang['clan']);
				if($ibforums->member['mgroup']==1 or $ibforums->member['mgroup']==2 or $ibforums->member['mgroup']==5)
			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'ug_no_access' ) );
		$ibforums->lang = $std->load_words($ibforums->lang, 'lang_clans'   , $ibforums->lang_id );
		$this->html = $std->load_template('skin_clans');

		switch($ibforums->input['code']) {

    		case 'add':
			$this->add();
    			break;

    		case 'doadd':
			$this->doadd();
    			break;

    		case 'cjoin':
			$this->cjoin();
    			break;

    		case 'docjoin':
			$this->docjoin();
    			break;


    		case 'edit':
			$this->edit();
    			break;

    		case 'doedit':
			$this->doedit();
    			break;

    		case 'pw':
			$this->pw();
    			break;

    		case 'dopw':
			$this->dopw();
    			break;

    		case 'del':
			$this->del();
    			break;

    		case 'dodel':
			$this->dodel();
    			break;

			default:
    			$this->add();
    			break;
		}

		$print->add_output("$this->output");
		$print->do_output( array( 'TITLE' => $this->page_title, 'JS' => 1, NAV => $this->nav ) );
		}

	//*********************************************/
	//
	// Adding a Clan
	//
	//*********************************************/

		function add() {
		global $ibforums, $DB, $std, $print;
		$this->page_title = $ibforums->lang['clan']." -> ".$ibforums->lang['add_clan'];
		$this->nav        = array( $ibforums->lang['add_clan'] );
		$this->output    .= $this->html->add_start();
		$this->output    .= $this->html->add_end();
		$name= $ibforums->member['id'];
		$DB->query("SELECT tcugid, mod_id FROM ibf_tcusergroups WHERE mod_id='{$name}'");
		$r = $DB->get_num_rows();

		if ($r >'0') {
			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'already_mod' ) );
			}

		}

		function doadd() {
		global $ibforums, $DB, $std, $print;
		$this->page_title = $ibforums->lang['clan']." -> ".$ibforums->lang['add_clan'];
		$this->nav        = array( $ibforums->lang['clan'] );
		$name= $ibforums->member['id'];
		$cname= $ibforums->input["cname"];
		$cdesc= $ibforums->input["cdesc"];
		$state= $ibforums->input["state"];
		$password= $ibforums->input["password"];
		$cjoin= time();
		$time= time();
		//$row=$ibforums->input;if(is_array($row)) foreach ($row as $d=>$e) echo "{$d}=>{$e}<br />";
		if (empty($cname))
		{
			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'empty_clanname' ) );
		}

		if (empty($state))
		{
					$std->Error( array( 'LEVEL' => 1, 'MSG' => 'empty_clanstate' ) );
		}

		if (empty($password) or $password=='0')
		{
					$std->Error( array( 'LEVEL' => 1, 'MSG' => 'empty_clanpw' ) );
		}

		//+--------------------------------------------
		//| Is this clan already taken?
		//+--------------------------------------------

		$DB->query("SELECT name FROM ibf_tcusergroups WHERE LOWER(name)='".strtolower($cname)."'");
		$name_check = $DB->fetch_row();

		if ($name_check['name'])
		{
			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'already_exist' ) );
		}

		$db_string = $DB->compile_db_insert_string( array(
													'mod_id'         => $name,
													'name'  => $cname,
													'description'	   => $cdesc,
													'state' => $state,
													'password' => md5($password),
													'made' => $time,
										  )       );
		$DB->query("INSERT INTO ibf_tcusergroups (".$db_string['FIELD_NAMES'].") VALUES(".$db_string['FIELD_VALUES'].")");

		$DB->query("SELECT tcugid, mod_id FROM ibf_tcusergroups WHERE mod_id='{$name}'");
		$r = $DB->fetch_row();
		$DB->query("UPDATE ibf_members SET clanid='".$r['tcugid']."', clanname='$cname', cjoin='$cjoin' WHERE id={$name}");


		$print->redirect_screen( $ibforums->lang['pass_redirect'], "act=ladder" );



		}

		//+--------------------------------------------
		//| Join Clan
		//+--------------------------------------------


		function cjoin() {
		global $ibforums,$print,$std,$DB;
		$DB->query("SELECT * FROM ibf_members WHERE id='".$ibforums->member['id']."'");
		$r = $DB->fetch_row();
		$cname=$r['clanname'];
		if ($cname)
		{
		$std->Error( array( 'LEVEL' => 1, 'MSG' => 'to_many' ) );
		}

		$DB->query("SELECT * FROM ibf_tcusergroups WHERE password>'0' ORDER BY tcugid DESC");
		$c = $DB->fetch_row();
		if($c>0) {

			$clan .= "<option value='".$c['tcugid']."'>".$c['name']."</option>";
		}
		else {

		$std->Error( array( 'LEVEL' => 1, 'MSG' => 'no_clan_pw' ) );
		}

		$this->output .= $this->html->cjoin($clan);
		}

		function docjoin() {
		global $ibforums,$print,$std,$DB;
		$id = $ibforums->input["clan"];
		$cpw= $ibforums->input["password"];

		$DB->query("SELECT * FROM ibf_tcusergroups WHERE tcugid='$id' AND password!='' LIMIT 1");
		if($DB->get_num_rows() <= 0) {
			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'not_valid_pw' ) );
 		}
		$DB->query("SELECT * FROM ibf_tcusergroups WHERE tcugid='$id' AND password!=''");
		$c = $DB->fetch_row();
		if(md5($cpw) == $c['password']) {
			$DB->query("UPDATE ibf_members SET clanid='".$c['tcugid']."', clanname ='{$c['name']}' WHERE id='{$ibforums->member['id']}' LIMIT 1");
			$print->redirect_screen( $ibforums->lang['joined_clan'], 'act=ladder' );
		} else {
			$std->Error( array( 'LEVEL'	=> 1,  'MSG' => 'wrong_pw') );
			}
		}

	//*********************************************/
	//
	// So you have a Clan. If your a mod then....
	//
	//*********************************************/

		//+--------------------------------------------
		//| Edit Clan
		//+--------------------------------------------


		function edit() {
		global $ibforums, $DB, $std, $print;
		$this->page_title = $ibforums->lang['show_groups']." -> ".$ibforums->lang['details'];
		$this->nav        = array( $ibforums->lang['show_groups'] );
			$page_query = "&amp;tcugid=".$ibforums->input['tcugid'];
			if($ibforums->input['tcugid']=="") $std->Error( array( 'LEVEL' => 1, 'MSG' => 'incorrect_use' ) );
			$DB->query("SELECT * FROM ibf_tcusergroups WHERE tcugid={$ibforums->input['tcugid']}");
			if($DB->get_num_rows() <1) $std->Error( array( 'LEVEL' => 1, 'MSG' => 'ug_no_usergroup' ) );
			$row=$DB->fetch_row();
			if ($row['mod_id'] != $ibforums->member['id'])	{
						$std->Error( array( 'LEVEL' => 1, 'MSG' => 'hack_attempt' ) );
						}
			$r_arr=explode(",",$row['mod_id']);
			// Get moderator names
			$mod_ids = trim(urldecode($IN['id']));
			$mod_ids = ($mod_ids==""? $row['mod_id']:$mod_ids);
			$DB->query("SELECT name,id FROM ibf_members WHERE id IN ({$row['mod_id']}) LIMIT 0,3");
			$row['mod_name']="";while($rw=$DB->fetch_row()) {$row['mod_name'].=$rw['name'].",";} $row['mod_name']=substr($row['mod_name'],0,-1);

		$this->output    .= $this->html->edit_start($row);
		}

		function doedit() {
		global $ibforums, $DB, $std, $print;
		$this->page_title = $ibforums->lang['show_groups']." -> ".$ibforums->lang['details'];
		$this->nav        = array( $ibforums->lang['show_groups'] );
		//$row=$ibforums->input;if(is_array($row)) foreach ($row as $d=>$e) echo "{$d}=>{$e}<br />";
		$name = $ibforums->input["name"];
		$cname= $ibforums->input["cname"];
		$cdesc= $ibforums->input["cdesc"];
		$state= $ibforums->input["state"];


		//+--------------------------------------------
		//| Make sure all fields are filled in
		//+--------------------------------------------

		if (empty($cname))	{

					$std->Error( array( 'LEVEL' => 1, 'MSG' => 'no_clan_form' ) );
					}

		$DB->query("SELECT name FROM ibf_tcusergroups WHERE LOWER(name)='".strtolower($cname)."'");
		$name_check = $DB->fetch_row();
		$DB->query("SELECT name FROM ibf_tcusergroups WHERE tcugid='".$ibforums->input['tcugid']."'");
		$name_check1 = $DB->fetch_row();

		if ($name_check['name'] AND $name_check1['name']!=$name_check['name'] )
		{
			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'already_exist' ) );
		}


				$DB->query("SELECT name FROM ibf_tcusergroups WHERE tcugid='".$ibforums->input['tcugid']."'");

				$row=$DB->fetch_row();
				if($row['name']!=$ibforums->input['cname']) { // we need to edit all members because you change the mask :@
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
						$out_arr[]=$ibforums->input['cname']; // here comes the new one :D
						$DB->query("UPDATE ibf_members SET clanname='".implode(",",$out_arr)."' WHERE id={$rw['id']}");
					}
		}


		$db_string = $DB->compile_db_update_string( array (
													'name'  => $cname,
													'description'	   => $cdesc,
													'state' => $state,

												  )       );

		$DB->query("UPDATE ibf_tcusergroups SET $db_string WHERE tcugid='".$ibforums->input['tcugid']."'");

		$print->redirect_screen( $ibforums->lang['pass_redirect'], "act=ladder" );
	}

		//+--------------------------------------------
		//| Clan password
		//+--------------------------------------------

		function pw() {
		global $ibforums, $DB, $std, $print;
		$this->page_title = $ibforums->lang['show_groups']." -> ".$ibforums->lang['details'];
		$this->nav        = array( $ibforums->lang['show_groups'] );
			$page_query = "&amp;tcugid=".$ibforums->input['tcugid'];
			if($ibforums->input['tcugid']=="") $std->Error( array( 'LEVEL' => 1, 'MSG' => 'incorrect_use' ) );
			$DB->query("SELECT * FROM ibf_tcusergroups WHERE tcugid={$ibforums->input['tcugid']}");
			if($DB->get_num_rows() <1) $std->Error( array( 'LEVEL' => 1, 'MSG' => 'ug_no_usergroup' ) );
			$row=$DB->fetch_row();

			if ($row['mod_id'] != $ibforums->member['id'])	{
			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'hack_attempt' ) );
						}
			$this->output    .= $this->html->password($row);
		}

		function dopw() {
		global $ibforums, $DB, $std, $print;
		$this->page_title = $ibforums->lang['show_groups']." -> ".$ibforums->lang['details'];
		$this->nav        = array( $ibforums->lang['show_groups'] );

		$DB->query("SELECT * FROM ibf_tcusergroups WHERE tcugid={$ibforums->input['tcugid']}");
		$row=$DB->fetch_row();
 		if ( $ibforums->input['current_pass'] == "" or empty($ibforums->input['current_pass']) )
 		{
 			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'complete_form' ) );
 		}

 		//--------------------------------------------

 		$cur_pass = trim($ibforums->input['current_pass']);
		$new_pass = trim($ibforums->input['password_new1']);
 		$chk_pass = trim($ibforums->input['password_new2']);

 		//--------------------------------------------

 		if ( ( empty($new_pass) ) or ( empty($chk_pass) ) )
 		{
 			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'complete_form' ) );
 		}

 		//--------------------------------------------

 		if ($new_pass != $chk_pass)
 		{
 			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'pass_no_match' ) );
 		}

 		//--------------------------------------------

 		if (md5($cur_pass) != $row['password'])
 		{
 			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'wrong_pass' ) );
 		}

 		//--------------------------------------------

 		$md5_pass = md5($new_pass);

 		//--------------------------------------------
 		// Update the DB
 		//--------------------------------------------

 		$DB->query("UPDATE ibf_tcusergroups SET password='$md5_pass' WHERE tcugid={$ibforums->input['tcugid']}");

 		//--------------------------------------------
 		// Redirect...
 		//--------------------------------------------

 		$print->redirect_screen( $ibforums->lang['pass_redirect'], 'act=tcusergroups' );
		}

		//+--------------------------------------------
		//| Deleting a clan
		//+--------------------------------------------

		function del() {
		global $ibforums, $DB, $std, $print;
		$this->page_title = $ibforums->lang['show_groups']." -> ".$ibforums->lang['details'];
		$this->nav        = array( $ibforums->lang['show_groups'] );
			$page_query = "&amp;tcugid=".$ibforums->input['tcugid'];
			if($ibforums->input['tcugid']=="") $std->Error( array( 'LEVEL' => 1, 'MSG' => 'incorrect_use' ) );
			$DB->query("SELECT * FROM ibf_tcusergroups WHERE tcugid={$ibforums->input['tcugid']}");
			if($DB->get_num_rows() <1) $std->Error( array( 'LEVEL' => 1, 'MSG' => 'ug_no_usergroup' ) );
			$row=$DB->fetch_row();

			if ($row['mod_id'] != $ibforums->member['id'])	{
			$std->Error( array( 'LEVEL' => 1, 'MSG' => 'hack_attempt' ) );
						}
			$this->output    .= $this->html->clan_del($row);
		}

		function dodel() {
		global $ibforums, $DB, $std, $print;
		$this->page_title = $ibforums->lang['show_groups']." -> ".$ibforums->lang['details'];
		$this->nav        = array( $ibforums->lang['show_groups'] );
				$submit = $ibforums->input["submit"];
				if (!isset($submit))	{

							$std->Error( array( 'LEVEL' => 1, 'MSG' => 'proper_form' ) );
							}



						$DB->query("SELECT name FROM ibf_tcusergroups WHERE tcugid='".$ibforums->input['tcugid']."'");

						$row=$DB->fetch_row();
						{ // we need to find all clan members so we can remove there clan
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
								$out_arr[]=$ibforums->input['cname']; // here comes the new one :D
								$DB->query("UPDATE ibf_members SET clanid= '0', clanname= '0',lastgame= '{$ibforums->lang['leftclan']}',totalgames= '0', wins= '0',losses= '0',streak= '0',tcpoints= '0', cjoin= '0' WHERE id={$rw['id']}");
							}
				}



				$DB->query("DELETE FROM ibf_tcusergroups WHERE tcugid='".$ibforums->input['tcugid']."'");

		$print->redirect_screen( $ibforums->lang['pass_redirect'], "act=ladder" );

		}


}

?>