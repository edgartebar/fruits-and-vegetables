<?php

namespace App\Tests\Functional\Market\Aplication\List;

use App\Tests\Functional\DataFixtures\FruitsDataFixture;
use App\Tests\Functional\DataFixtures\VegetablesDataFixture;
use App\Tests\Functional\FunctionalTestCase;
use Doctrine\Common\DataFixtures\ReferenceRepository;

class ListItemTest extends FunctionalTestCase
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

    public function testGetAllItems(): void
    {
        $this->client->request('GET', '/items', [], [], ['CONTENT_TYPE' => 'application/json']);

        $this->assertResponseIsSuccessful();

        $responseContent = $this->client->getResponse()->getContent();
        $items = json_decode($responseContent, true);

        $this->assertIsArray($items);

        $this->assertCount(6, $items);
    }

    public function testFilterByTypeAndName(): void
    {
        $this->client->request('GET', '/items?type=vegetable', [], [], ['CONTENT_TYPE' => 'application/json']);

        $this->assertResponseIsSuccessful();

        $responseContent = $this->client->getResponse()->getContent();
        $items = json_decode($responseContent, true);

        $this->assertIsArray($items);
        $this->assertCount(3, $items);
    }

    public function testFilterByGreaterThan(): void
    {
        $this->client->request('GET', '/items?gt=150', [], [], ['CONTENT_TYPE' => 'application/json']);

        $this->assertResponseIsSuccessful();

        $responseContent = $this->client->getResponse()->getContent();
        $items = json_decode($responseContent, true);

        $this->assertIsArray($items);
        $this->assertCount(3, $items);
    }

    public function testFilterByLessThan(): void
    {
        $this->client->request('GET', '/items?lt=150', [], [], ['CONTENT_TYPE' => 'application/json']);

        $this->assertResponseIsSuccessful();

        $responseContent = $this->client->getResponse()->getContent();
        $items = json_decode($responseContent, true);

        $this->assertIsArray($items);
        $this->assertCount(5, $items);

    }

    public function testFilterByGreaterThanAndLessThan(): void
    {
        $this->client->request('GET', '/items?gt=100&lt=200', [], [], ['CONTENT_TYPE' => 'application/json']);

        $this->assertResponseIsSuccessful();

        $responseContent = $this->client->getResponse()->getContent();
        $items = json_decode($responseContent, true);

        $this->assertIsArray($items);
        $this->assertCount(5, $items);
    }

    public function testGetItemsInKilograms(): void
    {
        $this->client->request('GET', '/items?units=kg', [], [], ['CONTENT_TYPE' => 'application/json']);

        $this->assertResponseIsSuccessful();

        $responseContent = $this->client->getResponse()->getContent();
        $items = json_decode($responseContent, true);

        $this->assertIsArray($items);

        foreach ($items as $item) {
            $this->assertArrayHasKey('weight', $item);
            $this->assertSame('kg', $item['units']);
        }
    }

    public function testGetItemsInGrams(): void
    {
        $this->client->request('GET', '/items?units=g', [], [], ['CONTENT_TYPE' => 'application/json']);

        $this->assertResponseIsSuccessful();

        $responseContent = $this->client->getResponse()->getContent();
        $items = json_decode($responseContent, true);

        $this->assertIsArray($items);

        foreach ($items as $item) {
            $this->assertArrayHasKey('weight', $item);
            $this->assertSame('g', $item['units']);
        }
    }
}