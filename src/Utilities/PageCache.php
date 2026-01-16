<?php

namespace Bitcms\Utilities;

use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\Http\ServerRequest;

abstract class PageCache
{
    const string CACHE_DIR = 'tmp/cache/page_cache';

    public static function generateForView(EventInterface $event): void
    {
        /** @var Response $response */
        $response = $event->getSubject()->getResponse();

        /** @var ServerRequest $request */
        $request = $event->getSubject()->getRequest();

        if (
            !$request->is('get') ||
            $response->getStatusCode() !== 200 ||
            $response->getType() !== 'text/html' ||
            str_contains($request->getUri()->getPath(), '/bitcms')
        ) {
            return;
        }

        self::checkCacheDirectory();
        $fileName = self::generateCacheFileName($request->getRequestTarget());


        $filePath = ROOT . DS . self::CACHE_DIR . DS . $fileName;
        $cachedString = '<!-- Cached on ' . date('Y-m-d H:i:s') . ' - By the amazing and empowering Gijs Code -->';
        file_put_contents($filePath, (string)$response->getBody() . $cachedString);
    }

    public static function getForView(EventInterface $event): ?string
    {
        // check if there is a cached version of the current URL and return it
        /** @var ServerRequest $request */
        $request = $event->getSubject()->getRequest();
        $url = $request->getRequestTarget();

        $fileName = self::generateCacheFileName($url);
        $filePath = ROOT . DS . self::CACHE_DIR . DS . $fileName;
        if (file_exists($filePath)) {
            return file_get_contents($filePath);
        }

        return null;
    }

    protected static function checkCacheDirectory(): void
    {
        $cacheDir = ROOT . DS . self::CACHE_DIR;
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }
    }

    protected static function generateCacheFileName(string $url): string
    {
        // convert the url to a file name safe string
        $fileName = preg_replace('/[^a-zA-Z0-9-_]/', '_', $url);

        //  get the browser type (chrome / firefox / safari / edge / opera) from the user agent
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (stripos($userAgent, 'chrome') !== false) {
            $fileName .= '_chrome';
        } elseif (stripos($userAgent, 'firefox') !== false) {
            $fileName .= '_firefox';
        } elseif (stripos($userAgent, 'safari') !== false) {
            $fileName .= '_safari';
        } elseif (stripos($userAgent, 'edge') !== false) {
            $fileName .= '_edge';
        } elseif (stripos($userAgent, 'opera') !== false) {
            $fileName .= '_opera';
        } else {
            $fileName .= '_other';
        }

        // check if the user is on mobile or desktop
        $isMobile = preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $userAgent);
        if ($isMobile) {
            $fileName .= '_mobile';
        } else {
            $fileName .= '_desktop';
        }

        return md5($fileName) . '.html';
    }
}
