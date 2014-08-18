<?php
use \Studievolg\Router as Router;
use \Studievolg\View as View; 
/**
 * This File contains all routes.
 * The routes first param make use of regular expression.
 * 
 * (\d+) stands for any digit [0-9]
 * (\w+) stands for any word [A-Za-z0-9_]
 * (.*?) stands for ANYTHING
 * 
 * Any regex part is added as a function parameter, in the same order as defined.
 */

Router::route('inloggen', function() {
            $controller = new \Studievolg\Controller\BaseController;
            $controller->authenticate();
        }); 

Router::route('uitloggen', function() {
            $controller = new \Studievolg\Controller\BaseController;
            $controller->logout();
        }); 

Router::route('docent/evaluate/(.*)', function($examCode){
            $controller = new \Studievolg\Controller\BaseController;
            $controller->evaluateExam($examCode);
});
        
Router::route('docent', function() {
            session_start();
            if(!$_SESSION['user'] instanceof \Studievolg\Model\Gebruiker || $_SESSION['user']->getRol()->getNaam() != "Docent")
                    header("Location: /logout");

            header("Location: /docent/overviewexam");
        }); 
        
Router::route('docent/createexam', function() {
            $controller = new \Studievolg\Controller\Docent\DocentController;
            $controller->createExam();
        }); 
        
Router::route('docent/overviewexamresult/(.*?)', function($tentamenCode) {
            $controller = new \Studievolg\Controller\Docent\DocentController;
            $controller->overviewExamResults($tentamenCode);
        }); 
        
Router::route('docent/overviewexam', function() {
            $controller = new \Studievolg\Controller\Docent\DocentController;
            $controller->overviewExam();
        });   
        
Router::route('docent/inputexamresult/(.*?)', function($tentamenCode) {      
            $controller = new \Studievolg\Controller\Docent\DocentController;
            $controller->inputExamResults($tentamenCode);
        }); 

//Redirect root to inloggen
Router::route('', function() {
            header("Location: /inloggen");
        });

//Catch any other route, and forward to 404
Router::route('(.*)', function() {
            //header("Location: /404");
        });