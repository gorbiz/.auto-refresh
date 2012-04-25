# .auto-refresh

Auto refresh any browser window as your one-filed-web-application is being edited.

## Usage example

    $ cd my-web-application/
    $ git clone git@github.com:gorbiz/.auto-refresh.git
    $ google-chrome http://example.com/my-web-application/.auto-refresh

You can now open http://example.com/my-web-application/.auto-refresh in any (reasonably modern) browser on any device, and as soon as you change your <whatever>.html or <whatever>.php file the page will refresh in all browsers on all devices.

## Be aware

PHP is required on the server-side.

JavaScript in required on the client-side.

For mobile web applications passing "?m" will enable some common meta-tags for mobile web application, possibly solving styling issues. The full URL would then be http://example.com/my-web-application/.auto-refresh?m

This is yet a hack ...as if you did not already see that.
