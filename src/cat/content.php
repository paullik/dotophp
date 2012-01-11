<?php
/**
 * @file src/category/category.php
 * @brief Category's content
 * @author Paul Barbu
 *
 * @ingroup catFiles
 */

require 'constants.php';
?>

<form action="" method="post">
<table border="0" cellspacing="5">
<tr><td>
<label for="name" title="<?php echo TOOLTIP_NICK_CAT_EV ?>">Name:</label></td><td><input title="<?php echo TOOLTIP_NICK_CAT_EV ?>" type="text" maxlength="20" name="name" id="name" tabindex="1"
 <?php echo isset($feedback['category']['name']) ? 'value="' . $feedback['category']['name'] . '"' : NULL ?> /></td><td>

<label for="desc" title="<?php echo TOOLTIP_DESC ?>">Description:</label></td><td><textarea title="<?php echo TOOLTIP_DESC ?>" tabindex="2" rows="3" cols="23" name="description" id="desc">
<?php echo isset($feedback['category']['description']) ? $feedback['category']['description'] : NULL ?></textarea></td></tr>

<tr><td>
<label for="color" title="<?php echo TOOLTIP_COLOR ?>">Color:</label></td><td><input title="<?php echo TOOLTIP_COLOR ?>" type="text" maxlength="7" tabindex="3" name="color" id="color"
 value="<?php echo isset($feedback['category']['color']) ? $feedback['category']['color'] : COLOR_CODE ?>" /></td><td>

<label for="repeat">Repeat:</label></td><td><select tabindex="4" name="repeat" id="repeat">
 <?php arrayToOption(array_values($REPEATS), array_keys($REPEATS), isset($feedback['category']['repeat']) ? $feedback['category']['repeat'] : NULL); ?>
</select></td></tr><tr><td colspan="4"><center>
<?php
echo isset($feedback['category']['category_id']) ? '<input type="hidden" name="category_id" value="' .
            $feedback['category']['category_id'] . '" />' : NULL ?>
<input type="submit" name="<?php echo $feedback['category']['action'] ?>" value="<?php echo ucfirst($feedback['category']['action']) ?>" tabindex="5" /></center></td></tr>
</table>
</form>

<?php
if(is_array($feedback_pre['rcats'])){
    echo '<h3>';

    foreach($feedback_pre['rcats'] as $err){
        switch($err){
            case C_ERR_NAME: printf('Invalid name! (#%d)<br />', C_ERR_NAME);
                break;
            case C_ERR_DESC: printf('The description contains invalid characters! (#%d)<br />', C_ERR_DESC);
                break;
            case C_ERR_COLOR: printf('Invalid color code! (#%d)<br />', C_ERR_COLOR);
                break;
        }
    }

    echo '</h3>';
}
else if(is_numeric($feedback_pre['rcats'])){
    echo '<h3>';

    switch($feedback_pre['rcats']){
        case ERR_DB: printf('A database error occured, please contact the admin! (#%d)', ERR_DB);
            break;
        case ERR_DB_CONN: printf('A database connection error occured, please contact the admin! (#%d)', ERR_DB_CONN);
            break;
        case C_ERR_DUPLICATE: printf('No duplicates allowed! (#%d)', C_ERR_DUPLICATE);
            break;
        case ERR_NONE: printf('Added!');
            break;
        case MODIFIED: printf('Modified!');
            break;
        case C_ERR_NAME: printf('Invalid name! (#%d)<br />', C_ERR_NAME);
            break;
        case C_ERR_DESC: printf('The description contains invalid characters! (#%d)<br />', C_ERR_DESC);
            break;
        case C_ERR_COLOR: printf('Invalid color code! (#%d)<br />', C_ERR_COLOR);
            break;
    }

    echo '</h3>';
}
else if(isset($feedback['category']['code']) && is_array($feedback['category']['code'])){
    echo '<h3>';

    switch($feedback['category']['code'][0]){
        case DELETED:
            $category = 'category';
            if($feedback['category']['code'][1] > 1){
                $category = 'categories';
            }

            printf('Deleted %d %s!', $feedback['category']['code'][1], $category);
            break;
    }

    echo '</h3>';
}

if(!empty($feedback['category']['categories'])){

echo<<<'mini_menu'
<hr /><h4>Your categories:</h4><form action="" method="post">
<input type="submit" name="del" value="Delete" tabindex="6" />
mini_menu;

    $name = 'modify-sel';
    $value = 'Modify selected';

    if(isset($feedback['category']['category_id'])){
        $name = 'stop';
        $value = 'Finish editing';
    }
    echo '<input type="submit" name="' . $name . '" value="' . $value . '" tabindex="7" />';

    arrayToDiv($feedback['category']['categories'], 'format_cat', NULL, 'cat');

    echo '</form>';
}