<?php

namespace App;

use Elastic\Elasticsearch\ClientBuilder;

class Index {
    
    const properties = [
                        'title' => [
                            'type' => 'keyword'
                        ],
                        'description' => [
                            'type' => 'nested',
                            'properties' => [
                                'line' => [
                                    'type' => 'text'
                                ]]
                        ],                        
                        'price1' => [
                            'type' => 'text'
                        ],
                        'price2' => [
                            'type' => 'text'
                        ]
                    ];

    protected $client;
       
    public function __construct(array $hosts, string $user, string $password)
    {
        $this->client = ClientBuilder::create()
                ->setHosts($hosts)
                ->setBasicAuthentication($user, $password)
                ->setSSLVerification(false)
                ->build();
    }

    public function createIndex(string $name) {
        $params = [
            'index' => $name,
            'listing' => [
                'mappings' => [
                    'properties' => Index::properties
                ]
            ]
        ];
        
        $this->client->indices()->create($params);
    }
    
    public function fill(string $name, array $list) {        
        $params = [];
        
        foreach($list as $i => $val) {
            $params['body'][] = [
                'index' => [
                    '_index' => $name,
                     '_id'    => $i
                ]
            ];
            
            $params['body'][] = $val;
        }
        
        $this->client->bulk($params);

    }
}
