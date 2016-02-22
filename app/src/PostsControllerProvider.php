<?php namespace Ihsw;

use Silex\Application as SilexApplication,
  Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Ihsw\Application;
use IhswEntity\Post;

class PostsControllerProvider implements ControllerProviderInterface
{
  public function connect(SilexApplication $app)
  {
    // misc
    $controllers = $app['controllers_factory'];

    // route definitions
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
