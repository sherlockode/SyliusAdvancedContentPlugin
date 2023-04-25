# Sylius AdvancedContent plugin

----

[ ![](https://img.shields.io/packagist/l/sherlockode/sylius-advanced-content-plugin)](https://packagist.org/packages/sherlockode/sylius-advanced-content-plugin "License")
[ ![](https://img.shields.io/packagist/v/sherlockode/sylius-advanced-content-plugin)](https://packagist.org/packages/sherlockode/sylius-advanced-content-plugin "Version")
[ ![](https://poser.pugx.org/sherlockode/sylius-advanced-content-plugin/downloads)](https://packagist.org/packages/sherlockode/sylius-advanced-content-plugin "Total Downloads")
[ ![Support](https://img.shields.io/badge/support-contact%20author-blue])](https://www.sherlockode.fr/contactez-nous/?utm_source=github&utm_medium=referral&utm_campaign=plugins_sylius_acb)

![image](https://user-images.githubusercontent.com/22291441/230099691-0fad8407-9883-4f0c-bdbd-9d6a8245a8db.png)

## Table of Content

----

* [Overview](#overview)
* [Installation](#installation)
* [Configuration](#configuration)
* [Usage](#usage)
* [Demo](#demo-sylius-shop)
* [Additional resources for developers](#additional-resources-for-developers)
* [License](#license)
* [Contact](#contact)


# Overview

----

This plugin enables Sherlockode's AdvancedContentBundle on your Sylius website.

It provides advanced CMS features for end user contribution.
Users can build their website pages quickly and effortlessly thanks to our intuitive interface.
Several standard elements are included, such as text block, heading, image, image carousel, video player, ...
Responsive layouts can be shaped as needed with row and column elements.
Drafts are saved automatically and it's easy to rollback to a previous version.
Custom elements can be added simply with a few lines of code.

# Installation

----

Install the plugin with composer:

```bash
$ composer require sherlockode/sylius-advanced-content-plugin
```

# Configuration

----

Import the routing configuration and Sylius configuration from the bundle

```yaml
# config/sylius_acb.yaml
imports:
    - { resource: "@SherlockodeSyliusAdvancedContentPlugin/Resources/config/config.yaml" }
```

```yaml
# config/routes/sylius_acb.yaml
sherlockode_advanced_content_bundle:
    resource: "@SherlockodeAdvancedContentBundle/Resources/config/routing/base.xml"
    prefix: '/%sylius_admin.path_name%/acb'

sherlockode_advanced_content:
    resource: "@SherlockodeSyliusAdvancedContentPlugin/Resources/config/admin_routing.yaml"
    prefix: '/%sylius_admin.path_name%/acb'
```

Regarding the assets, the same setup as for the standalone AdvancedContentBundle should be done.

Update your `package.json` with the following:

```json
{
  "dependencies": {
    "@fortawesome/fontawesome-free": "^6.1.2",
    "jquery": "^3.5.0",
    "jquery-ui": "1.12.1"
  }
}
```

In the admin JS entry file from your assets, add the resources from the bundle:

```js
// ./assets/admin/entry.js
//...
import '../../vendor/sherlockode/advanced-content-bundle/Resources/public/css/index.scss';
import '../../vendor/sherlockode/advanced-content-bundle/Resources/js/index.js';
import '../../vendor/sherlockode/sylius-advanced-content-plugin/src/Resources/public/css/index.scss';

import '@fortawesome/fontawesome-free/css/fontawesome.css';
import '@fortawesome/fontawesome-free/css/solid.css';
```

If you are using Webpack, you can add the following lines to your admin     configuration:
```js
// ./webpack.config.js
//...
Encore.addLoader({
    resolve: {
        alias: {
            './acb-notification.js$': path.resolve(__dirname, 'vendor/sherlockode/sylius-advanced-content-plugin/src/Resources/js/AdvancedContentBundle/acb-notification.js')
        }
    }
});
```

# Usage

----

The plugin adds a new Content section in the admin menu.\
It includes links to the Page grid, to the Content grid and to the Tools page.

You can checkout our documentation on the [Advanced Content Bundle](https://github.com/sherlockode/advanced-content-bundle) to learn more on how to use the plugin:
- [Terminology](https://github.com/sherlockode/advanced-content-bundle#terminology)
- [Upload Configuration](https://github.com/sherlockode/advanced-content-bundle#upload-configuration)
- [Advanced Documentation](https://github.com/sherlockode/advanced-content-bundle#advanced-documentation)


# Demo Sylius Shop

----

We created a demo app with some useful use-cases of plugins!
Visit [sylius-demo.sherlockode.fr](https://sylius-demo.sherlockode.fr/) to take a look at it. The admin can be accessed under
[sylius-demo.sherlockode.fr/admin/login](https://sylius-demo.sherlockode.fr/admin/login) link.\
Plugins that we have used in the demo:

| Plugin name                  | GitHub                                                     | Sylius' Store |
|------------------------------|------------------------------------------------------------|---------------|
| Advance Content Bundle (ACB) | https://github.com/sherlockode/SyliusAdvancedContentPlugin | -             |
| Mondial Relay                | https://github.com/sherlockode/SyliusMondialRelayPlugin    | -             |
| Checkout Plugin              | https://github.com/sherlockode/SyliusCheckoutPlugin        | -             |
| FAQ                          | https://github.com/sherlockode/SyliusFAQPlugin             | -             |


# Additional resources for developers

----

To learn more about our contribution workflow and more, we encourage you to use the following resources:
* [Sylius Documentation](https://docs.sylius.com/en/latest/)
* [Sylius Contribution Guide](https://docs.sylius.com/en/latest/contributing/)
* [Sylius Online Course](https://sylius.com/online-course/)


# License

----

This plugin's source code is completely free and released under the terms of the [MIT license](LICENSE).


# Contact

----

If you want to contact us, the best way is to fill the form on [our website](https://www.sherlockode.fr/contactez-nous/?utm_source=github&utm_medium=referral&utm_campaign=plugins_sylius_acb) or send us an e-mail to contact@sherlockode.fr with your question(s). We guarantee that we answer as soon as we can!
