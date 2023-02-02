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
