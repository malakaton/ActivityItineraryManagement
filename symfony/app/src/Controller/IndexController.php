<?php

namespace Academy\App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->redirect('/reports/index.html');
    }
}
