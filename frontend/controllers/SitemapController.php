<?php

namespace frontend\controllers;

use frontend\models\Article;
use frontend\models\ArticleCategory;
use frontend\models\Product;
use frontend\models\ProductCategory;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SitemapController extends BaseController
{
    public $layout;
    
    public function actionIndex()
    {
        $items = [];
        $article_categories = ArticleCategory::find()->where(['parent_id' => null])->allActive();
        foreach ($article_categories as $item) {
            $items[] = Url::to(['sitemap/article', \common\models\PageGroup::URL_SLUG => $item->slug], true);
        }
        $items[] = Url::to(['sitemap/tag'], true);
        
        Yii::$app->response->format = Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml; charset=utf-8');
        $this->layout = false;
        
        return $this->render('index', [
            'items' => $items
        ]);
    }
    
    public function actionArticle()
    {
        $slug = Yii::$app->request->get(\frontend\models\PageGroup::URL_SLUG, '');
        if ($article_category = ArticleCategory::find()->where(['slug' => $slug])->oneActive()) {
            
            $home = ['url' => Url::home(true), 'img' => ''];
            
            $parent = null;
            
            $category = ['url' => $article_category->getLink(), 'img' => $article_category->getImage()];
            
            $children_categories = $article_category->getAllChildren()->allActive();
            $children = [];
            foreach ($children_categories as $item) {
                $children[] = ['url' => $item->getLink(), 'img' => $item->getImage()];
            }
            
            $articles = $article_category->getAllArticles()->allPublished();
            $items = [];
            foreach ($articles as $item) {
                $items[] = ['url' => $item->getLink(), 'img' => $item->getImage()];
            }

            Yii::$app->response->format = Response::FORMAT_RAW;
            $headers = Yii::$app->response->headers;
            $headers->add('Content-Type', 'text/xml; charset=utf-8');
            $this->layout = false;

            return $this->render('details', [
                'home' => $home,
                'parent' => $parent,
                'category' => $category,
                'children' => $children,
                'items' => $items,
            ]);
        } else {
            throw new NotFoundHttpException;
        }
    }
    
    public function actionTag()
    {
        $home = ['url' => Url::home(true), 'img' => ''];
        
        $category = null;
        $parent = null;
        $children = [];

        $items = [];
        $tags = \frontend\models\Tag::find()->allActive();
        foreach ($tags as $item) {
            $items[] = ['url' => $item->getLink(), 'img' => $item->getImage()];
        }
        
        Yii::$app->response->format = Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml; charset=utf-8');
        $this->layout = false;

        return $this->render('details', [
            'home' => $home,
            'parent' => $parent,
            'category' => $category,
            'children' => $children,
            'items' => $items,
        ]);
    }


//    public function actionIndex()
//    {
//        $items = [];
//        $article_categories = ArticleCategory::find()->where('id in (select article_category_id from ' . Article::tableName() . ')')->allActive();
//        foreach ($article_categories as $item) {
//            $items[] = Url::to(['sitemap/article', \common\models\PageGroup::URL_SLUG => $item->slug], true);
//        }
//        
//        Yii::$app->response->format = Response::FORMAT_RAW;
//        $headers = Yii::$app->response->headers;
//        $headers->add('Content-Type', 'text/xml; charset=utf-8');
//        $this->layout = false;
//        
//        return $this->render('index', [
//            'items' => $items
//        ]);
//    }
//    public function actionArticle()
//    {
//        $slug = Yii::$app->request->get(\frontend\models\PageGroup::URL_SLUG, '');
//        if ($article_category = ArticleCategory::find()->where(['slug' => $slug])->oneActive()) {
//            $home = ['url' => Url::home(true), 'img' => ''];
//            if ($parent = $article_category->parent) {
//                $parent = ['url' => $parent->getLink(), 'img' => $parent->getImage()];
//            } else {
//                $parent = null;
//            }
//            $category = ['url' => $article_category->getLink(), 'img' => $article_category->getImage()];
//            $articles = $article_category->getArticles()->allPublished();
//            $items = [];
//            foreach ($articles as $item) {
//                $items[] = ['url' => $item->getLink(), 'img' => $item->getImage()];
//            }
//
//            Yii::$app->response->format = Response::FORMAT_RAW;
//            $headers = Yii::$app->response->headers;
//            $headers->add('Content-Type', 'text/xml; charset=utf-8');
//            $this->layout = false;
//
//            return $this->render('details', [
//                'home' => $home,
//                'parent' => $parent,
//                'category' => $category,
//                'items' => $items,
//            ]);
//        } else {
//            throw new NotFoundHttpException;
//        }
//    }
}
