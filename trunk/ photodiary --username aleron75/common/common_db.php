<?


// PHOTODIARY
$TBL['posts'] = "photo_posts";
$FLD['posts']['id'] = "id_post";
$FLD['posts']['date'] = "dt_date";
$FLD['posts']['text'] = "tx_text";
$FLD['posts']['visible'] = "fl_visible";

// COMMENTS
$TBL['comments'] = "photo_comments";
$FLD['comments']['id'] = "id_comment";
$FLD['comments']['id_ref'] = "id_ref";
$FLD['comments']['date'] = "dt_date";
$FLD['comments']['time'] = "tm_time";
$FLD['comments']['name'] = "tx_name";
$FLD['comments']['email'] = "tx_email";
$FLD['comments']['url'] = "tx_url";
$FLD['comments']['text'] = "tx_text";
$FLD['comments']['x'] = "nm_x";
$FLD['comments']['y'] = "nm_y";
$FLD['comments']['angle'] = "nm_angle";

// CONFIG
$TBL['config'] = "photo_config";
$FLD['config']['id'] = "id_config";
$FLD['config']['title'] = "tx_title";
$FLD['config']['email'] = "tx_email";
$FLD['config']['username'] = "tx_username";
$FLD['config']['password'] = "tx_password";
$FLD['config']['lng'] = "tx_language";
$FLD['config']['optimize'] = "tx_optimize";
$FLD['config']['width'] = "nm_width";
$FLD['config']['height'] = "nm_height";

?>