<?php namespace Ihsw\Provider;

use Silex\Application as SilexApplication;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Ihsw\Application;
use Ihsw\Entity\Post;

class PostsControllerProvider implements ControllerProviderInterface
{
    public function connect(SilexApplication $app)
    {
        // misc
        $controllers = $app['controllers_factory'];

        // route definitions
        $controllers->post('/posts', function (Application $app, Request $request) {
            $req = $request->attributes->get('request-body');

            // misc
            $em = $app->getDb()->getEntityManager();

            // creating a new post
            $post = new Post();
            $post->body = $req['body'];
            $em->persist($post);
            $em->flush();

            return $app->json($post, Response::HTTP_CREATED);
        });
        $controllers->get('/post/{id}', function (Application $app, $id) {
            // misc
            $em = $app->getDb()->getEntityManager();

            // fetching a post
            $post = $em->getRepository('Ihsw\Entity\Post')->find($id);

            return $app->json($post);
        });
        $controllers->delete('/post/{id}', function (Application $app, $id) {
            // misc
            $em = $app->getDb()->getEntityManager();

            // removing a post
            $post = $em->getRepository('Ihsw\Entity\Post')->find($id);
            $em->remove($post);
            $em->flush();

            return $app->json([]);
        });
        $controllers->put('/post/{id}', function (Application $app, Request $request, $id) {
            $req = $request->attributes->get('request-body');

            // misc
            $em = $app->getDb()->getEntityManager();

            // updating a post
            $post = $em->getRepository('Ihsw\Entity\Post')->find($id);
            $post->body = $req['body'];
            $em->persist($post);
            $em->flush();

            return $app->json($post);
        });

        return $controllers;
    }
}
