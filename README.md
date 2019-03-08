# WP Translation Day 4 - Web Assets

This repository holds all the necessary files for the Theme & Plugins used at wptranslationday.org for our 4th event!

Please use the `develop` branch if you want to make any PRs. The `master` branch will be used for production only.

## About the theme

Our theme is a child-theme of [TwentySeventeen](https://wordpress.org/themes/twentyseventeen/). We're also making use of [TGM Plugin Activation](https://github.com/TGMPA/TGM-Plugin-Activation) to require necessary plugns needed for the website to run smoothly. These are [Classic Editor](https://wordpress.org/plugins/classic-editor/), [Advanced Custom Fields](https://wordpress.org/plugins/advanced-custom-fields/), [Disable Comments](https://wordpress.org/plugins/disable-comments/).

## Custom Post Types

The theme provides 3 Custom Post Types for Organizers, Speakers and Local Events. You will find a `.json` file with all the fields needed for these CPTs inside the `/inc` folder that you can import into ACF.

## General Documentation

__Front Page__

The Front Page is divided into 5 _Panels_. It's template file is located at `/template-parts/page/content-front-page.php`. When editing the Front Page you will see the custom fields that change each aspect of every panel those include:

- Enabled (on/off)
- Panel Anchor ID (to be used for menu # reference)
- Panel Image (the icon on the left side)
- Panel Background (the background image)
- Panel Heading (the title)
- Panel Text (the main text at the right side)

__Note:__ The 4th panel also has a Countdown Date and a Countdown Finished Message so you can easily change the timer of the Front Page.