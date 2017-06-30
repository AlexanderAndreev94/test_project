<?php
use  \yii\widgets\Pjax;
use \yii\widgets\ActiveForm;
use \yii\helpers\Html;

    //$this->registerJsFile('@web/js/jquery-1.4.3.min.js');
?>
<div class="oneArticle">
    <?php Pjax::begin(); ?>
    <div class="article">
        <div class="articleTitle">
            <h1><?=$this->title;?></h1>
        </div>

        <div class="articleImage">
            <?php
                $js = <<<JS

                        $("a#single_image").fancybox({
                            'overlayShow' : true,
                            'transitionIn' : 'elastic',
                            'transitionOut' : 'elastic',
                            'hideOnContentClick' : true
                        });

JS;
                $this->registerJs($js);
            ?>
            <a id="single_image" href="<?= 'uploads/'.$image->image; ?>"><img src="<?= 'uploads/'.$image->image; ?>" alt=""/></a>
        </div>
        <div class="articleContent">
            <p>
                <?=$article->content;?>
            </p>
        </div>
        <div class="articleComments">
            <div class="commentHeader">
                <h3>Comments</h3>
            </div>

            <?php
                if(!empty($comments))
                {
                    $umodel = new \app\models\UserIdentity();

                    foreach($comments as $comment)
                    {
                        if($comment->status == 'active')
                        {
                            $user = $umodel->find()->where('id=:id', [':id'=>$comment->user_id])->one();
                            echo '
                                <div class="commentBody" style="border: none;
                                                                border-radius: 5px;
                                                                background: lightgreen;
                                                                color: white;
                                                                text-align:left;
                                                                box-sizing: border-box;
                                                                padding-left: 10px;
                                                                height:40px;
                                                                margin-bottom: 5px;">
                                    <div class="user">'.$user->username.' said:'.'</div>
                                    <div class="comment">'.$comment->content.'</div>
                                </div>
                            ';
                        }

                    }
                }
            ?>

            <div class="commentForm">
                <?php

                use \yii\helpers\Url;

                    if(Yii::$app->user->id != 0)
                    {



                        $model = new \app\models\Comment();

                        $action = 'main/show&id='.$post_id;
                        $form = ActiveForm::begin([
                            'id' => 'commentForm', 'action' => [$action], 'method' => 'post',
                            'options' => ['data-pjax' => '1', 'enctype' => 'multipart/form-data']
                        ]);
                        echo $form->field($model, 'content')->textarea(['id'=>'commentInput', 'rows'=>4]);
                        echo $form->field($model, 'post_id')->textInput(['value'=>$post_id, 'id'=>'postid']);
                        echo $form->field($model, 'user_id')->textInput(['value'=>$user_id, 'id'=> 'uid']);
                        echo $form->field($model, 'date_created')->textInput(['value'=>date('Y:m:d'), 'id'=>'date']);
                        echo $form->field($model, 'status')->textInput(['value'=>'active', 'id'=>'status']);
                      //  echo \yii\helpers\Html::submitButton('Send', ['id'=>'commentButton', 'class'=>'btn btn-success',]);
                       echo Html::a("Comment", Url::to(['main/show', 'id'=>$post_id]), ['class' => 'btn btn-lg btn-primary']);
                        ActiveForm::end();
                    }

                ?>
            </div>



        </div>
    </div>
    <?php Pjax::end();?>
</div>



