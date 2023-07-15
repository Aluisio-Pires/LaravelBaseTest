**LaravelBaseTest**

A BaseTest for your Laravel Project.

## Requirements

- Laravel 8+

## Install
```
   composer require aluisio-pires/laravel-base-test
```

## Usage

**Change your Feature Test Class to extend BaseTest.**
Example:
   ```
   <?php


    use AluisioPires\LaravelBaseTest\BaseTest;
    use App\Models\YourModel;
    use Illuminate\Foundation\Testing\DatabaseTransactions;
    
    class YourModelTest extends BaseTest
    {
      use DatabaseTransactions;
    
      public function test_index()
        {
            YourModel::factory()->create();
            $this->simpleTest('get', route('your-model.index'));
        }
    }
   ```

A shorter way is extends BaseTestTransactions:
   ```
   <?php


    use AluisioPires\LaravelBaseTest\BaseTestTransactions;
    use App\Models\YourModel;
    
    class YourModelTest extends BaseTestTransactions
    {    
      public function test_index()
        {
            YourModel::factory()->create();
            $this->simpleTest('get', route('your-model.index'));
        }
    }
   ```
For now you have:
* BaseTest
* BaseTestTransactions (BaseTest with DatabaseTransactions trait)
* BaseTestMigrations (BaseTest with DatabaseMigrations trait)
* BaseTestTruncation (BaseTest with DatabaseTruncation trait)

You can create your own BaseTest:
   ```
   <?php
    namespace Tests;

    use AluisioPires\LaravelBaseTest\BaseTest as LaravelBaseTest;
    use Illuminate\Foundation\Testing\DatabaseTransactions;
    
    class BaseTest extends LaravelBaseTest
    {
      use YourTrait;

      protected function yourOwnFunction()
      {
        ...
      }
      
    }
   ```
