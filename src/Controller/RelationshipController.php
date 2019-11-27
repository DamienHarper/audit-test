<?php

namespace App\Controller;

use App\Entity\Relationship;
use App\Form\RelationshipType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class RelationshipController extends AbstractController
{
    /**
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @Route("/relationships", name="relationships")
     */
    public function index()
    {
        $relationships = $this->getDoctrine()
                      ->getRepository(Relationship::class)->findAll();
        return $this->render('relationship/list.html.twig', [
            'relationships' => $relationships
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @Route("/relationship/create", name="relationship_create")
     */
    public function create(Request $request)
    {
        $relationship = new Relationship();

        $form = $this->createForm(RelationshipType::class, $relationship, array("action" => $this->generateUrl("relationship_create")));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $request->request->get('relationship');
            $entityManager = $this->getDoctrine()->getManager();
            $relationship->setRelationship($data['relationship']);
            $relationship->setStatus($data['status']);
            $entityManager->persist($relationship);
            $entityManager->flush();

            return $this->redirectToRoute('relationships');
        }

        return $this->render("relationship/create.html.twig", [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @Route("/relationship/{id}/edit", name="relationship_edit")
     */
    public function edit(Request $request, $id)
    {
        $data = $this->getDoctrine()
                ->getRepository(Relationship::class)
                ->find($id);

        $form = $this->createForm(RelationshipType::class, $data);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $form_data = $form->getData();
            $reqData =  $request->request->get('relationship');
            $entityManager = $this->getDoctrine()->getManager();

            $relationship = $this->getDoctrine()
                           ->getRepository(Relationship::class)
                           ->findOneBy(array('id' => $form_data->getId()));

            $relationship->setRelationship($reqData['relationship']);
            $relationship->setStatus($reqData['status']);
            $entityManager->flush();
            return $this->redirectToRoute("relationships");
        }

        return $this->render("relationship/edit.html.twig", [
            'relationship' => $data,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/getAllRelationship", methods={"GET"})
     */
    public function getAllRelationship()
    {
        $relationships = $this->getDoctrine()
            ->getRepository(Relationship::class)
            ->findAll();

        $relationship_data =[];
        foreach($relationships as $key=>$val){
            $relationship_data[$key]['id'] = $val->getId();
            $relationship_data[$key]['relationship'] = $val->getRelationship();
            $relationship_data[$key]['status'] = $val->isEnabled();
        }

        return new JsonResponse([
            "data" => $relationship_data
        ]);

    }

    /**
     * @Security("is_granted('ROLE_ADMIN')")
     *
     * @Route("/relationship/{id}/delete", methods={"GET"})
     */
    public function delete(Request $request, $id)
    {
        $relationship = $this->getDoctrine()
            ->getRepository(Relationship::class)
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($relationship);
        $em->flush();
        
        return $this->redirectToRoute("relationships");
    }

    /**
     * @Route("/relationship/check_duplicate_relationship", name="check_duplicate_relationship")
    */
    public function check_duplicate_relationship(Request $request)
    {
        $id = null;
        $data = $request->request->all();
        if (isset($data['id']) && !empty($data['id'])) {
            $id = $data['id'];
        }
        $relationship = $data['relationship']['relationship'];
        $relationship_count = $this->getDoctrine()
                          ->getRepository(Relationship::class)
                          ->getCount($relationship, $id);
        if ($relationship_count) {
            return new JsonResponse(false);
        }

        return new JsonResponse(true);
    }

}
