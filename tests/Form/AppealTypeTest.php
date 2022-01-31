<?php

namespace App\Tests\FormType;

use App\Form\AppealType;
use App\Entity\Appeal;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Validator\Validation;

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

        $form = $this->factory->create(AppealType::class, $model);

        $expected = new Appeal();
        $expected->setPhone('+7(123)000-00-00');
        $expected->setCustomer('Arthur Dent');
        $expected->setStatus(0);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $model);
    }
}
