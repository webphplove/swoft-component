<?php declare(strict_types=1);

use Swoft\Bean\BeanFactory;
use Swoft\Bean\Container;
use Swoft\Event\EventInterface;
use Swoft\Event\Manager\EventManager;

/**
 * Swoft is a helper class serving common framework functions.
 *
 * @since 2.0
 */
class Swoft
{
    use \Swoft\Concern\PathAliasTrait;

    public const VERSION = '2.0.0-beta';

    public const FONT_LOGO = "
  ____                __ _     _____                                            _      ____         
 / ___|_      _____  / _| |_  |  ___| __ __ _ _ __ ___   _____      _____  _ __| | __ |___ \  __  __
 \___ \ \ /\ / / _ \| |_| __| | |_ | '__/ _` | '_ ` _ \ / _ \ \ /\ / / _ \| '__| |/ /   __) | \ \/ /
  ___) \ V  V / (_) |  _| |_  |  _|| | | (_| | | | | | |  __/\ V  V / (_) | |  |   <   / __/ _ >  < 
 |____/ \_/\_/ \___/|_|  \__| |_|  |_|  \__,_|_| |_| |_|\___| \_/\_/ \___/|_|  |_|\_\ |_____(_)_/\_\                                                                                                    
";

    /**
     * @var \Swoft\SwoftApplication
     */
    public static $app;

    /**
     * @return \Swoft\SwoftApplication
     */
    public static function app(): \Swoft\SwoftApplication
    {
        return self::$app;
    }

    /**
     * Get main server instance
     *
     * @return \Swoft\Server\Server|\Swoft\Http\Server\HttpServer|\Swoft\WebSocket\Server\WebSocketServer
     */
    public static function server(): \Swoft\Server\Server
    {
        return \Swoft\Server\Server::getServer();
    }

    /**
     * Get swoole server
     *
     * @return \Swoole\Server
     */
    public static function swooleServer(): \Swoole\Server
    {
        return self::server()->getSwooleServer();
    }

    /*******************************************************************************
     * bean short methods
     ******************************************************************************/

    /**
     * Whether has bean
     *
     * @param string $name
     *
     * @return bool
     */
    public static function hasBean(string $name): bool
    {
        return Container::$instance->has($name);
    }

    /**
     * Get bean object by name
     *
     * @param string $name Bean name Or alias Or class name
     *
     * @return object|mixed
     * @throws \Swoft\Bean\Exception\ContainerException
     * @throws \ReflectionException
     */
    public static function getBean(string $name)
    {
        return Container::$instance->get($name);
    }

    /**
     * @see Container::getSingleton()
     *
     * @param string $name
     *
     * @return mixed
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public static function getSingleton(string $name)
    {
        return Container::$instance->getSingleton($name);
    }

    /*******************************************************************************
     * Some short methods
     ******************************************************************************/

    /**
     * Get an ReflectionClass object by input class.
     *
     * @param string $class
     *
     * @return array
     * @throws ReflectionException
     */
    public static function getReflection(string $class): array
    {
        return \Swoft\Stdlib\Reflections::get($class);
    }

    /**
     * Trigger an swoft application event
     *
     * @param string|EventInterface $event eg: 'app.start' 'app.stop'
     * @param null|mixed            $target
     * @param array                 $params
     *
     * @return EventInterface
     * @throws \Swoft\Bean\Exception\ContainerException
     */
    public static function trigger($event, $target = null, ...$params): EventInterface
    {
        /** @see EventManager::trigger() */
        return BeanFactory::getSingleton('eventManager')->trigger($event, $target, $params);
    }

    /**
     * Trigger an swoft application event. like self::trigger(), but params is array
     *
     * @param string|EventInterface $event
     * @param null|mixed            $target
     * @param array                 $params
     *
     * @return EventInterface
     * @throws \Throwable
     */
    public static function triggerByArray($event, $target = null, array $params = []): EventInterface
    {
        /** @see EventManager::trigger() */
        return BeanFactory::getSingleton('eventManager')->trigger($event, $target, $params);
    }
}
