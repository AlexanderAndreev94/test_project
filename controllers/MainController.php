<?php
/**
 * Created by PhpStorm.
 * User: alexander.andreev
 * Date: 28.06.2017
 * Time: 14:37
 */

namespace app\controllers;


use app\models\Category;
use app\models\Comment;
use app\models\LoginForm;
use app\models\Post;
use app\models\Postimage;
use app\models\UserIdentity;
use yii\web\Controller;
use yii;

class MainController extends  Controller
{
    public function actionRegistration()
    {
        $model = new UserIdentity();

        if(Yii::$app->request->isPjax)
        {
            $model->load(Yii::$app->request->post());
            $model->datetime_registration = date("Y-m-d H:i:s");
            $model->role = "user";
            $model->status = 1;

            $result = UserIdentity::find($model->username)->one();

            if($result->username != $model->username)
            {
                $model->save();

                $lmodel = new LoginForm();
                if ($lmodel->load(Yii::$app->request->post()) && $lmodel->login()) {
                    $session = Yii::$app->session;
                    if(!$session->isActive)
                    {
                        $session->open();
                        $session->set('username', $model->username);
                    }
                    return true;
                }
                /*
                */

                return $this->render('about');
            }
        }

        return false;
    }

    public function actionLogin()
    {/*
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }*/

        $model = new LoginForm();

        if(Yii::$app->request->isPjax)
        {
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return true;
            }
        }


        return false;
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->render('about');
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionHome()
    {
        $id=0;
        $session = Yii::$app->session;

        if(!$session->isActive)
        {
            $session->open();
        }
        else
        {
            $id = $session->get('lastPostId');
            $id++;
        }

        $post_model = new Post();

        $count = $post_model->find()->count();

      /*  $pub_date = $post_model->pub_date;
        $post_name = $post_model->title;
        $categ = $post_model->getCategory();
        $img = $post_model->getPostimages();
        $descr = $post_model->content;
*/

        //$articles = (new yii\db\Query())->select(['id','pub_date','title','content', 'category_id', 'status'])->from('Post')->limit(10)->offset($id)->all();
        $articles = $post_model->find()->limit(10)->offset($id)->all();
      /*  if(!empty($articles[9]['id']))
            $id = $articles[9]['id'];*/
        $session->set('lastPostId', $id);

        $categories = Category::find()->all();
    //    $c_count = count($categories);

        return $this->render('home', ['articles' => $articles, 'categories' => $categories]);
    }

    public function actionContact()
    {
        return $this->render('contact');
    }

    public function actionCatsort($id)
    {
        $articles = new Post();

        $art_sort = $articles->find()->where('category_id=:id',[':id'=>$id])->all();
        $categories = Category::find()->all();

        return $this->render('home', ['articles'=>$art_sort, 'categories' => $categories]);
    }

    public function actionShow($id)
    {
        $comments = new Comment();

        if(Yii::$app->request->isPjax)
        {
            $comments->load(Yii::$app->request->post());
            $comments->save();
        }

        $articles = new Post();

        $article = $articles->find()->where('id=:id', [':id'=>$id])->one();
        $img = new Postimage();
        $image = $img->find()->where('post_id=:id', [':id'=>$id])->one();


        $comments_ar = $comments->find()->where('post_id=:id', [':id'=>$id])->all();

        $user_id = Yii::$app->user->id;
        $users = new UserIdentity();

        $users = $users->find()->all();

        return $this->render('article', ['article'=>$article,'post_id'=>$id, 'users'=>$users, 'image' => $image, 'comments' => $comments_ar, 'user_id' => $user_id]);
    }

 /*   public function actionComment()
    {
        if(Yii::$app->request->isPjax)
        {
            $model = new Comment();

            $model->load(Yii::$app->request->post());
            $model->save();
        }
        return;
    }*/
}