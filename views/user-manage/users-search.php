<?php
use yii\widgets\Pjax;
?>
    <?php Pjax::begin(['id' => 'transactions']) ?>
        <?php
                foreach($users as $user){
                    echo $user->email;
                    echo '<br>';
                }
        ?>
    <?php Pjax::end(); ?>
