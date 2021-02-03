<?php

namespace App\Controller\Admin;

use App\Entity\BadAnswer;
use App\Entity\Question;
use App\Form\BadAnswerType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class QuestionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Question::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('category'),
            TextField::new('name'),
            TextField::new('answer'),
            CollectionField::new('badAnswers')
            ->setEntryType(BadAnswerType::class),
        ];
    }
}
