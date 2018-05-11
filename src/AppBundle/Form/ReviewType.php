<?php
namespace AppBundle\Form;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ReviewType extends AbstractType
{
    /*
    Les 3 premières lignes sont consacrées à une annotation dite "inline", qui permet d'ajouter sa propre description à
    la suite de celle héritée. En effet, elle est là pour inclure la description de la méthode parente AbstractType, et
    te permettre d'ajouter la tienne à la suite.
    La ligne suivante est la déclaration de la méthode buildForm() prenant deux paramètres, un objet $builder de type
    FormBuilderInterface (contenant du coup ses propres méthodes), et un tableau contenant les tâches et options à appliquer.
    Une fois dans la méthode, tu constates l'ajout à l'objet $builder de chacun de tes champs. C'est ici que tes inputs
    seront récupérés afin de les persister en BDD.
     */
    /**
     * {@inheritdoc} Including all fields from Review entity.
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextareaType::class, [
                'attr' => ['maxlenght' => 250, 'label' => 'Description']
            ])
            ->add('publicationDate', DateType::class, [
                'data' => new \DateTime('now')
            ])
            ->add('note', IntegerType::class, [
                'attr' => ['min' => 0, 'max' => 5, 'label' => 'Note']
            ])
            ->add('agreeTerms', CheckboxType::class, ['mapped' => false])
            ->add('userRated', EntityType::class, [
                'class' => 'AppBundle\Entity\User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.lastName', 'ASC');
                },
                'choice_label' => 'lastName'
            ])
            ->add('reviewAuthor');
    }


    /*
     * Bon, le builder est créé. Mais comment relier le formulaire avec l'entité maintenant ? Car en l'état, il ne sert à rien !
     */
    /**
     * {@inheritdoc} Targeting Review entity
     */

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Review'
        ));
    }

    /**
     * {@inheritdoc} getName() is now deprecated
     */

    public function getBlockPrefix()
    {
        return 'appbundle_review';
    }


}
