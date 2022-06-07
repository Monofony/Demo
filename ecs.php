<?php

use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->import('vendor/mobizel/coding-standard/ecs.php');

    $header = <<<EOM
This file is part of the Monofony demo project.

(c) Monofony

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOM;

    $services = $ecsConfig->services();
    $services
        ->set(HeaderCommentFixer::class)
        ->call('configure', [[
            'header' => $header,
            'location' => 'after_open',
        ]])
    ;
};
