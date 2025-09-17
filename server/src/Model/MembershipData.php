<?php

namespace App\Model;

use App\Entity\Member;
use App\Entity\MembershipType;
use App\Enums\MemberPosition;
use Symfony\Component\Serializer\Attribute\Groups;

class MembershipData
{
    #[Groups('membership:list')]
    public int $id;

    #[Groups('membership:list')]
    public MemberPosition $position;

    #[Groups('membership:list')]
    public \DateTimeImmutable $starting;

    #[Groups('membership:list')]
    public \DateTimeImmutable $ending;

    #[Groups('membership:list')]
    public MembershipType $type;

    public function __construct(Member $member)
    {
        $this->id = $member->getMembership()->getId();
        $this->position = $member->getPosition();
        $this->starting = $member->getStarting();
        $this->ending = $member->getEnding();
        $this->type = $member->getType();
    }
}
