<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "mt_custom_page".
 *
 * @property integer $id
 * @property string $slug_name
 * @property string $page_name
 * @property string $content
 * @property string $seo_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $icons
 * @property string $assign_to
 * @property integer $sequence
 * @property integer $status
 * @property string $date_created
 * @property string $date_modified
 * @property integer $open_new_tab
 * @property integer $is_custom_link
 */
class MtCustomPage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mt_custom_page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_name', 'seo_title', 'date_created'], 'required'],
            [['content'], 'string'],
            [['sequence', 'status', 'open_new_tab', 'is_custom_link'], 'integer'],
            [['date_created', 'date_modified'], 'safe'],
            [['slug_name', 'page_name', 'seo_title', 'meta_description', 'meta_keywords', 'icons'], 'string', 'max' => 255],
            [['assign_to'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug_name' => 'Slug Name',
            'page_name' => 'Page Name',
            'content' => 'Content',
            'seo_title' => 'Seo Title',
            'meta_description' => 'Meta Description',
            'meta_keywords' => 'Meta Keywords',
            'icons' => 'Icons',
            'assign_to' => 'Assign To',
            'sequence' => 'Sequence',
            'status' => 'Status',
            'date_created' => 'Date Created',
            'date_modified' => 'Date Modified',
            'open_new_tab' => 'Open New Tab',
            'is_custom_link' => 'Is Custom Link',
        ];
    }
}
