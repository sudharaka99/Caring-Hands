<?php

namespace Tests\Unit;

use App\Rules\PhoneNumber;
use PHPUnit\Framework\TestCase;

class PhoneNumberTest extends TestCase
{
    /** @dataProvider validPhoneNumbers */
    public function test_it_accepts_valid_phone_numbers($phone)
    {
        $this->assertTrue((new PhoneNumber())->passes('phone', $phone));
    }

    public static function validPhoneNumbers(): array
    {
        return [
            'Sri Lankan mobile' => ['0712345601'],
            'international mobile' => ['+94712345678'],
            'formatted international number' => ['+1 (415) 555-2671'],
            'spaced number' => ['123 456 7890'],
        ];
    }

    /** @dataProvider invalidPhoneNumbers */
    public function test_it_rejects_invalid_phone_numbers($phone)
    {
        $this->assertFalse((new PhoneNumber())->passes('phone', $phone));
    }

    public static function invalidPhoneNumbers(): array
    {
        return [
            'too few digits' => ['123456'],
            'too many digits' => ['1234567890123456'],
            'letters' => ['07123abc01'],
            'multiple plus signs' => ['++94712345678'],
            'extension text' => ['0712345601 ext 2'],
        ];
    }
}