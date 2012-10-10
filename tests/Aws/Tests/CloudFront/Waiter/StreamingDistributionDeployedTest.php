<?php

namespace Aws\Tests\CloudFront\Waiter;

use Guzzle\Http\Message\Response;
use Guzzle\Plugin\Mock\MockPlugin;

/**
 * @covers Aws\CloudFront\Waiter\StreamingDistributionDeployed
 */
class StreamingDistributionDeployedTest extends \Guzzle\Tests\GuzzleTestCase
{
    public function testReturnsTrueIfDeployed()
    {
        $client = $this->getServiceBuilder()->get('cloudfront');
        $this->setMockResponse($client, array(
            'cloudfront/GetStreamingDistribution_InProgress',
            'cloudfront/GetStreamingDistribution_Deployed'
        ));
        $client->waitUntil('streaming_distribution_deployed', 'foo', array(
            'interval' => 0
        ));
    }

    /**
     * @expectedException \Aws\Common\Exception\RuntimeException
     * @expectedExceptionMessage Maximum number of failures while waiting: 1
     */
    public function testDoesNotBufferOtherExceptions()
    {
        $client = $this->getServiceBuilder()->get('cloudfront');
        $this->setMockResponse($client, array(new Response(404)));
        $client->waitUntil('streaming_distribution_deployed', 'foo');
    }
}