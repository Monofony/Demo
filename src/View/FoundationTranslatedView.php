<?php

/*
 * This file is part of the Monofony demo.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\View;

use BabDev\PagerfantaBundle\View\TranslatedView;

final class FoundationTranslatedView extends TranslatedView
{
    protected function previousMessageOption()
    {
        return 'prev_message';
    }

    protected function nextMessageOption()
    {
        return 'next_message';
    }

    protected function buildPreviousMessage($text)
    {
        return sprintf('%s', $text);
    }

    protected function buildNextMessage($text)
    {
        return sprintf('%s', $text);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'foundation_translated';
    }
}
