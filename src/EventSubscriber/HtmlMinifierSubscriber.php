<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class HtmlMinifierSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        $contentType = $response->headers->get('Content-Type');

        // On minifie uniquement le HTML
        if ($contentType && str_contains($contentType, 'text/html')) {
            $content = $response->getContent();

            // Minification simple
            $minified = $this->minifyHtml($content);

            dd($minified);

            $response->setContent($minified);
        }
    }

    private function minifyHtml(string $html): string
    {
        // Supprimer les commentaires HTML
        $html = preg_replace('/<!--(?!\[if).*?-->/', '', $html);

        // Supprimer les espaces entre les balises
        $html = preg_replace('/>\s+</', '><', $html);

        // Supprimer les lignes vides, retours, tabulations
        $html = preg_replace('/\s{2,}/', ' ', $html);
        $html = str_replace(["\n", "\r", "\t"], '', $html);

        return trim($html);
    }
}
