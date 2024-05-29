# Loop Challenge App

## Estimated vs Tracked time table

Please, note that tasks are not in the order as per the assignment but rather in the order as I implemented them. For the task number 4 I estimated time to implement the page programmatically, eventually I implemented it using views.

| Task | Estimated time | Tracked time |
|:-----|---------------:|-------------:|
| 1.   |            30m |          30m |
| 2.   |            20m |          20m |
| 3.   |            30m |          30m |
| 8.   |             3h |           2h |
| 4.   |             3h |           1h |
| 5.   |             1h |           1h |
| 6.   |            30m |          30m |
| 7.   |             2h |           1h |
| 9.   |             1h |           3h |

## Installation

1. `git clone` this repository. Make sure you run PHP with version 8.0 or higher (I like the constructor property promotion feature).
2. Run `composer install`
3. Run `drush si standard` to install the Drupal. If you do not have `drush` installed globally, use the `./vendor/bin/drush`.
4. Drupal creates _shortcut_ entities which prevent us to import config. Lets delete them `drush edel shortcut`.
5. Also, site UUID prevents accidentally importing configuration on incorrect Drupal website. So we need to change our UUID to the correct one: `drush cset system.site uuid ec6a8407-55d2-4628-85fc-5649c92f99cb -y`
6. Run `drush cim` to import the configuration. Make sure the config directory is set in settings.php like this `$settings['config_sync_directory'] = '../config/sync';`
7. Let create some content: `drush genc 30 --bundles=event`
7. There is the overview page (task 4) on the front page.
8. I'll be glad for any feedback. Thank you for your time and the opportunity.
