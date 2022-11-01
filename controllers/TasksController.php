<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Category;
use app\models\Task;
use taskForce\businessLogic\Task as TaskStatus;

class TasksController extends Controller
{
	public function actionIndex()
    {
        $tasks = Task::find()
                     ->where(['status' => TaskStatus::STATUS_NEW])
                     ->with('category', 'city')
                     ->orderBy(['created_at' => SORT_DESC])
                     ->all();

        return $this->render('index', ['tasks' => $tasks]);
    }
}