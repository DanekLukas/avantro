<?php
require_once dirname(__DIR__).'/vendor/autoload.php';
require_once dirname(__DIR__).'/App/Parser.php';
require_once dirname(__DIR__).'/App/Index.php';

use App\Parser;
use App\Index;

    $data = file_get_contents('https://foxentry.com/cs/cenik-api');
    $parser = new Parser($data);
    $list = $parser->getData('table#price-table > tbody > tr:not(.table-section)');
    
    $indexName = 'avantro';
    $index = new Index(['https://localhost:9200'], 'elastic', 'passwrd');
    $index->createIndex($indexName);          
    $index->fill($indexName, $list);
?>
done