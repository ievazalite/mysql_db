
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<!DOCTYPE html>
<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
<a href="message.php">Message</a>
<a href="number_in_list.php">Number in List</a>

<div class="container">
<form action="">
<?php

    include 'DB.php';
    $db = new DB('localhost', 'root', 'root', 'mysql_db');
    $db->fetchAll('users');
    
    
    if(array_key_exists('update', $_GET)){
        $id = $_GET['update'];
        $user = $db->find($id);
        if($user !== []){
            echo "<h3> <a href='/'>&lt;-</a> Atjauninam ierakstu ar id $id </h3>";
            echo "<input type='hidden' name='update-id' value='$id'>";
        }  
    }
    else{
        $user = [];
    }
?>
    <label for="email">Epasts</label>
    <input type="text" name='email' value="<?= text(@$user['email']); ?>">
    <label for="username">Lietotājvārds</label>
    <input id='username' type="text" name='username' value="<?= text(@$user['username']); ?>">

    <button type='submit'>submit</button>
</form>


<?php

 //START
 if (
    array_key_exists('update-id', $_GET) &&
    is_numeric($_GET['update-id'])
) {
    $db->update($_GET['update-id'], $_GET['username'], $_GET['email']);
}
//END

    if (
        array_key_exists('username', $_GET) &&
        array_key_exists('email', $_GET) &&
        is_string($_GET['username']) &&
        is_string($_GET['email'])
    ) {
        $db->add(
        'users', 
            ['username' => @$_GET['username'],
            'email' => @$_GET['email']
            ]
        );
    }

    if(array_key_exists('delete', $_GET)){
        $id = (int) $_GET['delete'];
        $db->delete('users', $id);
    }

   

    foreach($db->getAll() as $row){
        echo "<p>";
        echo "<b>" . $row['id'] . "</b>";
        echo "username:" . text($row['username']);
        echo " email:" . text($row['email']);
        echo " <a href='?delete=" . $row['id'] . "'>delete</a>";
        echo " <a href='?update=" . $row['id'] . "'>update</a>";
        echo "</p>";
    }

    

    function text($string){
        return htmlentities($string);
    }

    
?>
</div>