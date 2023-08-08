<?php
namespace AluisioPires\LaravelBaseTest;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use AluisioPires\LaravelBaseTest\BaseTest;

class BaseTestTransactions extends BaseTest
{
    use DatabaseTransactions;
}
