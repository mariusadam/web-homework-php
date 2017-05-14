<?php

namespace App\Form;

use App\Entity\FootballTeam;
use App\Repository\FootballTeamRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Class FootballTeamForm
 *
 * @package App\Form
 *
 * @author  Marius Adam
 */
class FootballTeamForm extends AbstractType
{
    /**
     * @var FootballTeamRepository
     */
    private $teamRepo;

    /**
     * @var string
     */
    private $actionUrl;

    /**
     * FootballTeamForm constructor.
     *
     * @param FootballTeamRepository $teamRepo
     * @param string                 $actionUrl
     */
    public function __construct(FootballTeamRepository $teamRepo, $actionUrl)
    {
        $this->teamRepo = $teamRepo;
        $this->actionUrl = $actionUrl;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAction($this->actionUrl)
                ->setMethod('POST')
                ->add(
                    'id',
                    ChoiceType::class,
                    [
                        'choices'     => $this->teamRepo->getAllIds(),
                        'placeholder' => 'Select an id',
                    ]
                )
                ->add('name', TextType::class)
                ->add('playedGames', IntegerType::class)
                ->add('wonGames', IntegerType::class)
                ->add('lostGames', IntegerType::class)
                ->add('scoredGoals', IntegerType::class)
                ->add('score', NumberType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', FootballTeam::class)
                 ->setDefault('crsf_field_name', '_team_random_token')
                 ->setDefault('crsf_token_id', self::class)
                 ->setDefault('crsf_protection', true);
    }


}