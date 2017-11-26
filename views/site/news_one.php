<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $news \app\models\News */

$this->title = 'News';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <p><a class="btn btn-primary" href="<?= Url::to('/news') ?>">Back</a></p>

    <div class="row">

        <div class="row-lg-4">
            <h2 class="col-md-9 col-md-offset-5"><?= $news->title ?></h2>

            <p><?= $news->content ?></p>

        </div>

    </div>

</div>
