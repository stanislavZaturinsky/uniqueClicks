<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $news \app\models\News[] */
/* @var $newHashCode string */

$this->title = 'News';
$this->registerJsFile('@web/js/news.js', ['depends' => 'yii\web\JqueryAsset']);
?>
<div class="news-index">

    <?= Html::hiddenInput('new-hash-code', $newHashCode) ?>
    <div class="row">

        <?php if (!$news): ?>
            <h2 class="col-md-9 col-md-offset-5">News don't exist</h2>
        <?php endif ?>

        <?php foreach ($news as $key => $item): ?>

            <div class="col-lg-4">
                <h2><?= $item->title ?></h2>

                <p><?= $item->content ?></p>

                <p>
                    <a class       ="btn btn-primary js-new"
                       data-news-id="<?= $item->id ?>"
                       href        ="<?= Url::to('/news/' . $item->id) ?>">Read more
                    </a>
                </p>
            </div>

        <?php endforeach ?>

    </div>

</div>