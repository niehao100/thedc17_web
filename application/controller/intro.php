<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Intro extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://yourproject/home/index (which is the default page btw)
     */
    public function rule()
    {
        // load views
        require APP . 'view/_templates/header.php';
        $myfile = fopen(APP . 'view/intro/rule.md', "r") or die("Unable to open file!");
        $mess=fread($myfile,filesize(APP . 'view/intro/rule.md'));
        $info=Parsedown::instance()->text($mess); 
        require APP . 'view/intro/rule.php';
        require APP . 'view/_templates/footer.php';
    }
}
