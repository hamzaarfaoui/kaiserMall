<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Marques;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class MarquesController extends Controller
{
    /*
     * Marques list
     */
    public function listAction()
    {
        $dm = $this->getDoctrine()->getManager();
        $marques = $dm->getRepository('App:Marques')->findAll();
        return $this->render('marques/list.html.twig', array('marques' => $marques));
    }
    
    /*
     * Marque details
     */
    public function showAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $marque = $dm->getRepository('App:Marques')->find($id);
        return $this->render('marques/show.html.twig', array('marque' => $marque));
    }
    
    /*
     * New Marque page
     */
    public function newAction()
    {
        $dm = $this->getDoctrine()->getManager();
        $categories = $dm->getRepository('App:CategoriesMere')->findAll();
        return $this->render('marques/new.html.twig', array('categories' => $categories));
    }
    
    /*
     * Marques by categorie
     */
    public function marquesByCategorieAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $categorie = $dm->getRepository('App:SousCategories')->find($id);
        $marques = $dm->getRepository('App:Marques')->findBy(array('sousCategorie' => $categorie));
        $caracteristiques = $dm->getRepository('App:Caracteristiques')->findBy(array('sousCategorie' => $categorie));
        $couleurs = $dm->getRepository('App:couleurs')->findBy(array('sousCategorie' => $categorie));
        $caracteristiques_list = '';
        foreach ($caracteristiques as $caracteristique) {
            $caracteristiques_list .= '<div class="col-md-12"><div class="row">';
            $caracteristiques_list .= '<b>'.$caracteristique->getName().'</b><table><tr>';
            foreach ($caracteristique->getValeurs() as $valeur) {
                $caracteristiques_list .= '<td>';
                $caracteristiques_list .= '<div style="margin-right: 15px;"><input id="'.$valeur->getId().'" type="checkbox" name="valeurs[]" value="'.$valeur->getId().'"><label class="caracteristiques" for="'.$valeur->getId().'"> '.$valeur->getName().'</label></div>';
                $caracteristiques_list .= '</td>';
            }
			$caracteristiques_list .= '</tr></table>';
            
            $caracteristiques_list .= '</div></div>';
        }
        $couleurs_list = '<p><b>Couleur</b></p>';
        foreach ($couleurs as $couleur) {
            $couleurs_list .= '<input type="radio" name="couleur" class="couleur-radio"id="couleur-'.$couleur->getId().'" value="'.$couleur->getId().'" >
                <label for="couleur-'.$couleur->getId().'" class="couleur-label"><div style="background-color: '.$couleur->getCode().';height: 35px;width: 35px;"></div></label>';
        }
        $options = '<option value="">Sélectionner une marque</option>';
        foreach ($marques as $marque){
            $options .= '<option value="'.$marque->getId().'">'.$marque->getName().'</option>';
        }
        return new JsonResponse(['status'=>'ok', 'options'=>$options, 'caracteristiques' => $caracteristiques_list, 'couleurs' => $couleurs_list]);
    }
    
    /*
     * New marque traitement
     */
    public function newTraitementAction(Request $request)
    {
        $dm = $this->getDoctrine()->getManager();
        $marque = new Marques();
        $marque->setName($request->get('nom'));
        $marque->setContent($request->get('descriptionC'));
        $marque->setCreatedAt(new \DateTime('now'));
        $categorie_id = $request->get('categorie');
        $categorie = $dm->getRepository('App:SousCategories')->find($categorie_id);
        $marque->setSousCategorie($categorie);
        $dm->persist($marque);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La marque ".$marque->getName()." a été ajoutée");
        return $this->redirectToRoute('dashboard_marques_back_edit', array('id' => $marque->getId()));
    }
    
    /*
     * Marque edit
     */
    public function editAction($id)
    {
        $dm = $this->getDoctrine()->getManager();
        $marque = $dm->getRepository('App:Marques')->find($id);
        $categories = $dm->getRepository('App:CategoriesMere')->findAll();
        return $this->render('marques/edit.html.twig', array('marque' => $marque, 'categories' => $categories));
    }
    
    /*
     * Edit Marque traitement
     */
    public function editTraitementAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $marque = $dm->getRepository('App:Marques')->find($id);
        $marque->setName($request->get('nom'));
        $marque->setContent($request->get('description'));
        $marque->setUpdatedAt(new \DateTime('now'));
        $categorie_id = $request->get('categorie');
        $categorie = $dm->getRepository('App:SousCategories')->find($categorie_id);
        $marque->setSousCategorie($categorie);
        
        $dm->persist($marque);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La marque ".$marque->getName()." a été ajoutée");
        return $this->redirectToRoute('dashboard_marques_back_edit', array('id' => $marque->getId()));
    }
    
    /*
     * Delete Marque
     */
    public function deleteAction(Request $request, $id)
    {
        $dm = $this->getDoctrine()->getManager();
        $fileSystem = new Filesystem();
        $marque = $dm->getRepository('App:CategoriesMere')->find($id);
        $fileSystem->remove(array('symlink', $this->getParameter('images_marques')."/".$marque->getImage(), ''.$marque->getImage().''));
        $dm->remove($marque);
        $dm->flush();
        $request->getSession()->getFlashBag()->add('success', "La marque ".$marque->getName()." supprimée");
        return $this->redirectToRoute('dashboard_marques_back_index');
    }
}
