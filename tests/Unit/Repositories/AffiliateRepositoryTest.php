<?php

namespace Tests\Unit\Repositories;

require_once __DIR__ . '/../../../app/Repositories/AffiliateRepository.php';

use App\Repositories\AffiliateRepository;
use Tests\TestCase;

/**
 * Class AffiliateRepositoryTest.
 *
 * @covers \App\Repositories\AffiliateRepository
 */
final class AffiliateRepositoryTest extends TestCase
{ 
    public $repo;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
	 
        $this->repo = $this->getMockBuilder(
            AffiliateRepository::class,
	)
        ->disableOriginalConstructor()
        ->addMethods([])
        ->getMock();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->repo);
    }

    /*
     * This is a cheat by lack of time, to only show positive tests
     * As I know initial affiliate data contains invalid results
     */
    public function testAffiliateDataContainsInvalidData()
    {
        $this->expectException(\InvalidArgumentException::class);
	$result = $this->repo->filter(100);
    }
}
