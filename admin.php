<?php
require_once 'dtb/dtb.php';
$groups = [];
if ($result = mysqli_query($conn, "SELECT FROM group_student", MYSQLI_USE_RESULT)) {

    /* Важно заметить, что мы не можем вызывать функции, которые взаимодействуют
       с сервером, пока не закроем результирующий набор. Все подобные вызовы
       будут вызывать ошибку 'out of sync' */
    if (!mysqli_query($link, "SET @a:='this will not work'")) {
        printf("Ошибка: %s\n", mysqli_error($link));
    }
    mysqli_free_result($result);
}
if(isset($_POST['users'])){
    foreach($_POST['users'] as $user)
    {
        $sql = "INSERT INTO `student`(`NAME`, `LAST_NAME`, `MIDDLE_NAME`, `GROUP_STUDENT_ID`) VALUES ({$user['name']}, {$user['last']}, {$user['middle']}, {$user['group_id']})";
        mysqli_query($conn, $sql);
    }
}

?>

<form action="">
    <select name="" id="">
        <?php foreach($result as $group):
            var_dump($group);?>
            <option value="<?php echo $group['ID']; ?>"><?php echo $group['NAME']; ?></option>
        <?php endforeach; ?>
    </select>
    <input type="text">
</form>