/*
+--------------------------------------------------------------------------
//Written and Coded by Phil_b
//Modified for IPB 2.0.x by Ruud
//
//Thanks to x00179 for letting me use his usergroup mod for the basis for the clans section. Many hours coding saved :)
//
//All Support will be given through http://www.ibplanet.com
//Tested and made for 1.2 Final
//
//Features: - Fully Functioning Gaming Ladder
//	    - Allows Players to Report games and then see the individual game stats, warrior and clan rankings and individual profile stats.
//
//Restrictions: - Doesnt make you win the game ;)
//
//
//IMPORTANT -  MAKE SURE TO BACKUP ALL FILES!
//        
+--------------------------------------------------------------------------
*/

//---------------------------------------------------------------------------//
//Step 1 : Upload db_hack.php to your main forum directory (where index.php and admin.php are).  Run
//         it, and then delete it.  
//---------------------------------------------------------------------------//

//---------------------------------------------------------------------------//
//Step 2 : Open /index.php
//---------------------------------------------------------------------------//

Search For: 		

                 'calendar'   => array( "calendar"           , 'calendar'      ),
Add Below: 

		 'clans'      => array( 'clans'              , 'clans'         ),
		 'ladder'     => array( 'ladder'             , 'ladder'        ),
		 'tcusergroups'	=> array( 'tcusergroups'     , 'tcusergroups'  ),


[CLOSE: /index.php]

//---------------------------------------------------------------------------//
//Step 3 : Open /Admin.php
//---------------------------------------------------------------------------//

Search For:

					 'blog'		 => array( 'blog'	         , 'blog' ),

Add After:

			                 'ladder'    => array( 'ladder'          , 'ladder' ), 
			                 'clan'      => array( 'clan'            , 'clan' ),


[CLOSE: /Admin.php]
-----------------------------------------------


//---------------------------------------------------------------------------//
//Step 4 : Open /lang/en/lang_profile.php
//---------------------------------------------------------------------------//

Search For:

$lang = array (

Add After:

'no_clan'  => "<b>No Clan</b>",


[CLOSE: /lang/en/lang_profile.php]
-----------------------------------------------

//---------------------------------------------------------------------------//
//Step 5 : Open /lang/en/lang_global.php
//---------------------------------------------------------------------------//

Search For:

'tb_calendar' => "Calendar",

Add After:

'tb_ladder' => "Ladder",


[CLOSE: /lang/en/lang_global.php]
-----------------------------------------------

//---------------------------------------------------------------------------//
//Step 6 : Open /lang/en/lang_error.php
//---------------------------------------------------------------------------//

Search For:

$lang = array (

Add After:

//ladder
enter_clan_name					=>	"Please enter a clan name",
no_clan						=>	"Sorry, you can't do anything in a clan if your not in one",
not_leader						=>	"Sorry, you are not a clan leader",
no_such_clan					=>	"No Such Clan or Not Invited, or a member of another clan.",
ug_on_validate				=> "You are already on the validating list",
ug_no_access				=> "No access.",
empty_clanname				=> "You did not add a clan name",
empty_clanstate				=> "You did not add a clan state (open/closed)",
empty_clanpw				=> "You did not add a clan password",
already_mod					=> "You already are a clan leader. To create a new clan please delete your old one.",
mod_no_leave				=> "You cannot leave a clan that you are the leader of. If you want to leave please delete your clan.",
'clan_changed'				=> "While adding your clan the opponent has either deleted his clan or readded it. Try to Report the whole game again and it should work. <b>Dont just press back start over!</b>.",
'dup_name'				=> "You cannot enter the same name twice!",


[CLOSE: /lang/en/lang_error.php]
-----------------------------------------------


//---------------------------------------------------------------------------//
//Step 7 : Open /sources/Admin/admin_pages.php
//---------------------------------------------------------------------------//

Search For:

                               1700 => array(
							1 => array( 'View Moderator Logs'  , 'act=modlog'    ),
							2 => array( 'View Admin Logs'      , 'act=adminlog'  ),
							3 => array( 'View Email Logs'      , 'act=emaillog'  ),
							4 => array( 'View Email Error Logs', 'act=emailerror' ),
							5 => array( 'View Bot Logs'        , 'act=spiderlog' ),
							6 => array( 'View Warn Logs'       , 'act=warnlog'   ),
						   ),


Add After:

                               #Ladder settings

			       1800 => array (
			   				1 => array( 'Basic Settings'           , 'act=clan&code=main' ),
			   				2 => array( 'Add a Clan'       , 'act=clan&code=add'   ),
			   				3 => array( 'Manage Clans'       , 'act=clan'   ),
			   				4 => array( 'Manage Games'  , 'act=ladder'    ),
						      ),


Search For:

				  300 => array( 'Users and Groups'  , '#B5F1B6;margin-bottom:12px;' ),

				  
Add After:

                                  1800 => array( 'Ladder' , '#0B9BE5' ),


Search For:

				  300 => "Manage members, groups and ranks",

Add After:

                                  1800 => "Add/Manage Ladder Clans and Games",



[CLOSE: /sources/Admin/admin_pages.php]
-----------------------------------------------


//---------------------------------------------------------------------------//
//Step 8 : Open /sources/Profile.php
//---------------------------------------------------------------------------//

Search For:

		if (!$member['hide_email']) {
			$info['email'] = "<a href='{$this->base_url}act=Mail&amp;CODE=00&amp;MID={$member['id']}'>{$ibforums->lang['click_here']}</a>";
		}
		else
		{
			$info['email'] = $ibforums->lang['private'];
		}

Add After:

	   	if ($member['clanname'])
				{
					$info['clanname'] = $member['clanname'];
				}
				else
				{
					$info['clanname'] = $ibforums->lang['no_clan'];
    		}

		if ($member['wins'] or $member['clanname'])
				{
					$info['wins'] = $member['wins'];
				}
				else
				{
					$info['wins'] = $ibforums->lang['no_info'];
    		}

    		if ($member['losses'] or $member['clanname'])
				{
					$info['losses'] = $member['losses'];
				}
				else
				{
					$info['losses'] = $ibforums->lang['no_info'];
    		}

    		if ($member['streak'] or $member['clanname'])
				{
					$info['streak'] = $member['streak'];
				}
				else
				{
					$info['streak'] = $ibforums->lang['no_info'];
    		}
	
    		if ($member['tcpoints'] or $member['clanname'])
				{
					$info['tcpoints'] = $member['tcpoints'];
				}
				else
				{
					$info['tcpoints'] = $ibforums->lang['no_info'];
    		}


[CLOSE: /sources/Profile.php]
-----------------------------------------------

//---------------------------------------------------------------------------//
//Step 9 : Open /skin/sx/skin_global.php
//---------------------------------------------------------------------------//

Search For:

&nbsp; &nbsp;&nbsp;<img src="{$ibforums->vars['img_url']}/atb_calendar.gif" border="0" alt="" />&nbsp;<a href='{$ibforums->base_url}act=calendar'>{$ibforums->lang['tb_calendar']}</a>

Add After:

&nbsp; &nbsp;&nbsp;<img src="{$ibforums->vars['img_url']}/atb_ladder.gif" border="0" alt="" />&nbsp;<a href='{$ibforums->base_url}act=ladder'>{$ibforums->lang['tb_ladder']}</a>


[CLOSE: /skin/sx/skin_global.php]
-----------------------------------------------

//---------------------------------------------------------------------------//
//Step 10 : Open /skin/sx/skin_profile.php
//---------------------------------------------------------------------------//

Search For:

<table class="tablebasic" cellspacing="0" cellpadding="2">
<tr>
 <td>{$info['photo']}</td>
 <td width="100%" valign="bottom">
   <div id="profilename">{$info['name']}</div>
   <div>
	 <a href='{$info['base_url']}act=Search&amp;CODE=getalluser&amp;mid={$info['mid']}'>{$ibforums->lang['find_posts']}</a> &middot;
	 <a href='{$info['base_url']}act=Msg&amp;CODE=02&amp;MID={$info['mid']}'>{$ibforums->lang['add_to_contact']}</a>
	 <!--MEM OPTIONS-->
   </div>
 </td>
</tr>
</table>
<br />

Add After:

<table width="100%" border='0' align='center' cellpadding='0' cellspacing='2'>
  <tr>
    <td width='50%' height="130" valign='top' class="plainborder">
    <table cellspacing="1" cellpadding='6' width='100%'>
        <tr>
          <td align='left' colspan='2' class='maintitle'>Personal Ladder Information</td>
        </tr>
        <tr>
          <td class="row3" width='30%' valign='top'><b>Clan Name</b></td>
          <td align='left' width='70%' class='row1'><b>{$info['clanname']}</b></td>
        </tr>
        <tr>
				 <td class="row3" valign='top'><b>Points</b></td>
				 <td align='left' class='row1'>{$info['tcpoints']}</td>
        </tr>
        <tr>
		          <td width="30%" valign='top' class="row3"><b>Wins</b></td>
		          <td width="70%" align='left' class='row1'>{$info['wins']}</td>
		        </tr>
		        <tr>
		          <td class="row3" valign='top'><b>Losses</b></td>
		          <td align='left' class='row1'>{$info['losses']}</td>
		        </tr>
		        <tr>
		          <td class="row3" valign='top'><b>Streak</b></td>
		          <td align='left' class='row1'>{$info['streak']}</td>
		        </tr>
		        </table></td>

  </tr>
</table>


[CLOSE: /skin/sx/skin_profile.php]
-----------------------------------------------

//---------------------------------------------------------------------------//
//Step 11 : Edit your Style Sheet in the Admin CP
//---------------------------------------------------------------------------//


Place somewhere in the CSS

		/
		/* Ladder Addon */

.row3 { background-color: #35363F}
.row4 { background-color: #25262f ; padding:3px }
.row5 { background-color: #3F3F3F ; padding:4px ; border: 1px #000 ;}
.row6 { background-color: #2C2C2C ; padding:4px }

.darkrow2 { background-color: #35363F ; color:#707C99; }

-----------------------------------------------


UPLOAD:

Sources to /Sources/
Lang to /Lang/
Skin to /Skin/
Uploads to /uploads/   //this is the place were maps are kept.
Content of style_images to your correct style_images directory


	
Make sure all files uploaded and enjoy :)