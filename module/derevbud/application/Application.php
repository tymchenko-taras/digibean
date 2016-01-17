<?php
/**
 * Created by JetBrains PhpStorm.
 * User: t.tymchenko
 * Date: 22.10.14
 * Time: 14:00
 * To change this template use File | Settings | File Templates.
 */

class Derevbud_Application extends Base_Application{
    protected $modules = array(
        'Base',
        'User',
        'Derevbud',
    );
}