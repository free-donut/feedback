<?php

namespace App\Tests\FormType;

use App\Form\AppealType;
use App\Entity\Appeal;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Validator\Validation;

// ...

class AppealTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'customer' => 'Arthur Dent',
            'phone' => '+7(123)000-00-00',
            'status' => 0,
        ];

        $model = new Appeal();
        // $model will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(AppealType::class, $model);

        $expected = new Appeal();
        // ...populate $object properties with the data stored in $formData
        $expected->setPhone('+7(123)000-00-00');
        $expected->setCustomer('Arthur Dent');
        $expected->setStatus(0);

        // submit the data to the form directly
        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $model was modified as expected when the form was submitted
        $this->assertEquals($expected, $model);
    }
}
