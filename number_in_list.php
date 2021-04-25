<link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
<a href="index.php">Main</a>
<a href="message.php">Message</a>


<div class="container">
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (file_exists('input.json')) {
    $content = file_get_contents('input.json');
    $input = json_decode($content, true);

    if (is_array($input)) {

        ?>
        <table>
        <tr>
            <th>firstConditionTest</th>
            <th>secondConditionTest</th>
            <th>thirdConditionTest</th>
            <th>fourthConditionTest</th>

        </tr>
        <?php

        foreach ($input as $array) {
            echo "<tr>";
            
            echo "<td>";
            firstConditionTest($array);
            echo "</td>";

            echo "<td>";
            secondConditionTest($array);
            echo "</td>";

            echo "<td>";
            thirdConditionTest($array);
            echo "</td>";

            echo "<td>";
            fourthConditionTest($array);
            echo "</td>";

            echo "<td>";
            fifthConditionTest($array);
            echo "</td>";

            echo "</tr>";
        }

        echo "</table>";
    }
}




function firstConditionTest($array) {
    $size = count($array);

    for ($i = 0; $i < $size; $i++) {
        if ($size == $array[$i]) {
            echo $size;
            return;
        }
    }
    echo 'FALSE';
}


function secondConditionTest($array) {
    $count = count($array);
    for ($k = 0; $k < $count - 1; $k++) {
        for ($i = $k + 1; $i < $count; $i++) {
            $v1 = $array[$k];
            $v2 = $array[$i];
            $sum = $v1 + $v2;
            if (in_array($sum, $array)) {
                echo $v1 . "+" . $v2 . " = " . $sum;
                return;
            }
        }
    }

    echo "FALSE";

    /*
    Divu skaitļu summa ir vienāda ar citu skaitli;
    $array = [1, -2, 5, 10, 3, 1, 90, -3];
    (1 + (-3) === (-2)) == TRUE
    return -2;
    */

}


function thirdConditionTest($array) {
    $count = count($array);
    sort($array);
    $last_diff = false;
    for ($i = 0; $i <= $count - 2; $i++) {
        $diff = $array[$i + 1] - $array[$i];
        if ($last_diff === false) {
            $last_diff = $diff;
        }
        elseif ($last_diff !== $diff) {
                echo "FALSE";
                return;
            }
    }

    echo $last_diff;


    /*
    vai skaitļu pieaugums ir vienāds???!!????
    [-3, 0, 3, 6, 9] == true
    [-3, 1, 3, 6, 9] == false
    [-3, 9, -6, 0, 9, 3] == true
    [-2, 0, 2, 4, 6] == true

    $array = [-3, 9, -6, 0, 9, 3];
    sort($array);

    $array === [-6, -3, 0, 3, 6, 9];
    -3 - -6 = 3;
    0 - -3 = 3;
    3 - 0 = 3;
    6 - 3 = 3;
    9 - 6 = 3;
    */

}

function fourthConditionTest($array) {

    $count = count($array);
    for ($i = 0; $i <= $count-1; $i++){
        $v1 = $array[$i];
        for ($k = 0; $k <= $count-1; $k++){
            $v2 = $array[$k];
            for($j = 0; $j <= $count-1; $j++){
                $v3 = $array[$j];
                $sum = $v1 + $v2 + $v3;
                if($sum === $count){
                    echo $v1 . "+" . $v2 . "+" . $v3 . " = " . $sum;
                    return;
                }
            }
        }
    }

    echo "FALSE";

    /*
     Vai trīs skaitļu summa ir vienāda ar skaitļu daudzmu
        $array = [1, 3, 4, 10, 3, 90, 2];
        $array[0] + $array[1] + $array[4] === count($array);
        1 + 3 + 3 === 7;
    */

}


function fifthConditionTest($array) {

    //start of the getFiboNumbers(fiboarray)
    $count = count($array);
    sort($array);
    $fibo = [1];
    $current = 1;
    $previous = 0;
    for ($i = 0; $i < $count - 1; $i++) {
        $current = $current + $previous;
        $previous = $current - $previous;
        array_push($fibo, $current);
    } //end of getFiboNumbers
    
    //compare the two arrays
    sort($array);
    $placeholder = true;
    for($i=0; $i<$count; $i++){
        if($array[$i] !== $fibo[$i]){
            $placeholder = false;
        }
    }
    //making the result look clean in the table
    if($count===0){
        echo" false <br>";
    }
    else if($placeholder){
        echo " true <br>";
    } else {
        echo" false <br>";
    }     
}



?>
</div>



    // Vai skaitļus var sarindot fibonačī virknē?

    /*
        1, 1, 2, 3, 5, 8, 13, ...

    */