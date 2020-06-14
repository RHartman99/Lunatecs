# FRC Team 316 Official WordPress Theme

![Lunatecs Logo](https://i.imgur.com/I47yjRL.png)

## Table of Contents

- [Information](#information)
- [Features](#features)
- [Requirements](#requirements)
- [Instructions](#instructions)
- [How To Make Custom Page Templates](#how-to-make-custom-page-templates)
- [How To Pass Data to Twig](#how-to-pass-data-to-twig)
- [Tailwind Notes](#tailwind-notes)
- [Editor Setup](#editor-setup)
  - [VS Code](#vs-code)
    - [Recommended Extensions](#recommended-extensions)

## Information

This is the codebase for FRC Team 316's current WordPress theme. It extends the NextLevel base theme created by [Richard Kanson](https://github.com/rkanson).

## Features

- PostCSS
  - TailwindCSS
  - Auto-prefixer
  - Nested Rules
  - Custom Media Queries (See example below)
- JS
  - ESLint
  - StimulusJS (Babel & Polyfills supporting IE11)
  - AnimeJS
  - FontAwesome
- BrowserSync

Custom Media Queries

```
  @media (width >= 1024px) {
    @apply mx-4;
  }
```

## Requirements

- Node (>= 10.15.1)
  - npm (>= 6.9.0)
- Composer (>= 1.7.3)

## Instructions

- `npm install`
  - installs all node packages
- `composer install`
  - installs all php packages
- `npm start`
  - starts development locally
  - change the proxy URL in the gulpfile.js
- `npm run build`
  - builds for production

## How To Make Custom Page Templates

- Create 2 files in this format:
  - `TEMPLATE_NAME.php`
  - `/templates/TEMPLATE_NAME.twig`
- Add the following to the php file

```
<?php

/*
* Template Name: TEMPLATE_NAME
* Pages Covered: CUSTOM PAGE
*/

get_header();
echo $twig->render('TWIG_TEMPLATE.twig');
get_footer();

```

- Add the following to the twig file

```
{% extends "layouts/base.twig" %}
{% block content %}
  YOUR HTML GOES HERE
{% endblock content %}
```

- Replace `TEMPLATE_NAME` with the name you want to appear in the Wordpress editor
- Replace `CUSTOM_PAGE` with the name of the page that this template will be used for
- Replace `TWIG_TEMPLATE` with the name of the twig file you created

**Example**

- contact.php

```
<?php

/*
* Template Name: Contact
* Pages Covered: Contact Us
*/

get_header();
echo $twig->render('contact.twig');
get_footer();
```

- /templates/contact.twig

```
{% extends "layouts/base.twig" %}
{% block content %}
  YOUR HTML GOES HERE
{% endblock content %}
```

## How To Pass Data To Twig

- example.php

```
$variable = get_post(1);
$context['VARIABLE'] = $variable;
```

- example.twig

```
<div>
  {{ variable }}
</div>
```

[Click Here to View Timber Cheatsheet](https://timber.github.io/docs/guides/cheatsheet/)

## Tailwind Notes

I've edited the base Tailwind config with a few new classes that are not listed on the documentation. See below.

**font-lato & font-mont**

- font-family: Lato
- font-family: Montserrat

**2px modifier**

- Added a 2px modifier to all utilities that use spacing
- Example: `h-2px` (height: 2px)
- Example: `mx-2px` (margin: 0 2px)

## Editor Setup

### VS Code

- PostCSS - [Extension](https://marketplace.visualstudio.com/items?itemName=cpylua.language-postcss)
- Twig - [Extension](https://marketplace.visualstudio.com/items?itemName=mblode.twig-language-2)

#### Recommended Extensions

This is a list of some of the extensions I have installed. While the 2 plugins above are included, I also recommend a lot (if not all) of the following, in use with this theme as well as any other project. Copy and paste the following in your terminal.

```
code --install-extension alefragnani.project-manager code --install-extension bmewburn.vscode-intelephense-client code --install-extension christian-kohler.npm-intellisense code --install-extension christian-kohler.path-intellisense code --install-extension CoenraadS.bracket-pair-colorizer code --install-extension cpylua.language-postcss code --install-extension dbaeumer.vscode-eslint code --install-extension EditorConfig.EditorConfig code --install-extension esbenp.prettier-vscode code --install-extension formulahendry.auto-close-tag code --install-extension formulahendry.auto-rename-tag code --install-extension mblode.twig-language-2
```

#### Recommended Settings

These settings are to configure some options in the above plugins, as well as enable some editor defaults like fix on save, hiding node_modules from the explorer, etc.

```
{
  "editor.formatOnPaste": true,
  "editor.formatOnSave": true,
  "files.associations": {
    "*.tag": "html",
    "*.j2": "jinja-html",
    "*.twig": "twig",
  },
  "git.enableSmartCommit": true,
  "git.autorefresh": true,
  "html.format.indentInnerHtml": true,
  "html.validate.scripts": true,
  "html.validate.styles": true,
  "javascript.format.enable": true,
  "php.suggest.basic": false,
  "[html]": {
    "editor.defaultFormatter": "esbenp.prettier-vscode"
  },
  "[jsonc]": {
    "editor.defaultFormatter": "esbenp.prettier-vscode"
  },
  "emmet.syntaxProfiles": {
    "postcss": "css"
  },
  "emmet.includeLanguages": {
    "jinja-html": "html",
    "jinja": "html",
    "j2": "html",
    "javascript": "javascriptreact",
    "vue-html": "html",
    "postcss": "css",
    "twig": "html",
    "html.erb": "html",
  },
  "javascript.updateImportsOnFileMove.enabled": "always",
  "[javascript]": {
    "editor.defaultFormatter": "esbenp.prettier-vscode"
  },
  "[json]": {
    "editor.defaultFormatter": "esbenp.prettier-vscode"
  },
  "auto-close-tag.activationOnLanguage": [
    "php",
    "blade",
    "javascript",
    "javascriptreact",
    "typescript",
    "typescriptreact",
    "plaintext",
    "markdown",
    "vue",
    "twig",
    "html.erb"
  ],
  "auto-rename-tag.activationOnLanguage": [
    "php",
    "blade",
    "javascript",
    "javascriptreact",
    "typescript",
    "typescriptreact",
    "plaintext",
    "markdown",
    "vue",
    "twig",
    "html.erb"
  ],
  "editor.codeActionsOnSave": {
    "source.fixAll.eslint": true
  }
}
```
