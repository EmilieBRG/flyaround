<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use AppBundle\Entity\Review;

/**
 * Class ReviewController
 * @package AppBundle\Controller
 * @route("review")
 */

class ReviewController extends Controller
{
    /**
     *List one text, one publicationDate and one note, with few IDs.
     *
     * @Route("/{id}", name="review_index", requirements={"id": "\d+"})
     * @Method("GET")
     * @ParamConverter("review", options={"mapping": {"id": "id"}})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Review $review)
    {
        return $this->render('review/index.html.twig', [
            'review' => $review,
        ]);
    }

    /**
     * Creates a new review entity.
     *
     * @Route("/new", name="review_new")
     * @Method({"GET", "POST"})
     */
    public function newAction()
    {
        $review = new Review();
        $form = $this->createForm('AppBundle\Form\ReviewType', $review);
        $form->handleRequest();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($review);
            $em->flush();

            return $this->redirectToRoute('review_show', ['id' => $review->getId()]);
        }

        return $this->render('review/new.html.twig', [
            'review' => $review,
            'form' => $form->createView(),
        ]);
    }
}
