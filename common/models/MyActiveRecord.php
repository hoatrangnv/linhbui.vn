<?php

namespace common\models;
use common\utils\StringUtils;
use common\utils\FileUtils;
use Yii;
use yii\db\ActiveRecord;

class MyActiveRecord extends ActiveRecord {
    const IMAGE_HUGE = '600x600';
    const IMAGE_LARGE = '500x500';
    const IMAGE_MEDIUM = '350x350';
    const IMAGE_SMALL = '230x230';
    const IMAGE_TINY = '120x120';
    
    const BANNER_HUGE = '900x900';
    const BANNER_LARGE = '750x750';
    const BANNER_MEDIUM = '450x450';
//    const BANNER_SMALL = '120x120';
//    const BANNER_TINY = '60x60';
    
    public static $image_resizes = [
        'huge' => self::IMAGE_HUGE,
        'large' => self::IMAGE_LARGE,
        'medium' => self::IMAGE_MEDIUM,
        'small' => self::IMAGE_SMALL,
        'tiny' => self::IMAGE_TINY,
    ];
    
    public static $banner_resizes = [
        'huge' => self::BANNER_HUGE,
        'large' => self::BANNER_LARGE,
        'medium' => self::BANNER_MEDIUM,
//        'small' => self::BANNER_SMALL,
//        'tiny' => self::BANNER_TINY,
    ];
    
    /** 
   * function ->getImage ($suffix, $refresh) 
   */ 
   public $_image; 
   public function getImage($suffix = null, $refresh = false) 
   { 
       if ($this->_image === null || $refresh == true) { 
           $this->_image = FileUtils::getImage([ 
               'imageName' => $this->image, 
               'imagePath' => $this->image_path, 
               'imagesFolder' => Yii::$app->params['images_folder'], 
               'imagesUrl' => Yii::$app->params['images_url'], 
               'suffix' => $suffix, 
               'defaultImage' => Yii::$app->params['default_image'] 
           ]); 
       } 
       return $this->_image; 
   }
        
    /**
    * function ->getBanner ($suffix, $refresh)
    */
    public $_banner;
    public function getBanner($suffix = null, $refresh = false)
    {
        if ($this->_banner === null || $refresh == true) {
            $this->_banner = FileUtils::getImage([
                'imageName' => $this->banner,
                'imagePath' => $this->image_path,
                'imagesFolder' => Yii::$app->params['images_folder'],
                'imagesUrl' => Yii::$app->params['images_url'],
                'suffix' => $suffix,
                'defaultImage' => Yii::$app->params['default_image']
            ]);
        }
        return $this->_banner;
    }
    
    public $a = '';

    public function a($params = [], $content = null)
    {
        $result = "<a href=\"{$this->getLink()}\" title=\"" . str_replace("\"", "'", $this->name) . "\"";
        if (is_array($params)) {
            foreach ($params as $attr => $val) {
                if ($attr == 0) {
                    $result .= "class=\"$val\"";
                } else if ($attr == 1) {
                    $result .= "id=\"$val\"";
                } else {
                    $result .= $attr . "=\"$val\"";
                }
            }
        } else if ($params != '') {
            $result .= "class=\"$params\"";
        }
        if ($content !== null) {
            $result .= ">$content</a>";
        } else {
            $result .= ">$this->name</a>";
        }
        return $result;
    }
    
    public $img = '';

    public function img($params = [], $suffix = null)
    {
        $result = "<img title=\"" . str_replace("\"", "'", $this->name) . "\" alt=\"" . str_replace("\"", "'", $this->name) . "\"";
        $has_src = false;
        if (is_array($params)) {
            foreach ($params as $attr => $val) {
//                if ($attr == 0) {
//                    $result .= "class=\"$val\"";
//                } else if ($attr == 1) {
//                    $result .= "id=\"$val\"";
//                } else {
                    $result .= "$attr=\"$val\"";
//                }
                if ($attr == 'src') {
                    $has_src = true;
                }
            }
        } else if ($params != '') {
            $result .= "class=\"$params\"";
        }
        if (!$has_src) {
            if ($suffix !== null) {
                $result .= "src=\"{$this->getImage($suffix, true)}\">";
            } else {
                $result .= "src=\"{$this->getImage()}\">";
            }
        } else {
            $result .= ">";
        }
        return $result;
    }

    public function banner($params = [], $suffix = null)
    {
        if ($suffix !== null) {
            $params['src'] = $this->getBanner($suffix, true);
        } else {
            $params['src'] = $this->getBanner();
        }
        return $this->img($params);
    }
    
    public function auth()
    {
        $user = User::find()->where(['username' => $this->created_by])->one();
        if ($user) {
            return $user->alias;
        }
        return 'Admin';
    }
    
    public function desc($column = 'description', $length = 40)
    {
        return StringUtils::summaryText($this->$column, $length, ' [...]');
    }
    
    public function date( $format = 'd-m-Y H:i', $column = 'published_at')
    {
        return date($format, $this->$column);
    }
    
    public function contentWithAdsense($adsense, $number = 2, $str_find = '</p>')
    {
        $content = $this->content;
        $length = strlen($content);
        
        for ($i = 1; $i <= $number; $i++) {
            $start = (int) floor(($length / $number) * ($i - 0.75));
            $pos = strpos($content, $str_find, $start);
            $content = substr_replace($content, "$str_find $adsense", $pos, strlen($str_find));
        }
        
        return $content;
    }
    
    /** 
    * @inheritdoc 
    * @return ArticleQuery the active query used by this AR class. 
    */ 
    public static function find() 
    {
        return new MyActiveQuery(get_called_class());
    }
    
    public function getAllChildren()
    {
        $allChildren = $this->children;
        foreach ($allChildren as $item) {
            $allChildren = array_merge($allChildren, $item->allChildren);
        }
        $query = static::find();
        $query->where(['in', 'id', \yii\helpers\ArrayHelper::getColumn($allChildren, 'id')]);
        $query->multiple = true;
        return $query;
    }
    
    //================================
    const STATUS_INDEX_FOLLOW = 0;
    const STATUS_NOINDEX_NOFOLLOW = 1;
    const STATUS_INDEX_NOFOLLOW = 2;
    const STATUS_NOINDEX_FOLLOW = 3;
    
    public static $statuses = [
        self::STATUS_INDEX_FOLLOW => 'index, follow',
        self::STATUS_NOINDEX_NOFOLLOW => 'noindex, nofollow',
        self::STATUS_INDEX_NOFOLLOW => 'index, nofollow',
        self::STATUS_NOINDEX_FOLLOW => 'noindex, follow',
    ];
}
