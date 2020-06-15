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

namespace App\View\Template;

use Pagerfanta\View\Template\Template;

final class FoundationTemplate extends Template
{
    /**
     * @var array
     */
    static protected $defaultOptions = array(
        'current_message'     => 'You\'re on page',
        'prev_message'        => '&larr; Previous',
        'next_message'        => 'Next &rarr;',
        'active_suffix'       => '',
        'css_container_class' => 'pagination',
        'css_prev_class'      => 'button pagination_button',
        'css_next_class'      => 'button pagination_button',
        'css_dots_class'      => 'ellipsis',
        'css_active_class'    => 'current_page',
        'css_disabled_class'  => 'disabled'
    );

    /**
     * @return string
     */
    public function container()
    {
        return sprintf(
            '<nav aria-label="Pagination"><ul class="%s">%%pages%%</ul></nav>',
            $this->option('css_container_class')
        );
    }

    /**
     * @param int $page
     *
     * @return string
     */
    public function page($page)
    {
        $text = $page;

        return $this->pageWithText($page, $text, 'Page '.$page);
    }

    /**
     * @param int $page
     * @param string $text
     * @param string $ariaLabel
     *
     * @return string
     */
    public function pageWithText($page, $text, $ariaLabel = null)
    {
        $class = null;

        return $this->pageWithTextAndClass($page, $text, $class, $ariaLabel);
    }

    /**
     * @param int $page
     * @param string $text
     * @param string $class
     * @param string $ariaLabel
     *
     * @return string
     */
    public function pageWithTextAndClass($page, $text, $class, $ariaLabel = null)
    {
        $href = $this->generateRoute($page);

        return $this->linkLi($class, $href, $text, $ariaLabel);
    }

    /**
     * @return string`
     */
    public function previousDisabled()
    {
        $class = $this->previousDisabledClass();
        $text = $this->option('prev_message');

        return $this->spanLi($class, $text, $text);
    }

    /**
     * @return string
     */
    public function previousDisabledClass()
    {
        return $this->option('css_prev_class').' '.$this->option('css_disabled_class');
    }

    /**
     * @param int $page
     * @return string
     */
    public function previousEnabled($page)
    {
        $text = $this->option('prev_message');
        $class = $this->option('css_prev_class');

        return $this->pageWithTextAndClass($page, $text, $class, $this->option('prev_message'));
    }

    /**
     * @return string
     */
    public function nextDisabled()
    {
        $class = $this->nextDisabledClass();
        $text = $this->option('next_message');

        return $this->spanLi($class, $text, $text);
    }

    /**
     * @return string
     */
    public function nextDisabledClass()
    {
        return $this->option('css_next_class').' '.$this->option('css_disabled_class');
    }

    /**
     * @param int $page
     *
     * @return string
     */
    public function nextEnabled($page)
    {
        $text = $this->option('next_message');
        $class = $this->option('css_next_class');

        return $this->pageWithTextAndClass($page, $text, $class, $text);
    }

    /**
     * @return string
     */
    public function first()
    {
        return $this->page(1);
    }

    /**
     * @param int $page
     *
     * @return string
     */
    public function last($page)
    {
        return $this->page($page);
    }

    /**
     * @param int $page
     *
     * @return string
     */
    public function current($page)
    {
        $text = trim($page.' '.$this->option('active_suffix'));
        $class = $this->option('css_active_class');

        return $this->spanLi($class, $text, $this->option('current_message'));
    }

    /**
     * @return string
     */
    public function separator()
    {
        return sprintf('<li class="%s" aria-hidden="true"></li>', $this->option('css_dots_class'));
    }

    /**
     * @param string $class
     * @param string $href
     * @param string $text
     * @param string $arialLabel
     *
     * @return string
     */
    protected function linkLi($class, $href, $text, $arialLabel)
    {
        $liClass = $class ? sprintf(' class="%s"', $class) : '';

        return sprintf('<li%s><a href="%s" aria-label="%s">%s</a></li>', $liClass, $href, $arialLabel, $text);
    }

    /**
     * @param string $class
     * @param string $text
     * @param string $altText
     *
     * @return string
     */
    protected function spanLi($class, $text, $altText = null)
    {
        $altText = $altText ? $altText : $text;
        $liClass = $class ? sprintf(' class="%s"', $class) : '';

        return sprintf('<li%s><span class="show-for-sr">%s</span> %s</li>', $liClass, $altText, $text);
    }
}
