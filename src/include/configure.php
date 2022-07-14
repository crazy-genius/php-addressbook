<?php

use AddressBook\AuthLoginFactory;
use AddressBook\Globals\VariableBag;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "config/config.php";
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "include/dbconnect.php";

global $db, $dbname;

$id = VariableBag::get('id');
$searchstring = VariableBag::get('searchstring');
$alphabet = VariableBag::get('alphabet');
$group = VariableBag::get('group');
$resultnumber = VariableBag::get('resultnumber');
$submit = VariableBag::get('submit');
$update = VariableBag::get('update');
$delete = VariableBag::get('delete');
$part = VariableBag::get('part');
$new = VariableBag::get('new');
$add = VariableBag::get('add');
$remove = VariableBag::get('remove');
$edit = VariableBag::get('edit');
$del_format = VariableBag::get('del_format');

//
// Setup the default columns displayed
//
if (!isset($disp_cols)) {
    $disp_cols
        = ["select"
        , "lastname"
        , "firstname"
        , "email"
        , "telephone"
        , "edit"
        , "details"];
}

// Define the tables names,
// if not defined in "config.php"
$table = $table ?? "addressbook";
$month_lookup = $month_lookup ?? "month_lookup";
$table_groups = $table_groups ?? "group_list";
$table_grp_adr = $table_grp_adr ?? "address_in_groups";
// (optional) user from database
$usertable = $usertable ?? "users";
// the domain
$domain_id = $domain_id ?? 0;
// keep a history instead of deleting and updating
$keep_history = $keep_history ?? false;
// the default color
$skin_color = $skin_color ?? "blue";
// the table prefix
$table_prefix = $table_prefix ?? "";
// Show link to "group-edit" menu
$public_group_edit = $public_group_edit ?? true;
// Define default homepage guessing
$homepage_guess = $homepage_guess ?? true;
// Define quick address adding
$quickadd = $quickadd ?? false;
// Define default map guessing
$map_guess = $map_guess ?? true;
// Use images for e-mail addresses
$mail_as_image = $mail_as_image ?? false;
// Use images for e-mail addresses
$mail_accept = $mail_accept ?? [];
// Define default ajax mode
$use_ajax = $use_ajax ?? true;
// Define default (empty) map key
$google_maps_keys = $google_maps_keys ?? ['' => ""];

// Enable "use_sso" mode, if keys are availabe
$use_sso = (isset($sso_facebook_id) && $sso_facebook_id != "")
    || (isset($sso_google_id) && $sso_google_id != "")
    || (isset($sso_yahoo_id) && $sso_yahoo_id != "")
    || (isset($sso_hotmail_id) && $sso_hotmail_id != "")
    || (isset($sso_twitter_id) && $sso_twitter_id != "");

// Enable "doodle" mode, if keys are availabe
$use_doodle = isset($doodle['key']) && isset($doodle['secret']);

// Define default ZIP handling
if (isset($plz_pattern)) $zip_pattern = $plz_pattern;
if (!isset($zip_pattern)) $zip_pattern = "";

// Define default image location (same server)
if (!isset($url_images)) $url_images = "";

// Define default language behavoir
if (!isset($lang)) $lang = 'choose';

// Define default UNO-languages
if (!isset($default_languages)) $default_languages = "ar,de,fr,it,th,ru";

// Split the default (displayed) languages
if (isset($default_languages)) {
    $default_languages = explode(",", $default_languages);
}

//
// --- Set default values to parameters, if need
//
if (!isset($page_ext))
    $page_ext = ".php";
$page_ext_qry = $page_ext . "?";

if (!isset($read_only))
    $read_only = false;
$read_only = $read_only || isset($_GET["readonly"]);

$group_name = null;
if (isset($group)) {
    $group_name = $group;
}

$is_fix_group = false;
if (isset($nogroups)) {
    $is_fix_group = $nogroups;
} else {
    $is_fix_group = isset($_GET["fixgroup"]);
}

// Remember the current group
if (!$is_fix_group and $group_name) {
    $page_ext_qry = "$page_ext?group=$group_name&amp;";
    $page_ext = "$page_ext?group=$group_name";
}
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . "prefs.inc.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . "translations.inc.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . "mailer.inc.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . "login.inc.php";
include_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . "version.inc.php";

// Apply the table prefix, if available
$table = $table_prefix . $table;
$month_lookup = $table_prefix . $month_lookup;
$table_groups = $table_prefix . $table_groups;
$table_grp_adr = $table_prefix . $table_grp_adr;
$usertable = $table_prefix . $usertable;

$login = AuthLoginFactory::getBestLogin();

if (!isset($required_roles)) {
    $required_roles = [];
}

if (!$login->hasRoles($required_roles)) {
    include dirname(__DIR__) . DIRECTORY_SEPARATOR . "include/format.inc.php";
    echo "<title>" . ucfmsg("ADDRESS_BOOK") . "</title>";
    include dirname(__DIR__) . DIRECTORY_SEPARATOR . "include/login.inc.html";
    die;
}

// Get domain
$user = $login->getUser();
$username = $user->getName();
$domain_id = $user->getDomain();

// Check "read only" of user
$read_only = $read_only || $user->hasRole("readonly");

// Check "forced group"
if ($user->getGroup() != "") {
    $is_fix_group = true;
    $group = $user->getGroup();
    $group_name = $user->getGroup();
};

if (isset($domain) && isset($domain[$domain_id]) && isset($domain[$domain_id]['skin'])) {
    $skin_color = $domain[$domain_id]['skin'];
}

// To run the script on systeme with "register_globals" disabled,
// import all variables in a bit secured way: Remove HTML Tags.
foreach ($_REQUEST as $key => $value) {
    // Allow all tags in headers and footers
    if (in_array($key, ['domain_id', 'read_only'])) {

        // Security-Fix: ignore this fields!!

    } elseif (in_array($key, ['group_header', 'group_footer'])) {
        ${$key} = $value;

        // Handle arrays
    } elseif (is_array($value)) {
        foreach ($value as $entry) {
            ${$key}[] = strip_tags($entry);
        }
    } else {
        // ${$key} = htmlspecialchars($value); --chatelao-20071121, doesn't work with Chinese Characters
        ${$key} = strip_tags($value);
    }

    // TBD: prevent SQL-Injection
}

//
// ------------------- Group query handling ------------------------
//

$select_groups = "SELECT `groups`.*
       	               , parent_groups.group_name  parent_name
       	               , parent_groups.group_id    parent_id
       	            FROM $table_groups AS `groups`
               LEFT JOIN $table_groups AS parent_groups
                      ON `groups`.group_parent_id = parent_groups.group_id
                   WHERE `groups`.domain_id = $domain_id";

// Create "n-level" non-locking recursion
$max_level = 3;

$sql_from = "";
$sql_where = "";

for ($i = 0; $i < $max_level; $i++) {
    if ($i > 0) {
        $sql_from .= "     , ";
        $sql_where .= " OR ";
    }
    $sql_from .= "$table_groups g$i";
    $sql_where .= "( ";

    for ($j = 0; $j < $max_level; $j++) {
        if ($j > 0) {
            $sql_where .= "\n  AND ";
        }
        if ($j >= $i) {
            $sql_where .= "g$j.group_name = '$group_name'";
        } else {
            $sql_where .= "g$j.group_parent_id = g" . ($j + 1) . ".group_id";
        }
    }
    $sql_where .= ")\n";
}
// echo nl2br("select * from ".$sql_from." WHERE ".$sql_where."\n");

// Assemble the statements
$base_where = "$table.domain_id = $domain_id ";
$base_where .= "AND $table.deprecated is null ";
if ($group_name == "") {
    $base_select = " * ";
    $base_from = $table;
} else {

    if ($group_name === "[none]" || $group_name === "[no group]") {
        $base_select = " * ";
        $base_from = "$table";
        $base_where .= "AND $table.id not in (select distinct id from $table_grp_adr)";
    } elseif (isset($_REQUEST['nosubgroups'])) {
        $base_select = " * ";
        $base_from = "$table_grp_adr, $table_groups, $table";
        $base_where .= "AND $table.id = $table_grp_adr.id "
            . "AND $table_grp_adr.group_id  = $table_groups.group_id "
            . "AND $table_groups.group_name = '$group_name'";
    } else {
        $base_select = "DISTINCT $table.*";
        $base_from = "$table_grp_adr, $sql_from, $table";
        $base_where .= "AND $table.id = $table_grp_adr.id "
            . "AND $table_grp_adr.group_id  = g0.group_id "
            . "AND ($sql_where)";
    }
}

$base_from_where = "$base_from 
                          WHERE $base_where ";
$month_from_where = "$base_from LEFT OUTER JOIN $month_lookup
                                   b_month_lookup ON $table.bmonth = b_month_lookup.bmonth
                                LEFT OUTER JOIN (SELECT bmonth AS amonth, bmonth_short AS amonth_short, bmonth_num AS amonth_num FROM $month_lookup) AS 
                                   a_month_lookup ON $table.amonth = a_month_lookup.amonth
                          WHERE $base_where ";

$groups_from_where = "$table_groups WHERE domain_id = '$domain_id' ";
$group_from_where = $groups_from_where . "group_name = '$group_name' ";

if (isset($part)) {
    $participants = array_filter(explode(';', $part));
    $part_ids = [];

    foreach ($participants as $one_part) {
        if (ctype_digit($one_part)) {
            $part_ids[] = $one_part;
        }
    }
    $part_sql = "(" . $table . ".id = '" . implode("' OR id = '", $part_ids) . "')";
} elseif (isset($id)) {
    $part_sql = $table . ".id = '$id'";
}

include("address.class.php");
include("group.class.php");

