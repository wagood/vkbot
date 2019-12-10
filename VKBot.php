<?php
use VK\Client\VKApiClient;
use Dotenv\Dotenv;

/**
 * Class VKBot
 * @author WAGOOD [wagood@yandex.ru]
 */
class VKBot extends VK\CallbackApi\Server\VKCallbackApiServerHandler {
  // API version
  protected static $API_VERSION;

  // API key
  protected static $ACCESS_TOKEN;

  // Callback API keys
  protected static $GROUP_SECRET;
  protected static $GROUP_ID;
  protected static $GROUP_CONFIRMATION_TOKEN;

  protected $VKApiClient; // VK\Client\VKApiClient instance

  public function __construct()
  {
    // load form .env
    Dotenv::createImmutable(__DIR__)->load();
    self::$API_VERSION = getenv('API_VERSION');
    self::$ACCESS_TOKEN = getenv('ACCESS_TOKEN');
    self::$GROUP_SECRET = getenv('GROUP_SECRET');
    self::$GROUP_ID = getenv('GROUP_ID');
    self::$GROUP_CONFIRMATION_TOKEN = getenv('GROUP_CONFIRMATION_TOKEN');
    $this->VKApiClient = new VKApiClient(self::$API_VERSION);
  }

  public function confirmation(int $group_id, ?string $secret): string {
    if ($secret === self::$GROUP_SECRET && $group_id === self::$GROUP_ID) {
      echo self::$GROUP_CONFIRMATION_TOKEN;
    }
  }

  public function messageNew(int $group_id, ?string $secret, array $object): string {
    if (is_array($object) && isset($object['text'], $object['peer_id'])) {
      $message_text = strtolower(trim($object['text']));
      $peer_id = $object['peer_id'];
      if (strcmp($message_text, 'привет') === 0) {
        $this->VKApiClient->messages()->send(
          self::$ACCESS_TOKEN,
          [
            'random_id' => time(),
            'peer_id' => $peer_id,
            'message' => 'И тебе привет!'
          ]);
      }
      if (strcmp($message_text, 'пока') === 0){
        $this->VKApiClient->messages()->send(
          self::$ACCESS_TOKEN,
          [
            'random_id' => time(),
            'peer_id' => $peer_id,
            'message' => 'Возвращайся поболтать!'
          ]);
      }
    }
    echo 'ok';
  }
}