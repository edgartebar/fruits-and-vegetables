<?php

namespace App\Tests\Functional\Market\Aplication\Search;

use App\Tests\Functional\DataFixtures\FruitsDataFixture;
use App\Tests\Functional\DataFixtures\VegetablesDataFixture;
use App\Tests\Functional\FunctionalTestCase;
use Doctrine\Common\DataFixtures\ReferenceRepository;

class SearchItemTest extends FunctionalTestCase
{
    private ReferenceRepository $referenceRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->referenceRepository = $this->databaseTool->loadFixtures([
            FruitsDataFixture::class,
            VegetablesDataFixture::class,
        ])->getReferenceRepository();
    }

    public function testSearchWithoutFilters(): void
    {
        $this->client->request('GET', '/items/search', [], [], ['CONTENT_TYPE' => 'application/json']);

        $this->assertResponseIsSuccessful();

        $responseContent = $this->client->getResponse()->getContent();
        $items = json_decode($responseContent, true);

        $this->assertIsArray($items);
        $this->assertCount(6, $items);

    }

    public function testSearchWithTypeFilter(): void
    {
        $this->client->request('GET', '/items/search?type=fruit', [], [], ['CONTENT_TYPE' => 'application/json']);

        $this->assertResponseIsSuccessful();

        $responseContent = $this->client->getResponse()->getContent();
        $items = json_decode($responseContent, true);

        $this->assertIsArray($items);
        $this->assertCount(3, $items);
    }

    public function testSearchWithNameFilter(): void
    {
        $this->client->request('GET', '/items/search?name=Carrot', [], [], ['CONTENT_TYPE' => 'application/json']);

        $this->assertResponseIsSuccessful();

        $responseContent = $this->client->getResponse()->getContent();
        $items = json_decode($responseContent, true);

        $this->assertIsArray($items);
        $this->assertCount(1, $items);
        $this->assertEquals('Carrot', $items[0]['name']);
    }

    public function testSearchWithMultipleFilters(): void
    {
        $this->client->request('GET', '/items/search?type=vegetable&name=Tomato', [], [], ['CONTENT_TYPE' => 'application/json']);

        $this->assertResponseIsSuccessful();

        $responseContent = $this->client->getResponse()->getContent();
        $items = json_decode($responseContent, true);

        $this->assertIsArray($items);
        $this->assertCount(1, $items);
        $this->assertEquals('Tomato', $items[0]['name']);
    }

    public function testSearchWithPagination(): void
    {
        $this->client->request('GET', '/items/search?type=vegetable&limit=2&offset=1', [], [], ['CONTENT_TYPE' => 'application/json']);

        $this->assertResponseIsSuccessful();

        $responseContent = $this->client->getResponse()->getContent();
        $items = json_decode($responseContent, true);

        $this->assertIsArray($items);
        $this->assertCount(2, $items);
    }
}