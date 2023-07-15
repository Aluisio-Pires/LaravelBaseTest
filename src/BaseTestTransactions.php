<?php
namespace AluisioPires\LaravelBaseTest;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class BaseTestTransactions extends BaseTest
{
    use DatabaseTransactions;
}
