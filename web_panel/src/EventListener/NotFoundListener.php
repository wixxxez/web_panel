<?php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
class NotFoundListener
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        // Check if the exception is a NotFoundHttpException
        if (!$event->getThrowable() instanceof NotFoundHttpException) {
            return;
        }

        // Render your custom 404 page using Twig
        $content = $this->twig->render('errors/error404.html.twig');

        // Create the response with the rendered content
        $response = new Response($content);

        // Set the response code to 404
        $response->setStatusCode(Response::HTTP_NOT_FOUND);

        // Send the response
        $event->setResponse($response);
    }
}
?>