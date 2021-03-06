<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "widget".
 *
 * @property integer $id
 * @property integer $page_group_id
 * @property integer $place
 * @property integer $position
 * @property string $name
 * @property string $template
 * @property string $item_image_size
 * @property string $link_target
 * @property string $link_follow
 * @property string $item_template
 * @property string $style
 * @property string $object_class
 * @property integer $sql_offset
 * @property integer $sql_limit
 * @property string $sql_order_by
 * @property string $sql_where
 * @property integer $status
 * @property integer $is_active
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $created_by
 * @property string $updated_by
 *
 * @property WidgetToPageGroup[] $widgetToPageGroups
 * @property PageGroup[] $pageGroups
 */
class Widget extends \common\models\Widget
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'widget';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_group_id', 'place', 'position', 'sql_offset', 'sql_limit', 'status', 'is_active', 'created_at', 'updated_at'], 'integer'],
            [['name', 'item_image_size', 'link_target', 'link_follow', 'object_class', 'sql_order_by', 'sql_where', 'created_by', 'updated_by'], 'string', 'max' => 255],
            [['template', 'item_template'], 'string', 'max' => 511],
            [['style'], 'string', 'max' => 2000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_group_id' => 'Page Group ID',
            'place' => 'Place',
            'position' => 'Position',
            'name' => 'Name',
            'template' => 'Template',
            'item_image_size' => 'Item Image Size',
            'link_target' => 'Link Target',
            'link_follow' => 'Link Follow',
            'item_template' => 'Item Template',
            'style' => 'Style',
            'object_class' => 'Object Class',
            'sql_offset' => 'Sql Offset',
            'sql_limit' => 'Sql Limit',
            'sql_order_by' => 'Sql Order By',
            'sql_where' => 'Sql Where',
            'status' => 'Status',
            'is_active' => 'Is Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWidgetToPageGroups()
    {
        return $this->hasMany(WidgetToPageGroup::className(), ['widget_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPageGroups()
    {
        return $this->hasMany(PageGroup::className(), ['id' => 'page_group_id'])->viaTable('widget_to_page_group', ['widget_id' => 'id']);
    }
}
