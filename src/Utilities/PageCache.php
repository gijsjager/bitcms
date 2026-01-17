<?php

namespace Bitcms\Utilities;

use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\Http\ServerRequest;

abstract class PageCache
{
    const string CACHE_DIR = 'tmp/cache/page_cache';
    static bool $enabled = true;

    /**
     * Call this method if you want to disable the page cache for the current request
     * @return void
     */
    public static function disable(): void
    {
        self::$enabled = false;
    }

    /**
     * Generate a cached version of the current page
     * @param EventInterface $event
     * @return void
     */
    public static function generateForView(EventInterface $event): void
    {
        /** @var Response $response */
        $response = $event->getSubject()->getResponse();

        /** @var ServerRequest $request */
        $request = $event->getSubject()->getRequest();

        if (!self::willUseCache($request, $response)) {
            return;
        }

        self::checkCacheDirectory();
        $fileName = self::generateCacheFileName($request->getRequestTarget());

        $filePath = ROOT . DS . self::CACHE_DIR . DS . $fileName;

        $body = (string)$response->getBody();
        if (empty($body)) {
            return;
        }

        // append a cached string to the body
        $cachedString = '<!-- Cached on ' . date('Y-m-d H:i:s') . ' - By the amazing and empowering Gijs Code -->';
        file_put_contents($filePath, $body . $cachedString);
    }

    /**
     * Get the cached version of the current page if available
     * @param EventInterface $event
     * @return string|null
     */
    public static function getForView(EventInterface $event): ?string
    {
        $request = $event->getSubject()->getRequest();
        $response = $event->getSubject()->getResponse();

        if (!self::willUseCache($request, $response)) {
            return null;
        }

        // check if there is a cached version of the current URL and return it
        $url = $request->getRequestTarget();
        $fileName = self::generateCacheFileName($url);
        $filePath = ROOT . DS . self::CACHE_DIR . DS . $fileName;
        if (file_exists($filePath)) {
            return file_get_contents($filePath);
        }

        return null;
    }

    /**
     * Clear cached pages that match the given needle
     * @param string $needle
     * @return void
     */
    public static function clear(string $needle): void
    {
        $cacheDir = ROOT . DS . self::CACHE_DIR;
        if (is_dir($cacheDir)) {
            $files = glob($cacheDir . DS . '*.html');
            foreach ($files as $file) {
                if (str_contains($file, md5(preg_replace('/[^a-zA-Z0-9-_]/', '_', $needle)))) {
                    unlink($file);
                }
            }
        }
    }

    /**
     * Clear all cached pages
     * @return void
     */
    public static function clearAll(): void
    {
        $cacheDir = ROOT . DS . self::CACHE_DIR;
        if (is_dir($cacheDir)) {
            $files = glob($cacheDir . DS . '*.html');
            foreach ($files as $file) {
                unlink($file);
            }
        }
    }

    /**
     * Ensure the cache directory exists
     * @return void
     */
    protected static function checkCacheDirectory(): void
    {
        $cacheDir = ROOT . DS . self::CACHE_DIR;
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }
    }

    /**
     * Generate a cache file name based on the URL and user agent
     * @param string $url
     * @return string
     */
    protected static function generateCacheFileName(string $url): string
    {
        // convert the url to a file name safe string
        $fileName = preg_replace('/[^a-zA-Z0-9-_]/', '_', $url);

        //  get the browser type (chrome / firefox / safari / edge / opera) from the user agent
        $userAgent = $_SERVER['HTTP_USER_AGENT'];

        // check if the user is on mobile or desktop
        $isMobile = preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $userAgent);
        if ($isMobile) {
            $fileName .= '_mobile';
        } else {
            $fileName .= '_desktop';
        }

        return $fileName . '.html';
    }

    /**
     * Determine if the cache should be used for the given request and response
     * @param ServerRequest $request
     * @param Response $response
     * @return bool
     */
    protected static function willUseCache(ServerRequest $request, Response $response): bool
    {
        if (
            !self::$enabled ||
            $request->getQuery('_nocache', false) ||
            !$request->is('get') ||
            $response->getStatusCode() !== 200 ||
            $response->getType() !== 'text/html' ||
            str_contains($request->getUri()->getPath(), '/bitcms')
        ) {
            return false;
        }

        return true;
    }
}
