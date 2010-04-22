elgg.session = {};
elgg.session.user;

/**
 * @return {ElggUser} The logged in user
 */
elgg.get_loggedin_user = function() {
	return elgg.session.user;
};

/**
 * @return {number} The GUID of the logged in user
 */
elgg.get_loggedin_userid = function() {
	var user = elgg.get_loggedin_user();
	return user ? user.guid : 0;
};

/**
 * @return {boolean} Whether there is a user logged in
 */
elgg.isloggedin = function() {
	var user = elgg.get_loggedin_user();
	return (user instanceof elgg.ElggUser);
};

/**
 * @return {boolean} Whether there is an admin logged in
 */
elgg.isadminloggedin = function() {
	var user = elgg.get_loggedin_user();
	return elgg.isloggedin() && user.isAdmin();
};