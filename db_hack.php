<?php
/*
+--------------------------------------------------------------------------
Written and Coded by Phil_b
Modified for IPB 2.0.x by Ruud

All Support will be given through http://www.ibplanet.com
Tested and made for 1.2 Final.
+--------------------------------------------------------------------------
*/


define( 'ROOT_PATH'  , "./" );
define( 'KERNEL_PATH', ROOT_PATH.'ips_kernel/' );

// Require the configuration
require ROOT_PATH."conf_global.php";
//--------------------------------
// Load the DB driver and such
//--------------------------------

$INFO['sql_driver'] = ! $INFO['sql_driver'] ? 'mysql' : strtolower($INFO['sql_driver']);

require ( KERNEL_PATH.'class_db_'.$INFO['sql_driver'].".php" );

$DB = new db_driver;

$DB->obj['sql_database']     = $INFO['sql_database'];
$DB->obj['sql_user']         = $INFO['sql_user'];
$DB->obj['sql_pass']         = $INFO['sql_pass'];
$DB->obj['sql_host']         = $INFO['sql_host'];
$DB->obj['sql_tbl_prefix']   = $INFO['sql_tbl_prefix'];
$DB->obj['query_cache_file'] = ROOT_PATH.'sources/sql/'.$INFO['sql_driver'].'_queries.php';
$DB->obj['use_shutdown']     = USE_SHUTDOWN;
require $root_path."conf_global.php";
require $root_path."sources/functions.php";

$std   = new FUNC;
$input = $std->parse_incoming();
//--------------------------------
// Get a DB connection
//--------------------------------

$DB->connect();


// Start the script

if ($input['a'] == "")
{
	echo "<p align=center><b>Welcome to the Ladder v1.2 Installer<br><font size=4>Click <a href='?a=do'>here</a> for a fresh install</font><br><br><font size=4>Click <a href='?a=do_upgrade'>here</a> to upgrade from v1.1</font></b></p>";
}
elseif ($input['a'] == "do")
{


$query1="CREATE TABLE ".$INFO['sql_tbl_prefix']."tcug_validate (
			  tcugid int(11) default NULL,
			  mid mediumint(8) default NULL
			) TYPE=MyISAM;";


$query2="CREATE TABLE ".$INFO['sql_tbl_prefix']."tcusergroups (
 tcugid int(11) NOT NULL auto_increment,
  name varchar(255) default NULL,
  description text,
  perm_id int(10) NOT NULL default '0',
  mod_id varchar(255) NOT NULL default '0',
  state enum('open','closed','hidden') NOT NULL default 'closed',
  wins mediumint(8) unsigned NOT NULL default '0',
  loss mediumint(8) NOT NULL default '0',
  points mediumint(8) unsigned NOT NULL default '0',
  streak mediumint(8) unsigned NOT NULL default '0',
  totalgames mediumint(8) unsigned NOT NULL default '0',
  password varchar(255) NOT NULL default '0',
  made int(10) NOT NULL default '0',
  PRIMARY KEY  (tcugid)
) TYPE=MyISAM";


$query3="CREATE TABLE ".$INFO['sql_tbl_prefix']."ladder_matches (
  id int(4) NOT NULL auto_increment,
  Time varchar(128) NOT NULL default '',
  clan1_n varchar(250) NOT NULL default '0',
  Clan1 varchar(150) NOT NULL default '',
  member11_n varchar(250) NOT NULL default '0',
  Member11 varchar(128) NOT NULL default '',
  member12_n varchar(250) NOT NULL default '0',
  Member12 varchar(150) NOT NULL default '',
  member13_n varchar(250) NOT NULL default '0',
  Member13 varchar(100) NOT NULL default '',
  clan2_n varchar(250) NOT NULL default '0',
  Clan2 varchar(150) NOT NULL default '',
  member21_n varchar(250) NOT NULL default '0',
  Member21 varchar(16) NOT NULL default '',
  member22_n varchar(250) NOT NULL default '0',
  Member22 varchar(150) NOT NULL default '',
  member23_n varchar(250) NOT NULL default '0',
  Member23 varchar(150) NOT NULL default '',
  Type varchar(150) NOT NULL default '',
  Map varchar(150) NOT NULL default '',
  rworl int(4) NOT NULL default '0',
  comment text NOT NULL,
  clan1points mediumint(8) unsigned NOT NULL default '0',
  clan2points mediumint(8) unsigned NOT NULL default '0',
  clan1add mediumint(8) unsigned NOT NULL default '0',
  clan2add mediumint(8) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM";


$query4="ALTER TABLE ".$INFO['sql_tbl_prefix']."members ADD clanid mediumint(8) unsigned NOT NULL default '0'";
$query5="ALTER TABLE ".$INFO['sql_tbl_prefix']."members ADD clanname varchar(20) NOT NULL default '0'";
$query6="ALTER TABLE ".$INFO['sql_tbl_prefix']."members ADD wins mediumint(8) unsigned NOT NULL default '0'";
$query7="ALTER TABLE ".$INFO['sql_tbl_prefix']."members ADD losses mediumint(8) NOT NULL default '0'";
$query8="ALTER TABLE ".$INFO['sql_tbl_prefix']."members ADD tcpoints mediumint(8) unsigned NOT NULL default '0'";
$query9="ALTER TABLE ".$INFO['sql_tbl_prefix']."members ADD streak mediumint(8) unsigned NOT NULL default '0'";
$query10="ALTER TABLE ".$INFO['sql_tbl_prefix']."members ADD totalgames mediumint(8) unsigned NOT NULL default '0'";
$query11="ALTER TABLE ".$INFO['sql_tbl_prefix']."members ADD lastgame varchar(30) NOT NULL default '0'";
$query12="ALTER TABLE ".$INFO['sql_tbl_prefix']."members ADD cjoin int(10) NOT NULL default '0'";






$DB->query($query1);
$DB->query($query2);
$DB->query($query3);
$DB->query($query4);
$DB->query($query5);
$DB->query($query6);
$DB->query($query7);
$DB->query($query8);
$DB->query($query9);
$DB->query($query10);
$DB->query($query11);
$DB->query($query12);




$DB->close_db();

echo "<b>Database Successfully Updated for Ladder v1.2</b><br>";

echo "<b>Delete db_hack.php NOW!</b>";

 }

elseif ($input['a'] == "do_upgrade")
{

$query1="ALTER TABLE ".$INFO['sql_tbl_prefix']."tcusergroups ADD password varchar(255) NOT NULL default '0'";
$query2="ALTER TABLE ".$INFO['sql_tbl_prefix']."tcusergroups ADD made int(10) NOT NULL default '0'";

$query3="ALTER TABLE ".$INFO['sql_tbl_prefix']."ladder_matches ADD made int(10) NOT NULL default '0'";
$query4="ALTER TABLE ".$INFO['sql_tbl_prefix']."ladder_matches ADD clan1_n varchar(250) NOT NULL default '0'";
$query5="ALTER TABLE ".$INFO['sql_tbl_prefix']."ladder_matches ADD member11_n varchar(250) NOT NULL default '0'";
$query6="ALTER TABLE ".$INFO['sql_tbl_prefix']."ladder_matches ADD member12_n varchar(250) NOT NULL default '0'";
$query7="ALTER TABLE ".$INFO['sql_tbl_prefix']."ladder_matches ADD member13_n varchar(250) NOT NULL default '0'";
$query8="ALTER TABLE ".$INFO['sql_tbl_prefix']."ladder_matches ADD clan2_n varchar(250) NOT NULL default '0'";
$query9="ALTER TABLE ".$INFO['sql_tbl_prefix']."ladder_matches ADD member21_n varchar(250) NOT NULL default '0'";
$query10="ALTER TABLE ".$INFO['sql_tbl_prefix']."ladder_matches ADD member22_n varchar(250) NOT NULL default '0'";
$query11="ALTER TABLE ".$INFO['sql_tbl_prefix']."ladder_matches ADD member23_n varchar(250) NOT NULL default '0'";
$query12="ALTER TABLE ".$INFO['sql_tbl_prefix']."ladder_matches ADD comment text NOT NULL";

$query13="ALTER TABLE ".$INFO['sql_tbl_prefix']."members ADD cjoin int(10) NOT NULL default '0'";


$DB->query($query1);
$DB->query($query2);
$DB->query($query3);
$DB->query($query4);
$DB->query($query5);
$DB->query($query6);
$DB->query($query7);
$DB->query($query8);
$DB->query($query9);
$DB->query($query10);
$DB->query($query11);
$DB->query($query12);
$DB->query($query13);

$DB->close_db();

echo "<b>Database Successfully Updated for Ladder v1.2</b><br>";

echo "<b>Delete db_hack.php NOW!</b>";

 }
?>