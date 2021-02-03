<?php

namespace App\Service;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NavBarManager extends AbstractController
{
    private $info;

    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;
    }

    public function infoNav()
    {
        $navBar = $this->categories->findAll();

        return $navBar;
    }
}