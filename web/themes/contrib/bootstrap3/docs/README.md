<!-- @file Documentation landing page and topics for the https://drupal-bootstrap.org site. -->
<!-- @mainpage -->
# Drupal Bootstrap 3 Documentation

{.lead} The official documentation site for the [Drupal Bootstrap 3] base theme

The majority of this site is automatically generated from source files
located through out the project's repository. Topics are extracted from Markdown
files and the rest is extracted from embedded PHP comments.

---

## Topics

Below are some topics to help get you started using the [Drupal Bootstrap 3] base
theme. They are ordered based on the level one typically progresses while using
a base theme like this.

#### [Contributing](<!-- @url contributing -->)

#### [Getting Started](<!-- @url getting_started -->)

#### [Theme Settings](<!-- @url theme_settings -->)

#### [Sub-Theming](<!-- @url sub_theming -->)

#### [Templates](<!-- @url templates -->)

#### [Utilities](<!-- @url utility -->)

#### [Plugin System](<!-- @url plugins -->)
- [@BootstrapAlter](<!-- @url plugins_alter -->)
- [@BootstrapForm](<!-- @url plugins_form -->)
- [@BootstrapPreprocess](<!-- @url plugins_preprocess -->)
- [@BootstrapPrerender](<!-- @url plugins_prerender -->)
- [@BootstrapProcess](<!-- @url plugins_process -->)
- [@BootstrapProvider](<!-- @url plugins_provider -->)
- [@BootstrapSetting](<!-- @url plugins_setting -->)
- [@BootstrapUpdate](<!-- @url plugins_update -->)

#### [Project Maintainers](<!-- @url maintainers -->)

---

## Terminology

The term **"bootstrap"** can be used excessively through out this project's
documentation. For clarity, we will always attempt to use this word verbosely
in one of the following ways:

- **[Drupal Bootstrap 3]** refers to the Drupal base theme project.
- **[Bootstrap Framework](https://getbootstrap.com/docs/3.4/)** refers to the
  external front end framework.
- **[drupal_bootstrap 3](https://api.drupal.org/apis/drupal_bootstrap3)** refers
  to Drupal's bootstrapping process or phase.

When referring to files inside the [Drupal Bootstrap 3] project directory, they
will always start with `./themes/bootstrap3` and continue to specify the full
path to the file or directory inside it. The dot (`.`) is representative of
your Drupal installation's `DOCROOT` folder. For example, the file that is
responsible for displaying the text on this page is located at
`./themes/bootstrap3/docs/README.md`.

When referring to files inside a sub-theme, they will always start with
`./themes/THEMENAME/`, where `THEMENAME` is the machine name of your sub-theme.
They will continue to specify the full path to the file or directory inside it.
For example, the primary file Drupal uses to determine if a theme exists is:
`./themes/THEMENAME/THEMENAME.info.yml`.

{.alert.alert-info} **NOTE:** It is common practice to place projects found on
Drupal.org inside a sub-folder named `contrib` and custom/site-specific code
inside a `custom` folder. If your site is set up this way, please adjust all
paths accordingly (i.e. `./themes/contrib/bootstrap3` and
`./themes/custom/THEMENAME`).

[Drupal Bootstrap 3]: https://www.drupal.org/project/bootstrap3
