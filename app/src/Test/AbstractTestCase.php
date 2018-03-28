<?php namespace Ihsw\Test;

use Silex\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Ihsw\Application;

abstract class AbstractTestCase extends WebTestCase
{
    use RequestHelpers;
    use EntityHelpers;

    public function createApplication()
    {
        $app = new Application();
        $app['debug'] = true;
        $app->error(function (\Exception $e, $code) use ($app) {
            printf("error: %s\n", $e->getMessage());
            return $app->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
        return $app->load();
    }
}
