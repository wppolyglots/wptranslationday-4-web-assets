# WP Translation Day 4 - Web Assets

This repository holds all the necessary files for the Theme & Plugins used at wptranslationday.org for our 4th event!

Please use the `develop` branch if you want to make any PRs. The `master` branch will be used for production only.

## About the theme

Our theme is a child-theme of [TwentySeventeen](https://wordpress.org/themes/twentyseventeen/). We're also making use of [TGM Plugin Activation](https://github.com/TGMPA/TGM-Plugin-Activation) to require necessary plugns needed for the website to run smoothly. These are [Classic Editor](https://wordpress.org/plugins/classic-editor/), [Advanced Custom Fields](https://wordpress.org/plugins/advanced-custom-fields/), [Disable Comments](https://wordpress.org/plugins/disable-comments/), [Forminator](https://wordpress.org/plugins/forminator/).

# General Documentation

## General Pages

__Front Page__

The Front Page is divided into 5 _Panels_. It's template file is located at `/template-parts/page/content-front-page.php`. When editing the Front Page you will see the custom fields that change each aspect of every panel those include:

- Enabled (on/off)
- Panel Anchor ID (to be used for menu # reference)
- Panel Image (the icon on the left side)
- Panel Background (the background image)
- Panel Heading (the title)
- Panel Text (the main text at the right side)

__Note 1:__ The 4th panel also has a Countdown Date and a Countdown Finished Message so you can easily change the timer of the Front Page.

__Note 2:__ You will also find the `Event Date` custom field, this is used to calculate the automation on the Schedule page to show the current live Talk. Set it to the Events Date!

__Note 3:__ You will also find the `Maintenance Mode` custom field, this is used to easily put the website under maintenance for non logged in users.

## Custom Post Types

The theme provides 4 Custom Post Types for Organizers, Speakers and Local Events. You will find a `acf-export.json` file with all the fields needed for these CPTs inside the `/assets/` folder that you can import into ACF.

It will also check if the necessary pages exist and if not they will be automatically created as `The Team` for the Organizers, `The Speakers` for the Speakers, `Schedule` for the talks and `Local Events` for the Local Events CPTs.

__Organizers__

This CPT is bound to the `the-team` slug and it will be automatically loaded in the `page-the-team.php` that is included with the theme. The information that we use is this:

- Organizer Name ( Post Title )
- Image ( upload a custom avatar )
- Username wp.org
- Username slack
- Facebook Profile URL
- Twitter Profile URL
- LinkedIn Profile URL
- Website URL
- Role
- Bio
- Order (this is used if custom ordering is needed on the front-end and the template file has to be adjusted as well)

__Speakers__

This CPT is bound to the `the-speakers` slug and it will be automatically loaded in the `page-the-speakers.php` that is included with the theme. The information that we use is this:

- Speaker Name ( Post Title )
- Image ( upload a custom avatar )
- Username wp.org
- Username slack
- Facebook Profile URL
- Twitter Profile URL
- LinkedIn Profile URL
- Website URL
- Talk Subject
- Bio

__Local Events__

This CPT is bound to the `the-local-events` slug and it will be automatically loaded in the `page-the-local-events.php` that is included with the theme. The information that we use is this:

- City
- Country / State
- Continent
- Locale
- Organizer Name
- Organizer Username wp.org
- Organizer Username slack
- Co-organizers
- UTC Start Time
- UTC End Time
- Announcement URL
- Interviewer
- Continent - Country/State - City __(this field is used for sorting purposes do not edit it, it will be automatically populated)__

__Talks__

This CPT is bound to the `the-schedule` slug and it will be automatically loaded in the `page-the-schedule.php` that is included with the theme. The information that we use is this:

- Title ( Post Title )
- Description
- Speaker ( in relation to Speakers )
- UTC Start Time
- Live or Pre-recorded
- Duration
- Target Audience
- Target Language
- Video URL

## Forms

Forminator has an export / import feature for every form. You will find the necessary file for importing each form in `/assets/` folder named after `forminator-FORM.txt`. If you make any updates on the form please re-export so we can keep these files updated as well with the latest settings.

The form submissions will be kept within the database for easier handling as well.