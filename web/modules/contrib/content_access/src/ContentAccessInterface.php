<?php

namespace Drupal\content_access;

/**
 * Provides an interface for content_access constants.
 */
interface ContentAccessInterface {

  /**
   * The threshold until we try to mass update node grants immediately.
   */
  const CONTENT_ACCESS_MASS_UPDATE_THRESHOLD = 1000;

}
