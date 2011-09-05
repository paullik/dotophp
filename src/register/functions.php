<?php
/**
 * @file src/register/functions.php
 * @brief Regstration functions
 * @author Paul Barbu
 *
 * @ingroup registerFiles
 */

/**
 * @defgroup registerFiles Register module
 */

/**
 * Checks if a given nickname is valid(according to the domain fileds)
 *
 * @param string $nick the nickname to be checked
 *
 * @return BOOL TRUE if the nickname is valid, else FALSE
 */
function isValidNick($nick){
    //GAP
}

/**
 * Add a new user into the database
 *
 * @param string $first_name user's first name
 * @param string $last_name user's last name
 * @param string $description user's description
 * @param string $nickname
 * @param string $email
 * @param BOOL $private private or public account
 * @param string $tz timezone set by user
 * @param string $country
 * @param string $city
 * @param string $phone user's phone number
 * @param int $birthday unix timestamp
 * @param string $sex 'M' or 'F'
 *
 * @return an array consisting of a BOOL value and a NULL or the error string,
 * array(BOOL, string)
 */
function addUser($first_name, $last_name, $description = NULL, $nickname, $email,
    $private, $tz, $country, $city, $phone = NULL, $birthday = NULL, $sex
    ){
    //GAP
}