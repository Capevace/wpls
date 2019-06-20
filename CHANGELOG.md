# WPLS Changelog

## 3.3.0
* Removed Web Installer & Updater due to instability, will be rewritten and readded in a later version.
* Fixed markdown not being parsed in "View Details" section
* Fixed issue where Laravel route caching would't work properly due to a closure (this triggered an error during install)

## 3.2.0
* Added Web Installer & Updater

## 3.1.1
* Fixed compiled assets not being included in the build.

## 3.1.0
* Licenses can now be activated multiple times. Default is 1 time per license but this can be customized while creating licenses.
* The storage path for packages has been moved outside of the system folder.
* To update WPLS all you need to do is replace the system folder with the newer one (as it was originally intended).
* Added command wpls:update if some updates require active changes.
* Moved assets out of public folder, so they can be replaced too.

## 3.0.1
* Quick Bug fixes

## 3.0.0
* Rewrite in Laravel
* Same functionality as before