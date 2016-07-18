<?php

namespace Drupal\views_timelinejs\TimelineJS;

use Drupal\views_timelinejs\TimelineJS\EraInterface;
use Drupal\views_timelinejs\TimelineJS\SlideInterface;
use Drupal\views_timelinejs\TimelineJS\TimelineInterface;

/**
 * Defines a TimelineJS3 timeline.
 */
class Timeline implements TimelineInterface {

  /**
   * The timeline scale.
   *
   * @var string
   */
  protected $scale = 'human';

  /**
   * The timeline's title slide.
   *
   * @var SlideInterface
   */
  protected $title_slide;

  /**
   * The timeline's array of event slides.
   *
   * @var array
   */
  protected $events = array();

  /**
   * The timeline's array of eras.
   *
   * @var array
   */
  protected $eras = array();

  /**
   * {@inheritdoc}
   */
  public function setTitleSlide(SlideInterface $slide) {
    $this->title_slide = $slide;
  }

  /**
   * {@inheritdoc}
   */
  public function getTitleSlide() {
    return $this->title_slide;
  }

  /**
   * {@inheritdoc}
   */
  public function addEvent(SlideInterface $slide) {
    $this->events[] = $slide;
  }

  /**
   * {@inheritdoc}
   */
  public function getEvents() {
    return $this->events;
  }

  /**
   * {@inheritdoc}
   */
  public function addEra(EraInterface $era) {
    $this->eras[] = $era;
  }

  /**
   * {@inheritdoc}
   */
  public function getEras() {
    return $this->eras;
  }

  /**
   * {@inheritdoc}
   */
  public function setScaleToHuman() {
    $this->scale = 'human';
  }

  /**
   * {@inheritdoc}
   */
  public function setScaleToCosomological() {
    $this->scale = 'cosomological';
  }

  /**
   * {@inheritdoc}
   */
  public function getScale() {
    return $this->scale;
  }

  /**
   * {@inheritdoc}
   */
  public function buildArray() {
    $timeline = array('scale' => $this->scale);
    if (!empty($this->title_slide)) {
      $timeline['title'] = $this->title_slide->buildArray();
    }
    foreach ($this->events as $event) {
      $timeline['events'][] = $event->buildArray();
    }
    foreach ($this->eras as $era) {
      $timeline['eras'][] = $era->buildArray();
    }
    return $timeline;
  }

}
