<?php

    use yii\helpers\Html;
    use yii\widgets\Pjax;

    $this->title = 'Home';

//$count
///переделать выдачу постов. Сделать циклом по 10 статей
?>
<?php Pjax::begin(); ?>
    <div class="articleContainer">
<?php
    //$art_sort
    foreach($articles as $article)
    {
        echo '

                <div class="article">
                    <div class="articleHeader">
                        <div class="name">
                            <p>'.Html::a($article->title, 'index.php?r=main/show&id='.$article->id).'</p>
                        </div>
                        <div class="postDate">
                            <p>'.$article->pub_date.'</p>
                        </div>
                    </div>
                </div>

        ';
    }

?>
    <div class="nextBtn">
        <?= Html::a("Next 10 posts", ['main/home'], ['class' => 'btn btn-lg btn-primary']);
        ?>
    </div>
    </div>



<div class="catTree">
    <div class="treeHeader"><h3>Categories</h3></div>
    <div class="catList">

        <?php

        foreach($categories as $category)
        {
            if($category->status = 'active')
                echo '<div class="catItem">'.Html::a($category->title, "index.php?r=main/catsort&id=".$category->id).'</div>';
        }


        ?>

    </div>
</div>
<?php Pjax::end(); ?>