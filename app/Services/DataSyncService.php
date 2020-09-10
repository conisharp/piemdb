<?php

namespace App\Services;

use App\Models\Movie;
use App\Repositories\Interfaces\IPieMDBDataSourceRepository;
use App\Services\Interfaces\IDataSyncService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Storage;

class DataSyncService implements IDataSyncService
{
    protected $client;
    protected $host;
    protected $pieMDBDataSourceRepository;

    public function __construct(Client $client, IPieMDBDataSourceRepository $pieMDBDataSourceRepository)
    {
        $this->client = $client;
        $this->host = env('PIEMDB_JSON_DATASOURCE');
        $this->pieMDBDataSourceRepository = $pieMDBDataSourceRepository;
    }

    public function synchronize()
    {
        $this->_cleanup();
        $data = $this->pieMDBDataSourceRepository->all();

        foreach ($data as &$dataEntry) {
            $this->_parseImages($dataEntry['cardImages']);
            $this->_parseImages($dataEntry['keyArtImages']);
            Movie::create(['entry' => json_encode($dataEntry)]);
        }
    }

    protected function _parseImages(&$images)
    {
        foreach ($images as $key => &$image) {
            if (!empty($image['url'])) {
                try {
                    $storagePath = storage_path(sprintf('app/public/%s.%s', uniqid('', true), pathinfo($image['url'], PATHINFO_EXTENSION)));
                    $this->client->get($image['url'], ['sink' => $storagePath]);
                    $image['url'] = asset(Storage::url(sprintf('%s.%s', pathinfo($storagePath, PATHINFO_FILENAME), pathinfo($storagePath, PATHINFO_EXTENSION))));
                    continue;
                } catch (ClientException $exception) {
//                    dump($exception);
                } catch (\Exception $exception) {
//                    dump($exception);
                }
            }

            unset($images[$key]);
        }

        $images = array_values($images);
    }

    protected function _cleanup()
    {
        $files = Storage::allFiles('public');

        array_shift($files);

        Storage::delete($files);

        Movie::query()->truncate();
    }
}
