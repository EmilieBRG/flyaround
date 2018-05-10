<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use AppBundle\Entity\Flight;
use AppBundle\Entity\PlaneModel;
use AppBundle\Entity\Reservation;
use AppBundle\Entity\User;


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
     * @Route("/{review_id}/text/{text_id}/publicationdate/{publicationdate_id}/note/{note_id}", name="review_index", requirements={"review_id": "\d+"})
     * @Method("GET")
     * @ParamConverter("text", options={"mapping": {"text_id": "id"}})
     * @ParamConverter("publicationdate", options={"mapping": {"publicationdate_id": "id"}})
     * @ParamConverter("note", options={"mapping": {"note_id": "id"}})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Text $text, PublicationDate $publicationDate, Note $note)
    {
        return $this->render('review/index.html.twig', array(
            'text' => $text,
            'publicationdate' => $publicationDate,
            'note' => $note
        ));
    }

    /**
     *Form one text, one publicationDate and one note, with few IDs.
     *
     * @Route("/new/{review_id}/text/{text_id}/publicationdate/{publicationdate_id}/note/{note_id}", name="review_new", requirements={"review_id": "\d+"})
     * @Method("POST")
     * @ParamConverter("text", options={"mapping": {"text_id": "id"}})
     * @ParamConverter("publicationdate", options={"mapping": {"publicationdate_id": "id"}})
     * @ParamConverter("note", options={"mapping": {"note_id": "id"}})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Text $text, PublicationDate $publicationDate, Note $note)
    {
        return $this->render('review/new.html.twig', array(
            'text' => $text,
            'publicationdate' => $publicationDate,
            'note' => $note
        ));
    }
}
