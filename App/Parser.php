<?php

namespace App;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelectorConverter;

class Parser {
    
    protected $converter;
    protected $crawler;
    
    public function __construct(string $data)
    {
        $this->converter = new CssSelectorConverter();
        $this->crawler = new Crawler();
        $this->crawler->addContent($data);
    }
    
    public function getData(string $path): array
    {
        $ret = [];
        
        $all = $this->crawler->filter($path);
        foreach($all as $val) {
            if($val->childElementCount === 3) {
                
                [$title, $description, $price1, $price2] =
                    preg_split('/\n\n\n*/', trim($val->textContent));
                
                $ret[] = [
                    'title'=> $title,
                    'description' => explode("\n", $description),
                    'price1' => $price1,
                    'price2' => $price2];
            }
        }
        return $ret;
    }    
}