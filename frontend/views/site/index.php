<?php

use frontend\models\Article;
use yii\helpers\Url;

?>
<div class="col-l">
    <div class="slider clearfix">
        <?php
        if (isset($hot_items[0])) {
        ?>
        <div class="slide_left">
            <div class="flex_viewport">
                <div class="cover">
                    <?= $hot_items[0]->a([], $hot_items[0]->img([], Article::IMAGE_HUGE)) ?>
                </div>
                <span class="desc">
                    <h2 class="title-news"><?= $hot_items[0]->a([], "<strong>{$hot_items[0]->name}</strong>") ?></h2>
                    <p class="desc"><?= $hot_items[0]->desc() ?></p>
                </span>
            </div>
        </div>
        <div class="slide_right list-news-other">
            <ul class="list list-unstyle">
                <?php
                $i = 0;
                foreach (array_slice($hot_items, 1, 8) as $item) {
                    $i++;
                ?>
                <li class="clearfix">
                    <?php
                    if ($i == 1) {
                    ?>
                    <img src="<?= Url::home(true) ?>/images/hot-icon.gif">
                    <?php
                    }
                    ?>
                    <?= $item->a([], "<strong>$item->name</strong>") ?>
                <?php
                }
                ?>
            </ul>
        </div>
        <?php
        }
        ?>
    </div>
    <?= $this->render('//modules/adsense') ?>
    <section class="categories">
        <?php
        foreach ($hot_categories as $category) {
        ?>
        <div class="listArticles clearfix">
            <h3 class="title">
                <?= $category->a([], "<strong>$category->name</strong>") ?>
            </h3>
            <div class="row-fluid clearfix">
                <?php
                $articles = $category->getAllArticles()->orderBy('published_at desc')->limit(4)->allPublished();
                ?>
                <?php
                if (isset($articles[0])) {
                ?>
                <div class="col6 fl">
                    <article class="post">
                        <h2 class="title-news">
                            <?= $articles[0]->a([], "<strong>{$articles[0]->name}</strong>") ?>
                        </h2>
                        <?= $articles[0]->a(['class' => 'cover'], $articles[0]->img([], Article::IMAGE_LARGE)) ?>
                        <p class="desc">
                            <?= $articles[0]->desc() ?>
                        </p>
                    </article>
                </div>
                <div class="list-news-other">
                    <ul class="list_col list-unstyle">
                        <?php
                        foreach (array_slice($articles, 1, 3) as $item) {
                        ?>
                        <li class="thumb clearfix">
                            <h3 class="title-news"><?= $item->a([], "<strong>$item->name</strong>") ?></h3>
                            <?= $item->a(['class' => 'cover'], $item->img([], Article::IMAGE_TINY)) ?>
                            <p class="desc">
                                <?= $item->desc() ?>
                            </p>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
        <?php
        }
        ?>
    </section>
</div>
