<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use app\models\UserIdentity;
use \yii\widgets\ActiveForm;
use \yii\bootstrap\Modal;
use \yii\widgets\Pjax;

AppAsset::register($this);
?>
<?php $this->beginPage()?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title><?= Html::encode($this->title) ?></title>
    <?= Html::csrfMetaTags() ?>
    <?php $this->head(); ?>
</head>
<body>
<?php $this->beginBody(); ?>
<div class="wrapper">
    <div class="head"><h1>My Web Application</h1></div>
    <div class="menuBar">

        <?php
        use \yii\bootstrap\NavBar;
        NavBar::begin([
            'options' => [
                'class' => 'menuBar',
            ],
        ]);
        use \yii\bootstrap\Nav;
        $userModel = new UserIdentity();
        $user = $userModel->find()->where('id=:id',[':id'=>Yii::$app->user->id])->one();
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-left'],
            'items' => [
                ['label' => 'Home', 'url' => ['/main/home'],],
                ['label' => 'About', 'url' => ['/main/about']],
                ['label' => 'Contact', 'url' => ['/main/contact']],
                Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'options' => ['id'=>'loginLink', 'data-toggle' => 'modal', 'data-target' => '#loginModal']]
                ) : (
                    '<li>'
                    . Html::beginForm(['/main/logout'], 'post')
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
                ),
                ['label' => 'Registration', 'options' => ['id'=>'regLink', 'data-toggle'=>'modal', 'data-target'=>'#regModal']],
                $user->role == 'admin' ? (['label' => 'Admin', 'url'=>['admin/index']]) : (['label'=>'']),
            ],
        ]);
        NavBar::end();

        ?>
    </div>
    <div class="content">
        <?php

            /*Reg*/
        Pjax::begin();
            Modal::begin([
                'header' => 'Register new user',
                'id'=>'regModal'
            ]);

            $model = new UserIdentity();

            $form = \yii\widgets\ActiveForm::begin([
                'id' => 'regForm', 'action' => ['main/registration'], 'method' => 'post',
                'options' => ['data-pjax' => true,'enctype' => 'multipart/form-data']
            ]);

            echo $form->field($model, 'username')->textInput(['id'=>'uname']);
            echo $form->field($model, 'email')->textInput(['id'=>'email']);
            echo $form->field($model, 'password')->passwordInput(['id'=>'pw']);
            echo $form->field($model, 'captcha')->widget(\yii\captcha\Captcha::className());

        //    echo Html::button('Register', ['id'=>'regButton', 'class'=>'btn btn-success',]);
            echo Html::submitButton('Register', ['id'=>'regButton', 'class'=>'btn btn-success',]);
            ActiveForm::end();

            Modal::end();
        Pjax::end();

        /*Login*/
            Pjax::begin();
            Modal::begin([
                'header'=>'Login',
                'id'=>'loginModal'
            ]);

            $loginModel = new \app\models\LoginForm();

            $form = ActiveForm::begin([
                'id' => 'LoginForm', 'action' => ['main/login'], 'method' => 'post',
                'options' => ['data-pjax' => true,'enctype' => 'multipart/form-data']
            ]);
            echo $form->field($loginModel, 'username')->textInput(['id'=>'unameL']);
            echo $form->field($loginModel, 'password')->passwordInput(['id'=>'pwL']);
            echo Html::submitButton('Login', ['id'=>'loginButton', 'class'=>'btn btn-success',]);
            ActiveForm::end();
            Modal::end();
            Pjax::end();
        ?>
        <?= $content ?>
    </div>
    <div class="footer">
        <div class="fcontent">
            <p>Copyright &copy; 2017 by MyCompany.</p>
            <p>All Rights Reserved.</p>
            <p>Powered by <?php echo Html::a('YII Framework', 'http://www.yiiframework.com');?></p>
        </div>
    </div>
</div>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>