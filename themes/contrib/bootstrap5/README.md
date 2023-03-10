# Bootstrap 5 theme

## INTRODUCTION

This is a very non-prescriptive vanilla Bootstrap 5 theme
with simple configuration. It can be used out of the box or
as a subtheme for creating very flexible web designs with
minimal changes (just override Bootstrap 5 _variables.scss
or this theme's _variables_drupal.scss and recompile css!)

## FEATURES

* Bootstrap 5 library ([5.2.3](https://blog.getbootstrap.com/2022/11/22/bootstrap-5-2-3/) and [5.1.3](https://blog.getbootstrap.com/2021/10/05/bootstrap-5-1-2/)) included
* Bootstrap 5 breakpoints
* Bootstrap 5 integration with CKEditor
* Bootstrap 5 configuration within admin user interface
* Interface for creating subtheme
* Can be used as is (subtheme is required for template and CSS overrides)
* Drupal 9 and 10 compatible

## Companion module:

Use [Bootstrap 5 tools](https://www.drupal.org/project/twbstools) companion module for
better content editor and developer experience. Features:

* Bootstrap 5 style guide (view all Bootstrap 5 components on one page)


## REQUIREMENTS

### Installation: composer
INSTALLATION

`composer require drupal/bootstrap5`

Head to `Appearance` and install bootstrap5 theme.

## CONFIGURATION

Head to `Appearance` and clicking bootstrap5 `settings`.

### Subtheme

* Enable theme.
* Head to `/admin/appearance/settings/bootstrap5`.
* Scroll down to `Subtheme` section.
* Name your subtheme and click `Create`.

## Development and patching

- Install development dependencies by running `npm install`
- To lint SASS files run `npm run lint:sass` (it will fail build if lint fails)
- To lint JS files run `npm run lint:js` (it will fail build if lint fails)
- To compile SASS run `sass scss/style.scss css/style.css` (requires [SASS compiler](https://sass-lang.com/install))
- To compile JS: run `npm run build:js`
- optional: create symlink from bootstrap5 repo folder to a local Drupal installation to simplify development `ln -s /path/to/bootstrap5 /path/to/local-drupal-site/web/themes/contrib`

## FAQ

### FAQ - Menu subnesting

Nesting is considered bad practice in Bootstrap 5. It is bad for UX, mobile
usage and accessibility.

Hence, there are no examples in the [current documentation](https://getbootstrap.com/docs/5.0/components/dropdowns/#menu-items).

Read more:

* https://github.com/twbs/bootstrap/issues/27659
* https://github.com/twbs/bootstrap/issues/16387#issuecomment-97153831

Theme developers need to implement their own solution if they are catering
for multi level menus.

To get started copy `templates/navigation/menu--main.html.twig` to your
subtheme and modify as follows:

```
{% import _self as menus %}

{#
We call a macro which calls itself to render the full tree.
@see http://twig.sensiolabs.org/doc/tags/macro.html
#}
{{ menus.build_menu(items, attributes, 0) }}

{% macro build_menu(items, attributes, menu_level) %}
  {% import _self as menus %}
  {% if items %}
    {% if menu_level == 0 %}
    <ul{{ attributes.addClass('navbar-nav mr-auto') }}>
    {% else %}
    <ul class="dropdown-menu">
    {% endif %}
    {% for item in items %}
      {{ menus.add_link(item, attributes, menu_level) }}
    {% endfor %}
    </ul>
  {% endif %}
{% endmacro %}

{% macro add_link(item, attributes, menu_level) %}
  {% import _self as menus %}
  {%
    set list_item_classes = [
      'nav-item',
      item.is_expanded ? 'dropdown',
      item.is_expanded and (menu_level > 0) ? 'dropdown-submenu',
    ]
  %}
  {%
    set link_class = [
      'nav-item',
      'nav-link',
      item.in_active_trail ? 'active',
      menu_level == 0 and (item.is_expanded or item.is_collapsed) ? 'dropdown-toggle',
    ]
  %}
  {%
    set toggle_class = [
    ]
  %}
  <li{{ item.attributes.addClass(list_item_classes) }}>
    {% if menu_level == 0 %}
      {{ link(item.title, item.url, { 'class': link_class, 'data-toggle' : 'dropdown', 'title': ('Expand menu' | t) ~ ' ' ~ item.title }) }}
    {% else %}
      {{ link(item.title, item.url, { 'class': link_class }) }}
    {% endif %}
    {% if item.below %}
      {{ menus.build_menu(item.below, attributes, menu_level + 1) }}
    {% endif %}
  </li>
{% endmacro %}
```
