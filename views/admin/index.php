<?php
    use yii\helpers\Html;
    use yii\widgets\Pjax;
    use \yii\bootstrap\Modal;
    use \yii\widgets\ActiveForm;

   echo $this->title;
?>
<div class="adminContainer">
    <?php Pjax::begin();?>
    <div class="left">
        <div>Categories, posts and comments page</div>
        <?php
            if(isset($id))
            {
                if($id == 1)
                {
                    foreach($categories as $category)
                    {
                        echo '
                            <div>'.$category->title.'</div>
                    ';
                    }
                }
                if($id == 2)
                {

                    foreach($posts as $post)
                    {
                        $cat = $categories->find()->where('id=:id', [':id'=>$post->category_id])->one();
                        echo '
                            <div style="border: 1px solid; border-radius: 5px; width: 200px; height: 50px; margin-top: 10px; box-sizing: border-box; padding-left: 5px;">
                                <p>'.'Title: '.$post->title.'</p>
                                <p>'.'Category: '.$cat->title.' '.Html::a("Edit", "admin/edit&id=".$post->id."&param=e", ['id'=>'editLink', 'data-toggle' => 'modal', 'data-target' => '#editPostModal']).' '.Html::a("Delete", "admin/edit&id=".$post->id."&param=d").'</p>

                            </div>
                        ';

                        Modal::begin([
                            'header'=>'Edit post',
                            'id' => 'editPostModal'
                        ]);

                        $form = ActiveForm::begin(
                            [
                                'id' => 'editPostForm', 'action' => ['admin/edit&id='.$post->id.'&param=e'], 'method' => 'post',
                                //      'options' => ['data-pjax' => true,'enctype' => 'multipart/form-data']
                            ]
                        );

                        echo $form->field($post, 'id')->textInput()->label('postId');
                        echo $form->field($post, 'title')->textInput()->label('title');
                        echo $form->field($post, 'content')->textarea(['rows'=>4])->label('content');
                        echo $form->field($post, 'status')->textInput()->label('status');
                        echo Html::submitButton('Edit', ['class'=>'btn btn-success']);
                        ActiveForm::end();
                        Modal::end();
                    }

                    ;


                }
                if($id == 3)
                {
                    foreach($posts as $post)
                    {
                        echo '
                            <div style="border: 1px solid; border-radius: 5px; width: 200px; height: 50px; margin-top: 10px; box-sizing: border-box; padding-left: 5px;">
                                <p>'.'Title: '.$post->title.'</p>
                                <p>'.Html::a("Edit comments", "", ['id'=>'editCommentLink', 'data-toggle' => 'modal', 'data-target' => '#editCommentsModal']).'</p>

                            </div>
                        ';
                        $commentModel = new \app\models\Comment();
                        Modal::begin([
                            'header'=>'Edit comments',
                            'id' => 'editCommentsModal'
                        ]);

                        $form = ActiveForm::begin(
                            [
                                'id' => 'editPostForm', 'action' => ['admin/editcomment'], 'method' => 'post',
                                //      'options' => ['data-pjax' => true,'enctype' => 'multipart/form-data']
                            ]
                        );

                        echo $form->field($commentModel, 'id')->textInput()->label('comment ID');
                        echo $form->field($commentModel, 'post_id')->textInput(['value'=>$post->id])->label('Post ID');
                        echo $form->field($commentModel, 'content')->textarea(['rows'=>4])->label('content');
                        echo $form->field($commentModel, 'date_created')->textInput()->label('comment creation date');
                        echo $form->field($commentModel, 'status')->textInput()->label('status');
                        echo Html::submitButton('Edit', ['class'=>'btn btn-success']);
                        ActiveForm::end();
                        Modal::end();
                    }
                }
            }

        ?>
    </div>
    <div class="right">
        <div><?= Html::a('Categories', 'index.php?r=admin/show&id=1'); ?></div>
        <div><?= Html::a('Edit posts', 'index.php?r=admin/show&id=2'); ?></div>
        <?php
            if(isset($id))
            {
                if($id == 2)
                {
                    echo '<div style="text-align:center;">'.Html::a('Add new post', '#', ['id'=>'editLink', 'data-toggle' => 'modal', 'data-target' => '#addPostModal']).'</div>';

                    $model = new \app\models\Post();
                    Modal::begin([
                        'header'=>'Edit post',
                        'id' => 'addPostModal'
                    ]);

                    $form = ActiveForm::begin(
                        [
                            'id' => 'addPostForm', 'action' => ['admin/add'], 'method' => 'post',
                            //      'options' => ['data-pjax' => true,'enctype' => 'multipart/form-data']
                        ]
                    );

                    echo $form->field($model, 'title')->textInput()->label('title');
                    echo $form->field($model, 'content')->textarea(['rows'=>4])->label('content');
                    echo $form->field($model, 'category_id')->textInput()->label('category id');
                    echo $form->field($model, 'status')->textInput()->label('status');
                    echo $form->field($model, 'pub_date')->textInput(['value'=>date('Y:m:d')])->label('publication date');
                    echo Html::submitButton('Edit', ['class'=>'btn btn-success']);
                    ActiveForm::end();
                    Modal::end();
                }
            }
        ?>
        <div><?= Html::a('Edit comments', 'index.php?r=admin/show&id=3'); ?></div>
    </div>
    <?php Pjax::end();?>
</div>


