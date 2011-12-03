<?php
/**
 * @file src/logout/logout.php
 * @brief Main file for the logout module
 * @author Paul Barbu
 *
 * @ingroup logoutFiles
 */

$_SESSION = array();

if(ini_get("session.use_cookies")){
    $params = session_get_cookie_params();

    if(!setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"],
            $params["secure"], $params["httponly"])){
        return LO_ERR_DEL;
    }
}

if(!session_destroy()){
    return LO_ERR_DESTROY;
}

return ERR_NONE;
/* vim: set ts=4 sw=4 tw=80 sts=4 fdm=marker nowrap et :*/