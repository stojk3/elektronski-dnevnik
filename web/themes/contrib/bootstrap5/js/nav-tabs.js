/**
 * @file
 * Responsive navigation tabs (local tasks).
 *
 * Element requires to have class .is-collapsible and attribute
 *   [data-drupal-nav-tabs]
 */
((Drupal, once) => {
  function init(index, tab) {
    const target = tab.querySelector('[data-drupal-nav-tabs-target]');

    const openMenu = () => {
      target.classList.toggle('is-open');
      const toggle = target.querySelector('.tab-toggle');
      const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', !isExpanded);
    };

    tab.addEventListener('click', (event) => {
      if (event.target.matches('[data-drupal-nav-tabs-toggle]')) {
        openMenu();
      }
    });
  }

  /**
   * Initialize the tabs JS.
   */
  Drupal.behaviors.navTabs = {
    attach(context) {
      const elements = once(
        'nav-tabs',
        '[data-drupal-nav-tabs].is-collapsible',
        context,
      );
      elements.forEach((element, index) => {
        init(index, element);
      });
    },
  };
})(Drupal, once);
