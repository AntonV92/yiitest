<?php 

namespace app\modules\orders\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use app\modules\orders\models\Index;

class MainWidget extends Widget
{
    public $message;

    public function init()
    {
        //parent::init();
        
        $this->message = (new Index())->index();
    }

    public function run()
    {
        
    }

    public function index()
    {
        return $this->message;
    }
}