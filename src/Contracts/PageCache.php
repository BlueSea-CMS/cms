<?php

namespace BlueSea\Cms\Contracts;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PageCache
{
    /**
     * Handle creation of page's caching.
     *
     *
     * @param \Illuminate\Http\Request
     * @param \Illuminate\Http\Response
     * @return bool
     */
    public function create(Request $request, Response $response)
    {
        return $this->shouldCreate($request, $response) ? $this->buildCache($request, $response) : false;
    }

    /**
     * Recursively removes all cached pages
     *
     * @return void
     */
    public function clear()
    {
        return $this->deleteFiles($this->cachePath());
    }

    private function shouldCreate(Request $request, Response $response)
    {
        return $response->getStatusCode() == 200 && $request->isMethod('GET');
    }

    private function buildCache(Request $request, Response $response)
    {
        $file = new Filesystem();

        return (bool) $file->put($this->getOutputPath($request), $response->getContent(), true);
    }

    private function getOutputPath(Request $request)
    {
        $dest = $this->cachePath() . '/';

        $dest .= ltrim($request->getPathInfo(), '/');

        if(!is_dir($dest))
        {
            mkdir($dest, 0777, true);
        }

        return $dest . $this->getOutputFile() . '.html';
    }

    public function cachePath()
    {
        return config('BlueSeaCms.cache.path') != null ? public_path(config('BlueSeaCms.cache.path')) : public_path('BlueSeaCms');
    }

    private function getOutputFile()
    {
        return (config('BlueSeaCms.cache.index')) ?? 'BlueSeaCms_cache_index';
    }

    private function getFiles($folder)
    {
        $files = scandir($folder);

        array_splice($files, array_search('.', $files), 1);

        array_splice($files, array_search('..', $files), 1);

        return $files;
    }

    private function deleteFiles($folder)
    {
        $files = $this->getFiles($folder);

        foreach($files as $file)
        {
            $path = $folder . '/' . $file;
            if(is_dir($path))
            {
                $this->deleteFiles($path);
                rmdir($path);
            }
            else
            {
                unlink($path);
            }
        }

    }
}
