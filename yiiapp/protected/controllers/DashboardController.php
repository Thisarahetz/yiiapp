<?php

class DashboardController extends Controller
{

    public $pageTitle = 'This is the page title';

    // public function actionHome(){
    //     $this->render('view');
    // }

    public function actionHome(){

        $this->layout = 'basic';

        $emails = ['test@gmail.com','johndoe@gmail.com'];
        $this->render('view',['emails'=>$emails]);
    }

    public function actionEvents()
{
    // $events = Event::model()->findAll();
    $events = Event::model()->findByPk(1);
    // echo $events;
    // var_dump($events);
    $this->render("events",['events'=>$events]);
}

    public function message($message){
        echo $message;
    }
}