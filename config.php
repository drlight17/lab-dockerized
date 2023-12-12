<?php
// --------------------------------------------------------------------
// User Interface Language
// --------------------------------------------------------------------

// Specify language to be used for buttons, messages, etc. On Linux
// systems the corresponding language pack needs to be installed.
// (Installed language packs can be listed by "locale -a").
//
// The address book will be displayed in English if:
//  - no language is set
//  - language is set to __auto__ but the user's preferred language is
//    not available

// set_language("__auto__");	// Detect from browser settings

// set_language("en_US.UTF-8");	// English (US)
// set_language("fr_FR.UTF-8");	// Français (France)	    French
// set_language("es_ES.UTF-8");	// Español (España)	    Spanish
// set_language("it_IT.UTF-8"); // Italiano (Italia)	    Italian
// set_language("de_DE.UTF-8");	// Deutsche (Deutschland)   German
set_language("ru_RU.UTF-8");	// Russian

// --------------------------------------------------------------------
// Address book name (for page title and browser search plugin)
// --------------------------------------------------------------------

$site_name = gettext("Адресная книга Вашей организации");

// --------------------------------------------------------------------
// Links displayed in page footer
//
// This application's software license requires you to provide users
// with a means of obtaining the source code (i.e. the link below).
// You may however choose to provide the source from a different
// location, e.g. to a copy containing your own local changes, or if
// users have only limited connectivity to the external Internet that
// would prevent them from accessing the default location. Please see
// the license agreement (file "license.html" in "doc" folder) for
// full information.
// --------------------------------------------------------------------

$site_footer_links = array(
	//array("url"=>"doc/index.html","text"=>gettext("User Guide")),
	array("url"=>"https://www.domain.org/",
		"text"=>gettext("&copy ".date("Y")." Ваша организация"))
	);

// --------------------------------------------------------------------
// LDAP server to connect to.
//
// LDAP server type is one of:
//	ad		Microsoft Active Directory
//	edir		Novell eDirectory
//	openldap	OpenLDAP
//	custom		Custom type (configure schema, etc, "by hand")
//
// For Active Directory, providing just the domain name will
// load balance across available domain controllers.
// --------------------------------------------------------------------

$ldap_server = new ldap_server(
	"ad",				// LDAP server type
	"DC=domain,DC=org",	// DN of address book
	"ldap://dc.domain.org",		// host name/IP address/URL
	389				// port number
	);

// --------------------------------------------------------------------
// Settings for looking up user login names into LDAP bind DNs
// --------------------------------------------------------------------

// Location which will be searched to look up user's DN during the
// login process.
//
// Configure this setting to search for login user accounts outside
// the part of the directory tree containing the Address Book. If this
// setting is not configured then searches will start from
// $ldap_server->base_dn.

// $ldap_server->dn_search_base = "CN=Users,DC=turnersoft,DC=co,DC=uk";

// LDAP credentials used to search for the user's DN during the
// login process.
//
// Use a "generic" user that has only read permission to search for a
// user's DN.
//
// If these settings are not configured (or if both the user name and
// password are empty) then an "anonymous bind" will be used.

$ldap_server->dn_search_user = "user@domain.org";
$ldap_server->dn_search_password = "password";

// Search filter used to look up a user's DN during the login process.
//
// If this setting is not configure then set then a default search filter
// will be used (which is appropriate to the directory type).

// $ldap_server->dn_search_filter = "(uid=__USERNAME__)";

// --------------------------------------------------------------------
// Attributes that are checked when evaluating group membership
// --------------------------------------------------------------------

// $group_member_attributes = array("member","roleOccupant","memberUid");

// --------------------------------------------------------------------
// User names and passwords for logging on to the LDAP server
// --------------------------------------------------------------------

// Default credentials used to browse the directory when no user has
// explicitly logged in ("anonymous" access).
//
// Remove or comment out this section if you don't want to people to
// have any access unless they have logged in by name.

$ldap_server->add_user("__ANONYMOUS__",
	array(
		// LDAP login (or bind DN) to connect to the directory
		//
		// If the LDAP server is set up to allow "anonymous bind"
		// then the the user name and password can be left blank,
		// otherwise replace with a "generic" user that has read
		// permission.

		"ldap_dn"=>"user@domain.org",
		"ldap_password"=>"password",

		// Permissions granted to anonymous users:

		"allow_browse"=>false,
		"allow_search"=>true,
		"allow_view"=>true,
		"allow_ldap_path"=>false,
		"allow_export"=>true,
		"allow_export_bulk"=>true,
//		"front_page_search_filter"=>"(&(objectClass=user)(mail=*)(!(userAccountControl:1.2.840.113556.1.4.803:=2))(!(description=service))(carLicense=YES))"
	));

// --------------------------------------------------------------------

// Adding other user mappings (besides __ANONYMOUS__) will cause a
// "log in" link to be displayed at the top right of each page.
//
// The following shows how to grant extra permissions to a specifc
// named user (such as a system administrator).

//$ldap_server->add_user("admin",
//	array(
		// LDAP login (or bind DN) to connect to the directory
//		"ldap_dn"=>"Administrator@turnersoft.co.uk",
		// Permissions granted to this user:

//		"allow_browse"=>true,
//		"allow_search"=>true,
//		"allow_view"=>true,
//		"allow_create"=>true,
//		"allow_edit"=>true,
//		"allow_delete"=>true,
//		"allow_extend"=>true,
//		"allow_export"=>true,
//		"allow_export_bulk"=>true,
//		"allow_system_admin"=>true
//	));
// samoilov 20.12.2021 add admin group
$ldap_server->add_group("CN=Domain Admins,CN=Users,DC=domain,DC=org",
        array(
                "allow_edit"=>true,
		"allow_system_admin"=>true,
		"allow_browse"=>true,
		"allow_ldap_path"=>true,
		"allow_extend"=>false,
        ));

// --------------------------------------------------------------------

// Other users who log in by name will be granted the permissions
// associated with __DEFAULT__ (below).
//
// The user's LDAP login (or bind DN) will be created by replacing
// __USERNAME__ with the name the user typed into the login box.

$ldap_server->add_user("__DEFAULT__",
	array(
		// LDAP login (or bind DN) to connect to the directory
//		"ldap_dn"=>"cn=__USERNAME__,o=turnersoft",
// samoilov 20.12.2021 to allow user self service
//		"ldap_dn"=>"CN=Administrator,CN=Users,DC=ksc,dc=loc",
//		"ldap_password"=>"rkmSciZd8",
		// Permissions granted to this user:

		"allow_browse"=>true,
		"allow_search"=>true,
		"allow_view"=>true,
		"allow_export"=>true,
		"allow_export_bulk"=>true,
		"allow_edit_self"=>true,
		"allow_ldap_path"=>false,
		"allow_folder_info"=>false,
//		"front_page_search_filter"=>"(&(objectClass=user)(mail=*)(!(userAccountControl:1.2.840.113556.1.4.803:=2))(!(description=service))(carLicense=YES))"
	));

// See "configuring users and permissions" in the manual for more info.

// --------------------------------------------------------------------
// Search/Browse Directory Settings
// --------------------------------------------------------------------

// List of object attributes used for searches
$search_ldap_attrib = array(
	"cn","mail","description","l","department");
// LDAP filter used for retrieving search results
//
// The token "___search_criteria___" will be replaced with an
// expression to search the attributes listed in $search_ldap_attrib
// for the string entered by the user, e.g.:
// (|(cn=whatever)(mail=whatever)(sn=whatever)...)
//$search_ldap_filter = "(&(objectClass=person)___search_criteria___)";
//$search_ldap_filter = "(&(mail=*)(|(&(objectClass=user)(!(objectClass=computer))(!(userAccountControl:1.2.840.113556.1.4.803:=2))))(carLicense=YES)___search_criteria___)";
$search_ldap_filter = "(&(objectClass=user)(mail=*)(!(userAccountControl:1.2.840.113556.1.4.803:=2))(!(description=service))(carLicense=YES)___search_criteria___)";

// LDAP filter used when browsing the directory
$browse_ldap_filter = "(|(objectClass=organizationalUnit)(&(objectClass=user)(mail=*)(!(userAccountControl:1.2.840.113556.1.4.803:=2))(!(description=service))(carLicense=YES)))";
//$browse_ldap_filter = "(&(mail=*)(|(&(objectClass=user)(!(objectClass=computer))(!(userAccountControl:1.2.840.113556.1.4.803:=2))))(carLicense=YES))";

// 1 - match anywhere in string (default)
// 2 - match start of string only (match versions 0.20 and earlier)

// $search_method = 1;

// Column layout used to display lists of records
// Note special attribute "sortableName" - uses syntax "surname,
// firstname" where both of these are defined

$ldap_server->set_display_columns("*",		// location to which the layout applies, or "*" for default/all
	array(
//		array("caption"=>"Фамилия",		"attrib"=>"sn",	"link_type"=>"object"),
		array("caption"=>"ФИО",		"attrib"=>"cn",	"link_type"=>"object"),
//		array("caption"=>"Имя и Отчество",	"attrib"=>"givenName",	"link_type"=>"object"),
		array("caption"=>"Эл. почты",		"attrib"=>"mail",		"link_type"=>"mail"),
		array("caption"=>"Номер телефона",	"attrib"=>"telephoneNumber",	"link_type"=>"phone_number"),
//		array("caption"=>"Mobile Phone",	"attrib"=>"mobile",		"link_type"=>"phone_number"),
//		array("caption"=>"Фото",		"attrib"=>"jpegPhoto",		"photo24.png"),
//		array("caption"=>"Подразделение",	"attrib"=>"o",		"link_type"=>"none"),
		array("caption"=>"Отдел",	"attrib"=>"department",		"link_type"=>"none"),
		array("caption"=>"Должность",	"attrib"=>"description",		"link_type"=>"none")
		)
	);

// Default sort order until user selects another by clicking a column header
$search_result_default_sort_order = "sn";

// Whether search suggestions (auto-complete) should be used
$enable_search_suggestions = true;

// Display folders and leaf objects separately, rather than mixed together
$display_folders_separately = true;

// Specify the collation locale (sorting language/region/script)
// to be used for browsing and displaying search results.
$lc_collate = "ru_RU";

// --------------------------------------------------------------------
// Directory Entry Detail/Info Settings
// --------------------------------------------------------------------

// Layout of the detail/info view
//
// Configurable attributes of a section - all optional:
//
//	section_name - Name/title of section (default blank/not shown)
//	width - Width of section (default unset - let browser decide)
//	new_row - Start section on a new row (default false)
//	colspan - Number of table columns to span (default 1)
//
// Details for each attribute:
//	LDAP attribute
//	Label/display name
//	Icon to display next to attribute
//	Whether to hide attribute when not editing

$ad = $ldap_server->server_type=="ad";

$ldap_server->add_display_layout("inetOrgPerson,user,contact",array(
	array("section_name"=>"Персональные данные",
		"attributes"=>array(
//			array("givenName",			"Имя и Отчество",		"contact24.png","allow_view"=>false),
			array("cn",			"ФИО",		"contact24.png","allow_view"=>true),
//			array("sn",				"Фамилия",		"contact24.png","allow_view"=>false),
			array("mail",				"Эл. почта",		"mail.png"),
			array("telephoneNumber",			"Телефон",		"landline-phone.png"),
//			array("streetAddress:l:st:postalCode",	"Postal Address",	"address.png"),
	//		array("c",				"Country",		"country.png")
			array("jpegPhoto",			"Фото",		"photo24.png")
			)
		),

	array("section_name"=>"Рабочая информация","width"=>"50%",
		"attributes"=>array(
//			array($ad ? "company" : "o",		"Подразделение",		"company.png"),
	//		array("o",		"Подразделение",		"company.png"),
	//		array("thumbnailLogo",			"Logo",			"logo24.png"),
			array("description",				"Должность",		"org-role.png"),
			array($ad ? "department" : "ou",	"Отдел",		"org.png"),
			array("l",	"Расположение",		"office.png")
			)
		)//,

//	array("section_name"=>"Additional Notes","new_row"=>true,"colspan"=>2,
//		"attributes"=>array(
//			array($ad ? "info" : "description")
//			)
//		)
	));

// Automatically include attributes for each auxiliary class which is
// used to extend the record being displayed.

// $append_auxiliary_layouts = true;

// --------------------------------------------------------------------
// Photo/Image Display Settings
// --------------------------------------------------------------------

// Display thumbnail photos next to directory entries instead of
// object class icons when browsing/searching
$enable_search_browse_thumbnail = false;

// Display thumbnail photo in the "navigation path" instead of
// object class icon in detailed info view
$enable_ldap_path_thumbnail = true;

// Size of thumbnail images displayed in search results
// and/or detail view navigation path, measured in pixels.
// This should match the size of other object schema icons.
//$thumbnail_image_size = "24x24";
$thumbnail_image_size = "48x48";

// Size of large images displayed in detail view, measured
// in pixels. Set to an empty string (or leave undefined) to
// disable scaling of these images.
//$photo_image_size = "96x96";
//$photo_image_size = "1024x1024";

// --------------------------------------------------------------------
// Phone integration settings
// --------------------------------------------------------------------

// Optionally specify a URL format to use for showing phone number
// attributes as HTML links, e.g. to support "click-to-dial".
// Leaving this option unset (or blank) to display phone numbers as
// plain text rather than a link.

 $phone_number_link_template = "tel:___phone_number___";

// Optional link target attribute for phone numbers "target" attribute.
// (May want to set to "_blank" for some click-to-dial software or if
// the address book has been hosted inside a HTML frame.

// $phone_number_link_target = "_blank";

// --------------------------------------------------------------------
// Data export settings
// --------------------------------------------------------------------

// May be prefered if importing into Android contacts - otherwise
// company logo will be displayed instead of photo
$exclude_logo_if_photo_present = true;

// --------------------------------------------------------------------
// Date and time formats
// --------------------------------------------------------------------

// Specify the format/layout for displaying "date" and "date_time"
// attributes (on an LDAP entry's "detailed info" page).

// See user guide for a list of the tokens (each consisting of %
// followed by a letter) which are used to describe the format/layout.

// See user guide for a list of the tokens which are used to describe
// the format/layout. (Each token is made up of % followed by a letter.)

$date_format = "%A %d %B %Y";
$date_time_format = "%A %d %B %Y %H:%M:%S";

// More compact format/layout for displaying "date" and "date_time"
// attributes in lists of search results or when browsing.

$short_date_format = "%d %b %Y";
$short_date_time_format = "%d %b %Y %H:%M:%S";

// --------------------------------------------------------------------
// Comma-separated list of country code standards, used to display
// code attributes as human-readable country names and populate
// drop-down lists of country names.
//
// Where more than one country code standard uses the same country
// code, the standard which is listed first will take priority.
//
//      official        ISO 3166-1 Officially Assigned Codes
//      user            ISO 3166-1 User-Assigned Codes
//      exceptional     ISO 3166-1 Exceptional Reservations
//      transitional    ISO 3166-1 Transitional Reservations
//      indeterminate   ISO 3166-1 Indeterminate Reservations
//      former          ISO 3166-3 Formerly Assigned Codes
//      wipo            WIPO ST.3 Country Codes
//      fips            FIPS 10-4 Country Codes
//
// See "Changing the country code interpretation" in the manual for
// more information about each standard.
// --------------------------------------------------------------------

$country_code_standard="official";

// --------------------------------------------------------------------
// Location of OpenLDAP modules (backends and overlays)
//
// This setting is used for loading extension modules when configuring
// OpenLDAP via the Address Book's web interface. The setting is
// not used for directory types other than OpenLDAP, or if you don't
// intend to use the Address Book to help configure your installation.
//
// Typical values for various operating systems:
//      Debian:                 /usr/lib/ldap
//      CentOS (64-bit):        /usr/lib64/openldap
// --------------------------------------------------------------------

$openldap_module_path = "/usr/lib/ldap";
?>