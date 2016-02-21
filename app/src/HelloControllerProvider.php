<?php namespace Ihsw;

use Silex\Application as SilexApplication,
  Silex\ControllerProviderInterface,
  Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Ihsw\Application;
use IhswEntity\Post;

class HelloControllerProvider implements ControllerProviderInterface
{
  public function connect(SilexApplication $app)
  {
    // adding middlewares
    $app->before(function(Request $request) {
      if ($request->headers->get('Content-type') !== 'application/json') {
        return;
      }

      $data = json_decode($request->getContent(), true);
      $request->attributes->set('request-body', $data);
    });
    $app->before(function(Request $request) use ($app) {
      $loggingEnvBlacklist = ['test', 'travis'];
      if (in_array(getenv('ENV'),  $loggingEnvBlacklist)) {
        return;
      }

      $app->getLogger()->addInfo('Url hit', [
        'url' => $request->getUri(),
        'body' => $request->getContent(),
        'content-type' => $request->headers->get('content-type'),
        'method' => $request->getMethod()
      ]);
    });

    /**
     * setting up the controllers
     */
    // misc
    $controllers = $app['controllers_factory'];

    // route definitions
    $controllers->get('/', function (Application $app) {
      return 'Hello, world!';
    });
    $controllers->get('/ping', function (Application $app) {
      return 'Pong';
    });
    $controllers->post(
      '/reflection',
      function (Application $app, Request $request) {
        return $app->json($request->attributes->get('request-body'));
      }
    );
    $controllers->post(
      '/posts',
      function (Application $app, Request $request) {
        $req = $request->attributes->get('request-body');

        // misc
        $em = $app->getDb()->getEntityManager();

        $post = new Post();
        $post->setBody($req['body']);
        $em->persist($post);
        $em->flush();

        return $app->json([
          'id' => $post->getId()
        ]);
      }
    );
    $controllers->get(
      '/post/{id}',
      function (Application $app, $id) {
        $em = $app->getDb()->getEntityManager();
        $post = $em->getRepository('IhswEntity\Post')->find($id);
        return $app->getSerializer()->serialize($post, 'json');
      }
    );
    $controllers->delete(
      '/post/{id}',
      function (Application $app, $id) {
        $em = $app->getDb()->getEntityManager();
        $post = $em->getRepository('IhswEntity\Post')->find($id);
        $em->remove($post);
        $em->flush();
        return $app->json([]);
      }
    );
    $controllers->put(
      '/post/{id}',
      function (Application $app, Request $request, $id) {
        $req = $request->attributes->get('request-body');

        // misc
        $em = $app->getDb()->getEntityManager();

        $post = $em->getRepository('IhswEntity\Post')->find($id);
        $post->setBody($req['body']);
        $em->persist($post);
        $em->flush();

        return $app->getSerializer()->serialize($post, 'json');
      }
    );

    return $controllers;
  }
}
