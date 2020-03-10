<?php

namespace Drupal\status_config\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Class watches for page load, logs and sets status message.
 */
class StatusConfigSubscriber implements EventSubscriberInterface {

  /**
   * Subscribes to page request event.
   */
  public function checkForPageLoad(GetResponseEvent $event) {
    $request_format = $event->getRequest()->getRequestFormat();

    $config = $this->configFactory->get('status_config.settings');

    $logmessage = $config->get('custom_log_message') ?? 'Custom log message';
    $statusmessage = $config->get('custom_status_message') ?? 'Custom status message';

    if ($request_format === 'html') {
      $this->loggerChannel->get('default')->info($logmessage);
      $this->messenger->addStatus($statusmessage);

    }
    else {
      // No message if not HTML request.
    }

  }

  protected $messenger;
  protected $loggerChannel;
  protected $configFactory;

  /**
   * Constructs .
   *
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $loggerChannel
   *   Write to log.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   Set messages.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   Load config values.
   */
  public function __construct(LoggerChannelFactoryInterface $loggerChannel, MessengerInterface $messenger, ConfigFactoryInterface $config_factory) {
    $this->loggerChannel = $loggerChannel;
    $this->messenger = $messenger;
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    // 'checkForPageLoad' is the name of our function
    $events[KernelEvents::REQUEST][] = ['checkForPageLoad'];
    return $events;
  }

}
