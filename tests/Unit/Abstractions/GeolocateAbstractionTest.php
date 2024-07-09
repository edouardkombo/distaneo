<?php

namespace Tests\Unit\Abstractions;

use App\Abstractions\GeolocateAbstraction;
use Tests\TestCase;

/**
 * Class GeolocateAbstractionTest.
 *
 * @covers \App\Abstractions\GeolocateAbstraction
 */
final class GeolocateAbstractionTest extends TestCase
{ 
    public $geolocate;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
	 
        $this->geolocate = $this->getMockForAbstractClass(
            GeolocateAbstraction::class,
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->geolocate);
    }

    public function testDistanceHasValidResult()
    {
	$result = $this->geolocate->distance(33,36);
        $this->assertGreaterThan(  
            0,  
            $result,  
            "Actual value is greater than 0"
        );
    }

    public function testInvalidLatitudeLongitudeIfAlphabetic()
    {
	$this->expectException(\InvalidArgumentException::class);
        $this->geolocate->distance('abc','def');
    }

    public function testInvalidLatitudeIfAlphabetic()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->geolocate->distance('abc',100);
    }

    public function testInvalidLongitudeIfAlphabetic()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->geolocate->distance(-79,"def");
    }    

    public function testInvalidLatitudeLongitudeIfAlphanumeric()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->geolocate->distance('abc12','d1e3f');
    }

    public function testInvalidLatitudeIfAlphanumeric()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->geolocate->distance('a1b2c12',100);
    }

    public function testInvalidLongitudeIfAlphanumeric()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->geolocate->distance(-79,"d1e2f12");
    }    

    public function testInvalidNegativeLatitudeData()
    {
	$this->expectException(\InvalidArgumentException::class);
	$this->geolocate->distance(-91,100);
    }

    public function testInvalidPositiveLatitudeData()
    {
	$this->expectException(\InvalidArgumentException::class);
	$this->geolocate->distance(91,100);
    }    

    public function testInvalidNegativeLongitudeData()
    {
	$this->expectException(\InvalidArgumentException::class);
	$this->geolocate->distance(80,-181);
    }

    public function testInvalidPositiveLongitudeData()
    {
	$this->expectException(\InvalidArgumentException::class);
	$this->geolocate->distance(80,181);
    } 

    public function testEmptyLatitudeData()
    {
	$this->expectException(\InvalidArgumentException::class);
	$this->geolocate->distance("",100);
    }

    public function testEmptyLongitudeData()
    {
	$this->expectException(\InvalidArgumentException::class);
	$this->geolocate->distance(80,"");
    }

    public function testEmptyLatitudeAndLongitudeData()
    {
	$this->expectException(\InvalidArgumentException::class);
	$this->geolocate->distance("","");
    }
}
