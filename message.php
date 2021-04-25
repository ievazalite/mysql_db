<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>

<!DOCTYPE html>
<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
<a href="index.php">Main</a>
<a href="number_in_list.php">Number in List</a>

<?php

include 'DB.php';
$db = new DB('localhost', 'root', 'root', 'mysql_db');
$db->fetchAll('messages');

 
if(array_key_exists('update', $_GET)){
    $id = $_GET['update'];
    $user = $db->find($id);
    if($user !== []){
        echo "<h3 class='updatenotice'> <a href='/'>&lt;-</a> Atjaunināt ierakstu ar id $id </h3>";
        echo "<input type='hidden' name='update-id' value='$id'>";
    }  
}
else{
    $user = [];
}

?>

<div class="container">
<form action="">

    <label for="email">Epasts</label>
    <input type="text" name='email' id='email' value="<?= text(@$message['email']); ?>">
    <label for="phone">Telefona numurs</label>
    <input type="text" name='phone' id='phone' value="<?= text(@$message['phone']); ?>">
    <label for="description">Apraksts</label>
    <input type="text" name='description' id='description' value="<?= text(@$message['description']); ?>">

    <button type="submit">submit</button>

</form>


<?php

    if (
        array_key_exists('update-id', $_GET) &&
        is_numeric($_GET['update-id'])
        ) {
    $db->update($_GET['update-id'], $_GET['email'], $_GET['phone'], $_GET['description']);
        }

    print_r($_GET);
    if (
        array_key_exists('email', $_GET) &&
        array_key_exists('phone', $_GET) &&
        array_key_exists('description', $_GET) &&
        is_string($_GET['email']) &&
        is_string($_GET['phone']) &&
        is_string($_GET['description'])
    ) {
        $db->add(
            'messages',
            [
                'email' => $_GET['email'],
                'phone' => $_GET['phone'],
                'description' => $_GET['description']
            ]
        );
    };


    if(array_key_exists('delete', $_GET)){
        $id = (int) $_GET['delete'];
        $db->delete('messages', $id);
    }

    foreach($db->getAll() as $row){
        echo "<p>";
        echo "<b>" . $row['id'] . "</b>";
        echo "email:" . text($row['email']);
        echo " phone:" . text($row['phone']);
        echo " description:" . text($row['description']);
        echo " <a href='?delete=" . $row['id'] . "'>delete</a>";
        echo " <a href='?update=" . $row['id'] . "'>update</a>";
        echo "</p>";
    }

    function text($string){
        return htmlentities($string);
    }


?>

</div>