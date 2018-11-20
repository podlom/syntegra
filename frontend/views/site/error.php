<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
$title = Yii::t('app', 'Home');
?>
    <section class="underhead underhead_type_error">
        <div class="wrap wrap_size_large">
            <div class="breadcrumbs">
                <ul>
                    <li><a href="/"><?=$title;?></a></li>
                </ul>
            </div>
            <h3 class="underhead__title wow fadeInLeft">404</h3>
        </div>
    </section>




<section class="section-err-cont">
    <div class="wrap wrap_size_large">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>
            The above error occurred while the Web server was processing your request.
        </p>
        <p>
            Please contact us if you think this is a server error. Thank you.
        </p>
    </div>
</section>
<?php
echo $this->render('/site/footer');