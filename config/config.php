<?php
/**
 * Created by PhpStorm.
 * User: cyber10
 * Date: 6/02/2017
 * Time: 13:47
 */
Config::set('site_name','Bakkerij De Smul');
Config::set('languages',array('nl','en'));

//Routes. Route name=>method prefix
Config::set('routes',array(
   'default'=>'',
    'admin'=>'admin_'
));
Config::set('default_route','default');
Config::set('default_language','nl');
Config::set('default_controller','pages');
Config::set('default_action','index');