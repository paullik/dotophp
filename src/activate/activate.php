<?php
/**
 * @file src/activate/activate.php
 * @brief Main file for activate module
 * @author Paul Barbu
 *
 * @ingroup activateFiles
 */

if(isset($_POST['activate'])){

    $result = NULL;

    list($activationCode, $_POST['pass'], $_POST['passconfirm'], $_POST['security_q'], $_POST['security_a']) =
        filterInput(isset($_POST['code']) ? $_POST['code'] : $_GET['code'],
            $_POST['pass'], $_POST['passconfirm'], $_POST['security_q'], $_POST['security_a']);

    if(!$feedback_pre['connect']){
        $result = A_ERR_DB_CONNECTION;
    }
    elseif(isValidPass($_POST['pass']) && $_POST['pass'] == $_POST['passconfirm']){
        if(isValidSecurityData($_POST['security_q']) &&
           isValidSecurityData($_POST['security_a'])){
            $id = getPendingUser($feedback_pre['connect'], $activationCode);

            if($id !== NULL){
                if(!mysqli_query($feedback_pre['connect'], 'BEGIN;')){
                    $result = A_ERR_DB;
                }
                elseif(!mysqli_query($feedback_pre['connect'],
                       'DELETE FROM pending WHERE user_id = ' . $id . ';')){
                    $result = A_ERR_DB;
                }
                elseif(!mysqli_query($feedback_pre['connect'],"UPDATE user SET password = SHA1('" .
                    $_POST['pass'] . "'), security_q = '" . $_POST['security_q'] . "', security_a = '" .
                    $_POST['security_a'] . "', activated = NOW() WHERE id = " . $id . ";"
                )){
                    $result = A_ERR_DB;
                }
                elseif(!mysqli_query($feedback_pre['connect'], 'COMMIT;')){
                    $result = A_ERR_DB;
                }
                else{
                    $result = ERR_NONE;
                }
            }
            else{
                $result = A_ERR_CODE;
            }
        }
        else{
            $result = A_ERR_SECURITY_DATA;
        }
    }
    else{
        $result = A_ERR_PASS;
    }

    unset($_POST['pass'], $_POST['passconfirm'], $_POST['security_q'], $_POST['security_a']);

    if($result == A_ERR_DB || $result == A_ERR_DB_CONNECTION){
        writeLog($config['logger']['activate'], '(' . mysqli_errno($feedback_pre['connect'])
                 . ') ' . mysqli_error($feedback_pre['connect']) . PHP_EOL);
        mysqli_query($feedback_pre['connect'], 'ROLLBACK;');
    }

    return $result;
}

return TRUE;
/* vim: set ts=4 sw=4 tw=80 sts=4 fdm=marker nowrap et :*/
