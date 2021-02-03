<?php

namespace App\Controller\Admin;

use App\Entity\BadAnswer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BadAnswerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BadAnswer::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
