Futilities is a series of functions, hooks and utilities that try to make WordPress a little easier to work with.

Lots of plugins do *stuff* and you're left trying to figure out exactly what's going on. The goal with Futilities is to ensure that you get complete manual control over which futilities actually get loaded and run via the control panel. This lets you turn things on and off depending on your needs.

Futilities were also designed to be easy to build yourself. You can add futilities to the system and turn them on and off easily.

Utility Classes, unlike Hooks, are namespaced and loaded automatically. Because you have the choice to use a utility function or not, there's no need to explicitly turn them on or off. At the very least, you're able to see the utility class files that are being loaded on the Settings page.

## TODO

* Add a user futilities folder that doesn't conflict with the base set.
* Actually sanitize input somewhat.