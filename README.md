# Sylius AdvancedContent plugin

This plugin enables Sherlockode's AdvancedContentBundle on your Sylius website.

## Installation

Install the plugin with composer:

```bash
$ composer require sherlockode/sylius-advanced-content-plugin
```

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

import '@fortawesome/fontawesome-free/css/fontawesome.css';
import '@fortawesome/fontawesome-free/css/solid.css';
```
