<?php namespace Ihsw;

use Silex\Application as SilexApplication;
use Symfony\Component\HttpFoundation\Request,
  Symfony\Component\HttpFoundation\Response;
use Monolog\Logger,
  Monolog\Handler\StreamHandler;
use Ihsw\DefaultControllerProvider,
  Ihsw\PostsControllerProvider,
  Ihsw\Db;

class Application extends SilexApplication
{
  private $db;
  private $serializer;
  private $logger;

  public function load()
  {
    // adding middlewares
    $this->before(function(Request $request) {
      if ($request->headers->get('Content-type') !== 'application/json') {
        return;
      }

      $data = json_decode($request->getContent(), true);
      $request->attributes->set('request-body', $data);
    });
    $this->before(function(Request $request) {
      $loggingEnvBlacklist = ['test', 'travis'];
      if (in_array(getenv('ENV'),  $loggingEnvBlacklist)) {
        return;
      }

      $this->getLogger()->addInfo('Url hit', [
        'url' => $request->getUri(),
        'body' => $request->getContent(),
        'content-type' => $request->headers->get('content-type'),
        'method' => $request->getMethod()
      ]);
    });


    // loading routes
    $this->mount('/', new DefaultControllerProvider());
    $this->mount('/', new PostsControllerProvider());

    return $this;
  }

  public function plain($body, $status = Response::HTTP_OK) {
    return new Response($body, $status, ['Content-type' => 'text/plain']);
  }

  public function getDb()
  {
    if (!is_null($this->db)) {
      return $this->db;
    }

    $this->db = new Db([
      'driver' => 'pdo_pgsql',
      'host' => getenv('DATABASE_HOST'),
      'dbname' => 'postgres',
      'user' => 'postgres',
      'password' => ''
    ]);
    return $this->db;
  }

  public function getLogger()
  {
    if (!is_null($this->logger)) {
      return $this->logger;
    }

    $logger = new Logger('pho-sho');
    $logger->pushHandler(new StreamHandler(sprintf('%s/log/app.log', getcwd())));
    $this->logger = $logger;
    return $this->logger;
  }
}
