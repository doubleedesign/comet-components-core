<?php
namespace Doubleedesign\Comet\Core;

/**
 * SectionMenu component
 *
 * @package Doubleedesign\Comet\Core
 * @version 1.0.0
 * @description Render a menu for the current section of your site, such as in the sidebar.
 */
#[AllowedTags([Tag::NAV])]
#[DefaultTag(Tag::NAV)]
class SectionMenu extends Menu {
    use ColorTheme;

    /**
     * @param  array  $attributes
     * @param  array<MenuItem>  $menuItems
     *
     * @phpstan-type MenuItem array{
     *   title: string,
     *   link_attributes: array{
     *     href: string,
     *     target?: string,
     *     'aria-current'?: string
     *   },
     *   children: array<MenuItem>
     * }
     */
    public function __construct(array $attributes, array $menuItems) {
        parent::__construct(
            array_merge($attributes, ['context' => 'section-navigation']),
            $menuItems
        );

        $this->set_color_theme_from_attrs($attributes, ThemeColor::PRIMARY);
    }

    protected function get_bem_name(): ?string {
        // We don't expect this to have a wrapper with 'section-menu' class - this *is* the wrapper,
        // so we don't want section-menu__menu as would be the default
        return 'section-navigation';
    }

    protected function get_html_attributes(): array {
        return array_merge(
            parent::get_html_attributes(),
            ['data-color-theme' => $this->colorTheme->value]
        );
    }
}
