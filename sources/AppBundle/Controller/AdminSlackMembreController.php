<?php

namespace AppBundle\Controller;

use AppBundle\Slack\UsersChecker;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminSlackMembreController extends Controller
{
    private $filename;

    public function checkMembersAction()
    {
        return $this->render('admin/slackmembers/index.html.twig', [
            'title' => "Veille de l'AFUP",
            'techletters' => [],
            'results' => $this->get(UsersChecker::class)->checkUsersValidity(),
        ]);
    }
}
