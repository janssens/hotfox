<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Reply;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Repository\RepositoryFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RequestContext;

class DefaultController extends AbstractController
{
    private $request;
    private $em;

    public function __construct(RequestStack $request,EntityManagerInterface $em){

        $this->request = $request;
        $this->em = $em;
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Route('/reply/', name: 'reply')]
    public function reply(RequestContext $request): Response
    {
        $token = $this->request->getCurrentRequest()->get('token');
        $short = $this->request->getCurrentRequest()->get('short');
        if (!$token && !$short){
            return $this->render('default/error.html.twig',['message'=>'paramètre manquant...']);
        }
        //get reply by token
        /** @var Reply $reply */
        $reply = $this->em->getRepository(Reply::class)->findOneBy(['token'=>$token]);
        if (!$reply){
            return $this->render('default/error.html.twig',['message'=>'L&rsquo;url que vous utilisez ne correspond pas à une réponse possible']);
        }
        //get instructor
        $instructor = $reply->getInstructor();
        //get race
        $race = $reply->getRace();
        //get question
        $question = $this->em->getRepository(Question::class)->findOneBy(['short'=>$short]);
        if (!$reply){
            return $this->render('default/error.html.twig',['message'=>'La réponse '.$short.' ne correspond pas à une question']);
        }
        $message = '';
        $questions = $this->em->getRepository(Question::class)->findBy(['is_active'=>true]);
        //check for existing reply
        if (!$reply->getAnswer() or $this->request->getCurrentRequest()->isMethod('post')) {
            $reply->setAnswer($question);
            $this->em->persist($reply);
            $this->em->flush();
            $this->addFlash('success', 'Votre réponse a bien été prise en compte, merci.');
        }else{
            $this->addFlash('notice', 'Vous avez déjà répondu à cette question.');
        }
        return $this->render('default/thank_you.html.twig',
            [   'reply'=>$reply,
                'questions'=>$questions,
                'token' => $token
            ]);
    }
}
