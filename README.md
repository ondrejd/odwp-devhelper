# odwp-devhelper

Plugin that helps with development for [WordPress](https://wordpress.org/).

__Note__: This plugin uses excelent [PrismJs](http://prismjs.com) library for syntax highlighting. Thanks!

## Description

Plugin offers set of wizards for creating new plugins, themes or significant parts of code (such as admin tables or metaboxes). These wizards produces source codes that are downloadable within `ZIP` archives. Values entered into wizards and generated codes are stored for later so can be easily reused or updated.

Plugin is not just for administrators but can be used by any registered user of your [WordPress](https://wordpress.org/) site.

## TODO

- [x] screen options cannot be saved on page __New table__.
- [ ] finish __New table__ wizard.
- [ ] finish __New plugin__ wizard.
- [ ] finish __New theme__ wizard.
- [ ] finish __Custom post type__ wizard.
- [ ] update version to __0.1.0__.
- [ ] make this plugin extendable by using [`apply_filters`](https://developer.wordpress.org/reference/functions/apply_filters/) and [`do_action`](https://developer.wordpress.org/reference/functions/do_action/).

## Changelog

_Note_: Versions are sorted from the newest to the oldest.

### Version 0.1.0

- Code moved on __GitHub__ to the repository [ondrejd/odwp-devhelper](https://github.com/ondrejd/odwp-devhelper).
- Code clean-up.
- Improved [`DevHelper_Screen_Prototype`](https://github.com/ondrejd/odwp-devhelper/blob/master/includes/class-devhelper_screen_prototype.php) class.
- Initial version of new plugin wizard.
- Initial version of new table wizard.
- Initial version of new theme wizard.
- Initial version of custom post type wizard.

### Version 0.0.1

- Initial version (some code ported from [ondrejd/wp-style-guide](https://github.com/ondrejd/wp-style-guide)).
