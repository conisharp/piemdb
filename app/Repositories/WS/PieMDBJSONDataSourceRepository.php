<?php


namespace App\Repositories\WS;


use App\Helpers\Encoding;
use App\Repositories\Interfaces\IPieMDBDataSourceRepository as IPieMDBDataSourceRepositoryIAlias;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class PieMDBJSONDataSourceRepository implements IPieMDBDataSourceRepositoryIAlias
{
    protected $client;
    protected $host;
    protected static $data;


    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->host = env('PIEMDB_JSON_DATASOURCE');
    }

    public function all()
    {
        $this->_load();

        return static::$data;
    }

    protected function _load()
    {
        static $executed = 0;

        if (!$executed) {
            try {
                $response = $this->client->get($this->host);

                static::$data = $response->getBody()->getContents();

                static::$data = Encoding::fixUTF8(static::$data);

                static::$data = \GuzzleHttp\json_decode(static::$data, true);

                $executed++;
            } catch (ClientException $exception) {
                dump($exception);
            } catch (\Exception $exception) {
                dump($exception);
            }
        }
    }
}
