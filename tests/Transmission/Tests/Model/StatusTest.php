<?php

namespace Transmission\Tests\Model;

use Transmission\Model\Status;

class StatusTest extends \PHPUnit\Framework\TestCase
{
    public function testShouldConstructUsingStatusInstance()
    {
        $state  = new Status(Status::STATUS_STOPPED);
        $status = new Status($state);

        $this->assertTrue($status->isStopped());
    }
}
