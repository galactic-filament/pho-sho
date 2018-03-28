<?php namespace Ihsw\Provider;

use Silex\Application as SilexApplication;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Ihsw\Application;
use Ihsw\Entity\User;

class UsersControllerProvider implements ControllerProviderInterface
{
    public function connect(SilexApplication $app)
    {
        // misc
        $controllers = $app['controllers_factory'];

        // route definitions
        $controllers->post('/users', function (Application $app, Request $request) {
            $req = $request->attributes->get('request-body');

            // misc
            $em = $app->getDb()->getEntityManager();

            // creating a new post
            $user = new User();
            $user->email = $req['email'];
            $user->hashedPassword = $req['password'];
            $em->persist($user);
            $em->flush();

            return $app->json($user, Response::HTTP_CREATED);
        });

        return $controllers;
    }
}
