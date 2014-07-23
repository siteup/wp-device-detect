wp-device-detect
================

A WordPress plugin that detects the device used by visitors and provides functions and shortcodes to display (or not) content  based on said devices.

This plugin is based on the excelent library: https://github.com/serbanghita/Mobile-Detect/

## USAGE

### FOR WordPress users

After activating the plugin, you can use the following shortcodes:

- ` [stp_phone]Content here...[/stp_phone] ` - this will display the content on phone ONLY;
- ` [stp_tablet]Content for tablet...[/stp_tablet] ` - the content will be displayed only on TABLETS;
- ` [stp_desktop]Content for desktop...[/stp_desktop] `- display content on the desktop only, hidding it on phones and tablets;
- ` [stp_mobile] Content for phones and tablets alike [/stp_mobile] ` - displays the content for everybody except desktop users;
 
### FOR WordPress developers

The following function are available to be used in plugins or theme:

- ` stp_phone() ` returns true if the users are using a phone to view the content, while ` stp_notphone() ` returns true if the user is NOT using a phone to view the content;
- ` stp_tablet() ` returns true if the users are using a tablet to view the content.  Vice-versa `stp_nottablet()`;
- ` stp_desktop() ` returns true for desktop users. You get it by now. Aliases: `stp_notdevice()` and `stp_notmobile()`;
- ` stp_mobile() ` returns true for phone and tablet users. 
