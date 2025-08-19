<?php

declare(strict_types=1);

namespace App\Shared\Domain\Aggregate;

use App\Shared\Domain\Bus\Event\DomainEvent;

abstract class AggregateRoot
{
    public ?DomainEvent $domainEvent = null;

    final public function pullDomainEvent(): ?DomainEvent
    {
        $domainEvent = $this->domainEvent;
        $this->domainEvent = null;

        return $domainEvent;
    }

    final protected function record(DomainEvent $domainEvent): void
    {
        $this->domainEvent = $domainEvent;
    }
}
