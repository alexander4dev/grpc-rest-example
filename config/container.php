<?php declare(strict_types=1);

/**
 * @link http://php-di.org/doc/
 */

return (function () {
    $builder = new DI\ContainerBuilder();
    $builder->useAnnotations(true);

    $builder->addDefinitions(__DIR__ . '/application.php');
    $definition = __DIR__ . '/application.php.local';
    if (file_exists($definition)) {
        $builder->addDefinitions($definition);
    }

    $builder->addDefinitions(__DIR__ . '/definitions.php');
    $definition = __DIR__ . '/definitions.php.local';
    if (file_exists($definition)) {
        $builder->addDefinitions($definition);
    }

    return $builder->build();
})();
