<?php

/**
 * 命令行前端控制器.
 *
 * @author Shi Long <long.shi@alibaba-inc.com>
 * @copyright ©2003-2103 phpwind.com
 * @license http://www.windframework.com
 *
 * @version $Id: WindCommandFrontController.php 3859 2012-12-18 09:25:51Z yishuo $
 */
class WindCommandFrontController extends AbstractWindFrontController
{
    /*
     * (non-PHPdoc) @see AbstractWindFrontController::createApplication()
     */
    public function createApplication($config, $factory)
    {
        $request = $factory->getInstance('request');
        $response = $factory->getInstance('response');
        $application = new WindCommandApplication($request, $response, $factory);
        $application->setConfig($config);

        return $application;
    }

    /*
     * (non-PHPdoc) @see AbstractWindFrontController::_components()
     */
    protected function _components()
    {
        return array(
            'request' => array(
                'path'  => 'WindCommandRequest',
                'scope' => 'application', ),
            'response' => array(
                'path'  => 'WindCommandResponse',
                'scope' => 'application', ),
            'router'       => array('path' => 'WindCommandRouter', 'scope' => 'application'),
            'windView'     => array('path' => 'WindCommandView', 'scope' => 'prototype'),
            'db'           => array('path' => 'WindConnection', 'scope' => 'singleton'),
            'configParser' => array(
                'path'  => 'WindConfigParser',
                'scope' => 'singleton', ),
            'error'        => array('path' => 'WIND:command.WindCommandError', 'scope' => 'application'),
            'errorMessage' => array('path' => 'WindErrorMessage', 'scope' => 'prototype'),
            'windLogger'   => array(
                'path'             => 'WindLogger',
                'scope'            => 'singleton',
                'destroy'          => 'flush',
                'constructor-args' => array(
                    '0' => array('value' => 'DATA:log'),
                    '1' => array('value' => '2'), ), ),
            'i18n' => array(
                'path'   => 'WindLangResource',
                'scope'  => 'singleton',
                'config' => array('path' => 'i18n'), ), );
    }

    /*
     * (non-PHPdoc) @see AbstractWindFrontController::_loadBaseLib()
     */
    protected function _loadBaseLib()
    {
        Wind::$_imports += array(
            'WIND:i18n.WindLangResource'    => 'WindLangResource',
            'WIND:log.WindLogger'           => 'WindLogger',
            'WIND:base.WindErrorMessage'    => 'WindErrorMessage',
            'WIND:parser.WindConfigParser'  => 'WindConfigParser',
            'WIND:db.WindConnection'        => 'WindConnection',
            'WIND:router.WindCommandRouter' => 'WindCommandRouter',

            'WIND:command.WindCommandView'         => 'WindCommandView',
            'WIND:command.WindCommandErrorHandler' => 'WindCommandErrorHandler',
            'WIND:command.WindCmmandRequest'       => 'WindCommandRequest',
            'WIND:command.WindCommandResponse'     => 'WindCommandResponse',
            'WIND:command.WindCommandController'   => 'WindCommandController',
            'WIND:command.WindCommandApplication'  => 'WindCommandApplication', );

        Wind::$_classes += array(
            'WindLangResource'  => 'i18n/WindLangResource',
            'WindLogger'        => 'log/WindLogger',
            'WindErrorMessage'  => 'base/WindErrorMessage',
            'WindConfigParser'  => 'parser/WindConfigParser',
            'WindConnection'    => 'db/WindConnection',
            'WindCommandRouter' => 'router/WindCommandRouter',

            'WindCommandView'         => 'command/WindCommandView',
            'WindCommandApplication'  => 'command/WindCommandApplication',
            'WindCommandController'   => 'command/WindCommandController',
            'WindCommandErrorHandler' => 'command/WindCommandErrorHandler',
            'WindCommandRequest'      => 'command/WindCommandRequest',
            'WindCommandResponse'     => 'command/WindCommandResponse', );
    }
}
