<?php
/**
 * Created by PhpStorm.
 * User: alexander.andreev
 * Date: 29.06.2017
 * Time: 16:43
 */

namespace app\controllers;

use app\models\Category;
use app\models\Comment;
use app\models\Post;
use app\models\Postimage;
use app\models\UploadForm;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii;

class AdminController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $data =  Yii::$app->request->post();
            $model->postid = $_POST['postid'];
            if ($model->upload()) {
                // file is uploaded successfully
                return $this->render('upload', ['model' => $model]);
            }
        }

        return $this->render('upload', ['model' => $model]);
    }

    public function actionShow($id)
    {
        if($id == 1)
        {
            $model = new Category();
            $cats = $model->find()->all();

            return $this->render('index', ['id' => $id, 'categories' => $cats]);
        }
        if($id == 2)
        {
            $pmodel = new Post();
            $posts = $pmodel->find()->all();

            $cmodel = new Category();

            return $this->render('index', ['id' => $id, 'posts' => $posts, 'categories' => $cmodel]);
        }
        if($id == 3)
        {
            $pmodel = new Post();
            $posts = $pmodel->find()->all();

            return $this->render('index', ['id' => $id, 'posts'=>$posts]);
        }
    }

    public function actionEdit($id, $param)
    {
        if($param == 'd')
        {
           $post = Post::findOne($id);
            $post->delete();
        }
        if($param == 'e')
        {
            $model = new Post();
            $model->load(Yii::$app->request->post());
            $model->save();
        }

    }

    public function actionAdd()
    {
        $model = new Post();

        if(Yii::$app->request->isPost)
        {
            $model->load(Yii::$app->request->post());
            $model->save();
        }
        return $this->render('index');
    }

    public function actionEditcomment()
    {
        $model = new Comment();

        if(Yii::$app->request->post())
        {
            $model->load(Yii::$app->request->post());
            $model->save();
        }
        return $this->render('index');
    }
}